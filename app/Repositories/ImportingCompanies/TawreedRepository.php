<?php

namespace App\Repositories\ImportingCompanies;

use App\Models\Company;
use App\Models\Mark;
use App\Models\ImportingCompanies\Tawreed\OrdersFiles;
use App\Models\ImportingCompanies\Tawreed\purchase_items;
use App\Models\ImportingCompanies\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Interfaces\ImportingCompanies\TawreedRepositoryInterface;
use App\Models\ImportingCompanies\Tawreed\Cart;
use App\Models\ProductClass;
use App\Models\Showroom\products_items;

class TawreedRepository implements TawreedRepositoryInterface
{
    public function listCompanies()
    {
        $data = Company::with('marks:company_id,name_ar')
            ->select('id', 'name_ar')->get();

        $title = "توريد جديد";
        $breadcrumb = array();
        $breadcrumb[0]['title'] = " الرئيسية";
        $breadcrumb[0]['url'] = route("dashboard");
        $breadcrumb[1]['title'] = "الشركات الموردة ";
        $breadcrumb[1]['url'] = route("products.index");
        $breadcrumb[2]['title'] = $title;
        $breadcrumb[2]['url'] = 'javascript:void(0);';

        $view = 'importingCompanies/Tawreed/index';
        return view(
            'layout',
            compact('title', 'data', 'view', 'breadcrumb')
        );
    }

    public function getCompanyById($companyId)
    {
        return Company::with('marks')->find($companyId);
    }

    public function searchProducts($request, $companyId)
    {
        

        $company = Company::findOrFail($companyId);
        if (!$company) {
            return response()->json(['message' => 'Company not found.'], 404);
        }
        Session::put('company_data', $company);

        $marks = Mark::all();
        $classes = ProductClass::all();

        $title = "البحث";
        $breadcrumb = array();
        $breadcrumb[0]['title'] = " الرئيسية";
        $breadcrumb[0]['url'] = route("dashboard");
        $breadcrumb[1]['title'] = "الشركات الموردة ";
        $breadcrumb[1]['url'] = route("products.index");
        $breadcrumb[2]['title'] = $title;
        $breadcrumb[2]['url'] = 'javascript:void(0);';

        $view = 'importingCompanies.Tawreed.search_form';
        return view(
            'layout',
            compact('title', 'view', 'breadcrumb', 'company', 'marks', 'classes', 'companyId')
        );
    }

    public function searchResults($request, $companyId)
    {
        // $request->validate([
        //     'model' => 'nullable|string|max:255',
        //     'number' => 'nullable|string|max:255',
        //     'mark_id' => 'nullable|exists:marks,id',
        //     'class_id' => 'nullable|exists:classes,id',
        // ]);

        $company = Company::findOrFail($companyId);
        if (!$company) {
            return response()->json(['message' => 'Company not found.'], 404);
        }
        Session::put('company_data', $company);

        // $query = Product::where('company_id', $companyId);
        $query = Product::with('mark','class');


        if ($request->filled('model')) {
            $query->where('model', 'like', "%" . $request->model . "%");
        }

        if ($request->filled('number')) {
            $query->where('number', $request->number);
        }

        if ($request->filled('mark_id')) {
            $query->where('mark_id', $request->mark_id);
        }

        if ($request->filled('class_id')) {
            $query->where('class_id', $request->class_id);
        }

        $results =  $query->get();

        $marks = Mark::all();
        $classes = ProductClass::all();

        $title = "البحث";
        $breadcrumb = array();
        $breadcrumb[0]['title'] = " الرئيسية";
        $breadcrumb[0]['url'] = route("dashboard");
        $breadcrumb[1]['title'] = "الشركات الموردة ";
        $breadcrumb[1]['url'] = route("products.index");
        $breadcrumb[2]['title'] = $title;
        $breadcrumb[2]['url'] = 'javascript:void(0);';

        $view = 'importingCompanies.Tawreed.search_form';
        return view(
            'layout',
            compact('title', 'results', 'view', 'breadcrumb', 'company', 'marks', 'classes', 'companyId')
        );
    }

    public function addToCart($request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
        ]);
        $product = Product::findOrFail($request->product_id);

        $cartItem = new Cart();
        $cartItem->product_id = $product->id;
        // $cartItem->company_id = $product->company_id;
        $cartItem->company_id = Session::get('company_data')->id;

        $cartItem->place = 'showroom';
        $cartItem->counter = 1;
        $cartItem->product_price = $product->price;
        $cartItem->save();

        session()->flash('success', 'تمت إضافة المنتج إلى السلة بنجاح!');
 
        return redirect()->back();
    }

    public function createCart($request)
    {
        $items = Cart::select('product_id','company_id', DB::raw('COUNT(*) as total_count'), DB::raw('SUM(product_price) as total_price'))
            ->groupBy('product_id')
            ->with('product','company')
            ->get();
    
        $title = "سلة المشتريات";
        $breadcrumb = array();
        $breadcrumb[0]['title'] = " الرئيسية";
        $breadcrumb[0]['url'] = route("dashboard");
        $breadcrumb[1]['title'] = "الشركات الموردة ";
        $breadcrumb[1]['url'] = route("products.index");
        $breadcrumb[2]['title'] = $title;
        $breadcrumb[2]['url'] = 'javascript:void(0);';

        $view = 'importingCompanies.Tawreed.cart';
        return view(
            'layout',
            compact('title', 'view', 'breadcrumb', 'items')
        );
    }

    public function deleteFromCart($product_id)
    {
        Cart::where('product_id', $product_id)->delete();

        session()->flash('success', 'تم حذف المنتج من السلة بنجاح.');

        return redirect()->route('tawreed.cart');
    }

    public function clearCart()
    {
        Cart::truncate();

        return redirect()->back()->with('success', 'تم حذف جميع العناصر من السلة بنجاح.');
    }

    public function addToPurchaseOrders()
    {
        $cartItems = Cart::all();

        $groupedItems = $cartItems->groupBy('product_id')->map(function ($items) {
            return [
                'product_id' => $items->first()->product_id,
                'count' => $items->count(), // Count the number of items for this product
                'total_price' => $items->sum('product_price') // Calculate the total price for this product
            ];
        });

        $totalAmount = $groupedItems->sum('total_price');

        $firstItem = $cartItems->first();

        if ($firstItem) {
            $companyId = $firstItem->company_id;
            $place = $firstItem->place;
        } else {
            return redirect()->back()->withErrors('Cart is empty');
        }

        $order = new OrdersFiles();
        $order->order_id = 0;
        $order->company_id = $companyId;
        $order->amount = $totalAmount;
        $order->place = $place;
        $order->created_by = Auth::user()->id;
        $order->updated_by = Auth::user()->id;
        $order->save();

        $orderId = $order->id;
       
        foreach ($groupedItems as $groupedItem) {
            $productItem = new purchase_items();
            $productItem->product_id = $groupedItem['product_id'];
            $productItem->order_id = $orderId;
            $productItem->count = $groupedItem['count'];
            $productItem->save();
        }

        Cart::truncate();

        return redirect()->route('tawreed.index')->with('success', 'تم تحويل طلب الشراء');
    }

    public function getAllPurchaseOrders($request)
    {
        $companies = Company::all();

        $purchaseOrders = OrdersFiles::with(['company', 'purchase'])
            ->where('send_status', null);

        if ($request->filled('order_id')) {
            $purchaseOrders->where('id', $request->order_id);
        }

        if ($request->filled('company_id')) {
            $purchaseOrders->where('company_id', $request->company_id);
        }

        $purchaseOrders = $purchaseOrders->get();

        $title = "طلبات الشراء";
        $breadcrumb = array();
        $breadcrumb[0]['title'] = " الرئيسية";
        $breadcrumb[0]['url'] = route("dashboard");
        $breadcrumb[1]['title'] = "الشركات الموردة ";
        $breadcrumb[1]['url'] = route("products.index");
        $breadcrumb[2]['title'] = $title;
        $breadcrumb[2]['url'] = 'javascript:void(0);';

        $view = 'importingCompanies.Tawreed.purchase_requests';
        return view(
            'layout',
            compact('title', 'purchaseOrders', 'companies', 'view', 'breadcrumb')
        );
    }

    public function sending($request, $id)
    {
        $data = OrdersFiles::findOrFail($id);

        $request->validate([
            'img' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        if ($request->hasFile('img')) {
            $file = $request->file('img');
            $filePath = $file->store('SentPurchaseRequests', 'public');
            $data->img =  $filePath;
            $data->status = 'active';
            $data->send_status = 1;
            $data->sending_user_id = Auth::user()->id;
            $data->send_date = now();
        }
        $data->status = 'active';
        $data->send_status = 1;
        $data->sending_user_id = Auth::user()->id;
        $data->send_date = now();
        $data->save();

        return redirect()->route('tawreed.purchaseOrders')->with('success', 'تم ارسال طلب الشراء');
    }

    public function deletePurchaseOrder($id)
    {
        $order = OrdersFiles::findOrFail($id);
        $order->delete();
        return redirect()->route('tawreed.purchaseOrders')->with('success', 'تم حذف الطلب بنجاح');
    }

    public function PurchaseOrdersArchive($request)
    {
        $companies = Company::all();

        $purchaseOrders = OrdersFiles::with(['company', 'purchase']);
        $purchaseOrders->where('send_status', 1);


        // Filter by order ID if provided
        if ($request->filled('order_id')) {
            $purchaseOrders->where('id', $request->order_id);
        }

        // Filter by company ID if provided
        if ($request->filled('company_id')) {
            $purchaseOrders->where('company_id', $request->company_id);
        }

        $purchaseOrders = $purchaseOrders->get();

        $title = "الأرشيف";
        $breadcrumb = array();
        $breadcrumb[0]['title'] = " الرئيسية";
        $breadcrumb[0]['url'] = route("dashboard");
        $breadcrumb[1]['title'] = "الشركات الموردة ";
        $breadcrumb[1]['url'] = route("products.index");
        $breadcrumb[2]['title'] = $title;
        $breadcrumb[2]['url'] = 'javascript:void(0);';

        $view = 'importingCompanies.Tawreed.purchase_requests_archive';
        return view(
            'layout',
            compact('title', 'purchaseOrders', 'companies', 'view', 'breadcrumb')
        );
    }

    public function print_order_company($order_id)
    {
        $order = purchase_items::with('product')->where('order_id',$order_id)->get();
        
    //    dd($order);
        $title = "المنتجات";
        $breadcrumb = array();
        $breadcrumb[0]['title'] = " ";
        $breadcrumb[0]['url'] = route("dashboard");

        $view = 'importingCompanies/Tawreed/print_order';
        return view(
            'layout',
            compact('title', 'order', 'view', 'breadcrumb','order_id')
        );
    }

    public function print_purchase($id)
    {

    }
}
