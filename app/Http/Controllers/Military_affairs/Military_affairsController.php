<?php

namespace App\Http\Controllers\Military_affairs;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Interfaces\Military_affairs\Military_affairsRepositoryInterface;
use Yajra\DataTables\DataTables;
use App\Models\Military_affairs;

class Military_affairsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

     public function __construct(Military_affairsRepositoryInterface $Military_affairsRepository)
    {
        $this->Military_affairsRepository = $Military_affairsRepository;
    }
    public function index()
    {

        return   $this->Military_affairsRepository->index();

    }
    public function convert($id)
    {
      return  $this->Military_affairsRepository->convert($id);

    }

    public function get_settlment($type = null){
        $this->Military_affairsRepository->get_settlment($type);
    }
    public function all_military_affairs_count($type=''){
        $this->Military_affairsRepository->all_military_affairs_count($type);
    }
}
