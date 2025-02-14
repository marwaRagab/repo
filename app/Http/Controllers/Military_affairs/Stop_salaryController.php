<?php

namespace App\Http\Controllers\Military_affairs;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Interfaces\Military_affairs\Stop_salaryRepositoryInterface;
use Yajra\DataTables\DataTables;
use App\Models\Military_affairs;

class Stop_salaryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

     public function __construct(Stop_salaryRepositoryInterface $Stop_salaryRepository)
    {
        $this->Stop_salaryRepository = $Stop_salaryRepository;
    }
    public function index(Request $request)
    {
        return   $this->Stop_salaryRepository->index($request);

    }
    public function stop_salary_convert(Request $request)
    {
        return   $this->Stop_salaryRepository->stop_salary_convert($request);
    }

   
}
