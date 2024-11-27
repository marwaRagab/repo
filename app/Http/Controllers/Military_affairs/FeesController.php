<?php

namespace App\Http\Controllers\Military_affairs;

use App\Http\Controllers\Controller;
use App\Interfaces\Military_affairs\FeesRepositoryInterface;
use App\Models\Military_affairs;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\DataTables;

class FeesController extends Controller
{
    
    protected $feesRepository;

    public function __construct(FeesRepositoryInterface $feesRepository)
    {
        $this->feesRepository = $feesRepository;
    }

    public function index(Request $request)
    {
        // dd("dd");
        return $this->feesRepository->index($request);
    }

    public function store(Request $request)
    {
        // dd("dd");
        return $this->feesRepository->store($request);
    }
    public function delete(Request $request)
    {
        return $this->feesRepository->delete($request);
    }

}
