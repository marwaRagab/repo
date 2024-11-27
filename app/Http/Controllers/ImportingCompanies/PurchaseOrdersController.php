<?php

namespace App\Http\Controllers\ImportingCompanies;

use App\Http\Controllers\Controller;
use App\Interfaces\ImportingCompanies\PurchaseOrdersRepositoryInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PurchaseOrdersController extends Controller
{
    protected $purchaseOrdersRepository;
    public function __construct(PurchaseOrdersRepositoryInterface $purchaseOrdersRepository)
    {
        $this->purchaseOrdersRepository = $purchaseOrdersRepository;
    }
    public function index(Request $request)
    {
        $data = $this->purchaseOrdersRepository->index($request);

        if ($data) {
            $user_id =  Auth::user()->id ?? null;
            $message = "تم الدخول لصفحة طلبات الشراء ";
            $this->log($user_id, $message);
        }

        return $data;
    }
    public function showOrderProducts($id)
    {
        $data = $this->purchaseOrdersRepository->showOrderProducts($id);

        if ($data) {
            $user_id =  Auth::user()->id ?? null;
            $message = "تم الدخول لصفحة منتجات طلب الشراء ";
            $this->log($user_id, $message);
        }

        return $data;
    }

    public function sending(Request $request, $id)
    {
        $data = $this->purchaseOrdersRepository->sending($request, $id);

        if ($data) {
            $user_id =  Auth::user()->id ?? null;
            $message = "تم ارسال طلب شراء ";
            $this->log($user_id, $message);
        }

        return $data;
    }

    public function destroy($id)
    {
        $data = $this->purchaseOrdersRepository->destroy($id);

        if ($data) {
            $user_id =  Auth::user()->id ?? null;
            $message = "تم حذف طلب شراء";
            $this->log($user_id, $message);
        }

        return $data;
    }
    public function print_invoice($order_id)
    {
        return $this->purchaseOrdersRepository->print_invoice($order_id);
    }
}
