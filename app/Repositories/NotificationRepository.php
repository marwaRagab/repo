<?php

namespace App\Repositories;

use App\Models\User;
use App\Models\Notification;
use Illuminate\Support\Facades\Auth;
use App\Interfaces\NotificationRepositoryInterface;

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
            ->where('user_id', Auth::user()->id)
            ->where('show', 0)
            // ->whereDate('created_at', \Carbon\Carbon::today())
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
