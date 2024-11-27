<?php

namespace App\Http\Controllers\Military_affairs;


use App\Http\Controllers\Controller;
use App\Interfaces\Military_affairs\CheckingRepositoryInterface;
use App\Interfaces\Military_affairs\Open_fileRepositoryInterface;
use App\Interfaces\Military_affairs\Stop_travelRepositoryInterface;
use App\Models\Governorate;
use App\Models\Military_affairs;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\DataTables;

class CheckingController extends Controller
{
    //
    protected $checkingRepository;

    public function __construct(CheckingRepositoryInterface $checkingRepository)
    {
        $this->checkingRepository = $checkingRepository;
    }

    public function index(Request $request)
    {
        // dd("dd");
        return $this->checkingRepository->index($request);


    }

    public function update_actions_up(Request $request)
    {
        // dd("dd");
        return $this->checkingRepository->update_actions_up($request);


    }
    public function update_actions_reminder(Request $request)
    {
        return $this->checkingRepository->update_actions_reminder($request);

    }

}
