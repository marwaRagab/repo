<?php

namespace App\Http\Controllers\Military_affairs;

use App\Http\Controllers\Controller;
use App\Interfaces\Military_affairs\Execute_alertRepositoryInterface;
use App\Models\Military_affairs;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\DataTables;

class Execute_alertController extends Controller
{
    //
    protected $Excute_alertRepository;
    public function __construct(Execute_alertRepositoryInterface $Excute_alertRepository)
    {
        $this->Excute_alertRepository = $Excute_alertRepository;
    }
    public function index(Request $request)
    {
        // dd("dd");
      return $this->Excute_alertRepository->index($request);


    }

    public function add_a3lan_date(Request $request)
    {

        return $this->Excute_alertRepository->add_a3lan_date($request);


    }










}
