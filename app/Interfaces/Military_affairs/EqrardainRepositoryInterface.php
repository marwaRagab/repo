<?php

namespace App\Interfaces\Military_affairs;

use Illuminate\Http\Request;

interface EqrardainRepositoryInterface
{
    public function index (Request $request);
    public function please_cancel_eqrar($id);

    public function update_actions_reminder(Request $request);

}
