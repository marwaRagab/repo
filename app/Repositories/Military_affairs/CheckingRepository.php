<?php

namespace App\Repositories\Military_affairs;

use App\Interfaces\Military_affairs\CheckingRepositoryInterface;
use App\Interfaces\Military_affairs\Open_fileRepositoryInterface;
use App\Interfaces\Military_affairs\Stop_travelRepositoryInterface;
use App\Models\Court;
use App\Models\Governorate;
use App\Models\Installment;
use App\Models\InstallmentNote;
use App\Models\Military_affairs\Military_affair;
use App\Models\Military_affairs\Military_affairs_certificate_type;
use App\Models\Military_affairs\Military_affairs_jalasaat;
use App\Models\Military_affairs\Military_affairs_notes;
use App\Models\Military_affairs\Military_affairs_status;
use App\Models\Military_affairs\Military_affairs_times_type;
use App\Models\Military_affairs\Stop_travel_types;
use App\Models\Ministry;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Validator;
use Inertia\Inertia;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\Auth;
use App\Models\Log;

class CheckingRepository implements CheckingRepositoryInterface
{
    protected $data;


    public function __construct()
    {
        //


        $this->data['governorates'] = Governorate::with('clients')->get();
        $this->data['courts'] = Court::with('government')->get();
        $this->data['stop_travel_types'] = Stop_travel_types::all();


    }

    public function index(Request $request)
    {

        $checking_type = $request->checking_type;
        $message = "تم دخول صفحة فتح رفع الاجراءات";
        $user_id = 1;
        //$user_id =  Auth::user()->id,
        // $this->log($user_id ,$message);
        // $user_id =  Auth::user()->id;
        $this->data['title'] = 'رفع الاجراءات';
        $this->data['items'] = Military_affair::

        when('certificate_type', function ($q) use ($checking_type) {

            if ($checking_type == 'actions_up') {
                $q->where('actions_up', 1);
                $q->where('military_affairs.archived', 0);
                $q->where('military_affairs.status', 'execute');
                return $q->where('is_reminder_amount', 0);

            } elseif ($checking_type == 'all_reminders') {
                $q->where('military_affairs.status', 'execute');
                $q->where('military_affairs.archived', 0);
                return $q->where('is_reminder_amount', 0);

            } elseif ($checking_type == 'archive') {
                $q->where('military_affairs.archived', 1);
                return $q->where('military_affairs.status', 'execute');

            } else {
                $q->where('military_affairs.archived', 0);
                return $q->where('actions_up', 0);

            }
        })
            ->with('installment')->get();


        $title = '  رفع الاجراءات';

        $breadcrumb = array();
        $breadcrumb[0]['title'] = " الرئيسية";
        $breadcrumb[0]['url'] = route("dashboard");
        $breadcrumb[1]['title'] = "الشئون القانونية";
        $breadcrumb[1]['url'] = route("military_affairs");
        $breadcrumb[2]['title'] = $title;
        $breadcrumb[2]['url'] = 'javascript:void(0);';

        foreach ($this->data['items'] as $value) {
            $value->phone = ($value->installment->client->client_phone ? $value->installment->client->client_phone->last() : '');

        }
        $this->data['view'] = 'military_affairs/Checking/index';
        return view('layout', $this->data, compact('breadcrumb'));

    }


    public function update_actions_up(Request $request)
    {

        $request->validate([
            'date' => 'required| date',
            'img_dir' => 'required|image|mimes:jpg,png,jpeg,gif|max:2048',
        ]);


        if ($request->hasFile('img_dir')) {
            $data_img_dir = $request->file('img_dir')->store('military_affairs', 'public'); // Store in the 'products' directory
        }
        $item_military_affairs = Military_affair::findorfail($request->military_affairs_id);

        $data['actions_up'] = 0;
        $data['img_dir'] = $data_img_dir;

        if ($request->convert_type) {
            $data['archived_img_dir'] = $data_img_dir;

            $data['archived'] = 1;

        }

        $item_military_affairs->update($data);
        return redirect()->route('checking');


    }

    ///////////////////////////////case_proof function
    public function update_actions_reminder(Request $request)
    {

        $request->validate([
            'date' => 'required| date',
            'img_dir' => 'required|image|mimes:jpg,png,jpeg,gif|max:2048',
            'reminder_img_dir' => 'required|image|mimes:jpg,png,jpeg,gif|max:2048',
        ]);


        if ($request->hasFile('reminder_img_dir')) {
            $data_reminder_img_dir = $request->file('reminder_img_dir')->store('military_affairs', 'public'); // Store in the 'products' directory
        }


        if ($request->hasFile('archived_img_dir')) {
            $data_img_dir = $request->file('archived_img_dir')->store('military_affairs', 'public'); // Store in the 'products' directory
        }

        $item_military_affairs = Military_affair::findorfail($request->military_affairs_id);
        $item_installment = Military_affair::findorfail($request->installment_id);
        $item_client = Military_affair::findorfail($request->client_id);
        $military_id = $request->military_affairs_id;
        $installment_id = $request->installment_id;
        $client_id = $request->client_id;

                $data['reminder_img_dir'] = $data_reminder_img_dir;
                $data['archived_img_dir'] = $data_img_dir;
                $data['archived'] = 1;


                $add_data_invoices_installment['creditor'] = 1;
                $add_data_invoices_installment['debtor'] = 0;
                $add_data_invoices_installment['install_month_id'] = 0;
                $add_data_invoices_installment['amount'] = abs($item_military_affairs->eqrar_dain_amount - $item_military_affairs->reminder_amount);
                $add_data_invoices_installment['install_month_id'] = 0;
                $add_data_invoices_installment['type'] = 'returns';
                $add_data_invoices_installment['user_id'] = Auth::user() ? Auth::user()->id : null;
                $add_data_invoices_installment['date'] = date('Y-m-d'); ;
                $add_data_invoices_installment['installment_id'] = $request->installment_id;
                $add_data_invoices_installment['description'] = '   تسليم مبلغ متبقي للعميل بعد  تحصيل كامل المديونية'
                    . '  العميل'
                    . '  '
                    . $item_client->name_ar
                    . ' '
                    . 'معاملة رقم '
                    . '( '
                    . $request->installment_id
                    . ' )';

                $add_data_invoices_installment['payment_type'] = 'cash';

                $add_data_invoices_installment['knet_code'] = '';
                Invoices_installment::create($add_data_invoices_installment);

              $update_done = $item_military_affairs->update($data);
              if ($update_done > 1) {
                  add_main_cash_invices($military_id, $installment_id, $client_id);
              }
                return redirect()->route('checking');


}















}
