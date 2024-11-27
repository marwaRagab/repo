<?php

namespace App\Http\Controllers\Transfer;

use App\Interfaces\Transfer\TransferRepositoryInterface;
use App\Http\Controllers\Controller;
use App\Models\ImportingCompanies\Product;
use App\Models\Showroom\products_items;
use Illuminate\Http\Request;
use App\Models\Log;
use Illuminate\Support\Facades\Auth;

class TransferController extends Controller
{
    protected $transferRepository;

    public function __construct(TransferRepositoryInterface $transferRepository)
    {
        $this->transferRepository = $transferRepository;
    }

    public function get_available_products(Request $request)
    {
        $data = $this->transferRepository->getAvailableProducts();

        if ($data) {
            $user_id =  Auth::user()->id ?? null;
            $message = "تم الدخول لصفحة المنتجات المتاحة ";
            $this->log($user_id, $message);
        }

        return $data;
    }

    public function show_available_products($classId)
    {
        $data = $this->transferRepository->getAvailableProductsByClassId($classId);

        if ($data) {
            $user_id =  Auth::user()->id ?? null;
            $message = "تم عرض المنتجات المتاحة في الصنف {$classId}";
            $this->log($user_id, $message);
        }

        return $data;
    }

    public function delete_available_product($id)
    {
        $data = $this->transferRepository->delete_available_product($id);

        if ($data) {
            $user_id =  Auth::user()->id ?? null;
            $message = "من المنتجات المتاحة {$id} تم ازالة المنتج ";
            $this->log($user_id, $message);
        }

        return $data;
    }
}
