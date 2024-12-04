<?php

namespace App\Listeners;

use Illuminate\Auth\Events\Logout;

class UpdateOfflineStatus
{
    public function handle(Logout $event)
    {
        $user = $event->user;
        $user->update(['on' => 0]);
    }
}
