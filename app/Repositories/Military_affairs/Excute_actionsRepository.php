<?php

namespace App\Repositories\Military_affairs;

use App\Interfaces\Military_affairs\CheckingRepositoryInterface;
use App\Interfaces\Military_affairs\Excute_actionsRepositoryInterface;
use App\Interfaces\Military_affairs\Open_fileRepositoryInterface;
use App\Interfaces\Military_affairs\Stop_travelRepositoryInterface;
use App\Models\Court;
use App\Models\Governorate;
use App\Models\Installment;
use App\Models\InstallmentNote;
use App\Models\InvoicesInstallment\Invoices_installment;
use App\Models\Military_affairs\Military_affair;


use App\Models\Military_affairs\Military_affairs_amount;
use App\Models\Military_affairs\Military_affairs_check;
use App\Models\Military_affairs\Military_affairs_times_type;
use App\Models\Military_affairs\Stop_travel_types;

use App\Models\Region;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class Excute_actionsRepository implements Excute_actionsRepositoryInterface
{
    protected $data;


    public function __construct()
    {
        //


        $this->data['governorates'] = Governorate::with('clients')->get();
        $this->data['courts'] = Court::with('government')->get();
        $color_array = ['bg-warning-subtle text-warning', 'bg-success-subtle text-success', 'bg-danger-subtle text-danger', 'px-4 bg-primary-subtle text-primary', 'bg-danger-subtle text-danger', 'me-1 mb-1  bg-warning-subtle text-warning'];

        for ($i = 0; $i < count($this->data['courts']); $i++) {
            $this->data['courts'][$i]['style'] = $color_array[$i];
        }
    }

    public function index(Request $request)
    {

        $checking_type = $request->checking_type;
        $message = "تم دخول صفحة فتح  رصيد التنفيذ";
        if($request->governorate_id){
            $governorate_id =Court::findorfail($request->governorate_id)->governorate_id  ;

        }else{
            $governorate_id='';
        }
        $user_id =  Auth::user()->id;
         log_move($user_id ,$message);

        $this->data['title'] = 'رصيد التنفيذ ';


        $data  = Military_affair::where(['military_affairs.archived' => 0, 'military_affairs.status' => 'execute'])
            ->with('installment', function ($query) {
                return $query->where('finished', '=', 0);
            })->with('military_amount')
            ->when(request()->has('governorate_id'), function ($query) use ($governorate_id) {
                $query->whereHas('installment.client', function ($q) use ($governorate_id) {
                    $q->where('governorate_id', $governorate_id);
                });
            })
            ->orderBy('excute_actions_amount', 'desc')
            ->get();
            
            

            $this->data['items'] = $data->filter(function ($item) use ($request) {
                return $item->installment && 
                       (!$request->has('governorate_id') || 
                        $request->get('governorate_id') == $item->installment->client->governorate_id);
            });


        $title = '   رصيد التنفيذ';

        $breadcrumb = array();
        $breadcrumb[0]['title'] = " الرئيسية";
        $breadcrumb[0]['url'] = route("dashboard");
        $breadcrumb[1]['title'] = "الشئون القانونية";
        $breadcrumb[1]['url'] = route("military_affairs");
        $breadcrumb[2]['title'] = $title;
        $breadcrumb[2]['url'] = 'javascript:void(0);';
        $this->data['check_amount'] = 0;
        foreach ($this->data['items'] as $value) {
            if (!empty($value->installment) && !empty($value->installment->client)) {
                $value->phone = ($value->installment->client->client_phone ? $value->installment->client->client_phone->last() : '');

            }

        }
        $this->data['item_type_time'] = Military_affairs_times_type::where(['type' => 'excute_actions', 'slug' => 'excute_actions'])->first();

        $this->data['view'] = 'military_affairs/Excute_actions/index';
        return view('layout', $this->data, compact('breadcrumb'));

    }

    public function all_checks_index(Request $request)
    {

        $checking_type = $request->check_type;
        if (!$checking_type) {
            $checking_type = 0;
        }
        $message = "تم دخول صفحة فتح  لشيكات المستلمة ";

        $user_id = Auth::user()->id;

        log_move($user_id, $message);

        $this->data['title'] = ' الشيكات المستلمة ';
        // dd($checking_type);


        $this->data['items'] = Military_affair::where([
            'military_affairs.archived' => 0,
            'military_affairs.status' => 'execute'
        ])
            ->with(['installment' => function ($query) {
                $query->where('status', 'finished');
            }])
            ->with('military_amount')
            ->with(['military_check' => function ($query) use ($checking_type) {
                $query->where('deposit', $checking_type)->orderBy('military_affairs_check.id');
            }])
            // Corrected to "orderBy" instead of "orderdBY"
            ->get();


        $title = '   الشيكات المستلمة ';

        $breadcrumb = array();
        $breadcrumb[0]['title'] = " الرئيسية";
        $breadcrumb[0]['url'] = route("dashboard");
        $breadcrumb[1]['title'] = "الشئون القانونية";
        $breadcrumb[1]['url'] = route("military_affairs");
        $breadcrumb[2]['title'] = $title;
        $breadcrumb[2]['url'] = 'javascript:void(0);';

        foreach ($this->data['items'] as $value) {
            $value->phone = ($value->installment->client->client_phone ? $value->installment->client->client_phone->last() : '');
            $value->phone = ($value->installment->client->client_phone ? $value->installment->client->client_phone->last() : '');

        }
        $this->data['item_type_time'] = Military_affairs_times_type::where(['type' => 'excute_actions', 'slug' => 'excute_actions'])->first();

        $this->data['view'] = 'military_affairs/Excute_actions/index_all_check';
        return view('layout', $this->data, compact('breadcrumb'));

    }


    public function add_amount(Request $request)
    {
        $item_military = Military_affair::findorfail($request->military_affairs_id);
        if ($request->check_found == 1) {
            $request->validate([
                'date' => 'required| date',
                'img_dir' => 'required|image|mimes:jpg,png,jpeg,gif|max:2048',
                'check_type' => 'required',
                'amount' => 'required',
            ]);



            if ($request->hasFile('img_dir')) {
                $filename = time() . '-' . $request->file('img_dir')->getClientOriginalName();
                $path = $request->file('img_dir')->move(public_path('military_affairs'), $filename);
                $data_img_dir= 'military_affairs'.'/'.$filename;
            }




        }

        $array_add = [
            'date' => $request->date ?? date('Y-m-d H:i:s'),
            'check_type' => $request->check_type ?? '',
            'amount' => $request->amount ?? '',
            'military_affairs_id' => $request->military_affairs_id,
            'img_dir' => $data_img_dir ?? ' '

        ];

        Military_affairs_amount::create($array_add);
        $update_data['excute_actions_amount'] = $item_military['excute_actions_amount'] + $request->amount;

        $update_data['excute_actions_counter'] = 1 + $item_military['excute_actions_counter'];

        $update_data['excute_actions_last_date_check'] = date('Y-m-d H:i:s');
        $item_military->update($update_data);
        return redirect()->route('excute_actions')->with('success', 'تم الاستعلام بنجاح  ');

    }


    ///////////////////////////////case_proof function
    public function add_check(Request $request)
    {

        $request->validate([
            'date' => 'required| date',
            'img_dir' => 'required|image|mimes:jpg,png,jpeg,gif|max:2048',
            'check_number' => 'required',
        ]);


        if ($request->hasFile('img_dir')) {
            $filename = time() . '-' . $request->file('img_dir')->getClientOriginalName();
            $path = $request->file('img_dir')->move(public_path('military_affairs'), $filename);
            $data_img_dir = 'military_affairs'.'/'. $filename;
        }

        $array_add = [
            'date' => $request->date,
            'check_number' => $request->check_number,
            'amount' => $request->check_amount,
            'military_affairs_id' => $request->military_affairs_id,
            'img_dir' => $data_img_dir

        ];

        Military_affairs_check::create($array_add);
        $last_check_add = Military_affairs_check::get()->last();


        $item_military_affairs = Military_affair::findOrFail($request->military_affairs_id);

        $items_amount = Military_affairs_amount::where(['military_affairs_id' => $item_military_affairs->id, 'military_affairs_check_id' => 0])->get();

        foreach ($items_amount as $value) {
            //  dd('ffff');
            $value->military_affairs_check_id = $last_check_add->id;
            $value->save();
        }
        $data['excute_actions_counter'] = 0;
        $data['excute_actions_amount'] = 0;
        $data['excute_actions_check_amount'] = $last_check_add->amount;
        $item_military_affairs->update($data);


        return redirect()->route('excute_actions');


    }


    public function add_check_finished(Request $request)
    {

        $request->validate([
            'date' => 'required| date',
            'img_dir' => 'required|image|mimes:jpg,png,jpeg,gif|max:2048',

        ]);


        if ($request->hasFile('img_dir')) {
            $filename = time() . '-' . $request->file('img_dir')->getClientOriginalName();
            $path = $request->file('img_dir')->move(public_path('military_affairs'), $filename);
            $data['img_dir'] = 'military_affairs'.'/'.$filename;
        }


        $check_item = Military_affairs_check::findOrFail($request->check_id);
        $data_check['deposit'] = 1;
        $data_check['deposit_date'] = $request->date;
        $data_check['deposit_user_id'] = Auth::user() ? Auth::user()->id : '';
        $data_check['deposit_img'] = $data['img_dir'];
        $data_check['img_dir'] = $data['img_dir'];
        $check_item->update($data_check);


        $description = "       الشئون القانونية : عملية ايداع شيك عن المعاملة رقم "
            . " ( " . $request->installment_id . " ) "
            . "باسم العميل :"
            . "        " . $request->client_name;

//            start

        $add_data_bank_2['date'] = time();
        $add_data_bank_2['user_id'] = Auth::user() ? Auth::user()->id : '';
        $add_data_bank_2['debtor'] = 1;
        $add_data_bank_2['cat_id'] = 4;
        $add_data_bank_2['type'] = 'income';
        $add_data_bank_2['datebasheer'] = date("Ymd");
        $add_data_bank_2['amount'] = $check_item->amount;
        $add_data_bank_2['description'] = 'من الشئون القانونية   :'
            . '<br>'
            . $description;
        if ($add_data_bank_2['amount'] > 0) {
            DB::table('fast_banks_invoices')->insert($add_data_bank_2);

        }

        $add_data1['description'] = "       الشئون القانونية : عملية ايداع شيك عن المعاملة رقم "
            . " ( " . $request->installment_id . " ) "
            . "باسم العميل :"
            . "        " . $request->client_name;

        $add_data1['type'] = 'income';

        $add_data1['payment_type'] = 'check';

        $add_data1['date'] = date('Y-m-d');

        $add_data1['install_month_id'] = 0;

        $add_data1['debtor'] = 1;

        $add_data1['creditor'] = 1;
        $add_data1['img'] = $data['img_dir'];

        $add_data1['installment_id'] = $request->installment_id;

        $add_data1['amount'] = $check_item->amount;
        $add_data1['created_by'] = Auth::user() ? Auth::user()->id : '';
        //  echo '<pre>';  print_r($add_data1); exit;

        Invoices_installment::create($add_data1);


        add_money_to_bank('5', $request->installment_id, $check_item->amount, 'military_affairs', $description, 'income', 'checkat');

        return redirect()->route('all_checks');


    }


}
