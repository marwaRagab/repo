<?php

namespace App\Http\Controllers\Military_affairs;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Interfaces\Military_affairs\SettlementRepositoryInterface;
use Yajra\DataTables\DataTables;
use App\Models\Military_affairs;

class SettlementController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

     public function __construct(SettlementRepositoryInterface $SettleRepository)
    {
        $this->SettleRepository = $SettleRepository;
    }
    public function index(Request $request)
    {
        return  $this->SettleRepository->index( $request);
    }
    public function add_settlement(Request $request)
    {
        return  $this->SettleRepository->add_settlement($request);
    }
    public function show_settlement($id){
        return  $this->SettleRepository->show_settlement($id);

    }

}
