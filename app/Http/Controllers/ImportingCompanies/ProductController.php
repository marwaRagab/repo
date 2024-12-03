<?php

namespace App\Http\Controllers\ImportingCompanies;

use App\Http\Controllers\Controller;
use App\Interfaces\ImportingCompanies\ProductRepositoryInterface;
use App\Models\ImportingCompanies\Product;
use Illuminate\Http\Request;
// use App\Http\Requests\ProductsRequest;

use Illuminate\Support\Facades\Auth;

class ProductController extends Controller
{
    protected $productRepository;
    public function __construct(ProductRepositoryInterface $productRepository)
    {
        $this->productRepository = $productRepository;
    }

    public function index()
    {
        $data = $this->productRepository->index();

        if ($data) {
            $user_id = Auth::user()->id ?? null;
            $message = "تم الدخول لصفحة المنتجات ";
            $this->log($user_id, $message);
        }

        return $data;
    }
    public function store(Request $request)
    {
        $data = $this->productRepository->store($request);

        if ($data) {
            $user_id = Auth::user()->id ?? null;
            $message = "تم اضافة منتج {$request->model} ";
            $this->log($user_id, $message);
        }

        return $data;
    }

    public function update($id, Request $request)
    {
        $data = $this->productRepository->update($id, $request);

        if ($data) {
            $user_id = Auth::user()->id ?? null;
            $message = "تم تحديث منتج {$request->model} ";
            $this->log($user_id, $message);
        }

        return $data;
    }

    public function destroy($id)
    {
        $data = $this->productRepository->destroy($id);

        if ($data) {
            $user_id = Auth::user()->id ?? null;
            $message = "تم حذف منتج";
            $this->log($user_id, $message);
        }

        return $data;
    }

    public function getProductsData()
    {
        return $this->productRepository->getProductsData();

    }

    public function getProductDetailsByNumber(Request $request)
    {
        $request->validate([
            'barcode' => 'nullable|string',
            'serial' => 'nullable|string',
        ]);

        // Retrieve product based on either barcode or serial
        $product = null;

        if ($request->has('barcode')) {
            $product = Product::with(['productsItems' => function ($query) {
                $query->where('available', 1);
            }])->where('number_type', 1)->where('number', $request->barcode)->first();
        } elseif ($request->has('serial')) {
            $product = Product::with(['productsItems' => function ($query) {
                $query->where('available', 1);
            }])->where('number_type', 2)->where('number', $request->serial)->first();
            // Product::where('serial_number', $request->serial)->first();
        }

        // Check if product was found
        if ($product) {
            return response()->json([
                'success' => true,
                'product' => [
                    'id' => $product->id,
                    'model' => $product->model,
                    'number' => $product->number,
                    // 'serial_number' => $product->serial_number,
                    'cost' => $product->net_price,
                    'price' => $product->price,
                ],
            ]);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Product not found',
            ]);
        }
    }

    public function print_all()
    {
        return $this->productRepository->print_all();
    }
}
