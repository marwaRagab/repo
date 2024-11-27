<?php

namespace App\Interfaces\Military_affairs;

use Illuminate\Http\Request;

interface SearchRepositoryInterface
{
    public function index (Request $request);
    public function get_searched(Request $request);
    public function show_images($id);
}
