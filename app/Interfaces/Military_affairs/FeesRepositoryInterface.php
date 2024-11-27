<?php

namespace App\Interfaces\Military_affairs;

use Illuminate\Http\Request;

interface FeesRepositoryInterface
{
    public function index (Request $request);
    public function store(Request $request);
    public function delete(Request $request);

}
