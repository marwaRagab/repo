<?php

namespace App\Interfaces\Military_affairs;

use Illuminate\Http\Request;

interface Execute_alertRepositoryInterface
{
    public function index(Request $request);


   public function add_a3lan_date(Request $request);

}
