<?php

namespace App\Http\Controllers\Payments;

use App\Http\Controllers\Controller;
use App\Interfaces\Military_affairs\Open_fileRepositoryInterface;
use App\Interfaces\Military_affairs\Stop_bankRepositoryInterface;
use App\Interfaces\Military_affairs\Stop_travelRepositoryInterface;
use App\Interfaces\Payments\PaymentsRepositoryInterface;
use App\Models\Governorate;
use App\Models\Military_affairs;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\DataTables;

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

    public function all_checks_index(Request $request)
    {
        // dd("dd");
        return $this->paymentRepository->all_checks_index($request);


    }


}
