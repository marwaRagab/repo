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

        $message ="تم عرض صفحة استلام البضاعة     " ;  
        $title='استلام البضاعة  ';

        //  $this->log(Auth::user()->id ?? 0,$message); 
        // $user_id =  Auth::user()->id;
        
        $all_orders = OrdersFiles::with('company','purchase')
            ->where('orders_files.received', 0)
            ->where('orders_files.send_status', 1)
            ->where('orders_files.place', 'showroom')
            ->where('orders_files.status', 'active')
            ->where('orders_files.order_id', 0)
            // ->select('orders_files.id', 'name_ar', 'place')
            ->get();

            // dd($all_orders);
      
        $view='showroom.recieving';
        $breadcrumb = array();
        $breadcrumb[0]['title'] = " الرئيسية";
        $breadcrumb[0]['url'] = route("dashboard");
        $breadcrumb[1]['title'] = "مخزن المعرض";
        $breadcrumb[1]['url'] = route("shoowroom.index");
        $breadcrumb[2]['title'] = $title;
        $breadcrumb[2]['url'] = 'javascript:void(0);';

        return view('layout',compact('title','view','all_orders','breadcrumb'));
    }

    public function getAll()
    {
        $data = OrdersFiles::join('companies', 'companies.id', '=', 'orders_files.company_id')                    
                    ->where('orders_files.company_id' , 'company.id')
                    ->where('orders_files.received' , 0)
                    ->where('orders_files.send_status' , 1)
                    ->where('orders_files.place' , 'showroom')
                    ->where('orders_files.status' , 'active')
                    ->where('orders_files.order_id' , 0)              
                    ->select('orders_files.id','name_ar','place')->get();
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
        $new_items = products_items::with('product','ordersFiles')
                                    ->where('purchase_id', $id)
                                    ->get(); 
            
        $purchase = OrdersFiles::findORFail($id); 
        if ($purchase->received == 1) {
            return redirect()->back()->with('message', 'تم الاستلام من قبل');
        }
        
        foreach($data as $one) {
            // dd($one);
               $receiving = $request->input('receiving_'.$one['id']);
                $counter_received = $request->input('counter_received_'.$one['id']);
                // dd($receiving);
                if ($counter_received > 0  && $receiving == 1) {
                    // dd($one);
                    $one->update([
                            'counter_received' => $counter_received ,
                            'cancel' => 0,
                        ]);
                        
                    $items = new products_items();

                    $items->purchase_id = $request->order_id;
                    $items->product_id = $one->product_id;
                    $items->final_price = $one->product->net_price;
                    $items->place = 'showroom';

                    if ($purchase->order_id > 0) {
                        $items->available = 0;
                    } else {
                        $items->available = 1;
                    }
                    $items->save();
                    if($one->product->class_id == 1)
                    {         
                        return $this->add_serial($request,$data);            
                    }       
                } 
                else {
                    $one->update([
                        'counter_received' => 0,
                        'cancel' => 1,
                    ]);
                 }

            }
            
      
        $price = products_items::where('purchase_id', $request->order_id)->get();
        $total = $price->sum('final_price');
       
        OrdersFiles::where('id', $request->order_id)
            ->update([
                'received_user_id' => Auth::user()->id ?? 0,
                'received' => 1,
                'amount' =>  $total
            ]);
        
        
        return redirect()->route('shoowroom.index')->with('message', 'تم الاستلام بنجاح');
    }

    public function add_serial(Request $request,$data)
    {
       
        foreach($data as $one) {
            $new_items = products_items::with('product','ordersFiles')
                            ->where('purchase_id', $one->id)
                            ->get();
                $receiving = $request->input('receiving_'.$one->order_id);
                $counter_received = $final_counter = $request->input('counter_received_'.$one->order_id );
                   
                if ($receiving == 1 and $counter_received > 0) {
                   
                            foreach($new_items as $prod_item)
                            {
                                dd($request->all());
                                products_items::where('id',$one->order_id)->udpate([
                                    'available' => 0,
                                    'serial_number' => $request->input('serial_number_'.$one->order_id),
                                    'serial_number_img' => $request->input('serial_number_img_'.$one->order_id),
                               ]); 
                               
                            }

                    return redirect()->route('shoowroom.index')->with('message', 'تم الاستلام بنجاح');
                } 

                
            }
                   
                $id =$request->id;
                $title='استلام البضاعة  ';
                $view='showroom.add_serial';
                $breadcrumb = array();
                $breadcrumb[0]['title'] = " الرئيسية";
                $breadcrumb[0]['url'] = route("dashboard");
                $breadcrumb[1]['title'] = "مخزن المعرض";
                $breadcrumb[1]['url'] = route("shoowroom.index");
                $breadcrumb[2]['title'] = $title;
                $breadcrumb[2]['url'] = 'javascript:void(0);';

                return view('layout',compact('title','view','breadcrumb','id','new_items'));
    }
}