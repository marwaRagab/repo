<?php

namespace App\Repositories\ImportingCompanies;

use App\Interfaces\ImportingCompanies\PurchaseOrdersRepositoryInterface;
use App\Models\Company;
use App\Models\ImportingCompanies\Tawreed\OrdersFiles;
use App\Models\ImportingCompanies\Tawreed\purchase_items;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Support\Facades\Auth;

class PurchaseOrdersRepository implements PurchaseOrdersRepositoryInterface
{

    public function index($request)
    {
        if ($request->ajax()) {
            // Fetch data for DataTable
            $purchaseOrders = Order::with(['client', 'order_item'])
                ->where('status', 'finished')
                ->where('archived', 0)
                ->where('sending', 'no')
                ->when($request->order_id, function ($query) use ($request) {
                    $query->where('id', $request->order_id);
                })
                ->when($request->company_id, function ($query) use ($request) {
                    $query->where('company_id', $request->company_id);
                });

            return datatables()
                ->eloquent($purchaseOrders)
                ->addColumn('client_name', function ($order) {
                    return $order->client->name_ar ?? '';
                })
                ->addColumn('products_count', function ($order) {
                    return $order->order_item->count();
                })
                ->addColumn('invoice_value', function ($order) {
                    return number_format($order->order_item->sum('price_qabila'), 3);
                })
                ->addColumn('order_products', function ($order) {
                    return '<a class="text-info" href="' . route('orders.products', $order->id) .'"> منتجات طلب الشراء</a>'; 
                })
                ->addColumn('actions', function ($order) {
                    return view('importingCompanies.Orders.partials.actions', compact('order'))->render();
                })
                ->rawColumns(['order_products','actions'])
                ->addIndexColumn()
                ->make(true);
        }

        $title = "طلبات الشراء";

        $breadcrumb = array();
        $breadcrumb[0]['title'] = " الرئيسية";
        $breadcrumb[0]['url'] = route("dashboard");
        // $breadcrumb[1]['title'] = "الشركات الموردة ";
        // $breadcrumb[1]['url'] = route("products.index");
        $breadcrumb[2]['title'] = $title;
        $breadcrumb[2]['url'] = 'javascript:void(0);';

        $companies = Company::all();
        $view = 'importingCompanies.Orders.index';
        return view(
            'layout',
            compact('title', 'view', 'breadcrumb', 'companies')
        );
    }

    public function showOrderProducts($id)
    {
        $items = OrderItem::with('product_order_items')->where('order_id', $id)->groupBy('id')->get();
        $productsCount = OrderItem::where('order_id', $id)->sum('counter');
        
        $title = "منتجات طلب الشراء";
        $breadcrumb = array();
        $breadcrumb[0]['title'] = " الرئيسية";
        $breadcrumb[0]['url'] = route("dashboard");
        $breadcrumb[1]['title'] = "طلبات الشراء ";
        $breadcrumb[1]['url'] = route("orders.index");
        $breadcrumb[2]['title'] = $title;
        $breadcrumb[2]['url'] = 'javascript:void(0);';

        $view = 'importingCompanies.Orders.order_products';
        return view(
            'layout',
            compact('title', 'view', 'breadcrumb', 'items', 'productsCount')
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
            $data->img = '/storage/' . $filePath;
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

        return redirect()->route('orders.index')->with('success', 'تم ارسال طلب الشراء');
    }

    public function destroy($id)
    {
        $order = OrdersFiles::findOrFail($id);
        $order->delete();
        return redirect()->route('orders.index')->with('success', 'تم حذف الطلب بنجاح');
    }

    public function print_invoice($order_id)
    {
        $order = Order::with('client')->findORFail($order_id);

        //    dd($order);
        $title = "المنتجات";
        $breadcrumb = array();
        $breadcrumb[0]['title'] = " ";
        $breadcrumb[0]['url'] = route("dashboard");

        $view = 'importingCompanies/Orders/print_invoice';
        return view(
            'layout',
            compact('title', 'order', 'view', 'breadcrumb', 'order_id')
        );
    }

}