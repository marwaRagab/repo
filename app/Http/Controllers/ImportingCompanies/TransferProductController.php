<?php

namespace App\Http\Controllers\ImportingCompanies;

use App\Http\Controllers\Controller;
use App\Interfaces\ImportingCompanies\TransferProductRepositoryInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TransferProductController extends Controller
{
    protected $transferProductRepository;

    public function __construct(TransferProductRepositoryInterface $transferProductRepository)
    {
        $this->transferProductRepository = $transferProductRepository;
    }

    public function index()
    {
        $data = $this->transferProductRepository->index();

        if ($data) {
            $user_id =  Auth::user()->id ?? null;
            $message = "تم الدخول لصفحة نقل المنتجات ";
            $this->log($user_id, $message);
        }

        return $data;
    }
    public function getAvailableProductsByClassId($classId)
    {
        $data = $this->transferProductRepository->getAvailableProductsByClassId($classId);

        if ($data) {
            $user_id =  Auth::user()->id ?? null;
            $message = "تم الدخول لصفحة نقل المنتجات ";
            $this->log($user_id, $message);
        }

        return $data;
    }

    //Cart

    public function addToCart(Request $request)
    {

        $data = $this->transferProductRepository->addToCart($request);

        if ($data) {
            $user_id =  Auth::user()->id ?? null;
            $message = " تم اضافة المنتج  {$request->product_id} لسلة المشتريات";
            $this->log($user_id, $message);
        }

        return $data;
    }

    public function viewCart()
    {
        $data = $this->transferProductRepository->viewCart();

        if ($data) {
            $user_id =  Auth::user()->id ?? null;
            $message = "تم الدخول لصفحة سلة المشتريات ";
            $this->log($user_id, $message);
        }

        return $data;
    }

    public function deleteFromCart($id)
    {
        $data = $this->transferProductRepository->deleteFromCart($id);

        if ($data) {
            $user_id =  Auth::user()->id ?? null;
            $message = " تم حذف المنتج  {product_id} من سلة المشتريات";
            $this->log($user_id, $message);
        }

        return $data;
    }

    public function transfer(Request $request)
    {
        $data = $this->transferProductRepository->transfer($request);

        if ($data) {
            $user_id =  Auth::user()->id ?? null;
            $message = " تم نقل منتجات";
            $this->log($user_id, $message);
        }

        return $data;
    }
}
