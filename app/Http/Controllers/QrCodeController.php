<?php

namespace App\Http\Controllers;

use App\Models\User;
use Endroid\QrCode\Builder\Builder;
use Endroid\QrCode\Encoding\Encoding;
use Endroid\QrCode\Writer\PngWriter;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
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
    public function generate($user_id=null)
    {
        $users = User::all();


        $destinationPath = public_path('qr_codes');

        if (!File::exists($destinationPath)) {
            File::makeDirectory($destinationPath, 0755, true);
        }
        if(!$user_id){
            foreach ($users as $user) {
                // Generate the QR code
                $qrCode = Builder::create()
                    ->writer(new PngWriter())
                    ->data( route('elec/users.edit', Crypt::encryptString($user->id)) )
                    ->encoding(new Encoding('UTF-8'))
                    ->size(300)
                    ->margin(10)
                    ->build();

                $encryptedName = md5(uniqid($user->id, true)) . '.png';

                $filePath = $destinationPath . '/' . $encryptedName;

                $qrCode->saveToFile($filePath);

                DB::table('users')->where('id', $user->id)->update(['qr_code_path' => "qr_codes/{$encryptedName}"]);

            }
        }else{



            $user_new=User::findorfail($user_id);

            // Generate the QR code
            $qrCode = Builder::create()
                ->writer(new PngWriter())
                ->data( route('users.edit', Crypt::encryptString($user_new->id)) )
                ->encoding(new Encoding('UTF-8'))
                ->size(300)
                ->margin(10)
                ->build();

            $encryptedName_user = md5(uniqid($user_new->id, true)) . '.png';

            $filePath = $destinationPath . '/' . $encryptedName_user;

            $qrCode->saveToFile($filePath);
            // $data['qr_code_path']='qr_codes/'.$encryptedName;

            DB::table('users')->where('id', $user_new->id)->update(['qr_code_path' => "qr_codes/{$encryptedName_user}"]);

        }
        return redirect()->route('users.index')->with('success', 'تم إضافة المستخدم بنجاح');


        //return "QR codes generated successfully!";

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
