<?php

namespace App\Interfaces\Military_affairs;

use Illuminate\Http\Request;

interface Stop_travelRepositoryInterface
{
    public function index (Request $request);
    public function stop_travel_convert(Request $request);


}
