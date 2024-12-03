<?php

namespace App\Repositories;

use App\Interfaces\NotificationRepositoryInterface;
use App\Models\Notification;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class NotificationRepository implements NotificationRepositoryInterface
{

    public function index()
    {
        $user = auth()->user();

        /* if ($user->support == 0) {
        $notifications = Notification::with('user')->whereNull('problem_id')
        ->orderBy('created_at', 'desc')->get();
        } else {
         */
        $notifications = Notification::with('user')
            ->orderBy('created_at', 'desc')->get();
        //   }

        $role = $user->roles ? $user->roles->name_ar : '';

        $title = "الاشعارات";
        $breadcrumb = array();
        $breadcrumb[0]['title'] = " الرئيسية";
        $breadcrumb[0]['url'] = route("dashboard");
        $breadcrumb[1]['title'] = $title;
        $breadcrumb[1]['url'] = 'javascript:void(0);';

        $view = 'notifications';
        return view(
            'layout',
            compact('title', 'view', 'breadcrumb', 'notifications', 'user', 'role')
        );
    }
}
