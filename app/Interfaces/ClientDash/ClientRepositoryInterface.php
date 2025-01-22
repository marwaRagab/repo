<?php

namespace App\Interfaces\ClientDash;

use Illuminate\Http\Request;

interface ClientRepositoryInterface
{
    public function index();
    public function get_data(Request $request);
}
