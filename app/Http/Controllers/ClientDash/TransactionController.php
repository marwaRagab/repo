<?php

namespace App\Http\Controllers\ClientDash;

use App\Http\Controllers\Controller;
use App\Interfaces\Showroom\TransactionRepositoryInterface;
use App\Models\Company;
use App\Models\ImportingCompanies\Product;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Session;



class TransactionController extends Controller
{
    protected $ShowroomRepository;

    public function __construct(TransactionRepositoryInterface $ShowroomRepository)
    {
        $this->ShowroomRepository = $ShowroomRepository;
    }

    public function index()
    {
        
      return $this->ShowroomRepository->getOrders();
        // if($data)
        // {
        //         $message ="تم الدخول الى صفحة استلام البضاعة ";
        //         // $this->log(Auth::user()->id,$message);
        // }
        // return $this->respondSuccess($data, 'Get Data successfully.');

    }

    public function updateOrder(Request $request, $id)
    {
        
        return $this->ShowroomRepository->updateOrder($request, $id);
        // if($data)
        // {
        //         $message ="تم الدخول الى صفحة  استلام المنتجات";
        //         // $this->log(Auth::user()->id,$message);
        // }
        // return $this->respondSuccess($data, 'Adding Data successfully.');
    }
    public function getAll()
    {
        return $this->ShowroomRepository->getAll();
    }

    public function show_serial($id)
    {
        return $this->ShowroomRepository->show_serial($id);
    }
    public function add_serial(Request $request, $id)
    {
        return $this->ShowroomRepository->add_serial($request, $id);
    }

   
}
