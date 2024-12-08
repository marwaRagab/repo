<?php

namespace App\Repositories\Military_affairs;

use App\Interfaces\Military_affairs\SettlementRepositoryInterface;
use App\Models\InstallmentNote;
use App\Models\InvoicesInstallment\Invoices_installment;
use App\Models\Log;
use App\Models\Military_affairs\Military_affairs_settlement;
use App\Models\Military_affairs\Military_affairs_settlement_month;
use App\Models\Military_affairs\Military_affairs_stop_bank_type;
use App\Models\Military_affairs\Military_affairs_stop_car_type;
use App\Models\Military_affairs\Military_affairs_stop_salary_type;
use App\Models\Military_affairs\Stop_travel_types;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

use App\Models\Military_affairs\Military_affair;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use App\Models\Governorate;
use App\Models\Court;
use Illuminate\Support\Facades\Validator;
use App\Models\Military_affairs\Military_affairs_settlement_type;


class SettlementRepository implements SettlementRepositoryInterface
{
    protected $data;
    protected $title;

    public function __construct()
    {
        $this->data['title'] = ' التسوية';
        $this->data['governorates'] = Governorate::with('clients')->get();
        $this->data['courts'] = Court::with('government')->get();
    }

    public function index(Request $request)
    {
        $message = "تم دخول صفحة التسوية";
        $user_id = Auth::user()->id ?? null;
        log_move($message, $user_id);


        $type_sellement = $request->type;


        if ($request->type) {

            if ($request->type == 'canceled') {
                $type_sellement = 3;
            } elseif ($request->type == 'done') {
                $type_sellement = 1;
            } elseif ($request->type == 'request') {
                $type_sellement = 2;
            }
        } else {

            $type_sellement = null;

        }


        $this->data['settlement_all'] = Military_affairs_settlement::all();

        $this->data['settlement'] = Military_affairs_settlement::when($type_sellement, function ($q) use ($type_sellement) {

            return $q->where('type', $type_sellement);
          })->with('military_affair', function ($query) {
             $query->where('status', '=', 'execute');
            return $query->where('archived', '=', 0);
           })->get();
        foreach ($this->data['settlement'] as $value) {
             if($value->installment_no>0)
             $no_installment = $value->installment_no;
              else $no_installment = 1 ;
            $Quotient = (int)($value->settle_amount /$no_installment );
            $Remainder = $value->settle_amount % $no_installment;
            $value->phone = ($value->military_affair->installment->client ? $value->military_affair->installment->client->client_phone->last() : '');
            $value->month_amount = $Quotient;
            $value->last_month_amount = $Quotient + $Remainder;

        }

        if ($request->type == 'request') {
            $new_type = 'done';
        } else {
            $new_type = 'canceled';

        }

        $this->data['item_type_time_old'] = Military_affairs_settlement_type::where(['type' => 'settlement', 'slug' => $request->type])->first();
        $this->data['item_type_time_new'] = Military_affairs_settlement_type::where(['type' => 'settlement', 'slug' => $new_type])->first();


        $breadcrumb = array();
        $breadcrumb[0]['title'] = " الرئيسية";
        $breadcrumb[0]['url'] = route("dashboard");
        $breadcrumb[1]['title'] = " التسوية ";
        $breadcrumb[1]['url'] = route("settle.index");
        $breadcrumb[2]['title'] = $this->data['title'];
        $breadcrumb[2]['url'] = 'javascript:void(0);';
        $view = 'military_affairs/settlement/index';
        $title = $this->title;
        return view('layout', compact(['title', 'view', 'breadcrumb']), $this->data);
    }

    public function add_settlement(Request $request)
    {


        $request->validate([
            'date' => 'required| date',
            'installment_no' => 'required',
            'military_affairs_id' => 'required',
            'first_amount_settle' => 'required|numeric',

        ]);

        $data['settle_amount'] = $request->amount;
        $data['first_amount_settle'] = $request->first_amount_settle;
        $data['type'] = 2;
        $data['installment_no'] = $request->installment_no;
        $data['date'] = $request->date;
        $data['military_affairs_id'] = $request->military_affairs_id;
        $data['created_by'] = Auth::user()->id ?? null;
        $data['created_at'] = date('Y-m-d');
        if (in_array("
            ", $request->action))
            $actions = ['0', '1', '2', '3'];
        else
            $actions = $request->action;
        $data['actions'] = json_encode($actions);


        Military_affairs_settlement::create($data);


        return redirect()->route('settle.index');

    }

    public function show_settlement($id)
    {

        $title = 'طلب تسوية ';
        $this->data['item_military'] = Military_affair::Findorfail($id);
        $message = "تم دخول صفحة  اضافة التسوية";
        $user_id = Auth::user()->id ?? null;
        log_move($message, $user_id);


        $breadcrumb = array();
        $breadcrumb[0]['title'] = " الرئيسية";
        $breadcrumb[0]['url'] = route("dashboard");
        $breadcrumb[1]['title'] = "التسوية ";
        $breadcrumb[1]['url'] = route("settle.add_settlement");
        $breadcrumb[2]['title'] = $title;
        $breadcrumb[2]['url'] = 'javascript:void(0);';


        $view = 'military_affairs/settlement/add_settle';
        $title = $this->title;
        return view('layout', compact(['title', 'view', 'breadcrumb']), $this->data);

    }

    public function pay_settlement(Request $request)
    {


        $request->validate([
            'img' => 'required|image|mimes:jpg,png,jpeg,gif|max:2048',
            'first_amount_settle' => 'required',
            'payment_type' => 'required',
        ]);

        $message = "تم  عمل اتمام لطلب التسوية";
        $user_id = Auth::user()->id ?? null;
        log_move($message, $user_id);

        $add_data['installment_id'] = $request->installment_id;

        $add_data['amount'] = $request->first_amount_settle;
        $settle_item = Military_affairs_settlement::Findorfail($request->settle_id);
        $actions_item = json_decode($settle_item->actions, true);
        $militray_id = $request->military_affairs_id;
        $old_case = Military_affairs_settlement_type::Findorfail($request->item_type_time_old);
        $new_case = Military_affairs_settlement_type::Findorfail($request->item_type_time_new);
        $add_data['payment_type'] = $request->payment_type;
        $add_data['pay_details'] = $request->pay_details;
        $add_data['status'] = 'done';
        $add_data['installment_type'] = 'first_installment';
        $add_data['payment_date'] = date('Y-m-d');
        $add_data['date'] = date('Y-m-d');
        $add_data['settle_id'] = $request->settle_id;
        $add_data['created_by'] = Auth::user()->id ?? null;
        Military_affairs_settlement_month:: create($add_data);
        $settle_id = Military_affairs_settlement_month::latest()->first();


        Add_note($old_case, $new_case, $militray_id);

        foreach ($actions_item as $item) {

            if ($item == 0) {
                $send_rev = Stop_travel_types::where('type', 'stop_travel')->where('slug', 'stop_travel_cancel_request')->first();
                Add_note($old_case, $send_rev, $militray_id);
            }
            if ($item == 1) {
                $send_rev = Military_affairs_stop_car_type::where('type', 'stop_cars')->where('slug', 'stop_car_cancel_request')->first();

                Add_note($old_case, $send_rev, $militray_id);
            }
            if ($item == 2) {
                $send_rev = Military_affairs_stop_bank_type::where('type', 'stop_bank')->where('slug', 'stop_bank_cancel_request')->first();

                Add_note($old_case, $send_rev, $militray_id);
            }
            if ($item == 3) {
                $send_rev = Military_affairs_stop_salary_type::where('type', 'stop_salary')->where('slug', 'stop_salary_cancel_request')->first();
                Add_note($old_case, $send_rev, $militray_id);
            }

        }
        $data_invoice['amount'] = $request->first_amount_settle;
        $data_invoice['description'] = "عملية  دفع  مبلغ مقدم تسوية  عن المعاملة  رقم " . " " . $request->installment_id;
        $data_invoice['type'] = 'income';
        $data_invoice['payment_type'] = 'part';
        $data_invoice['date'] = date('Y-m-d');
        $data_invoice['install_month_id'] = $settle_id;
        $data_invoice['debtor'] = 1;
        $data_invoice['creditor'] = 0;
        $data_invoice['installment_id'] = $request->installment_id;
        Invoices_installment::create($data_invoice);
        for ($i = 0; $i < $settle_item->installment_no; $i++) {
            $n_data['installment_id'] = $request->installment_id;
            if ($i == $settle_item->installment_no - 1)
                $n_data['amount'] = $request->month_amount;
            else
                $n_data['amount'] = $request->last_month_amount;
            $n_data['status'] = 'not_done';
            $n_data['installment_type'] = 'installment';
            $n_data['payment_date'] = 0;
            // $n_data['date'] = (date("Y-m-d", $add_data['date']) . "+" . ($i + 1) . " month");
            $n_data['date'] = date("Y-m-d", strtotime('+' . ($i + 1) . 'months'));
            $n_data['settle_id'] = $request->settle_id;
            $n_data['created_by'] = Auth::user()->id ?? null;
            Military_affairs_settlement_month::create($n_data);

        }
        $data_update['type'] = 1;
        $data_update['first_amount_settle'] = $request->first_amount_settle;

        $settle_item->update($data_update);
        return redirect()->route('settle.index');


    }

    public function cancel_settlement(Request $request)
    {


        $request->validate([
            'settle_date' => 'required| date',
            'military_affairs_id' => 'required',
            'note' => 'required',

        ]);
        $message = "تم  عمل الغاء التسوية";
        $user_id = Auth::user()->id ?? null;
        log_move($message, $user_id);

        $data['type'] = 3;

        $data['updated_by'] = Auth::user()->id ?? null;
        $data['updated_at'] = date('Y-m-d');

        $data['cancel_note'] = $request->note;
        $data['cancel_date'] = $request->settle_date;

        $item = Military_affairs_settlement::Findorfail($request->settle_id);
        $item->update($data);
        $array_cancel = Military_affairs_settlement_type::where('slug', 'canceled')->first();
        $old_case = Military_affairs_settlement_type::Findorfail($request->type_id);


        Add_note($old_case, $array_cancel, $request->military_affairs_id);


        return redirect()->route('settle.index');

    }

}
