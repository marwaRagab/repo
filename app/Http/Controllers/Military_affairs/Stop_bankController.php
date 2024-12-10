<?php

namespace App\Http\Controllers\Military_affairs;

use App\Models\Governorate;
use Illuminate\Http\Request;
use App\Models\Military_affairs;
use Yajra\DataTables\DataTables;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Interfaces\Military_affairs\Open_fileRepositoryInterface;
use App\Interfaces\Military_affairs\Stop_bankRepositoryInterface;
use App\Interfaces\Military_affairs\Stop_travelRepositoryInterface;

class Stop_bankController extends Controller
{
    //
    protected $stop_bankRepository;

    public function __construct(Stop_bankRepositoryInterface $stop_bankRepository)
    {
        $this->stop_bankRepository = $stop_bankRepository;
    }

    public function index(Request $request)
    {
        // dd("dd");
        return $this->stop_bankRepository->index($request);


    }

    public function archive(Request $request)
    {
        // dd("dd");
        return $this->stop_bankRepository->archive($request);


    }

    public function print_archive(Request $request)
    {
        // dd("dd");
        return $this->stop_bankRepository->print_archive($request);


    }

    public function change_states(Request $request)
    {
        // dd("dd");
        return $this->stop_bankRepository->change_states($request);


    }
    public function change_states_bank($id,$value)
    {

        return $this->stop_bankRepository->change_states_bank($id,$value);


    }

}
