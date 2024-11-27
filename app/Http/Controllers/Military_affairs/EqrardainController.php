<?php

namespace App\Http\Controllers\Military_affairs;


use App\Http\Controllers\Controller;
use App\Interfaces\Military_affairs\CheckingRepositoryInterface;
use App\Interfaces\Military_affairs\EqrardainRepositoryInterface;
use App\Interfaces\Military_affairs\Open_fileRepositoryInterface;
use App\Interfaces\Military_affairs\Stop_travelRepositoryInterface;
use App\Models\Governorate;
use App\Models\Military_affairs;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\DataTables;

class EqrardainController extends Controller
{
    //
    protected $eqrardainRepository;

    public function __construct(EqrardainRepositoryInterface $eqrardainRepository)
    {
        $this->eqrardainRepository = $eqrardainRepository;
    }

    public function index(Request $request)
    {
        // dd("dd");
        return $this->eqrardainRepository->index($request);


    }

    public function please_cancel_eqrar($id)
    {
        // dd("dd");
        return $this->eqrardainRepository->please_cancel_eqrar($id);


    }
    public function update_actions_reminder(Request $request)
    {
        return $this->eqrardainRepository->update_actions_reminder($request);

    }

}
