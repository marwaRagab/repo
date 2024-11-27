<?php

namespace App\Interfaces\Military_affairs;

use Illuminate\Http\Request;

interface ImageRepositoryInterface
{
    public function index(Request $request, $governorate_id = null);
    public function to_a3lan_eda3(Request $request);
    public function athbat_7ala($id);
}
