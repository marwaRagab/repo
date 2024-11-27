<?php

namespace App\Http\Controllers\ImportingCompanies;

use App\Http\Controllers\Controller;
use App\Interfaces\ImportingCompanies\TawreedRepositoryInterface;
use App\Models\Company;
use App\Models\Log;
use App\Models\ImportingCompanies\Tawreed\OrdersFiles;
use App\Models\ImportingCompanies\Product;
use App\Models\Log as ModelsLog;
use App\Models\Mark;
use App\Models\ProductClass;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Auth;

class TawreedController extends Controller
{
    protected $tawreedRepository;

    public function __construct(TawreedRepositoryInterface $tawreedRepository)
    {
        $this->tawreedRepository = $tawreedRepository;
    }

    public function index()
    {
        $data = $this->tawreedRepository->listCompanies();

        if ($data) {
            $user_id =  Auth::user()->id ?? null;
            $message = "تم الدخول لصفحة توريد جديد ";
            $this->log($user_id, $message);
        }

        return $data;
    }

    public function searchForm(Request $request, $companyId)
    {
        $data = $this->tawreedRepository->searchProducts($request, $companyId);

        if ($data) {
            $user_id =  Auth::user()->id ?? null;
            $message = " تم الدخول لصفحة البحث عن منتجات لشركة {$companyId}";
            $this->log($user_id, $message);
        }

        return $data;
    }

    public function searchResults(Request $request, $companyId)
    {
        return $this->tawreedRepository->searchResults($request, $companyId);
    }
    public function addToCart(Request $request)
    {

        $data = $this->tawreedRepository->addToCart($request);

        if ($data) {
            $user_id =  Auth::user()->id ?? null;
            $message = " تم اضافة المنتج  {$request->product_id} لسلة المشتريات";
            $this->log($user_id, $message);
        }

        return $data;
    }

    public function createCart(Request $request)
    {
        $data = $this->tawreedRepository->createCart($request);

        if ($data) {
            $user_id =  Auth::user()->id ?? null;
            $message = "تم الدخول لصفحة سلة المشتريات ";
            $this->log($user_id, $message);
        }

        return $data;
    }

    public function deleteProductFromCart($product_id)
    {
        $data = $this->tawreedRepository->deleteFromCart($product_id);

        if ($data) {
            $user_id =  Auth::user()->id ?? null;
            $message = " تم حذف المنتج  {product_id} من سلة المشتريات";
            $this->log($user_id, $message);
        }

        return $data;
    }

    public function clearCart()
    {
        $data = $this->tawreedRepository->clearCart();

        if ($data) {
            $user_id =  Auth::user()->id ?? null;
            $message = " تم افراغ سلة المشتريات";
            $this->log($user_id, $message);
        }

        return $data;
    }

    public function addToPurchaseOrders()
    {
        $data = $this->tawreedRepository->addToPurchaseOrders();

        if ($data) {
            $user_id =  Auth::user()->id ?? null;
            $message = " تم تحويل طلب شراء";
            $this->log($user_id, $message);
        }

        return $data;
    }

    public function purchaseOrders(Request $request)
    {
        $data = $this->tawreedRepository->getAllPurchaseOrders($request);

        if ($data) {
            $user_id =  Auth::user()->id ?? null;
            $message = "تم الدخول لصفحة طلبات الشراء ";
            $this->log($user_id, $message);
        }

        return $data;
    }


    public function sending(Request $request, $id)
    {
        $data = $this->tawreedRepository->sending($request, $id);

        if ($data) {
            $user_id =  Auth::user()->id ?? null;
            $message = " تم ارسال طلب الشراء  {$id}";
            $this->log($user_id, $message);
        }

        return $data;
    }

    public function deletePurchaseOrder($id)
    {
        $data = $this->tawreedRepository->deletePurchaseOrder($id);

        if ($data) {
            $user_id =  Auth::user()->id ?? null;
            $message = " تم حذف طلب الشراء  {$id}";
            $this->log($user_id, $message);
        }

        return $data;
    }

    public function PurchaseOrdersArchive(Request $request)
    {
        $data = $this->tawreedRepository->PurchaseOrdersArchive($request);

        if ($data) {
            $user_id =  Auth::user()->id ?? null;
            $message = "تم الدخول لصفحة ارشيف طلبات الشراء ";
            $this->log($user_id, $message);
        }

        return $data;
    }
    public function print_order_company($order_id)
    {
        return $this->tawreedRepository->print_order_company($order_id);
    }
    
     public function print_purchase($order_id)
    {
        return $this->tawreedRepository->print_purchase($order_id);
    }
}
