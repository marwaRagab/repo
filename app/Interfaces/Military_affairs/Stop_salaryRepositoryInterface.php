<?php

namespace App\Interfaces\Military_affairs;

use Illuminate\Http\Request;

interface Stop_salaryRepositoryInterface
{
    public function index(Request $request);
    public function stop_salary_convert(Request $request);

   
}
