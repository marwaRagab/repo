<?php

namespace App\Repositories\Showroom;

use App\Models\Company;
use App\Models\Mark;
use App\Models\Log;

use App\Http\Controllers\Controller;

use App\Models\ImportingCompanies\Tawreed\OrdersFiles;
use App\Models\ImportingCompanies\Tawreed\purchase_items;
use App\Models\Showroom\products_items;
use App\Models\ImportingCompanies\Product;
use App\Models\Showroom\products_delivery;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Interfaces\Showroom\ShowroomRepositoryInterface;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Validator;


class ShowroomRepository implements ShowroomRepositoryInterface
{
    public function getOrders()
    {

        $message = "تم عرض صفحة استلام البضاعة     ";
        $title = 'استلام البضاعة  ';

        //  $this->log(Auth::user()->id ?? 0,$message); 
        // $user_id =  Auth::user()->id;

        $all_orders = OrdersFiles::with('company', 'purchase')
            ->where('orders_files.received', 0)
            ->where('orders_files.send_status', 1)
            ->where('orders_files.place', 'showroom')
            ->where('orders_files.status', 'active')
            ->where('orders_files.order_id', 0)
            // ->select('orders_files.id', 'name_ar', 'place')
            ->get();
            
        // dd($all_orders);

        $view = 'showroom.recieving'; 
        $breadcrumb = array();
        $breadcrumb[0]['title'] = " الرئيسية";
        $breadcrumb[0]['url'] = route("dashboard");
        $breadcrumb[1]['title'] = "مخزن المعرض";
        $breadcrumb[1]['url'] = route("shoowroom.index");
        $breadcrumb[2]['title'] = $title;
        $breadcrumb[2]['url'] = 'javascript:void(0);';

        return view('layout', compact('title', 'view', 'all_orders', 'breadcrumb'));
    }

    public function getAll()
    {
        $data = OrdersFiles::join('companies', 'companies.id', '=', 'orders_files.company_id')
            ->where('orders_files.company_id', 'company.id')
            ->where('orders_files.received', 0)
            ->where('orders_files.send_status', 1)
            ->where('orders_files.place', 'showroom')
            ->where('orders_files.status', 'active')
            ->where('orders_files.order_id', 0)
            ->select('orders_files.id', 'name_ar', 'place')->get();
        //    dd($data);
        // if ($request->ajax()) {
        //     $data = Company::select('*');
        return DataTables::of($data)->toJson();
        // }
    }

    public function updateOrder($request, $id)
    {
        
        $data = purchase_items::with('product','order_file')
                                ->where('purchase_orders_items.order_id', $request->order_id)
                                ->get();
        // $new_items = products_items::with('product','ordersFiles')
        //                             ->where('purchase_id', $id)
        //                             ->get(); 
            
        $purchase = OrdersFiles::findORFail($id); 

        if ($purchase->received == 1) {
            return redirect()->back()->with('message', 'تم الاستلام من قبل');
        }
       
        foreach ($data as $one) {
           
            $messages = [
                'counter_received_'.$one->id.'.required' => 'العدد  مطلوب.',
                'receiving_'.$one->id.'.required' => 'الاستلام مطلوبة.',
            ];
    
            $validatedData = Validator::make($request->all(), [
                'counter_received_'.$one->id => 'required',
                'receiving_'.$one->id => 'required',
                
            ], $messages);
    
            if ($validatedData->fails()) {
    
                return redirect()->back()->withErrors($validatedData)->withInput();
            }
            else
            { 
               
                // $receiving = $request->input('receiving_'.$one['id']);
                $price = products_items::where('purchase_id', $request->order_id)->get();
                $total = $price->sum('final_price');
        
                OrdersFiles::where('id', $request->order_id)
                    ->update([
                        'received_user_id' => Auth::user()->id ?? 0,
                        'received' => 1,
                        'amount' =>  $total
                    ]);
                 $one->counter_received = $request->input('counter_received_'.$one['id']);
                
                $mmm['counter_received'] = $request->input('counter_received_'.$one['id']);
                $mmm['cancel'] = 0;

                $one->update($mmm);
                
                for($i=0; $i< $one->counter_received ;$i++)
                {
                   
                    $items = new products_items();
                    $items->purchase_id = $request->order_id;
                    $items->product_id = $one->product_id;
                    $items->final_price = $one->product->net_price;
                    $items->place = 'showroom';
                    $items->branch_id = Auth::user()->branch_id ?? '';

                    if ($purchase->order_id > 0) {
                        $items->available = 0;
                    } else {
                        $items->available = 1;
                    }
                    $items->save();
                } 
                return redirect()->route('shoowroom.index')->with('message', 'تم الاستلام بنجاح');

            }     
        }

        foreach($data as $prod)
                {
                    if ($prod->product->class_id == 63) { //the class id of iphone
                        //    return  $this->add_serial($request, $id); 
                        return redirect()->to('showroom/show_serial/' . $id);
                    } else {
                        $prod->update([
                            'counter_received' => 0,
                            'cancel' => 1,
                        ]);
                    }
                }
    }

    public function show_serial($id)
    {
       
        $new_items = products_items::with('product', 'ordersFiles')
            ->where('purchase_id', $id)
            ->get();
           
            // dd($new_items);
        $title = 'استلام البضاعة  ';
        $view = 'showroom.add_serial';
        $breadcrumb = array();
        $breadcrumb[0]['title'] = " الرئيسية";
        $breadcrumb[0]['url'] = route("dashboard");
        $breadcrumb[1]['title'] = "مخزن المعرض";
        $breadcrumb[1]['url'] = route("shoowroom.index");
        $breadcrumb[2]['title'] = $title;
        $breadcrumb[2]['url'] = 'javascript:void(0);';

        return view('layout', compact('title', 'view', 'breadcrumb', 'id', 'new_items'));
    }
    public function add_serial($request, $id)
    {
        // $data = purchase_items::with('product','order_file')
        //                         ->where('purchase_orders_items.order_id', $request->order_id)
        //                         ->get();
        
            $new_items = products_items::with('product', 'ordersFiles')
            ->where('purchase_id', $id)
            ->get();
            foreach ($new_items as $prod_item) {
                $messages = [
                    'serial_number_'.$prod_item->id.'.required' => 'السريال  مطلوب.',
                    'serial_number_img_'.$prod_item->id.'.required' => 'الصورة مطلوبة.',
                ];
        
                $validatedData = Validator::make($request->all(), [
                    'serial_number_'.$prod_item->id => 'required',
                    'serial_number_img_'.$prod_item->id => 'required',
                    
                ], $messages);
        
                if ($validatedData->fails()) {
        
                    return redirect()->back()->withErrors($validatedData)->withInput();
                }
                else
                { 
                    $serial = $request->input('serial_number_'.$prod_item->id);
                    if ($request->hasFile('serial_number_img_'.$prod_item->id)) {
                        // $file = $request->file('serial_number_img_'.$prod_item->id);
                        // $filePath = $file->store('uploads/new_photos', 'public');

                        $filename = time() . '-' . $request->file('serial_number_img_'.$prod_item->id)->getClientOriginalName();
                        $path = $request->file('serial_number_img_'.$prod_item->id)->move(public_path('showroom'), $filename);
                        $filePath = 'showroom' . '/' . $filename;

                        $prod_item->update([
                            'available' => 1,
                            'serial_number' => $serial,
                            'serial_number_img' => $filePath
                        ]);
                    }

                    return redirect()->route('shoowroom.index')->with('message', 'تم الاستلام بنجاح');
               }
            }
    }
}
