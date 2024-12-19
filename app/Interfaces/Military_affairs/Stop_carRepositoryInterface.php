<?php

namespace App\Interfaces\Military_affairs;

use Illuminate\Http\Request;

interface Stop_carRepositoryInterface
{
    public function index($governate_id = null, $stop_car_type = null);

}
