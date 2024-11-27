<?php

namespace App\Http\Controllers\Military_affairs;

use App\Http\Controllers\Controller;
use App\Interfaces\Military_affairs\PapersRepositoryInterface;
use Illuminate\Http\Request;

class PapersController extends Controller
{
    protected $PapersRepository;
    //protected $log_object;

    public function __construct(PapersRepositoryInterface $PapersRepository, Controller $log_object)
    {

        $this->PapersRepository = $PapersRepository;
        //      $this->log_object = $log_object;
    }

    public function index()
    {
        return $this->PapersRepository->index($id);

    }
    public function eqrar_not_received()
    {
        return $this->PapersRepository->eqrar_not_received();
    }
    public function get_count_eqrar_dain($slug = null)
    {
        return $this->PapersRepository->get_count_eqrar_dain($slug);
    }
   
    public function to_open_file(Request $request)
    {

        return $this->PapersRepository->to_open_file($request);
    }

    public function eqrar_received()
    {

        return $this->PapersRepository->eqrar_received();
    }

    public function to_eqrar_dain(Request $request)
    {

        return $this->PapersRepository->to_eqrar_dain($request);
    }
    public function nmozag_eqrar($id)
    {
        return $this->PapersRepository->nmozag_eqrar($id);
    }

}
