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
        // dd("dd");
        return $this->paymentRepository->index($request);


    }

    public function getPaymentsData()
    {
        return $this->paymentRepository->getPaymentsData();

    }

    public function all_checks_index(Request $request)
    {
        // dd("dd");
        return $this->paymentRepository->all_checks_index($request);


    }


}
