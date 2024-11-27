<?php

namespace App\Http\Controllers\Military_affairs;

use App\Http\Controllers\Controller;
use App\Interfaces\Military_affairs\Open_fileRepositoryInterface;
use App\Interfaces\Military_affairs\Stop_travelRepositoryInterface;
use App\Models\Governorate;
use App\Models\Military_affairs;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\DataTables;

class Stop_travelController extends Controller
{
    //
    protected $stop_travelRepository;

    public function __construct(Stop_travelRepositoryInterface $stop_travelRepository)
    {
        $this->stop_travelRepository = $stop_travelRepository;
    }

    public function index(Request $request)
    {
        // dd("dd");
        return $this->stop_travelRepository->index($request);


    }

    public function stop_travel_convert(Request $request)
    {
        // dd("dd");
        return $this->stop_travelRepository->stop_travel_convert($request);


    }

}
