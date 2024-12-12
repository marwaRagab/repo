<?php

namespace App\Http\Controllers\Military_affairs;

use App\Http\Controllers\Controller;
use App\Interfaces\Military_affairs\Open_fileRepositoryInterface;
use App\Models\Governorate;
use App\Models\Military_affairs;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\DataTables;

class Open_fileController extends Controller
{
    //
    protected $OpenFileRepository;
    public function __construct(Open_fileRepositoryInterface $OpenFileRepository)
    {
        $this->OpenFileRepository = $OpenFileRepository;
    }
    public function index(Request $request)
    {

        // dd(update_responsible(31,17,'execute'));

      return $this->OpenFileRepository->index($request);


    }
    public function convert_to_execute(Request $request)
    {
         return $this->OpenFileRepository->convert_to_execute($request);
    }

     public function index_case_proof (Request $request)
    {

        return $this->OpenFileRepository->index_case_proof($request);


    }
    public function return_to_lated(Request $request){
        return $this->OpenFileRepository->return_to_lated($request);

    }
    public function add_notes(Request $request)
    {

        return $this->OpenFileRepository->add_notes($request);


    }



    public function convert_ex_alert(Request $request)
    {
        return $this->OpenFileRepository->convert_ex_alert($request);
    }





}
