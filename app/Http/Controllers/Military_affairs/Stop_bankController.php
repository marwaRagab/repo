<?php

namespace App\Http\Controllers\Military_affairs;

use App\Http\Controllers\Controller;
use App\Interfaces\Military_affairs\Open_fileRepositoryInterface;
use App\Interfaces\Military_affairs\Stop_bankRepositoryInterface;
use App\Interfaces\Military_affairs\Stop_travelRepositoryInterface;
use App\Models\Governorate;
use App\Models\Military_affairs;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\DataTables;

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
