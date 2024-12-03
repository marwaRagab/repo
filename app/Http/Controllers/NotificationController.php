<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Interfaces\NotificationRepositoryInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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
            $user_id =  Auth::user()->id ?? null;
            $message = "تم الدخول على الاشعارات ";
            $this->log($user_id, $message);
        }

        return $data;
    }
}
