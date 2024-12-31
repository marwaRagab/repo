<?php

namespace App\Http\Controllers;

use App\Models\User;
use Endroid\QrCode\Builder\Builder;
use Endroid\QrCode\Encoding\Encoding;
use Endroid\QrCode\Writer\PngWriter;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;

class QrCodeController extends Controller
{
    /**
     * Generate and display a QR Code.
     *
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function generate()
    {
        // Fetch all users
        $users = User::all();

        // Define the public folder path for QR codes
        $destinationPath = public_path('qr_codes');

        // Ensure the directory exists
        if (!File::exists($destinationPath)) {
            File::makeDirectory($destinationPath, 0755, true); // Create directory if it doesn't exist
        }

        foreach ($users as $user) {
            // Generate the QR code
            $qrCode = Builder::create()
                ->writer(new PngWriter())
                ->data("User ID: {$user->id}, Email: {$user->email}") // Encode user details
                ->encoding(new Encoding('UTF-8'))
                ->size(300) // Size of the QR Code
                ->margin(10) // Margin around the QR Code
                ->build();

            $encryptedName = md5(uniqid($user->id, true)) . '.png';

            $filePath = $destinationPath . '/' . $encryptedName;

            $qrCode->saveToFile($filePath);

            DB::table('users')->where('id', $user->id)->update(['qr_code_path' => "qr_codes/{$encryptedName}"]);

        }

        return "QR codes generated successfully!";

    }

    public function download($userId)
    {
        $user = User::findOrFail($userId);

        if (!$user->qr_code_path || !File::exists(public_path($user->qr_code_path))) {
            return response()->json(['error' => 'QR Code not found.'], 404);
        }

        $filePath = public_path($user->qr_code_path);

        return response()->download($filePath, "user-{$user->name_ar}-qr-code.png");
    }

}