<?php

namespace App\Listeners;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

use Illuminate\Auth\Events\Login;

class UpdateOnlineStatus
{
    public function handle(Login $event)
    {
        $user = $event->user;
        $user->update(['on' => 1]);
    }
}