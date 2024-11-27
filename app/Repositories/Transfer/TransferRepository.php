<?php

namespace App\Repositories\Transfer;

use App\Interfaces\Transfer\TransferRepositoryInterface;
use App\Models\ImportingCompanies\Product;
use App\Models\ProductClass;
use App\Models\Showroom\products_items;
use Illuminate\Support\Facades\Auth;


class TransferRepository implements TransferRepositoryInterface
{
    public function getAvailableProducts()
    {
        // dd(Auth::user()->branch_id);
        $allProducts =  Product::with(['productsItems' => function ($query) {
            $query->where('available', 1)->where('branch_id', Auth::user()->branch_id ?? '');
        }, 'productsItems.product.class'])
            ->whereHas('productsItems', function ($query) {
                $query->where('available', 1)->where('branch_id', Auth::user()->branch_id ??'');
            })
            ->get()
            ->groupBy('class_id')
            ->map(function ($products, $classId) {
                return [
                    'class_name' => $products->first()->class->name_ar,
                    'class_id' => $classId,
                    'count_prods' => $products->sum(function ($product)   {
                        return $product->productsItems->count();
                    }),
                    'products' => $products,
                    'sum_pro' => $products->sum(function ($product)  {
                        return  $product->counte;
                    }),
                ];
            })
            ->filter();
    //   dd($allProducts);
        $view = 'transfer.available-products.index';
        $title = 'المنتجات المتوفرة';
        $breadcrumb = array();
        $breadcrumb[0]['title'] = " الرئيسية";
        $breadcrumb[0]['url'] = route("dashboard");
        $breadcrumb[1]['title'] = "المنتجات";
        $breadcrumb[1]['url'] = route("products.index");
        $breadcrumb[2]['title'] = $title;
        $breadcrumb[2]['url'] = 'javascript:void(0);';

        return view('layout', compact('allProducts', 'view', 'breadcrumb'));
    }

    public function getAvailableProductsByClassId($classId)
    {
        
        $items = products_items::with('product')->where('available', 1)
            ->whereHas('product', function ($query) use ($classId) {
                $query->where('class_id', $classId);
            })->where('branch_id', Auth::user()->branch_id ?? '')->get();
           
        $view = 'transfer.available-products.show_available_products';
        $title = 'تفاصيل المنتجات المتوفرة';
        $breadcrumb = array();
        $breadcrumb[0]['title'] = " الرئيسية";
        $breadcrumb[0]['url'] = route("Transfer.getAvailableProducts");
        $breadcrumb[1]['title'] = " المنتجات المتوفرة";
        $breadcrumb[1]['url'] = route("products.getByNumber");
        $breadcrumb[2]['title'] = $title;
        $breadcrumb[2]['url'] = 'javascript:void(0);';

        return view('layout', compact('items', 'view', 'breadcrumb'));
    }

    public function delete_available_product($id)
    {
        $productItem = products_items::find($id);

        if ($productItem) {
            $productItem->available = 0;
            $productItem->save();

            session()->flash('message', 'تم ازالة المنتج من المنتجات المتاحة');
        } else {
            session()->flash('error', 'لم يتم العثورعلى هذا المنتج');
        }

        return redirect()->back();
    }
}
