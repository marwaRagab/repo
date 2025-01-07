<?php

namespace App\Http\Controllers\Payments;

use App\Models\Governorate;
use Illuminate\Http\Request;
use App\Models\Military_affairs;
use Yajra\DataTables\DataTables;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Interfaces\Payments\PaymentsRepositoryInterface;
use App\Interfaces\Military_affairs\Open_fileRepositoryInterface;
use App\Interfaces\Military_affairs\Stop_bankRepositoryInterface;
use App\Interfaces\Military_affairs\Stop_travelRepositoryInterface;

class PaymentsController extends Controller
{
    //
    protected $paymentRepository;

    public function __construct(PaymentsRepositoryInterface $paymentRepository)
    {
        $this->paymentRepository = $paymentRepository;
    }


    public function index(Request $request)
    {
        //
        return $this->paymentRepository->index($request);

    }

    public function getPaymentsData(Request $request)
    {
        return $this->paymentRepository->getPaymentsData($request);

    }
    public function invoices_installment_index(Request $request)
    {
        //
        return $this->paymentRepository->invoices_installment_index($request);


    }



    public function print_invoice($invoice_id,$installment_id,$id,$serial)
    {
        // dd("dd");
        return $this->paymentRepository->print_invoice($invoice_id,$installment_id,$id,$serial);


    }
    public function set_archief($id)
    {

        return $this->paymentRepository->set_archief($id);


    }
    public function archieve_all($ids)
    {

        return $this->paymentRepository->archieve_all($ids);


    }

    public function print_all($ids,$allserials)
    {

        return $this->paymentRepository->print_all($ids,$allserials);


    }

    public function get_invoices_papers(Request $request)
    {

        return $this->paymentRepository->get_invoices_papers($request);


    }

    public function export_all(){
        return $this->paymentRepository->export_all();

    }
    public function print_invoice_export($id1,$id2){
        return $this->paymentRepository->print_invoice_export($id1,$id2);

    }

    // collect_affairs
    public function collect_affairs(Request $request)
    {
        //
        return $this->paymentRepository->collect_affairs($request);

    }

    public function getcollect_affairsData(Request $request)
    {
        return $this->paymentRepository->getcollect_affairsData($request);

    }




}
