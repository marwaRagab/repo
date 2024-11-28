<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Bank;
use App\Models\Order;
use App\Models\Client;
use App\Models\Regions;
use App\Models\Ministry;
use App\Models\ClientImg;
use App\Models\OrderItem;
use App\Models\ClientPhone;
use App\Models\Installment;
use App\Models\Nationality;
use Illuminate\Http\Request;
use App\Models\ClientAddress;
use App\Models\ClientWorking;
use App\Models\ClientMinistry;
use App\Models\Installment_month;
use App\Models\Installment_Client;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\InstallmentClientNote;
use App\Models\Showroom\products_items;
use App\Models\Installment_Client_Cinet;
use Illuminate\Support\Facades\Validator;
use App\Models\ImportingCompanies\Product;
use App\Models\InvoicesInstallment\Invoices_installment;

class InstallmentApproveController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($id)
    {
        //

        $data = Installment_Client::find($id);
        $working = ClientWorking::where('installment_clients_id', $id)->first();
        $cinetCount = DB::table('installment_client_cinet')->where('installment_clients_id', $id)->get();
        $ministry = Ministry::where('id', $data->ministry_id)->first();
        $nationality = Nationality::all();
        $region = Regions::all();
        $bank = Bank::all();
        $total_cient = Installment_Client_Cinet::where('installment_clients_id', $data->id)->sum('file_debit_amount_1');

          $user_id =  Auth::user()->id ?? null;
        $message = "تم الدخول الى صقحة المعاملات المقبولة " ;
        $this->log($user_id,$message);

        return view('installmentClient.transaction_approval', compact('data', 'working', 'cinetCount', 'ministry', 'nationality', 'region', 'bank', 'total_cient'));
    }

    public function indexCopy($id)
    {

        $title = 'اعتماد المعاملة';

        $breadcrumb = array();
        $breadcrumb[0]['title'] = " الرئيسية";
        $breadcrumb[0]['url'] = route("dashboard");
        $breadcrumb[1]['title'] = "عملاء الاقساط";
        $breadcrumb[1]['url'] = route("installmentApprove.indexCopy",$id);
        $breadcrumb[2]['title'] = $title;
        $breadcrumb[2]['url'] = 'javascript:void(0);';


        $data = Installment_Client::find($id);
        $working = ClientWorking::where('installment_clients_id', $id)->first();
        $cinetCount = DB::table('installment_client_cinet')->where('installment_clients_id', $id)->get();
        $ministry = Ministry::where('id', $data->ministry_id)->first();
        $nationality = Nationality::all();
        $region = Regions::all();
        $bank = Bank::all();
        $total_cient = Installment_Client_Cinet::where('installment_clients_id', $data->id)->sum('file_debit_amount_1');


        $user_id =  Auth::user()->id ?? null;
        $message = "تم الدخول الى صقحة المعاملات المقبولة " ;
        $this->log($user_id,$message);

        $d = [
            'Installment' => '',
            'view' => 'installmentClient/transaction_approvalCopy'
        ];


        // $data['view'] = 'installment/convert_approvedCopy';
        return view('layout', $d, compact('breadcrumb','d','data', 'working', 'cinetCount', 'ministry', 'nationality', 'region', 'bank', 'total_cient'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
//         dd($request);
        $messages = [
            "price_cost" => " price_cost required",
            "products" => " products required",
            "cost_install" => "cost_install required",
            "part" => "part required",
            "extra_first_amount" => " extra_first_amount required",
            "count_months" => " count_monthsrequired",
            "total" => " total required",
            "total_first_amount" => " total_first_amount required",
            "final_total" => " final_total required",
            "monthly_amount" => "monthly_amount required",
            "cinet_installment" => " cinet_installment required",
            "intrenal_installment" => " intrenal_installment required",
            "start_date" => " start_date required",
            "first_amount_pay_type" => " first_amount_pay_type required",
            "eqrardain_amount" => " eqrardain_amount required",
            // "notes" => "notes required",
            "name_ar" => "name_ar required",
            "civil_number" => " civil_number required",
            "first_name_ar" => " first_name_ar required",
            "second_name_ar" => " second_name_ar required",
            "third_name_ar" => "third_name_ar required",
            // "fourth_name_ar" => "fourth_name_arrequired",
            //"fifth_name_ar" => "fifth_name_ar required",
            "first_name_en" => "first_name_en required",
            "second_name_en" => "second_name_en required",
            "third_name_en" => " third_name_en required",
            //  "fourth_name_en" => "fourth_name_en required",
            // "fifth_name_en" => "fifth_name_en required",
            "gender" => "gender required",
            "nationality" => " nationality required",
            "phone" => "phone required",
            "phone_land" => "phone_land required",
            "nearist_phone1" => " nearist_phone1 required",
            "phone_work1" => "phone_work1 required",
            "nearist_phone2" => "nearist_phone2 required",
            "phone_work2" => " phone_work2 required",
            "region" => "region required",
            "block" => "block required",
            "street" => " street required",
            "jada" => "jada required",
            "building" => "building required",
            // "floor" => "floor required",
            //  "flat" => "flat required",
            "house_id" => "house_id required",
            "salary" => "Salary required",
            "bank" => "bank required",
            "ipan" => "ipan required",
            "location" => "location required",
            "kwfinder" => "kwfinder required",
            "email" => "email required",
            "checkbox" => "checkbox required",
            "qard_year" => "qard_year required",
            "qard_place" => "qard_place required",
            "qard_number" => "qard_number required",
            // "rules" => "rules required",
            "personal_image" => "personal_image required",
            "work_image" => "work_image required",
            "qard_paper" => "qard_paper required",
        ];

        $validatedData = Validator::make($request->all(), [
            "price_cost" => "required",
            "products" => "required",
            "cost_install" => "required",
            "part" => "required",
            "extra_first_amount" => "required",
            "count_months" => "required",
            "total" => "required",
            "total_first_amount" => "required",
            "final_total" => "required",
            "monthly_amount" => "required",
            "cinet_installment" => "required",
            "intrenal_installment" => "required",
            "start_date" => "required",
            "first_amount_pay_type" => "required",
            "eqrardain_amount" => "required",
            // "notes" => "required",
            "name_ar" => "required",
            "civil_number" => "required",
            "first_name_ar" => "required",
            "second_name_ar" => "required",
            "third_name_ar" => "required",
            //"fourth_name_ar" => "required",
            // "fifth_name_ar" => "required",
            "first_name_en" => "required",
            "second_name_en" => "required",
            "third_name_en" => "required",
            //  "fourth_name_en" => "required",
            // "fifth_name_en" => "required",
            "gender" => "required",
            // "nationality" => "required",
            "phone" => "required",
            "phone_land" => "required",
            "nearist_phone1" => "required",
            "phone_work1" => "required",
            "nearist_phone2" => "required",
            "phone_work2" => "required",
            "region" => "required",
            "block" => "required",
            "street" => "required",
            "jada" => "required",
            "building" => "required",
            // "floor" => "required",
            //"flat" => "required",
            "house_id" => "required",
            "salary" => "required",
            "bank" => "required",
            "ipan" => "required",
            "location" => "required",
            "kwfinder" => "required",
            // "email" => "required",
            "checkbox" => "required",
            "qard_year" => "required",
            "qard_place" => "required",
            "qard_number" => "required",
            // "rules" => "required",
            "personal_image" => "required",
            "work_image" => "required",
            "qard_paper" => "required",

        ], $messages);

        if ($validatedData->fails()) {


            return redirect()->back()->withErrors($validatedData)->withInput();
        }


        $client = new Client;
        $client->name_ar = $request->name_ar;
        $client->civil_number = $request->civil_number;
        $client->first_name_ar = $request->first_name_ar;
        $client->second_name_ar = $request->second_name_ar;
        $client->third_name_ar = $request->third_name_ar;
        //  $client->fourth_name_ar = $request->fourth_name_ar;
        // $client->fifth_name_ar = $request->fifth_name_ar;
        $client->first_name_en = $request->first_name_en;
        $client->second_name_en = $request->second_name_en;
        $client->third_name_en = $request->third_name_en;
        $client->fourth_name_en = $request->fourth_name_en;
        $client->fifth_name_en = $request->fifth_name_en;
        $client->gender = $request->gender;
        $client->nationality_id = $request->nationality;
        $client->ministry_ids = json_encode($request->ministry_id);
        $client->bank_ids = json_encode($request->bank);
        $client->ipan = $request->ipan;
        $client->location = $request->location;
        $client->kwfinder = $request->kwfinder;
        // $client->email = $request->email;
        $client->check_on_identity = $request->has('checkbox') ? 1 : 0;
        $client->salary = $request->salary;
        $client->house_id = $request->house_id;
        $client->created_by = Auth::user()->id ?? null;
        $client->updated_by = Auth::user()->id ?? null;
        $client->save();

        $ClientMinistry = new ClientMinistry;
        $ClientMinistry->client_id = $client->id;
        $ClientMinistry->ministry_id = $request->ministry_id;
        $ClientMinistry->save();

        $installment_client = Installment_Client::find($request->installment_client_id);
        $installment_client->client_id = $client->id;
        $installment_client->email = $request->email;
        $installment_client->status = "installment_client";
        $installment_client->cinet_installment = $request->cinet_installment;
        $installment_client->updated_by = Auth::user()->id ?? null;
        $installment_client->save();

        // address
        $address = new ClientAddress;
        $address->client_id = $client->id;
        $address->block = $request->block;
        $address->street = $request->street;
        $address->jada = $request->jada;
        $address->building = $request->building;
        $address->floor = $request->floor;
        $address->flat = $request->flat;
        $address->area_id = $request->region;
        $address->house_id = $request->house_id;
        $address->created_by = Auth::user()->id ?? null;
        $address->updated_by = Auth::user()->id ?? null;
        $address->save();

        // phone
        $phoneData = [
            [
                'name' => $request->nearist_phone1,
                'nearist_phone' => $request->phone_work1,
            ],
            [
                'name' => $request->nearist_phone2,
                'nearist_phone' => $request->phone_work2,
            ]
        ];
        foreach ($phoneData as $data) {
            $phone = new ClientPhone;
            $phone->client_id = $client->id;
            $phone->name = $data['name'];
            $phone->phone_land = $request->phone_land;
            $phone->nearist_phone = $data['nearist_phone'];
            $phone->phone = $request->phone;
            $phone->created_by = Auth::user()->id ?? null;
            $phone->updated_by = Auth::user()->id ?? null;
            $phone->save();
        }

        // image
        if ($request->hasFile('personal_image')) {
            $filename = time() . '-' . $request->file('personal_image')->getClientOriginalName();
            $personalImagePath = $request->file('personal_image')->move(public_path('client_images'), $filename);
            // $personalImagePath = $request->file('personal_image')->store('client_images', 'public');
            $img = new ClientImg;
            $img->name = $request->file('personal_image')->getClientOriginalName();
            $img->client_id = $client->id;
            $img->path = 'client_images' . '/' . $filename;
            $img->type = "my_img";
            $img->created_by = Auth::user()->id ?? null;
            $img->updated_by = Auth::user()->id ?? null;
            $img->save();
        }

        if ($request->hasFile('work_image')) {
            $filename = time() . '-' . $request->file('work_image')->getClientOriginalName();
            $workImagePath = $request->file('work_image')->move(public_path('client_images'), $filename);

            $img = new ClientImg;
            $img->name = $request->file('work_image')->getClientOriginalName();
            $img->client_id = $client->id;
            $img->path = 'client_images' . '/' . $filename;
            $img->type = "work_img";
            $img->created_by = Auth::user()->id ?? null;
            $img->updated_by = Auth::user()->id ?? null;
            $img->save();
        }
        // $img = new ClientImg;
        // $img->name = $request->personal_image;
        // $img->client_id = $client->id;
        // $img->path = $request->path;
        // $img->type="personal";
        // $img->created_by = Auth::user()->id ?? null;
        // $img->updated_by = Auth::user()->id ?? null;
        // $img->save();

        // $img = new ClientImg;
        // $img->name = $request->work_image;
        // $img->client_id = $client->id;
        // $img->path = $request->path;
        // $img->type="working";
        // $img->created_by = Auth::user()->id ?? null;
        // $img->updated_by = Auth::user()->id ?? null;
        // $img->save();

        // installment
        $qard_paperPath = $request->file('qard_paper')->store('qard_paper', 'public');

        $installment = new Installment;
        $installment->qard_year = $request->qard_year;
        $installment->client_id = $client->id;
        $installment->installment_clients = $installment_client->id;
        $installment->qard_place = $request->qard_place;
        $installment->qard_number = $request->qard_number;
        $installment->rules = $request->rules;
        $installment->qard_paper = $qard_paperPath;
        $installment->cost_install = $request->price_cost;
        $installment->cost_product = $request->cost_install;
        $installment->part = $request->part;
        $installment->first_amount = $request->part;
        $installment->total_first_amount = $request->total_first_amount;

        $installment->amount = $request->final_total;
        $installment->extra_part = $request->extra_first_amount;
        $installment->count_months = $request->count_months;
        $installment->months = $request->count_months;

        $installment->final_installment_amount = $request->total;
        $installment->total_madionia = $request->total;
        $installment->extra_first_amount = $request->extra_first_amount;

        $installment->total_part = $request->total_first_amount;
        $installment->total = $request->final_total;
        $installment->monthly_amount = $request->monthly_amount;
        $installment->installment = $request->monthly_amount;
        $installment->date = Carbon::now()->format('Y-m-d');

        $installment->cinet_installment = $request->cinet_installment;
        $installment->intrenal_installment = $request->intrenal_installment;
        $installment->start_date = $request->start_date;
        $installment->payment_type = $request->first_amount_pay_type;
        // eqrardain_amount
        $installment->eqrardain_amount = $request->eqrardain_amount;
        $installment->type = "installment";
        $installment->status = "finished";
        $installment->finished = 0;
        $installment->laws = "0";
        // notes
        // $installment->notes = $request->notes;
        $installment->created_by = Auth::user()->id ?? null;
        $installment->updated_by = Auth::user()->id ?? null;
        $installment->save();

        //  account
        $installment_months_part = new Installment_month;
        $installment_months_part->installment_id = $installment->id;
        $installment_months_part->amount = $request->total_first_amount;
        $installment_months_part->installment_type = "first_amount";
        $installment_months_part->cinet_amount = $installment->cinet_installment;
        $installment_months_part->internal_amount =$installment->intrenal_installment;
        $installment_months_part->status = "done";
        $installment_months_part->img_dir = "";
        $installment_months_part->notes = "";
        $installment_months_part->hesab_file = 0;
        $installment_months_part->lated_user_id = 0;
        $installment_months_part->next_date_user_id = 0;
        $installment_months_part->payment_type = $request->first_amount_pay_type;

        // $installment_months->date = strtotime("+" . $i . " month", $request->start_date);
        $installment_months_part->date = date('Y-m-d');
        $installment_months_part->payment_date = date('Y-m-d');
        $installment_months_part->created_by = Auth::user()->id ?? null;
        $installment_months_part->updated_by = Auth::user()->id ?? null;
        // //echo '<pre>';print_r($add_data_2);//exit;
        // $this->db_get->add_tb('installment_months', $add_data_28);
        $installment_months_part->save();

        $item = Invoices_installment::latest()->first();


       

        $invoice_installment = new Invoices_installment;
        $invoice_installment->amount = $request->total_first_amount;
        $invoice_installment->installment_id = $installment->id;
        $invoice_installment->description = "عملية  دفع مقدم عن المعاملة  رقم " . " " .$installment->id;
        $invoice_installment->type = "income";
        $invoice_installment->payment_type = $request->first_amount_pay_type;
        $invoice_installment->date = date('Y-m-d');
        $invoice_installment->install_month_id = $installment_months_part->id;
        $invoice_installment->debtor = 1;
        $invoice_installment->branch_id = Auth::user()->branch_id ?? null;
        $invoice_installment->balance = (int)$request->total_first_amount + (int)$item['balance'];
        $invoice_installment->balance_bank = $item->balance_bank;
        if ($request->first_amount_pay_type == 'cash') {
            $invoice_installment->balance_cash = $item['balance_cash'] + $request->total_first_amount;
            $invoice_installment['balance_knet'] = $item['balance_knet'];
            update_invoice_central_bank('cash', '+', $request->total_first_amount, 'installment');
        } else {
            $invoice_installment['balance_cash'] = $item['balance_cash'];
            $invoice_installment['balance_knet'] = $item['balance_knet'] + $request->total_first_amount;
            update_invoice_central_bank('knet', '+', $request->total_first_amount, 'installment');
        }

        $invoice_installment->save();


        for ($i = 0; $i < $request->count_months; $i++) {
            $installment_months = new Installment_month;
            $installment_months->installment_id = $installment->id;
            $installment_months->amount = $request->monthly_amount;
            $installment_months->installment_type = "installment";
            $installment_months->cinet_amount = (!is_numeric($request->cinet_installment) || $request->cinet_installment === "NaN") ? 0 : $request->cinet_installment;
            $installment_months->internal_amount = $request->intrenal_installment;
            $installment_months->img_dir = "";
            $installment_months->notes = "";
            $installment_months->hesab_file = 0;
            $installment_months->late_date = date('Y-m-d', strtotime("+" . $i . " month", strtotime($request->start_date)));
            $installment_months->lated_user_id = 0;
            $installment_months->next_date_user_id = 0;
            $installment_months->payment_type = $request->first_amount_pay_type;
            // $installment_months->date = strtotime("+" . $i . " month", $request->start_date);
            $installment_months->date = date('Y-m-d', strtotime("+" . $i . " month", strtotime($request->start_date)));
            $installment_months->payment_date = date('Y-m-d', strtotime("+" . $i . " month", strtotime($request->start_date)));
            $installment_months->created_by = Auth::user()->id ?? null;
            $installment_months->updated_by = Auth::user()->id ?? null;
            // //echo '<pre>';print_r($add_data_2);//exit;
            // $this->db_get->add_tb('installment_months', $add_data_28);
            $installment_months->save();
        }

        $products = json_decode($request->input('products'), true);
        $final_price = 0;

        foreach ($products as $product) {
            $final_price += (float)$product['cost']; // Casting the value to float
        }

        // dd($final_price);
        // order
        $order = new Order;
        $order->client_id = $client->id;
        $order->installment_id = $installment_client->id;
        $order->final_price = $final_price;
        $order->price = $request->total;  // المبلغ المقسط
        $order->payment_type = "installment";
        $order->status = "finished";
        $order->created_by = Auth::user()->id ?? null;
        $order->updated_by = Auth::user()->id ?? null;
        $order->save();

        // update order_id in installment
        $install = Installment::find($installment->id);
        $install->order_id = $order->id;
        $install->save();

        // $products = json_decode($request->input('products'), true);;
        // dd($products);

        foreach ($products as $product) {

            $p = Product::find($product['id']);
            // dd($product);
            $order_product = new OrderItem;
            $order_product->order_id = $order->id;
            $order_product->client_id = $client->id;
            $order_product->installment_id = $installment->id;
            $order_product->model = $product['model'];
            $order_product->number = $product['number'];
            $order_product->price = $product['price'];
            $order_product->cost = $product['cost'];
            $order_product->product_id = $product['id'];

            $order_product->product_items_id = $product['product_item_id'];

            //

            $order_product->final_price = $p->net_price;
            $order_product->counter = 1;
            $order_product->created_by = Auth::user()->id ?? null;
            $order_product->updated_by = Auth::user()->id ?? null;
            $order_product->save();

            if ($product['product_item_id']) {
                $product2 = products_items::where('product_id', $product['id'])->where('id', $product['product_item_id'])->first();
                $product2->available = 0;
                $product2->save();
            } else {
                $p->counte--;
                $p->save();
            }


        }


        $user_id = Auth::user()->id ?? "";
        // dd($user_id);
        $message = "تم اعتماد المعاملة رقم {$installment->id}";
        $this->log($user_id, $message);

        $data = new InstallmentClientNote;
        $data->reply = "note";
        $data->date = now()->format('Y-m-d');
        $data->time = now()->format('h:i:s');
        $data->installment_clients_id = $installment_client->id;
        $data->note = $message;
        $data->created_by = Auth::user()->id ?? null;
        $data->updated_by = Auth::user()->id ?? null;
        $data->save();
        // $this->installment_notes($request->installment_clients_id, $message);
        // $data['Installment']= Installment::with(['user','client','eqrar_not_recieve','installment_months','militay_affairs','installment_client'])->get();
        return redirect()->route('installment.admin');
    }
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

       public function getProductDetailsByNumber(Request $request)
    {
        // return response()->json($request);
        // return Product::with(['productsItems' => function ($query) {
        //     $query->where('available', 1);
        // }])
        //     ->where('number', $number)
        //     ->get();


        // Validate input
        $request->validate([
            'barcode' => 'nullable|string',
            'serial' => 'nullable|string',
        ]);

        // Retrieve product based on either barcode or serial
        $product = null;
        $number = null;
        $model = null;
        $cost = null;
        $price = null;
        $product_item_id = null;
        $id = null;

        if ($request->has('barcode')) {
            $product = Product::where('number', $request->barcode)->with(['productsItems' => function ($query) {
                $query->where('available', 1);
            }])->first();
            dd($product);
            $id = $product->id;
            $number = $request->barcode;
            $model = $product->model;
            $cost = $product->net_price;
            $price = $product->price;

        } elseif ($request->has('serial')) {
            /*  $product =  Product::with(['productsItems' => function ($query) use ($request) {
                 $query->where('available', 1)->where('serial_number',$request->serial);
             }])->first();
             $product_number=$request->serial;*/


            $product = products_items::where('available', 1)->where('serial_number', $request->serial)->with('product')->first();
            // dd($product);
            // return response()->json($product);
            $id = $product->product->id;
            $model = $product->product->model;
            $cost = $product->product->net_price;
            $price = $product->product->price;
            $number = $product->serial_number;
            $product_item_id = $product->id;

        }

        //  dd($product);

        // Check if product was found
        if ($product) {
            return response()->json([
                'success' => true,
                'product' => [
                      'id'=> $id,
                    'model' => $model,
                    'number' => $number,
                    'product_item_id' => $product_item_id,
                    // 'serial_number' => $product->serial_number,
                    'cost' => $cost,
                    'price' => $price,
                ],
            ]);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Product not found',
            ]);
        }


    }





    public function print_eqrardain_mothaq($amount)
    {

        $data['title'] = 'نظام الأقساط';
        $data['add_title'] = 'الأقساط';
        $data["amount"] = $amount;
        return view('installmentClient.print-debt-mothaq', compact('data' ));

    }
    public function print_eqrardain($id,$amount)
    {

        $data["item"] = Installment_Client::findorfail($id);

        $data['amount'] = $amount;

        $data["client"] =Client::findorfail($data["item"]['client_id']);

        return view('installmentClient.print_eqrardain', compact('data' ));




    }

    public function insert_to_invoice()
    {
        $installment = Installment::whereBetween('id', [1410, 1424])->get();
        
        foreach($installment as $item)
        {
        $last = Invoices_installment::latest()->first();

        $installment_months_part = Installment_month::where('installment_id',$item->id)->where('status','done')->where('installment_type','first_amount')->first();

        $invoice_installment = new Invoices_installment;
        $invoice_installment->amount = $item->total_first_amount;
        $invoice_installment->installment_id = $item->id;
        $invoice_installment->description = "عملية  دفع مقدم عن المعاملة  رقم " . " " .$item->id;
        $invoice_installment->type = "income";
        $invoice_installment->payment_type = $item->payment_type;
        $invoice_installment->date = $item->date;
        $invoice_installment->install_month_id = $installment_months_part->id;
        $invoice_installment->debtor = 1;
        $invoice_installment->branch_id = $item->user->branch_id ?? null;
        $invoice_installment->balance = (int)$item->total_first_amount + (int)$last['balance'];
        $invoice_installment->balance_bank = $last->balance_bank;
        if ($item->payment_type == 'cash') {
            $invoice_installment->balance_cash = $last['balance_cash'] + $item->total_first_amount;
            $invoice_installment['balance_knet'] = $last['balance_knet'];
            update_invoice_central_bank('cash', '+', $item->total_first_amount, 'installment');
        } else {
            $invoice_installment['balance_cash'] = $last['balance_cash'];
            $invoice_installment['balance_knet'] = $last['balance_knet'] + $item->total_first_amount;
            update_invoice_central_bank('knet', '+', $item->total_first_amount, 'installment');
        }

        $invoice_installment->save();

        }

        
    }


}
