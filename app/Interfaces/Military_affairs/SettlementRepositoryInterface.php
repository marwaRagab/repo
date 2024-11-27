<?php

namespace App\Interfaces\Military_affairs;

use Illuminate\Http\Request;

interface SettlementRepositoryInterface
{
    public function index(Request $request);
    public function add_settlement(Request $request);
    public function show_settlement($id);

}
