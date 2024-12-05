<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Interfaces\NotificationRepositoryInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class NotificationController extends Controller
{
    protected $notificationRepository;

    public function __construct(NotificationRepositoryInterface $notificationRepository)
    {
        $this->notificationRepository = $notificationRepository;
    }
    public function index()
    {
        $data = $this->notificationRepository->index();

        if ($data) {
            $user_id = Auth::user()->id ?? null;
            $message = "تم الدخول على الاشعارات ";
            $this->log($user_id, $message);
        }

        return $data;
    }

    public function updateTab(Request $request)
    {
        // Validate the tab ID
        $request->validate([
            'tab_id' => 'required|string',
        ]);
        $substring = Str::afterLast($request->tab_id, '-');

        DB::table('notifications') // Replace 'users' with your table name
            ->where('id', $substring) // Assuming you want to update for the logged-in user
            ->update(['show' => 1]);

        return response()->json(['message' => 'Tab updated successfully']);

    }
}
