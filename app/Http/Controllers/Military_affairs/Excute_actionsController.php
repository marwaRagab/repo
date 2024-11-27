<?php

namespace App\Http\Controllers\Military_affairs;


use App\Http\Controllers\Controller;
use App\Interfaces\Military_affairs\CheckingRepositoryInterface;
use App\Interfaces\Military_affairs\Excute_actionsRepositoryInterface;
use App\Interfaces\Military_affairs\Open_fileRepositoryInterface;
use App\Interfaces\Military_affairs\Stop_travelRepositoryInterface;
use App\Models\Governorate;
use App\Models\Military_affairs;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\DataTables;

class Excute_actionsController extends Controller
{
    //
    protected $Excute_actionsRepository;

    public function __construct(Excute_actionsRepositoryInterface $Excute_actionsRepository)
    {
        $this->Excute_actionsRepository = $Excute_actionsRepository;
    }

    public function index(Request $request)
    {
        // dd("dd");
        return $this->Excute_actionsRepository->index($request);


    }
    public function all_checks_index(Request $request)
    {
        // dd("dd");
        return $this->Excute_actionsRepository->all_checks_index($request);


    }

    public function add_amount(Request $request)
    {
        // dd("dd");
        return $this->Excute_actionsRepository->add_amount($request);


    }
    public function add_check(Request $request)
    {
        return $this->Excute_actionsRepository->add_check($request);

    }

    public function add_check_finished(Request $request)
    {
        return $this->Excute_actionsRepository->add_check_finished($request);

    }

}
