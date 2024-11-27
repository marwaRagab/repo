<?php

namespace App\Repositories\ImportingCompanies;

use App\Interfaces\ImportingCompanies\TransferProductRepositoryInterface;
use App\Models\Branch;
use App\Models\ImportingCompanies\Product;
use App\Models\ProductClass;
use App\Models\Showroom\products_items;
use App\Models\TransferBranch;
use App\Models\TransferBranchItem;
use App\Models\TransferCart;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class TransferProductRepository implements TransferProductRepositoryInterface
{
    public function index()
    {
        $allProducts =  Product::with(['productsItems' => function ($query) {
            $query->where('available', 1)->where('branch_id', Auth::user()->branch_id ?? '');
        }, 'productsItems.product.class'])
            ->whereHas('productsItems', function ($query) {
                $query->where('available', 1)->where('branch_id', Auth::user()->branch_id ?? '');
            })
            ->get()
            ->groupBy('class_id')
            ->map(function ($products, $classId) {
                return [
                    'class_name' => $products->first()->class->name_ar,
                    'class_id' => $classId,
                    'count_prods' => $products->sum(function ($product) {
                        return $product->productsItems->count();
                    }),
                    'products' => $products
                ];
            })
            ->filter();

        $view = 'importingCompanies.TransferProducts.index';
        $title = 'المنتجات المتوفرة';
        $breadcrumb = array();
        $breadcrumb[0]['title'] = " الرئيسية";
        $breadcrumb[0]['url'] = route("dashboard");
        $breadcrumb[1]['title'] = "المنتجات";
        $breadcrumb[1]['url'] = route("dashboard");
        $breadcrumb[2]['title'] = $title;
        $breadcrumb[2]['url'] = 'javascript:void(0);';

        return view('layout', compact('allProducts', 'view', 'breadcrumb'));
    }

    public function getAvailableProductsByClassId($classId)
    {
        $items = products_items::with('product')->where('available', 1)
             ->where('branch_id', Auth::user()->branch_id ?? '')
            ->whereHas('product', function ($query) use ($classId) {
                $query->where('class_id', $classId);
            })->get();

        $view = 'importingCompanies.TransferProducts.showProducts';
        $title = 'تفاصيل المنتجات المتوفرة';
        $breadcrumb = array();
        $breadcrumb[0]['title'] = " الرئيسية";
        $breadcrumb[0]['url'] = route("Transfer.getAvailableProducts");
        $breadcrumb[1]['title'] = " المنتجات المتوفرة";
        $breadcrumb[1]['url'] = route("dashboard");
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

    //Cart

    public function addToCart($request)
    {
        $request->validate([
            'product_item_id' => 'required|exists:products_items,id',
        ]);

        $productItem = products_items::findOrFail($request->product_item_id);

        $transferCart = new TransferCart();
        $transferCart->product_item_id = $request->product_item_id;
        $transferCart->product_id = $productItem->product->id;
        $transferCart->branch_id = $productItem->branch_id;
        $transferCart->model = $productItem->product->model;
        $transferCart->company_name = $productItem->product->company->name_ar;
        $transferCart->number = $productItem->product->number ? $productItem->product->number : $productItem->serial_number;
        $transferCart->description = $productItem->product->description;

        $transferCart->save();


        session()->flash('success', 'تمت إضافة المنتج إلى السلة بنجاح!');

        return redirect()->back();
    }

    public function viewCart()
    {
        $cart = TransferCart::all();
        $branches = Branch::all();
        $users = User::all();

        $title = "سلة المشتريات";
        $breadcrumb = array();
        $breadcrumb[0]['title'] = " الرئيسية";
        $breadcrumb[0]['url'] = route("dashboard");
        $breadcrumb[1]['title'] = "الشركات الموردة ";
        $breadcrumb[1]['url'] = route("products.index");
        $breadcrumb[2]['title'] = $title;
        $breadcrumb[2]['url'] = 'javascript:void(0);';

        $view = 'importingCompanies.TransferProducts.transferCart';
        return view(
            'layout',
            compact('title', 'view', 'breadcrumb', 'cart', 'branches', 'users')
        );
    }

    public function deleteFromCart($id)
    {

        TransferCart::where('id', $id)->delete();

        session()->flash('success', 'تم حذف المنتج من السلة بنجاح.');

        return redirect()->back();
    }

    public function transfer($request)
    {
        $cart = TransferCart::all();

        $groupedItems = $cart->groupBy('product_item_id')->map(function ($items) {
            return [
                'count' => $items->count(),
                'product_item_id' => $items->first()->product_item_id
            ];
        });

        $request->validate([
            'transport_id' => 'required|exists:users,id',
            'branch_id' => 'required|exists:branches,id',
            'img' => 'nullable|image|mimes:jpg,png,jpeg,gif|max:2048'
        ]);

        $firstItem = $cart->first();
        $oldBranch =  $firstItem->branch_id;

        $transfer = new TransferBranch();
        $transfer->from_branch_id = $oldBranch;
        $transfer->to_branch_id = $request->branch_id;
        if ($request->hasFile('img')) {
            $transfer->transport_img_dir = $request->file('img')->store('uploads/new_photos', 'public');
        }
        $transfer->received = 0;
        $transfer->user_id = Auth::user()->id;
        $transfer->transport_id = $request->transport_id;
        $transfer->date = now();
        $transfer->save();

        $transferId = $transfer->id;

        foreach ($groupedItems as $groupedItem) {
            $productItem = products_items::find($groupedItem['product_item_id']);

            if ($productItem) {
                $productItem->branch_id = $request->branch_id;
                $productItem->save();
            }
            $transferItem = new TransferBranchItem();
            $transferItem->transfer_id = $transferId;
            $transferItem->products_items_id = $groupedItem['product_item_id'];
            $transferItem->save();
        }

        TransferCart::truncate();

        session()->flash('success', 'تم نقل المنتجات بنجاح');
        return redirect()->route('transferProduct.index');
    }
}
