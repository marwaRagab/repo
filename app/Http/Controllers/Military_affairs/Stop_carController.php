<?php

namespace App\Http\Controllers\Military_affairs;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Interfaces\Military_affairs\Stop_carRepositoryInterface;
use Yajra\DataTables\DataTables;
use App\Models\Military_affairs;

class Stop_carController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

     public function __construct(Stop_carRepositoryInterface $Stop_carRepository)
    {
        $this->Stop_carRepository = $Stop_carRepository;
    }
    public function index()
    {
        return   $this->Stop_carRepository->index();

    }
   
}
