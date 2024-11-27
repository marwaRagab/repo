<?php

namespace App\Interfaces\Military_affairs;

use Illuminate\Http\Request;

interface CheckingRepositoryInterface
{
    public function index (Request $request);
    public function update_actions_up(Request $request);

    public function update_actions_reminder(Request $request);

}
