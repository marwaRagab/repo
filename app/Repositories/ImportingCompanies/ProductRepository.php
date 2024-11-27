<?php

namespace App\Repositories\ImportingCompanies;

use App\Models\ImportingCompanies\Product;
use App\Models\ProductClass;
use App\Models\Mark;
use App\Models\Company;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Log;
// use Illuminate\Http\Request;

use App\Http\Requests\ProductsRequest;
use Illuminate\Support\Facades\Auth;
use App\Interfaces\ImportingCompanies\ProductRepositoryInterface;

class ProductRepository implements ProductRepositoryInterface
{
    protected $data;
    public function __construct()
    {
        $this->data['companies'] = Company::where('active', 1)->get();
        $this->data['classes'] = ProductClass::all();
        $this->data['marks'] = Mark::all();
    }

    public function index()
    {
        $products = Product::with('mark','class')->get();

        $totalProducts = $products->count();
        $totalNetPrice = $products->sum('net_price');
        $totalPrice = $products->sum('price');

        $Allcompany = $this->data['companies'];
        $classes = $this->data['classes'];
        $marks = $this->data['marks'];

        $title = "المنتجات";
        $breadcrumb = array();
        $breadcrumb[0]['title'] = " الرئيسية";
        $breadcrumb[0]['url'] = route("dashboard");
        $breadcrumb[1]['title'] = "المنتجات ";
        $breadcrumb[1]['url'] = route("products.index");
        // $breadcrumb[2]['title'] = $title;
        // $breadcrumb[2]['url'] = 'javascript:void(0);';

        $view = 'importingCompanies/products/index2';
        return view(
            'layout',
            compact('title', 'products', 'Allcompany', 'classes', 'marks', 'view', 'breadcrumb', 'totalProducts', 'totalNetPrice', 'totalPrice')
        );
    }

    public function store($request)
    {
        $request->validate([
            'company_id' => 'required|exists:companies,id',
            'mark_id' => 'required|exists:marks,id',
            'class_id' => 'required|exists:classes,id',
            'model' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'net_price' => 'required|numeric|min:0',
            'number_type' => 'required|in:0,1',
            'barcode_number' => 'nullable|string|max:255',
            'serial' => 'nullable|string|max:255',
            'img' => 'nullable|image|mimes:jpg,png,jpeg,gif|max:2048'
        ]);

        $data = new Product();
        $data->company_id = $request->company_id;
        $data->mark_id = $request->mark_id;
        $data->class_id = $request->class_id;
        $data->model = $request->model;
        $data->price = $request->price;
        $data->net_price = $request->net_price;

        if ($request->hasFile('img')) {
            $data->img = $request->file('img')->store('uploads/new_photos', 'public');
        }

        if ($request->barcode_number) {
            $data->number = $request->barcode_number;
        }

        if ($request->serial_number) {
            $data->number = $request->serial_number;
        }

        $data->number_type = $request->number_type;
        $data->created_by = Auth::id();
        $data->save();

        return redirect()->route('products.index')->with('success', 'تمت الاضافة بنجاح.');
    }

    public function update($id, $request)
    {
        $request->validate([
            'company_id' => 'nullable|exists:companies,id',
            'mark_id' => 'nullable|exists:marks,id',
            'class_id' => 'nullable|exists:classes,id',
            'model' => 'nullable|string|max:255',
            'price' => 'nullable|numeric|min:0',
            'net_price' => 'nullable|numeric|min:0',
            'number_type' => 'nullable|in:0,1',
            'barcode_number' => 'nullable|string|max:255',
            'serial' => 'nullable|string|max:255',
            'img' => 'nullable|image|mimes:jpg,png,jpeg,gif|max:2048'
        ]);

        $data = Product::findOrFail($id);
        $data->company_id = $request->company_id;
        $data->mark_id = $request->mark_id;
        $data->class_id = $request->class_id;
        $data->model = $request->model ?? $data->model;
        $data->price = $request->price ?? $data->price;
        $data->net_price = $request->net_price ?? $data->net_price;
        if ($request->hasFile('img')) {
            // Optionally delete old image here if needed
            $data->img = $request->file('img')->store('images', 'public');
        }
        if ($request->barcode_number) {
            $data->number = $request->barcode_number ?? $data->number;
        }

        if ($request->serial_number) {
            $data->number = $request->serial_number ?? $data->number;
        }
        $data->img = $request->img ?? $data->img;
        $data->number_type = $request->number_type ?? $data->number_type;
        $data->updated_by = Auth::id();
        $data->save();

        return redirect()->route('products.index')->with('success', 'تم التعديل بنجاح');
    }

    public function destroy($id)
    {
        $data = Product::findOrFail($id);
        $data->delete();

        return redirect()->route('products.index')->with('success', 'تم الحذف بنجاح');
    }

    public function print_all()
    {
        $products = Product::with('mark','class','productsItems')
        ->whereHas('productsItems', function ($query) {
            $query->groupBy('product_id'); 
        })
        ->get();
    
        $title = "المنتجات";
        $breadcrumb = array();
        $breadcrumb[0]['title'] = " ";
        $breadcrumb[0]['url'] = route("dashboard");

        $view = 'importingCompanies/products/print_all';
        return view(
            'layout',
            compact('title', 'products', 'view', 'breadcrumb')
        );
    }
}
