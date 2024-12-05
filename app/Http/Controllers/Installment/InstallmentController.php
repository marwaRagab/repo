<?php

namespace App\Http\Controllers\Installment;
ini_set('memory_limit', '600M');

use App\Models\Nationality;
use Carbon\Carbon;
use App\Models\Client;
use App\Models\Order;
use App\Models\ClientImg;

use App\Models\Installment;
use Illuminate\Http\Request;
use App\Models\InstallmentNote;
use App\Models\InstallmentClientNote;
use App\Models\Installment_month;
use App\Models\InstallmentCar;
use App\Models\InstallmentIssue;
use App\Models\Prev_cols_clients;
use App\Models\Installment_Client;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

use Illuminate\Support\Facades\Redirect;

use Yajra\DataTables\Facades\DataTables;


use Illuminate\Support\Facades\Validator;
use App\Models\Military_affairs\Military_affair;


use App\Models\ImportingCompanies\Tawreed\OrdersFiles;
use App\Models\InvoicesInstallment\Invoices_installment;
use App\Models\Military_affairs\Military_affairs_amount;
use App\Models\Military_affairs\Military_affairs_settlement;
use App\Models\Military_affairs\Military_affairs_notes;
use App\Models\Military_affairs\Military_affairs_settlement_month;
use App\Models\PurchaseOrderItem;

class InstallmentController extends Controller
{
    public function index()
    {
       // dd($status);
        //
        $title='عملاء الاقساط';

        $breadcrumb = array();
        $breadcrumb[0]['title'] = " الرئيسية";
        $breadcrumb[0]['url'] = route("dashboard");

        $breadcrumb[1]['title'] = $title;
        $breadcrumb[1]['url'] = 'javascript:void(0);';

        $data['Installment'] = Installment::with(['user','client','eqrar_not_recieve','installment_months','militay_affairs','installment_client'])->OrderBy('installment.id','desc')->get();
        //  $data = Installment::with(['user','client','eqrar_not_recieve','installment_months','militay_affairs'])->get();

       if($data)
       {
//   $user_id = 1 ;
             $user_id =  Auth::user()->id ?? null;
               $message ="تم دخول صفحة عملاء الاقساط" ;
               $this->log($user_id ,$message);
       }


       $data['view']='installment/index';
       return view('layout',$data,compact('breadcrumb'));

        //    return view('installment.index',compact('data'));

       //  return $this->respondSuccess($data, 'Get Data successfully.');

    }

    public function storelocation(Request $request, $client_id)
    {
        // Validate incoming form data
        $request->validate([
            'location_google_map' => 'required|string',
            'kwfinder' => 'nullable|string',
            'location' => 'nullable|string',
            'Latitude' => 'nullable|string',
            'Longitude' => 'nullable|string',
            'house_id' => 'nullable|string',
        ]);

        // Find the installment entry and associated client
        $client = Client::findOrFail($client_id);

        // Update client details
        $client->update([
            'location_google_map' => $request->input('location_google_map'),
            'kwfinder' => $request->input('kwfinder'),
            'location' => $request->input('location'),
            'Latitude' => $request->input('Latitude'),
            'Longitude' => $request->input('Longitude'),
            'house_id' => $request->input('house_id'),
        ]);

        return redirect()->back()->with('success', 'Client information updated successfully.');
    }

    public function getCoordinatesAttribute(Request $request)
    {
        $url = $request->input('loc');
        $urlCoordinatesPosition = strpos($url, '@') + 1;

        $coordinates = [];

        if ($urlCoordinatesPosition !== false) {
            $coordinatesString = substr($url, $urlCoordinatesPosition);
            $coordinatesArray = explode(',', $coordinatesString);

            if (count($coordinatesArray) >= 2) {
                $coordinates = [
                    "lat" => $coordinatesArray[0],
                    "long" => $coordinatesArray[1],
                ];
            }
        }

        return response()->json($coordinates);
    }

    public function finished_installments()
    {
       // dd($status);

        $title='ارشيف المعاملات';

        $breadcrumb = array();
        $breadcrumb[0]['title'] = " الرئيسية";
        $breadcrumb[0]['url'] = route("dashboard");
        $breadcrumb[1]['title'] = "عملاء الاقساط";
        $breadcrumb[1]['url'] = route("installment.admin");
        $breadcrumb[2]['title'] = $title;
        $breadcrumb[2]['url'] = 'javascript:void(0);';


//         $data['Installment']= Installment::with(['user','client','eqrar_not_recieve','installment_months','militay_affairs','installment_client'])->get();
//

        $data['Installment']= Installment::with(['user','client','eqrar_not_recieve','installment_months','militay_affairs','installment_client'])->where('finished','1')->get();
        // $data['preclient'] = Prev_cols_clients::with('client_old')->where('id', $data['Installment']->client_id)->first();
        //  $data = Installment::with(['user','client','eqrar_not_recieve','installment_months','militay_affairs'])->get();

       if($data)
       {       $user_id = 1 ;
           //   $user_id =  Auth::user()->id,
               $message ="تم دخول صفحة الارشيف فى عملاء الاقساط" ;
               $this->log($user_id ,$message);
       }

       $data['view']='installment/archive';
       return view('layout',$data,compact('breadcrumb'));

        //    return view('installment.index',compact('data'));

       //  return $this->respondSuccess($data, 'Get Data successfully.');

    }

    public function getExcel()
    {
       // dd($status);
        //
        $title='احصائيات العملاء';

        $breadcrumb = array();
        $breadcrumb[0]['title'] = " الرئيسية";
        $breadcrumb[0]['url'] = route("dashboard");
        $breadcrumb[1]['title'] = "عملاء الاقساط";
        $breadcrumb[1]['url'] = route("installment.admin");
        $breadcrumb[2]['title'] = $title;
        $breadcrumb[2]['url'] = 'javascript:void(0);';

        $data['Client']= Client::with(['user','client_address','client_phone'])->get();
        //  $data = Installment::with(['user','client','eqrar_not_recieve','installment_months','militay_affairs'])->get();

       if($data)
       {       $user_id = 1 ;
           //   $user_id =  Auth::user()->id,
               $message ="تم دخول صفحة احصائيات العملاء" ;
               $this->log($user_id ,$message);
       }

       $data['view']='installment/excel';
       return view('layout',$data,compact('breadcrumb'));

    }

    public function show_installment($id)
    {

        //
        $title = 'عرض التفاصيل';

        $breadcrumb = array();
        $breadcrumb[0]['title'] = " الرئيسية";
        $breadcrumb[0]['url'] = route("dashboard");
        $breadcrumb[1]['title'] = "عملاء الاقساط";
        $breadcrumb[1]['url'] = route("installment.admin");
        $breadcrumb[2]['title'] = $title;
        $breadcrumb[2]['url'] = 'javascript:void(0);';

       
        $data['orders'] = Installment::with('orders.order_item.product_order', 'orders.order_item')->findOrFail($id);

        // Use a collection to gather the product orders and counters
        $purchase_orders_array = $data['orders']->orders->flatMap(function ($order) {
            return $order->order_item->map(function ($item) {
                return [
                    'product_order' => $item->product_order,
                    'counter' => $item->counter,
                ];
            });
        });

        $data['Installment'] = $installment= Installment::with(['user', 'client', 'eqrar_not_recieve', 'installment_months', 'militay_affairs'])->findOrFail($id);
       // $data['Installment_Client'] = $Installment_Client= Installment_Client::with(['installment_client'])->get();

        $data['Installment']->test = "";

        if($data['Installment']->installment_clients > 0 || $data['Installment']->installment_clients != null)
        {
            $data['Installment']->test = Installment_Client::findOrFail($data['Installment']->installment_clients)->cinet_installment;
        }

//        $data['Installment']->test = Installment_Client::findOrFail($data['Installment']->installment_clients)->cinet_installment;
       $data['Client'] = Client::with(['user', 'client_address', 'client_phone','client_image'])
            ->where('id', $data['Installment']->client_id)
            ->first();
        // $data['phone'] = ClientPhone::where('client_id',$client->id);
        $data['OrderItem'] = DB::table('orders_items')->where('order_id', $data['Installment']->order_id)->get();
        $data['purchase_orders_items'] = PurchaseOrderItem::with('product')->where('order_id', $data['Installment']->order_id)->get();

        $data['installment_months'] = Installment_month::where('installment_id', $id)->orderBy('date')->get();


        $data['count_installment_months'] = Installment_month::where('installment_id', $id)->where('status', 'done')->where('installment_type','!=','first_amount')->where('installment_type','!=','law_percent')->count();
        $data['done_amount'] = Installment_month::where('installment_id', $id)->where('status', 'done')->sum('amount');
        $data['done_amount_settlement'] = DB::table('military_affairs_settlement_months')->where('installment_id', $id)->where('status', 'done')->sum('amout');
        $data["military_affairs_item"] = DB::table('military_affairs')->where('installment_id', $id)->first();
        if ($data['Installment']->months == 36) {
            $data['not_done_amount'] = Installment_month::where('installment_id', $id)
                ->where('status', 'not_done')
                ->whereNotIn('installment_type', ['law_percent', 'first_amount', 'discount'])
                ->sum('amount');
        } else {
            $data['not_done_amount'] = Installment_month::where('installment_id', $id)
                ->where('status', 'not_done')
                ->whereNotIn('installment_type', ['first_amount', 'discount'])
                ->sum('amount');
        }
        $data['Installment_Client'] = Installment_Client::with(['user', 'ministry_working', 'bank'])->where('id', $data['Installment']->installment_clients)->first();
        $data['total_madionia1'] = $data['done_amount'] + $data['not_done_amount'];
        $data['nstallment_discount_amount'] = DB::table('invoices_installment')->where('installment_id', $id)->where('type','income');
        $data['not_done_count'] = Installment_month::where('installment_id', $id)->where('status', 'not_done')->where('installment_type', 'installment')->count();
        $current_date = now(); // Use Carbon to get the current date and time
        $data['not_done_count_lated'] = Installment_month::where('installment_id', $id)->where('status', 'not_done')->where('date', '<', $current_date)->count();
        $nstallment_discount = DB::table('invoices_installment')->where('installment_id', $id)->where('type', 'expenses_pending')->first();

        if (empty($nstallment_discount)) {
            $data['nstallment_discount'] = 0; // Default to 0 if no result is found
        } else {
            $data['nstallment_discount'] = $nstallment_discount->amount; // Use the amount if a result exists
        }

        $data['id'] = $id;
        $data['client_ministries']=DB::table('client_ministries')->where('client_id',$data['Client']->id)->get();
        // Extract ministry IDs from the collection
        $ministryIds = $data['client_ministries']->pluck('ministry_id')->toArray();

        // Retrieve ministries based on the IDs
        $data['ministries'] = DB::table('ministries')->whereIn('id', $ministryIds)->get();
        $data['client_addresses'] = DB::table('client_addresses')->where('client_id' , $data['Client']->id)->get();

        // Retrieve ministries based on the IDs
        $data['governorates'] = DB::table('governorates')
        ->where('id',  $data['Client']->client_address->first()->governorate_id)
        ->first();
        $data['regions'] = DB::table('regions')
        ->where('id',  $data['Client']->client_address->first()->area_id)
        ->first();

        // banks
        $data['client_banks']=DB::table('client_banks')->where('client_id',$data['Client']->id)->first();

        // dd( $data['Installment']);
        // $data['Installment']= Installment::with(['user','client','eqrar_not_recieve','installment_months','militay_affairs','installment_client'])->get();
        //  $data = Installment::with(['user','client','eqrar_not_recieve','installment_months','militay_affairs'])->get();

        if ($data) {
            $user_id = Auth::user()->id ?? null;
            $message = "تم دخول صفحة عرض التفاصيل للمعاملة";
            $this->log($user_id, $message);
        }
        $data['not_done_amount'] = $not_done_amount = Installment_month::where('installment_id', $id)->where('status', 'not_done')
            ->where('installment_type', 'installment')->sum('amount');

        $mil_item = Military_affair::with('installment')->get();
        $data['mil_amount'] = Military_affairs_amount::where('military_affairs_check_id', 0)->get();


        if ($installment->laws == 1) {
            $military_affair = Military_affair::where('installment_id', $id)->first();
            $data['settle_item'] = Military_affairs_settlement::with('military_affair', 'settle_month')->where('military_affairs_id', $military_affair->id)->get();

            $data['sum'] = $not_done_amount - $military_affair->excute_actions_amount - $military_affair->excute_actions_check_amount;

        } else {

            $data['sum'] = $not_done_amount;
        }


        $first_month = Installment_month::where('installment_id', $id)->where('status', 'not_done')->first();
        $data['install_amount'] = $first_month->amount ?? 0;

        $data['invoices'] = Invoices_installment::with('install_month', 'installment')
            ->where('installment_id', $id)->get();
        // dd($data['invoices']);
        $data['install_discount'] = Invoices_installment::with('installment')->where('type', 'expenses_pending')->get();

        // $data['settle_item'] = Military_affairs_settlement::with('military_affair')->get();


        // if(count($data['settle_item']) > 0){

        //    $data['settle_month_item'] = Military_affairs_settlement_month::where('settle_id',$data['settle_item']['id'])->where('installment_type','!=','first_amount')->get();
        // }


        // dd($data['settle_item']);
        // if(count($data['settle_item']) > 0){
        //    dd($data['settle_item']);
        //    $data['settle_month_item'] = Military_affairs_settlement_month::where('settle_id',$data['settle_item']['id'])
        //                                   ->where('installment_type','!=','first_amount')->get();
        // }
        // dd($data['Installment_Client']);
        //notes
        $data['InstallmentNote'] = InstallmentNote::where('installment_clients_id', $id)->get();
        if($data['Installment_Client'])
        {
            $data['Installmentcar'] = InstallmentCar::where('installment_clients_id', $data['Installment_Client']->id)->get();
            $data['Installmentissue'] = InstallmentIssue::where('installment_clients_id', $data['Installment_Client']->id)->get();
            $data['InstallmentClientNote'] = InstallmentClientNote::where('installment_clients_id', $data['Installment_Client']->id)->get();
            // $data['InstallmentClientNoteAccepted'] = InstallmentClientNote::where('installment_clients_id', $data['Installment_Client']->id)->where('')->get();
        }


        // dd()
        if($data["military_affairs_item"])
        {
            $data['MilitaryAffairNote'] = Military_affairs_notes::where('military_affairs_id', $data["military_affairs_item"]->id)->get();
        }
        $data['MilitaryAffairNote'] =null;


        //notes
        $data['InstallmentNote'] = InstallmentNote::where('installment_clients_id', $id)->get();
        if($data['Installment_Client'])
        {
            $data['Installmentcar'] = InstallmentCar::where('installment_clients_id', $data['Installment_Client']->id)->get();
            $data['Installmentissue'] = InstallmentIssue::where('installment_clients_id', $data['Installment_Client']->id)->get();
            $data['InstallmentClientNote'] = InstallmentClientNote::where('installment_clients_id', $data['Installment_Client']->id)->get();
        }


        // dd()
        if($data["military_affairs_item"])
        {
            $data['MilitaryAffairNote'] = Military_affairs_notes::where('military_affairs_id', $data["military_affairs_item"]->id)->get();
        // dd($data['MilitaryAffairNote']);

        }

        // order items

       

        $data['view'] = 'installment/show_details';
        return view('layout', $data, compact('breadcrumb', 'data','purchase_orders_array'));

        //  return $this->respondSuccess($data, 'Get Data successfully.');

    }

    public function pay_from($installment_id, Request $request)
    {
        $request->validate([
            'cash' => 'required',
            'knet' => 'required',
            'knet_code' => 'required',
        ],
        [
            'cash.required' => 'القيمة مطلوبة',
            'knet.required' => 'القيمة مطلوبة',
            'knet_code.required' => 'وصل الكى نت  مطلوب',
        ]);

        $title='نظام الأقساط';

        $breadcrumb = array();
        $breadcrumb[0]['title'] = " الرئيسية";
        $breadcrumb[0]['url'] = route("dashboard");
        $breadcrumb[1]['title'] = "عملاء الاقساط";
        $breadcrumb[1]['url'] = route("installment.admin");
        $breadcrumb[2]['title'] = $title;
        $breadcrumb[2]['url'] = 'javascript:void(0);';

        $installment_item = Installment::findOrFail($installment_id);
        $data['item'] = $item2 = $month = Installment_month::where('installment_id',$installment_id)->where('status','not_done')->orderBy('id', 'asc')->first();
        $invoice =  new Invoices_installment();


            if ($request->cash > 0 and $request->knet > 0) {
                $month->payment_type = 'cash/knet';
            } elseif ($request->cash > 0) {
                $month->payment_type = "cash";
            } else {
                $month->payment_type = "knet";
            }

            $month->update([
                'status' => "done",
                'created_by' => Auth::user()->id ?? null,
                'payment_date' => now()->format('Y-m-d'),
                'hesab_file' => 1
            ]);

            // if ($installment_item['laws'] == 1) {
            //     $this->update_payment_law($installment_id, $item2['amout']);

            //     $item = $this->db_get->get_where_r('laws', 'installment_id', $installment_id);

            //     if (!empty($item)) {
            //         $add_data2['payment_done'] = $month->amount + $item['payment_done'];

            //         $this->db_get->update_tb('laws', $item['id'], $add_data2);

            //     }
            // }

            // if ($month->installment_type == "first_amount") {
            //     Orders::where('id',$installment_item->order_id)->update([
            //         'status' => "finished"
            //     ]);
            // }

            if ($request->cash > 0) {
                $this->add_install_money($month->id, $request->cash , 'cash', '');
            }

            if ($request->knet > 0) {
                $this->add_install_money($month->id, $request->knet, 'knet', $request->knet_code);
            }
            if ($request->hasFile('img_dir')) {
                $file = $request->file('img_dir');
                $filePath = $file->store('uploads/new_photos', 'public');

                    $month->update([
                        'created_by' => Auth::user()->id ?? null,
                        'img_dir' => '/storage/' .$filePath,
                    ]);
                // for($i =0 ; $i < 2 ; $i++){
                    $invoice::where('install_month_id',$month->id)->update([
                        'img' => '/storage/' .$filePath,
                        'created_by' => Auth::user()->id ?? null,
                    ]);
                // }
            }
            if (empty($month)) {
                $installment_item->update([
                    'finished' => 1,
                ]);

                $military_affairs_item = Military_affair::where('installment_id', $installment_id)->get();

                if (!empty($military_affairs_item)) {

                    $military_affairs_item->update([
                        'checking' => 1
                    ]);
                }
            }

            return redirect()->back()->with('message', 'تم الدفع بنجاح');

    }

    public function add_install_money_part($id, $amount, $knet_code)
    {
        $installment_month = Installment_month::findORFail($id);
        $installment = Installment::findORFail($installment_month->installment_id);

        $invoice = new Invoices_installment;
        $last_invoice = Invoices_installment::latest()->first();

        if (!empty($installment->part_latif)) {

            $invoice->description  = "عملية  دفع قسط (رابط  ) عن معاملة العميل "
                //. $client['name']
                . " رقم " . " " . $installment_month->installment_id;
        }

        if (!empty($installment->part_paper)) {
              $invoice->description = "عملية  دفع قسط (رابط) عن معاملة العميل "
               // . $client['name']
                . " رقم " . " " . $installment_month->installment_id;

        }

            $invoice->amount  =  $amount;
            $invoice->description = "عملية  دفع قسط (رابط )عن المعاملة  رقم ". $installment_month->installment_id;
            $invoice->type  = "income";
            $invoice->payment_type   = 'part';
            $invoice->date   = now();
            $invoice->install_month_id  = $id;
            $invoice->knet_code  = $knet_code ? $knet_code:'';
            $invoice->installment_id  = $installment_month->installment_id;
            $invoice->created_by  = Auth::user()->id ?? null;
            $invoice->debtor = 1;
            $invoice->branch_id  = Auth::user()->branch_id ?? null;
            $invoice->balance =  $last_invoice->balance;
            $invoice->install_pay_type = 'installment';
            $invoice->balance_bank = empty($last_invoice->balance_bank) ? 0 : $last_invoice->balance_bank + $amount;

        $invoice->save();

    }

    public function pay_part($installment_id, Request $request)
    {

        $messages = [
            'knet_code.required' => 'كود الرابط مطلوب',
            'img_dir.required' => 'الصورة مطلوبة',
        ];

        $validatedData = Validator::make($request->all(), [
            'knet_code' => 'required',
            'img_dir' => 'required',
        ], $messages);
        if ($validatedData->fails()) {
            return redirect()->back()
                ->withErrors($validatedData)
                ->withInput();
        }
      else
      {
        $title='نظام الأقساط';
        $breadcrumb = array();
        $breadcrumb[0]['title'] = " الرئيسية";
        $breadcrumb[0]['url'] = route("dashboard");
        $breadcrumb[1]['title'] = "عملاء الاقساط";
        $breadcrumb[1]['url'] = route("installment.admin");
        $breadcrumb[2]['title'] = $title;
        $breadcrumb[2]['url'] = 'javascript:void(0);';

        $installment_item = Installment::findOrFail($installment_id);
        $data['item'] = $item2 = $month = Installment_month::where('installment_id',$installment_id)->where('status','not_done')->orderBy('id', 'asc')->first();
        $invoice =  new Invoices_installment();


            $month->update([
                'status' => "done",
                'created_by' => Auth::user()->id ?? null,
                'payment_date' => now()->format('Y-m-d'),
                'hesab_file' => 1,
                'payment_type' => "part"
            ]);

            $installment_item->update([
                'finished' => 1
              ]);

            $this->add_install_money_part($month->id, $month->amount, $request->knet_code);

            if ($request->hasFile('img_dir')) {
                $file = $request->file('img_dir');
                $filePath = $file->store('uploads/new_photos', 'public');

                    $month->update([
                        'created_by' => Auth::user()->id ?? null,
                        'img_dir' => '/storage/' .$filePath,
                    ]);
                // for($i =0 ; $i < 2 ; $i++){
                    $invoice::where('install_month_id',$month->id)->update([
                        'img' => '/storage/' .$filePath,
                        'created_by' => Auth::user()->id ?? null,
                    ]);
                // }
            }

            return redirect()->back()->with('message', 'تم الدفع بنجاح');
        }

    }

    public function add_install_money($id, $amount, $type, $knet_code)
    {
        $installment_month = Installment_month::findORFail($id);
        $invoice = new Invoices_installment;

        $sum = $amount;

        $last_invoice = Invoices_installment::latest()->first();

        if (!empty($last_invoice)) {
            //  echo '<pre>';  print_r($item); exit;
            switch ($last_invoice->type) {
                case "income":
                    $sum = $last_invoice->balance + $sum;
                    break;
                case "share_capital":
                    $sum = $last_invoice->balance  + $sum;
                    break;
                case "expenses":
                    $sum = $last_invoice->balance  - $sum;
                    break;
                case "export":
                    $sum = $last_invoice->balance  - $sum;
                    break;
                case "advance":
                    $sum = $last_invoice->balance  - $sum;
                    break;
                case "income_pending":
                    $sum = $last_invoice->balance ;
                    break;
                case "expenses_pending":
                    $sum = $last_invoice->balance ;
                    break;

                default:
                    break;
            }
        }

        if ($type == 'cash') {
            $invoice->balance_cash = empty($last_invoice->balance_cash) ? 0 :$last_invoice->balance_cash + $amount;
            $invoice->balance_knet = empty($last_invoice->balance_cash) ? 0 : $last_invoice->balance_knet;
            // update_invoice_central_bank('cash', '+', $add_data['amount'], 'installment');
        } else {
            $invoice->balance_cash = empty($last_invoice->balance_cash) ? 0 :$last_invoice->balance_cash;
            $invoice->balance_knet = empty($last_invoice->balance_cash) ? 0 : $last_invoice->balance_knet + $amount;
            // update_invoice_central_bank('knet', '+', $add_data['amount'], 'installment');
        }

            $invoice->amount  =  $amount;
            $invoice->description = "عملية  دفع قسط عن المعاملة  رقم ". $installment_month->installment_id;
            $invoice->type  = "income";
            $invoice->payment_type   = $type;
            $invoice->date   = now();
            $invoice->install_month_id  = $id;
            $invoice->knet_code  = $knet_code ? $knet_code:'';
            $invoice->installment_id  = $installment_month->installment_id;
            $invoice->created_by  = Auth::user()->id ?? null;
            $invoice->debtor = 1;
            $invoice->branch_id  = Auth::user()->branch_id ?? null;
            $invoice->balance = $sum;
            $invoice->install_pay_type = 'installment';
            $invoice->balance_bank = empty($last_invoice->balance_bank) ? 0 : $last_invoice->balance_bank;

        $invoice->save();

    }

    public function add_install_money_settle($id, $amount, $type, $knet_code)
    {
        $installment_month = Military_affairs_settlement_month::findORFail($id);
        $invoice = new Invoices_installment;

        $sum = $amount;

        $last_invoice = Invoices_installment::latest()->first();

        if (!empty($last_invoice)) {
            //  echo '<pre>';  print_r($item); exit;
            switch ($last_invoice->type) {
                case "income":
                    $sum = $last_invoice->balance + $sum;
                    break;
                case "share_capital":
                    $sum = $last_invoice->balance  + $sum;
                    break;
                case "expenses":
                    $sum = $last_invoice->balance  - $sum;
                    break;
                case "export":
                    $sum = $last_invoice->balance  - $sum;
                    break;
                case "advance":
                    $sum = $last_invoice->balance  - $sum;
                    break;
                case "income_pending":
                    $sum = $last_invoice->balance ;
                    break;
                case "expenses_pending":
                    $sum = $last_invoice->balance ;
                    break;

                default:
                    break;
            }
        }

        if ($type == 'cash') {
            $invoice->balance_cash = empty($last_invoice->balance_cash) ? 0 :$last_invoice->balance_cash + $amount;
            $invoice->balance_knet = empty($last_invoice->balance_cash) ? 0 : $last_invoice->balance_knet;
            // update_invoice_central_bank('cash', '+', $add_data['amount'], 'installment');
        } else {
            $invoice->balance_cash = empty($last_invoice->balance_cash) ? 0 :$last_invoice->balance_cash;
            $invoice->balance_knet = empty($last_invoice->balance_cash) ? 0 : $last_invoice->balance_knet + $amount;
            // update_invoice_central_bank('knet', '+', $add_data['amount'], 'installment');
        }

            $invoice->amount  =  $amount;
            $invoice->description = "عملية  دفع قسط عن المعاملة  رقم ". $installment_month->installment_id;
            $invoice->type  = "income";
            $invoice->payment_type   = $type;
            $invoice->date   = now();
            $invoice->install_month_id  = $id;
            $invoice->knet_code  = $knet_code ? $knet_code:'';
            $invoice->installment_id  = $installment_month->installment_id;
            $invoice->created_by  = Auth::user()->id ?? null;
            $invoice->debtor = 1;
            $invoice->branch_id  = Auth::user()->branch_id ?? null;
            $invoice->balance = $sum;
            $invoice->install_pay_type = 'settlement';
            $invoice->balance_bank = empty($last_invoice->balance_bank) ? 0 : $last_invoice->balance_bank;

        $invoice->save();

    }

    public function pay_settle($installment_id, Request $request)
    {
        $request->validate([
            'cash_settle' => 'required',
            'knet_settle' => 'required',
            'knet_code_settle' => 'required',
        ]);

        $title='نظام الأقساط';

        $breadcrumb = array();
        $breadcrumb[0]['title'] = " الرئيسية";
        $breadcrumb[0]['url'] = route("dashboard");
        $breadcrumb[1]['title'] = "عملاء الاقساط";
        $breadcrumb[1]['url'] = route("installment.admin");
        $breadcrumb[2]['title'] = $title;
        $breadcrumb[2]['url'] = 'javascript:void(0);';

        $installment_item = Installment::findOrFail($installment_id);
        $data['item'] = $item2 = $month = Military_affairs_settlement_month::with('military_affair')->where('status','not_done')->orderBy('id', 'asc')->first();
        $invoice =  new Invoices_installment();


            if ($request->cash_settle > 0 and $request->knet_settle > 0) {
                $month->payment_type = 'cash/knet';
            } elseif ($request->cash_settle > 0) {
                $month->payment_type = "cash";
            } else {
                $month->payment_type = "knet";
            }

            $month->update([
                'status' => "done",
                'created_by' => Auth::user()->id ?? null,
                'payment_date' => now()->format('Y-m-d'),
            ]);

            // if ($installment_item['laws'] == 1) {
            //     $this->update_payment_law($installment_id, $item2['amout']);
            // }
            if ($item2['installment_type'] == "first_amount") {
                $inst_item = Installment::findOrFail($item2->installment_id);
                $order = new Order();
                $order::where('id',$inst_item->order_id)->update([
                    'status' => 'finished'
                ]);
            }


            if ($request->cash_settle > 0) {
                $this->add_install_money_settle($month->id, $request->cash_settle , 'cash', '');
            }

            if ($request->knet_settle > 0) {
                $this->add_install_money_settle($month->id, $request->knet_settle, 'knet', $request->knet_code_settle);
            }
            if ($request->hasFile('img_dir')) {
                $file = $request->file('img_dir');
                $filePath = $file->store('uploads/new_photos', 'public');

                    $month->update([
                        'created_by' => Auth::user()->id ?? null,
                        'img_dir' => '/storage/' .$filePath,
                    ]);
                // for($i =0 ; $i < 2 ; $i++){
                    $invoice::where('install_month_id',$month->id)->update([
                        'img' => '/storage/' .$filePath,
                        'created_by' => Auth::user()->id ?? null,
                    ]);
                // }
            }
            if (empty($month)) {
                $installment_item->update([
                    'finished' => 1,
                ]);

                $military_affairs_item = Military_affair::where('installment_id', $installment_id)->get();

                if (!empty($military_affairs_item)) {

                    $military_affairs_item->update([
                        'checking' => 1
                    ]);
                }
            }

            return redirect()->back()->with('message', 'تم الدفع بنجاح');

    }

    public function pay_total_installs($installment_id, Request $request)
    {

        $messages = [

            'cash.required' => 'القيمة مطلوبة',
            'knet.required' => 'القيمة مطلوبة',
            'knet_code.required' => 'القيمة مطلوبة',
            'paper_img_dir.required' => 'الصورة مطلوبة',
        ];

        $validatedData = Validator::make($request->all(), [
            'cash' => 'required',
            'knet' => 'required',
            'knet_code' => 'required',
            'paper_img_dir' => 'required',

        ], $messages);
        if ($validatedData->fails()) {
            return redirect()->back()
                ->withErrors($validatedData)
                ->withInput();
        }
      else
      {
        $installment = Installment::findOrFail($installment_id);
        $client = Client::where('id',$installment->client_id);
        $data['not_done_count'] = Installment_month::where('installment_id', $installment_id)->where('status', 'not_done')->where('installment_type','installment')->count();
        $data['not_done_amount'] =  Installment_month::where('installment_id', $installment_id)->where('status', 'not_done')->where('installment_type','installment')->get();

        $not_done_amount = $data['not_done_amount']->sum('amount');

        $military_affair = Military_affair::where('installment_id', $installment_id)->get();

        if ($installment->laws == 1) {

            $data['sum'] = $not_done_amount - $military_affair->excute_actions_amount - $military_affair->excute_actions_check_amount;
        } else {

            $data['sum'] = $not_done_amount;
        }


        $installments = Installment_month::where('installment_id',$installment_id)->where('status','not_done')->get();
        $counter = count($installments);

        $months_id =array();
        for ($j = 0; $j < count($installments); $j++) {
            $months = Installment_month::where('installment_id',$installment_id)->where('status','not_done')->first();

            $months_id[] = $installments[$j]->id ;
            if ($request->cash > 0 and $request->knet > 0) {
                $months->payment_type = 'cash/knet';
            } elseif ($request->cash > 0) {
                $months->payment_type = "cash";
            } else {
                $months->payment_type = "knet";
            }

            $months->update([
                'status' => "done",
                'payment_date' => now(),
                'created_by' => Auth::user()->id ?? null
            ]);

            // if ($installments[$j]['installment_type'] == 'law_percent' or $installments[$j]['installment_type'] == '2_._5_percent') {
            //     $installment_type = $installments[$j]['installment_type'];

            //     $this->do_payment_to_tahseel($installments[$j]['installment_id'], $installments[$j]['amout'], $installment_type);
            // }
        }

        if ($request->cash > 0) {
            $this->add_install_money_all($installment_id, $counter, $request->cash, 'cash', '', '');
        }
        if ($request->knet > 0) {
            $this->add_install_money_all($installment_id, $counter, $request->knet, 'knet', $request->knet_code, '');
        }

        $installments_2 = Installment_month::where('installment_id',$installment_id)->where('status','not_done')->get();
        if (empty($installments_2)) {
            $installment->finished = 1;

            $installments_item_eqrar_dain = $this->all_eqrardeain_sql($installment_id);

            if (!empty($installments_item_eqrar_dain)) {
                $installment->please_cancel_eqrar_dain = 1;
            }

         $installment->update();
         $military_affairs_item_1 = Military_affair::where('installment_id', $installment_id)->get();

         }

        $ids = '';
        for ($j = 1; $j < count($months_id); $j++) {
            $ids = $months_id[$j] ;
        }

        $months = new Installment_month;
        $invoice =  Invoices_installment::where('install_month_id', 0)->where('installment_id',$installment_id)->get();

        if ($request->hasFile('paper_img_dir')) {
            $file = $request->file('paper_img_dir');
            $filePath = $file->store('uploads/new_photos', 'public');

            for ($j = 1; $j < count($months_id); $j++) {
                $months::where('id',$j)->update([
                    'created_by' => Auth::user()->id ?? null,
                    'img_dir' => '/storage/' .$filePath,
                ]);
            }

                $invoice->update([
                    'img' => '/storage/' .$filePath,
                    'created_by' => Auth::user()->id ?? null,
                ]);

        }
      }

        $title='نظام الأقساط';

        $breadcrumb = array();
        $breadcrumb[0]['title'] = " الرئيسية";
        $breadcrumb[0]['url'] = route("dashboard");
        $breadcrumb[1]['title'] = "عملاء الاقساط";
        $breadcrumb[1]['url'] = route("installment.admin");
        $breadcrumb[2]['title'] = $title;
        $breadcrumb[2]['url'] = 'javascript:void(0);';
        $data['id'] = $installment_id;

        return redirect()->back()->with('message', 'تم الدفع بنجاح');

    }

    public function add_install_money_all($installment_id, $counter, $amount, $type, $knet_code, $description)
    {
        $invoice = new Invoices_installment;
        $sum = $invoice->amount = $amount;

        if (empty($description)) {
            $description = "عملية  دفع($counter) قسط إجمالي  عن المعاملة  رقم " . " " . $installment_id;
        }

        $invoice->description = $description;
        $invoice->type = "income";
        $invoice->payment_type = $type;
        $invoice->install_pay_type = 'installment';

        if (!empty($knet_code)) {
            $invoice->knet_code = $knet_code;
        }

        $invoice->date = now();
        $invoice->install_month_id = 0;
        $invoice->debtor = 1;
        $invoice->installment_id = $installment_id;

        $last_invoice = Invoices_installment::latest()->first();

        if (!empty($last_invoice)) {

            switch ($last_invoice->type) {
                case "income":
                    $sum = $last_invoice->balance + $sum;
                    break;
                case "share_capital":
                    $sum = $last_invoice->balance  + $sum;
                    break;
                case "expenses":
                    $sum = $last_invoice->balance  - $sum;
                    break;
                case "export":
                    $sum = $last_invoice->balance  - $sum;
                    break;
                case "advance":
                    $sum = $last_invoice->balance  - $sum;
                    break;
                case "income_pending":
                    $sum = $last_invoice->balance ;
                    break;
                case "expenses_pending":
                    $sum = $last_invoice->balance ;
                    break;

                default:
                    break;
            }
        }

        $invoice->branch_id = Auth::user()->branch_id ?? null;
        $invoice->balance = $sum;
        $invoice->created_by = Auth::user()->id ?? null;
        $invoice->save();
    }

    public function pay_total_with_discount($installment_id, Request $request)
    {

        $messages = [

            'discount.required' => 'القيمة مطلوبة',
            'knet_code.required' => 'القيمة مطلوبة',
            'paper_img_dir.required' => 'الصورة مطلوبة',
        ];

        $validatedData = Validator::make($request->all(), [
            'discount' => 'required',
            'knet_code' => 'required',
            'paper_img_dir' => 'required',

        ], $messages);
        if ($validatedData->fails()) {
            return redirect()->back()
                ->withErrors($validatedData)
                ->withInput();
        }
      else
         {

        $installment = Installment::findOrFail($installment_id);
        $client = Client::where('id',$installment->client_id);
        $data['not_done_count'] = Installment_month::where('installment_id', $installment_id)->where('status', 'not_done')->where('installment_type','installment')->count();
        $data['not_done_amount'] =  Installment_month::where('installment_id', $installment_id)->where('status', 'not_done')->where('installment_type','installment')->get();

        $not_done_amount = $data['not_done_amount']->sum('amount');

        $military_affair = Military_affair::where('installment_id', $installment_id)->get();

        if ($installment->laws == 1 && ($not_done_amount != 0)) {

            $data['sum'] = $not_done_amount - $military_affair->excute_actions_amount - $military_affair->excute_actions_check_amount;

        } else {

            $data['sum'] = $not_done_amount;
        }

        $data['id'] = $installment_id;
        $installments = Installment_month::where('installment_id',$installment_id)->where('status','not_done')->get();
        $counter = count($installments);
        $months_id =array();
        for ($j = 0; $j < count($installments); $j++) {
            $months = Installment_month::where('installment_id',$installment_id)->where('status','not_done')->first();

            $months_id[] = $installments[$j]->id ;
            $months->payment_type = 'cash/knet/finish';

            $months->update([
                'status' => "done",
                'payment_date' => now(),
                'created_by' => Auth::user()->id ?? null
            ]);

            // $lawsaffairs = $this->db_get->get_where_r('lawsaffairs', 'installment_id', $installment_id);
            // if (!empty($lawsaffairs)) {
            //     $installment_type = $installments[$j]['installment_type'];
            //     $this->do_payment_to_tahseel($installments[$j]['installment_id'], $installments[$j]['amout'], $installment_type);
            // }
        }
        if ($request->discount_cash > 0) {

            $description = "عملية  دفع($counter) قسط إجمالي"
                . "مع خصم"
                . " بقيمة"
                . $$request->discount
                . " د.ك"
                . " "
                . "  عن المعاملة  رقم " . " " . $installment_id;

            $this->add_install_money_all($installment_id, $counter, $request->discount_cash, 'cash', '', $description);
            $this->add_install_money_all($installment_id, $counter, $request->cash, 'cash', '', '');
        }
        if ($request->discount_knet > 0) {
            $this->add_install_money_all($installment_id, $counter, $request->discount_knet, 'knet', $request->knet_code, '');
        }
        $installments_all = Installment_month::where('installment_id',$installment_id)->where('status','not_done')->get();
        if (empty($installments_all)) {
            $installment->finished = 1;
            $installment->created_by = Auth::user()->id ?? null;

            $installments_item_eqrar_dain = $this->all_eqrardeain_sql($installment_id);

            if (!empty($installments_item_eqrar_dain)) {
                $installment->please_cancel_eqrar_dain = 1;
            }

            $installment->update();
            $military_affairs_item_1 = Military_affair::where('installment_id', $installment_id)->get();
            if (!empty($military_affairs_item_1)) {

                $military_affairs_item_1::where('id',$military_affairs_item_1->id)->update([
                    'checking' => 1
                ]);
            }

               // $lawsaffair = $this->db_get->get_where_r('lawsaffairs', 'installment_id', $installment_id);

            // if (!empty($lawsaffair)) {
            //     $add_data67['finished'] = 1;

            //     $add_data67['tahseel'] = 1;

            //     $add_data67['tahseel_archive'] = 1;

            //     $add_data67['finished_date'] = time();

            //     $this->db_get->update_tb('lawsaffairs', $lawsaffair['id'], $add_data67);

            //     $total_amount_lawyer_tahseel = $this->total_amount_lawsaffairs_tahseel_invoices_sql('amount_lawyer', '');

            //     $total_amount_lawyer_received = $this->total_amount_lawsaffairs_tahseel_invoices_sql('amount_lawyer', '1');

            //     $lawyer_reminder_amount = $total_amount_lawyer_tahseel - $total_amount_lawyer_received;

            //     $message = 'لديك رصيد عمولة بمبلغ وقدره'
            //         . ' : '
            //         . $lawyer_reminder_amount
            //         . ' KD ';

            //     $phones = '60680264,55544445';

            //     if (strpos(base_url(), 'electronkw.com') !== false) {

            //         send_sms_helper($message, $phones);

            //     }

            //     // $this->send_sms($message, $phones);
            //     // echo '<pre>';  print_r($message );  exit;
            // }

         }
            $months= new Installment_month();
            $invoice =  Invoices_installment::where('install_month_id', 0)->where('installment_id',$installment_id)->get();

            $months->installment_id = $installment_id;
            $months->amount = $request->discount;
            $months->cinet_amount = 0;
            $months->internal_amount = 0;
            $months->img_dir = '';
            $months->notes = '';

            $months->installment_type = "discount";
            $months->hesab_file = 1;
            $months->status = "done";
            $months->created_by = Auth::user()->id ?? null;
            $months->date = now();
            $months->payment_date = now();

            $months->save();
            $months_id[] = Installment_month::latest()->first();

            if ($request->hasFile('paper_img_dir')) {
                $file = $request->file('paper_img_dir');
                $filePath = $file->store('uploads/new_photos', 'public');

                for ($j = 1; $j < count($months_id); $j++) {
                    $months::where('id',$j)->update([
                        'created_by' => Auth::user()->id ?? null,
                        'img_dir' => '/storage/' .$filePath,
                    ]);
                }
                foreach($invoice as $one){
                    $one->update([
                        'img' => '/storage/' .$filePath,
                        'created_by' => Auth::user()->id ?? null,
                    ]);
                }
            }

       }
        $title='نظام الأقساط';
        $breadcrumb = array();
        $breadcrumb[0]['title'] = " الرئيسية";
        $breadcrumb[0]['url'] = route("dashboard");
        $breadcrumb[1]['title'] = "عملاء الاقساط";
        $breadcrumb[1]['url'] = route("installment.admin");
        $breadcrumb[2]['title'] = $title;
        $breadcrumb[2]['url'] = 'javascript:void(0);';
        $data['id'] = $installment_id;

        return redirect()->back()->with('message', 'تم الدفع بنجاح');
    }

    public function pay_some_of_amount($installment_id, Request $request)
    {

        $messages = [
            'some_amount.required' => 'القيمة مطلوبة',
            'pay_way.required' => 'القيمة مطلوبة',
            'some_code.required' => 'القيمة  مطلوبة',
            'img_dir.required' => 'الصورة  مطلوبة',
        ];

        $validatedData = Validator::make($request->all(), [
            'some_amount' => 'required',
            'pay_way' => 'required',
            'some_code' => 'required',
            'img_dir' => 'required',
        ], $messages);
        if ($validatedData->fails()) {
            return redirect()->back()
                ->withErrors($validatedData)
                ->withInput();
        }
      else
         {

        $installment = Installment::findOrFail($installment_id);
        $installments = Installment_month::where('installment_id', $installment_id)->where('status', 'not_done')->where('installment_type','installment')->get();
        $first = Installment_month::where('installment_id', $installment_id)->where('status', 'not_done')->where('installment_type','installment')->first();


        // if ($first['installment_type'] == 'law_percent' or $first['installment_type'] == '2_._5_percent') {
        //     $installment_type = $installments[0]['installment_type'];
        //     $this->do_payment_to_tahseel($first['installment_id'], $first['amount'], $installment_type);

        // }


        $this->do_pay_to_bank($first->id, $request->some_amount, $request->pay_way);
        //  dd( );

        $months_id =array();
        $months = Installment_month::where('installment_id',$installment_id)->where('status','not_done')->first();

        for($i =0; $i < count($installments) ;$i++)

        // foreach($installments as $one)
        {

            if ($request->some_amount >= $installments[$i]['amount']) {

                $months_id[] = $installments[$i]['id'] ;
                $request->some_amount = $request->some_amount - $installments[$i]['amount'];

                $months->update([
                    'status' => "done",
                    'payment_date' => now(),
                    'created_by' => Auth::user()->id ?? null,
                    'payment_type' =>$request->pay_way,
                    'hesab_file' => 1
                ]);
            }
            else {
                if ($request->some_amount > 0) {
                    if($installments[$i]['installment_type'] == 'law_percent'){
                            $old_law_percent = $installments[$i]['amount'];
                        }

                    $reminder = $installments[$i]['amount'] - $request->some_amount;
                    $months_id[] = $installments[$i]['id'] ;

                    if ($request->some_amount > 0) {

                        $months->update([
                            'amount' => $installments[$i]['amount'],
                            'notes' => $reminder . "تم ترحيل جزء من القسط للشهر التالي وقدره :  ",
                            'created_by' => Auth::user()->id ?? null,
                        ]);

                        if($installments[$i]['installment_type'] =='law_percent') {
                            $months->amount = $old_law_percent - $request->some_amount;
                            $months->status = "not_done";
                            $months->installment_id = $installment_id;
                            $months->installment_type = "law_percent";
                            $months->date = now();
                            $months->notes = $reminder . "تم ترحيل جزء من  اتعاب المحامى  وقدره :  ";
                            $months->created_by = Auth::user()->id ?? null;

                            $months->save();
                        }
                    }
                    // $last_month = Installment_month::latest()->first();

                    $months = new Installment_month();
                    if (!empty($installments[$i + 1])) {

                        $months::where('id',$installments[$i + 1]['id'])->update([
                            'amount' => $installments[$i + 1]['amount'] + $reminder,
                            'notes' =>  $reminder . "تم إضافة جزء من القسط السابق وقدره :  ",
                            'created_by' => Auth::user()->id ?? null,
                        ]);
                    }
                }
                $request->some_amount = $request->some_amount - $installments[$i]['amout'];
            }

        }

                if (empty($months)) {

                    $installment->update([
                        'finished' => 1,
                        'finished_user_id' => Auth::user()->id ?? null,
                    ]);

                    $military_affairs_item_1 = Military_affair::where('installment_id', $installment_id)->get();
                    if (!empty($military_affairs_item_1)) {

                        $military_affairs_item_1::where('id',$military_affairs_item_1->id)->update([
                            'checking' => 1
                        ]);
                    }
                }

                $months = new Installment_month;
                $invoice =  Invoices_installment::where('install_month_id', $installments[0]['id'])->where('installment_id',$installment_id)->get();

                if ($request->hasFile('img_dir')) {
                    $file = $request->file('img_dir');
                    $filePath = $file->store('uploads/new_photos', 'public');

                    for ($j = 1; $j < count($months_id); $j++) {
                        $months::where('id',$j)->update([
                            'created_by' => Auth::user()->id ?? null,
                            'img_dir' => '/storage/' .$filePath,
                        ]);
                    }
                    foreach($invoice as $one){
                        $one->update([
                            'img' => '/storage/' .$filePath,
                            'created_by' => Auth::user()->id ?? null,
                        ]);
                    }
                }
         }

         $title='نظام الأقساط';
         $breadcrumb = array();
         $breadcrumb[0]['title'] = " الرئيسية";
         $breadcrumb[0]['url'] = route("dashboard");
         $breadcrumb[1]['title'] = "عملاء الاقساط";
         $breadcrumb[1]['url'] = route("installment.admin");
         $breadcrumb[2]['title'] = $title;
         $breadcrumb[2]['url'] = 'javascript:void(0);';
         $data['id'] = $installment_id;

         return redirect()->back()->with('message', 'تم الدفع بنجاح');
    }

    public function do_pay_to_bank($installment_month_id, $amount, $payment_type)
    {

        $month = Installment_month::findORFail($installment_month_id);
        $invoice = new Invoices_installment;

        $sum = $invoice->amount = $amount;
        $invoice->description = "عملية دفع جزء ";
        $invoice->payment_type = $payment_type;
        $invoice->type = "income";
        $invoice->date = now();
        $invoice->install_month_id = $installment_month_id;
        $invoice->installment_id = $month->installment_id;
        $invoice->debtor = 1;
        $invoice->install_pay_type = 'installment';

        $last_invoice = Invoices_installment::latest()->first();

        if ($payment_type == "knet") {
            $invoice->balance_knet = $last_invoice->balance_knet + $sum;
            $invoice->balance_cash = $last_invoice->balance_cash;
            $invoice->balance_bank = $last_invoice->balance_bank;
           // update_invoice_central_bank('knet', '+', $invoice->amount, 'installment');

        } else {
            $invoice->balance_cash = $last_invoice->balance_cash ?? + $sum ;
            $invoice->balance_knet = $last_invoice->balance_knet ?? 0;
            $invoice->balance_bank = $last_invoice->balance_bank ?? 0;
            //update_invoice_central_bank('cash', '+', $invoice->amount, 'installment');

        }

        $sum = $last_invoice->balance ?? + $sum;
        $invoice->balance = $sum;
        $invoice->branch_id = Auth::user()->branch_id ?? null;
        $invoice->created_by = Auth::user()->id ?? null;
        $invoice->save();

    }
    public function get_sum_installments($installment_id, Request $request)
    {


        $messages = [
            'cash.required' => 'القيمة مطلوبة',
            'knet.required' => 'القيمة مطلوبة',
            'knet_code.required' => 'الوصل  مطلوب',
        ];

        $validatedData = Validator::make($request->all(), [
            'cash' => 'required',
            'knet' => 'required',
            'knet_code' => 'required'

        ], $messages);
        if ($validatedData->fails()) {
            return redirect()->back()
                ->withErrors($validatedData)
                ->withInput();
        }
      else
         {

            $insall_ids = $request->payment_order_id;
            $installments = Installment_month::where('status','not_done')->where('installment_id',$installment_id)->get();
            $invoice =  new Invoices_installment();

            $sum = 0.000;


            if ($request->hasFile('paper_img_dir')) {
                $file = $request->file('paper_img_dir');
                $filePath = $file->store('uploads/new_photos', 'public');
                 $months = new Installment_month();
                for ($j = 1; $j < count($insall_ids); $j++) {


                    $months::where('id',$j)->update([
                        'created_by' => Auth::user()->id ?? null,
                        'img_dir' => '/storage/' .$filePath,
                    ]);
                }
                    $invoice->update([
                        'img' => '/storage/' .$filePath,
                        'created_by' => Auth::user()->id ?? null,
                    ]);

            }

            for ($j = 0; $j < count($insall_ids); $j++) {
                $months = Installment_month::where('id',$insall_ids[$j])->where('status','not_done')->first();
                $sum = $sum + $installments[$j]['amount'];
                    if ($request->cash > 0 and $request->knet > 0) {
                        $months->payment_type = "cash/knet";
                    } elseif ($request->cash > 0) {
                        $months->payment_type  = "cash";
                    } else {
                        $months->payment_type  = "knet";
                    }

                $months::where('id',$insall_ids[$j])->update([
                    'status' => "done",
                    'payment_date' => now(),
                    'created_by' => Auth::user()->id ?? null,
                ]);
            }

            if ($request->cash > 0) {
                $this->add_install_money_all($installment_id, count($insall_ids), $request->cash, 'cash', '', '');
            }
            if ($request->knet > 0) {
                $this->add_install_money_all($installment_id, count($insall_ids), $request->knet, 'knet', $request->knet_code, '');
            }

            if (empty($installments)) {
                 $inst =  Installment::findORFail($installment_id);

               $installments_item_eqrar_dain = Installment::where([
                'cancel_eqrar_dain'=> 0,
                'qard_paper' => 'LIKE %uploads/%',
                'id' => $installment_id
               ])->first();

                if (!empty($installments_item_eqrar_dain)) {
                    $inst->please_cancel_eqrar_dain = 1;
                }
                $inst->update([
                    'finished' => 1,
                ]);
            }

      return redirect()->back()->with('message', 'تم الدفع بنجاح',$data);
     }
    }


    public function lated_installments()
    {
        // dd($status);
        //

        $current_time = Carbon::now();
        $title = 'العملاء المتأخرين';

        $breadcrumb = array();
        $breadcrumb[0]['title'] = " الرئيسية";
        $breadcrumb[0]['url'] = route("dashboard");
        $breadcrumb[1]['title'] = "عملاء الاقساط";
        $breadcrumb[1]['url'] = route("installment.admin");
        $breadcrumb[2]['title'] = $title;
        $breadcrumb[2]['url'] = 'javascript:void(0);';

        $data['Installment'] = Installment::with([
            'user',
            'client',
            'eqrar_not_recieve',
            'installment_months',
            'militay_affairs',
            'installment_client'
        ])
            ->where('installment.type', 'installment')
            ->where('installment.status', 'finished')
            ->where('installment.laws', '0')
            ->where('installment.finished', '0')
            ->whereHas('installment_months', function ($query) use ($current_time) {
                $query->where('status', 'not_done') // Only select 'not_done' status
                ->where(function ($subQuery) use ($current_time) {
                    $subQuery->where('date', '<', $current_time)
                             ->where(function ($q) use ($current_time) {
                                 $q->where('late_date', '<', $current_time)
                                   ->orWhere('late_date', '=', 0); // Only overdue dates or no late date
                             });
                });
                     // Apply status directly on the query
            })
            ->whereHas('installment_months', function ($query) {
                $query->where('date', '!=', 131313); // Exclude specific date in the has query
            })
            ->get();

        if ($data) {
            // $user_id = 1;
              $user_id =  Auth::user()->id ?? null;
            $message = "تم دخول صفحة العملاء المتأخرين";
            $this->log($user_id, $message);
        }
        // dd($data);

        $data['view'] = 'installment/lated_installments';
        return view('layout', $data, compact('breadcrumb','data'));

        //    return view('installment.index',compact('data'));

        //  return $this->respondSuccess($data, 'Get Data successfully.');

    }


    public function lated_installments_update($id)
    {
        // dd($status);
        //

        // $current_time = Carbon::now();
        // $title = 'العملاء المتأخرين';

        // $breadcrumb = array();
        // $breadcrumb[0]['title'] = " الرئيسية";
        // $breadcrumb[0]['url'] = route("dashboard");
        // $breadcrumb[1]['title'] = "عملاء الاقساط";
        // $breadcrumb[1]['url'] = route("installment.admin");
        // $breadcrumb[2]['title'] = $title;
        // $breadcrumb[2]['url'] = 'javascript:void(0);';

        $data['Installment'] = Installment::find($id);
        $data['Installment']->laws = "1";
        $data['Installment']->save();

        if ($data) {
            // $user_id = 1;
            $user_id =  Auth::user()->id;
            $message = "تم تحويل هدة المعاملة الى الشءون القانونية ";
            $this->log($user_id, $message);
        }

        // dd($data);

        // $data['view'] = 'installment/lated_installments';
        // return view('layout', $data, compact('breadcrumb','data'));

        return redirect()->back();

        //    return view('installment.index',compact('data'));

        //  return $this->respondSuccess($data, 'Get Data successfully.');

    }


    public function warning_print_paper($id)
    {

        $data["item"] =$installment =Installment::findorfail($id);
      //  dd($data["item"]['client_id']);

        $client = Client::findorfail($data["item"]['client_id']);

        $not_done_count= $installment->getCountAttribute('not_done');

        $not_done_count_lated = $installment->count_installment_lated();


        $add_data["warning_print_user_id"] = Auth::user()->id ?? null;

        $add_data["warning_print_date"] = date('Y-m-d H:i:s');

       $installment->update($add_data);



        return view('installment.warning_print_paper', compact('installment','client','not_done_count' ,'not_done_count_lated' ));


    }


   public function print_contrct($id)
    {

        $args = func_get_args();

        $id = $args[0];

        if (count($args) == 1) {

            $kafil_id = 0;
            $start_date = 0;
        } elseif (count($args) == 2) {

            $kafil_id = 0;
            $start_date = $args[1];
        } else {
            $kafil_id = $args[1];
            $start_date = $args[2];
        }


        $installment = Installment::findorfail($id);


        $client = Client::findorfail($installment->client_id);


        $nationality = Nationality::findorfail($client['nationality_id'])->name_ar;


        if ($start_date != 0) {
            $data["item"]['start_date'] = strtotime($start_date);
        }


        $not_done_count = $installment->getCountAttribute('not_done');


        //  $data["items"] = $this->db_get->get_where_conditions('installment_months', $conditions);
        $items = Installment_month::where('installment_id', '=', $installment->id)->get();


        return view('installment.print_contrct', compact('installment', 'client', 'not_done_count', 'items', 'nationality'));


    }

    public function print_finished_installments($id)
    {
        $installment = Installment::findOrFail($id);
        $clients = Client::with(['bank'])->where('id', $installment->client_id)->first();
        // dd( $clients);
        return view('installment.print_finished_installments', compact(('clients')));
    }


    public function print_recive_ins_money($installment_id, $id){
        $installment = Installment::findOrFail($installment_id);
        $months = Installment_month::where('id',$id)->first();
        // dd( $clients);
        return view('installment.print_recive_ins_money', compact('installment','months'));
    }

    public function madionia_certificate($installment_id){
        $installment = Installment::findOrFail($installment_id);
        $Military_affair = Military_affair::where('installment_id',$installment_id)->first();
        $invoices_installment = Invoices_installment::where('installment_id',$installment_id)->first();
        $months = Installment_month::where('installment_id', $installment_id)->where('status','done')->orderBy('id', 'desc')->first();
        // dd( $clients);
        return view('installment.madionia_certificate', compact('installment','Military_affair','invoices_installment','months'));
    }


      public function print_install_paper_info($id)
    {


        $item = Installment::findorfail($id);

        //$data["client"] = $this->db_get->get_by_id('clients',$data["item"]['client_id']);

        $client = Client::findorfail($item->client_id);



       $rec_name = Auth::user()->name_ar;



        return view('installment.print_install_paper_info', compact('item', 'client','rec_name'));

    }

    public function recive_install_paper($id)
    {


        $item = Installment::findorfail($id);


        $client = Client::findorfail($item->client_id);


        $rec_name = Auth::user()->name_ar;


        return view('installment.recive_install_paper', compact('item', 'client', 'rec_name'));
    }


    public function print_invoice($id)
    {

          $data['order_id'] = $id;

           $order =Order::findorfail($id);
           $client = Client::findorfail($order->client_id);
        $user_name = Auth::user()->name_ar;
       //    dd($order->order_items);

          /* $data["items"] = $this->order_prods_details_sql($id);
           // echo '<pre>';print_r($data); //exit;
           for ($i = 0; $i < count($data["items"]); $i++) {

               $data["items"][$i]['items_serial_numbers'] = $this->get_serial_numbers_by_prod_sql($id, $data["items"][$i]['product_id']);
           }*/


        return view('installment.print_invoice',compact('order','client','user_name'));

    }

    public function show_upload_papers($id)
    {
        $title = ' نظام  الاقساط';

        $breadcrumb = array();
        $breadcrumb[0]['title'] = " الرئيسية";
        $breadcrumb[0]['url'] = route("dashboard");
        $breadcrumb[1]['title'] = 'تفاصيل المعاملة';
        $breadcrumb[1]['url'] = url('installment/installment.show-installment/' . $id);
        $breadcrumb[2]['title'] = $title;
        $breadcrumb[2]['url'] = 'javascript:void(0);';
        $data['view'] = 'installment/upload_papers';
        $item= Installment::findorfail($id);
        return view('layout', $data, compact('breadcrumb', 'item'));


    }


    public function upload_papers(Request $request)
    {
        $id = $request->installment_id;


        $data['installment'] = $installment = Installment::findorfail($id);
        $data['item'] = $installment_clients_id = Installment_Client::findorfail($data['installment']['installment_clients']);


        if ($request->hasFile('contract_1')) {
          
            $filename = time() . '-' . $request->file('contract_1')->getClientOriginalName();
            $path = $request->file('contract_1')->move(public_path('installment'), $filename);
            $add_data['contract_1'] = 'installment' . '/' . $filename; 
        }
        if ($request->hasFile('contract_2')) {
            $filename = time() . '-' . $request->file('contract_2')->getClientOriginalName();
            $path = $request->file('contract_2')->move(public_path('installment'), $filename);
            // $add_data['contract_2'] = $request->file('contract_2')->store('installment', 'public'); // Store in the 'products' directory
            $add_data['contract_2'] = 'installment' . '/' . $filename; 
        }
        if ($request->hasFile('contract_cinet_1')) {
            $filename = time() . '-' . $request->file('contract_cinet_1')->getClientOriginalName();
            $path = $request->file('contract_cinet_1')->move(public_path('installment'), $filename);
            // $add_data['contract_cinet_1'] = $request->file('contract_cinet_1')->store('installment', 'public'); // Store in the 'products' directory
            $add_data['contract_cinet_1'] = 'installment' . '/' . $filename;
        }
        if ($request->hasFile('contract_cinet_2')) {
            $filename = time() . '-' . $request->file('contract_cinet_2')->getClientOriginalName();
            $path = $request->file('contract_cinet_2')->move(public_path('installment'), $filename);
            // $add_data['contract_cinet_2'] = $request->file('contract_cinet_2')->store('installment', 'public'); // Store in the 'products' directory
            $add_data['contract_cinet_2'] = 'installment' . '/' . $filename;
        }
        if ($request->hasFile('prods_recieved_img')) {
            $filename = time() . '-' . $request->file('prods_recieved_img')->getClientOriginalName();
            $path = $request->file('prods_recieved_img')->move(public_path('installment'), $filename);
            // $add_data['prods_recieved_img'] = $request->file('prods_recieved_img')->store('installment', 'public'); // Store in the 'products' directory
            $add_data['prods_recieved_img'] = 'installment' . '/' . $filename;
        }
        if ($request->hasFile('qard_paper_img')) {
            $filename = time() . '-' . $request->file('qard_paper_img')->getClientOriginalName();
            $path = $request->file('qard_paper_img')->move(public_path('installment'), $filename);
            // $add_data['qard_paper_img'] = $request->file('qard_paper_img')->store('installment', 'public'); // Store in the 'products' directory
            $add_data['qard_paper_img'] = 'installment' . '/' . $filename;
        }

        if (!empty($add_data)) {

            $installment->update($add_data);
        } else {

            return redirect()->back()->with('error', 'برجاء رفع الصور');
        }

        $the_note = ' رفع العقود ونماذج الاستلام من داخل تفاصيل الاقساط';
        $data = new InstallmentNote();
        $data->connect = "note";
        $data->date = now()->format('Y-m-d');
        $data->time = now()->format('h:i:s');
        $data->installment_clients_id = $installment_clients_id;
        $data->client_id = $installment->client_id;
        $data->note = $the_note;
        $data->created_by = Auth::user()->id ?? null;
        $data->updated_by = Auth::user()->id ?? null;
        $data->save();

        return redirect()->route('installment.show-installment', $id)->with('success', 'تم العملية بنجاح');
    }

    public function edit_images($id)
    {

        $title = '   تعديل بيانات';

        $breadcrumb = array();
        $breadcrumb[0]['title'] = " الرئيسية";
        $breadcrumb[0]['url'] = route("dashboard");
        $breadcrumb[1]['title'] = 'تفاصيل المعاملة';
        $breadcrumb[1]['url'] = url('installment/installment.show-installment/' . $id);
        $breadcrumb[2]['title'] = $title;
        $breadcrumb[2]['url'] = 'javascript:void(0);';
        $data['view'] = 'installment/edit_images';

        return view('layout', $data, compact('breadcrumb', 'id'));


    }

    public function upload_edit_images(Request $request)
    {
        // dd($request->installment_id);


        $id = $request->installment_id;


        $data['installment'] = $installment = Installment::findorfail($id);
        $data['client'] = $clients = Client::findorfail($data['installment']['client_id']);
        $client_data_image = [];
        $installment_data_image = [];


        if ($request->hasFile('civil_img')) {
            $client_data_image['civil_img'] = $request->file('civil_img')->store('clients', 'public'); // Store in the 'products' directory
            $data_add['type'] = 'civil_img';
            $data_add['path'] = $client_data_image['civil_img'];
        }
        if ($request->hasFile('salary_img')) {
            $client_data_image['salary_img'] = $request->file('salary_img')->store('clients', 'public'); // Store in the 'products' directory
            $data_add['type'] = 'salary_img';
            $data_add['path'] = $client_data_image['salary_img'];
        }
        if ($request->hasFile('cid_img1')) {
            $client_data_image['cid_img1'] = $request->file('cid_img1')->store('clients', 'public'); // Store in the 'products' directory
            $data_add['type'] = 'cid_img1';
            $data_add['path'] = $client_data_image['cid_img1'];
        }
        if ($request->hasFile('cid_img_2')) {
            $client_data_image['cid_img_2'] = $request->file('cid_img_2')->store('clients', 'public'); // Store in the 'products' directory
            $data_add['type'] = 'cid_img_2';
            $data_add['path'] = $client_data_image['cid_img_2'];
        }
        if ($request->hasFile('cinet_img')) {
            $client_data_image['cinet_img'] = $request->file('cinet_img')->store('clients', 'public'); // Store in the 'products' directory
            $data_add['type'] = 'cinet_img';
            $data_add['path'] = $client_data_image['cinet_img'];
        }
        if ($request->hasFile('work_img')) {
            $client_data_image['work_img'] = $request->file('work_img')->store('clients', 'public');
            $data_add['type'] = 'work_img';
            $data_add['path'] = $client_data_image['work_img'];
        }
        if ($request->hasFile('my_img')) {
            $client_data_image['my_img'] = $request->file('my_img')->store('clients', 'public'); // Store in the 'products' directory
            $data_add['type'] = 'my_img';
            $data_add['path'] = $client_data_image['my_img'];
        }
        /////installment_images

        if ($request->hasFile('contract_1')) {
            $installment_data_image['contract_1'] = $request->file('contract_1')->store('installment', 'public'); // Store in the 'products' directory
        }
        if ($request->hasFile('contract_2')) {
            $installment_data_image['contract_2'] = $request->file('salary_img')->store('installment', 'public'); // Store in the 'products' directory
        }
        if ($request->hasFile('contract_cinet_2')) {
            $installment_data_image['contract_cinet_2'] = $request->file('contract_cinet_2')->store('installment', 'public'); // Store in the 'products' directory
        }
        if ($request->hasFile('contract_cinet_1')) {
            $installment_data_image['contract_cinet_1'] = $request->file('contract_cinet_1')->store('installment', 'public'); // Store in the 'products' directory
        }
        if ($request->hasFile('qard_paper_img')) {
            $installment_data_image['qard_paper_img'] = $request->file('qard_paper_img')->store('installment', 'public'); // Store in the 'products' directory
        }
        if ($request->hasFile('prods_recieved_img')) {
            $installment_data_image['prods_recieved_img'] = $request->file('prods_recieved_img')->store('installment', 'public');
        }
        if ($request->hasFile('part_10_dinar_img')) {
            $installment_data_image['part_10_dinar_img'] = $request->file('part_10_dinar_img')->store('installment', 'public'); // Store in the 'products' directory
        }
        if ($request->hasFile('part_paper')) {
            $installment_data_image['part_paper'] = $request->file('part_paper')->store('installment', 'public'); // Store in the 'products' directory
        }
        if ($request->hasFile('laws_paper_print_img')) {
            $installment_data_image['laws_paper_print_img'] = $request->file('laws_paper_print_img')->store('installment', 'public'); // Store in the 'products' directory
        }
        if ($request->hasFile('kafil_amana')) {
            $installment_data_image['kafil_amana'] = $request->file('kafil_amana')->store('installment', 'public'); // Store in the 'products' directory
        }

        for ($i = 1; $i <= count($client_data_image); $i++) {
            $data_add['client_id'] = $clients->id;
            $data_add['created_by'] = Auth::user()->id;
            $data_add['updated_by'] = Auth::user()->id;
            $data_add['created_at'] = date('Y-m-d-H-i-s');
            $data_add['updated_at'] = date('Y-m-d-H-i-s');
            ClientImg::insert($data_add);
        }
        $installment->update($installment_data_image);

        if (count($client_data_image) == 0 && count($installment_data_image) == 0) {

            return redirect()->back()->with('error', 'برجاء رفع الصور');
        } else {

            return redirect()->route('installment.show-installment', $id)->with('success', 'تم العملية بنجاح');
        }


    }

}
