<?php

namespace App\Repositories\Military_affairs;

use App\Models\Military_affairs\Military_affairs_bank_request;
use Carbon\Carbon;
use App\Models\Log;
use App\Models\Bank;
use Inertia\Inertia;
use App\Models\Court;
use App\Models\Client;
use App\Models\Ministry;
use App\Models\Governorate;
use App\Models\Installment;
use Illuminate\Http\Request;
use App\Models\InstallmentNote;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Validator;
use App\Models\Military_affairs\Military_affair;
use App\Models\Military_affairs\Stop_travel_types;
use App\Models\Military_affairs\Military_affairs_notes;
use App\Models\Military_affairs\Military_affairs_times;
use App\Models\Military_affairs\Military_affairs_status;
use App\Models\Military_affairs\Military_affairs_jalasaat;
use App\Models\Military_affairs\Prev_cols_military_affairs;
use App\Models\Military_affairs\Military_affairs_times_type;
use App\Models\Military_affairs\Military_affairs_stop_bank_type;
use App\Interfaces\Military_affairs\Open_fileRepositoryInterface;
use App\Interfaces\Military_affairs\Stop_bankRepositoryInterface;
use App\Models\Military_affairs\Military_affairs_certificate_type;
use App\Interfaces\Military_affairs\Stop_travelRepositoryInterface;


class Stop_bankRepository implements Stop_bankRepositoryInterface
{
    protected $data;


    public function __construct()
    {
        //


        $this->data['governorates'] = Governorate::with('clients')->get();
        $this->data['courts'] = Court::with('government')->get();
        $this->data['stop_bank_types'] = Military_affairs_stop_bank_type::OrderBY('orderby')->get();
        $this->data['ministries'] = Ministry::all();

        $color_array = ['bg-warning-subtle text-warning', 'bg-success-subtle text-success', 'bg-danger-subtle text-danger', 'px-4 bg-primary-subtle text-primary', 'bg-danger-subtle text-danger', 'me-1 mb-1  bg-warning-subtle text-warning', 'bg-warning-subtle text-warning'];

        $this->data['banks'] = Bank::all();
        for ($i = 0; $i < count($this->data['ministries']); $i++) {
            $this->data['ministries'][$i]['ministries_dates'] = date('Y-m-' . $this->data['ministries'][$i]['date']);

        }


        for ($i = 0; $i < count($this->data['courts']); $i++) {
            $this->data['courts'][$i]['style'] = $color_array[$i];
        }

        for ($i = 0; $i < count($this->data['stop_bank_types']); $i++) {
            $this->data['stop_bank_types'][$i]['style'] = $color_array[$i];
        }


    }

    public function index(Request $request)
    {
        //dd($this->data['ministries']->pluck('id'));
// dd($request->all());
        $governorate_id = $request->governorate_id;
        $message = "تم دخول صفحة  حجز بنوك  ";
        $user_id = 1;
        //$user_id =  Auth::user()->id,
        // $this->log($user_id ,$message);
        // $user_id =  Auth::user()->id;
        $this->data['title'] = '    حجز بنوك';
//         $this->data['items'] = Military_affair::where('archived','=',0)
//             ->where(['military_affairs.status' =>'execute', 'military_affairs.stop_bank' =>1  ])
//             ->with('installment')->with('status_all')
//             ->whereHas('installment', function ($q){
//                 return $q->where('finished',0);
//             })
// // ;
//             ->get();
//   dd( count($this->data['items']));
        $this->data['items'] = Military_affair::where('archived', 0)
            ->where(['military_affairs.status' => 'execute', 'military_affairs.stop_bank' => 1,'bank_archive'=>0])
            ->with('installment.client.get_ministry')
             ->whereHas('installment.client.get_ministry', function ($q) use ($request) {
                // dd('fff');
                $q->whereIn('date',$this->data['ministries']->pluck('date'));
            })

           ->with('status_all', function ($query) {
                return $query->where('type', '=', 'stop_bank');
            })
            ->with('installment', function ($query) {
                return $query->where('finished', '=', 0);
            })
            ->when(request()->has('date'), function ($query) use ($request) {
                $query->whereHas('installment.client.get_ministry', function ($q) use ($request) {

                    $q->where('date', $request->date);
                });
            })->when(request()->has('bank'), function ($query) use ($request) {
                $query->whereHas('installment.client.client_banks', function ($q) use ($request) {

                    $q->where('date', $request->bank);
                });
            })


            ->get();
        // dd($this->data['items']);

        $title = ' حجز بنوك';

        $breadcrumb = array();
        $breadcrumb[0]['title'] = " الرئيسية";
        $breadcrumb[0]['url'] = route("dashboard");
        $breadcrumb[1]['title'] = "الشئون القانونية";
        $breadcrumb[1]['url'] = route("military_affairs");
        $breadcrumb[2]['title'] = $title;
        $breadcrumb[2]['url'] = 'javascript:void(0);';
        $stop_type = $request->stop_bank_type;
        $date = $request->date;

        if (!$stop_type) {
            $stop_type = 'stop_bank_request';
        }

        if ($stop_type == 'stop_bank_command') {
            $new_type = 'stop_bank_researcher';
        } elseif ($stop_type == 'stop_bank_researcher') {
            $new_type = 'banks';
        } elseif ($stop_type == 'banks') {
            $new_type = 'stop_bank_doing';
        } elseif ($stop_type == 'stop_bank_cancel_request') {
            $new_type = 'stop_bank_cancel';
        } else {
            $new_type = 'stop_bank_command';

        }

        if ($date) {
            $date_sel = '';
        }

        $this->data['item_type_time_old'] = Military_affairs_stop_bank_type::where(['type' => 'stop_bank', 'slug' => $stop_type])->first();
        $this->data['item_type_time_new'] = Military_affairs_stop_bank_type::where(['type' => 'stop_bank', 'slug' => $new_type])->first();
        $mins = collect();
        $array_date = [];
        $array_bank = [];
        $x=0;

        //dd($this->data['items']);
        foreach ($this->data['items'] as $value) {

            if($value->installment && $value->status_all){
                $value->i=$x+1;
                $value->all_notes=get_all_notes('stop_bank',$value->id);
                $value->all_actions=get_all_actions($value->id);
                $value->get_all_delegations = get_all_delegations($value->id);



                $ministry = $value->installment->client->ministry->last()->ministry_id;
                $value->ministry_name = Ministry::findorfail($ministry);
                $date=date('Y-m-'.$value->ministry_name->date);
                $day_name = Carbon::parse($date)->format('l');
                if($day_name=='Saturday'){
                    $value->last_date=date('Y-m-'.$value->ministry_name->date-2);
                }elseif ($day_name=='Friday'){
                    $value->last_date=date('Y-m-'.$value->ministry_name->date-1);

                }else{
                    $value->last_date=date('Y-m-'.$value->ministry_name->date);
                }
                $x=$x+1;

                $bank = $value->installment->client->client_banks->last();
                $value->phone = ($value->installment->client->client_phone ? $value->installment->client->client_phone->last()->phone : '');


                /* $bank_name=Bank::where('slug','=',$bank->bank_name)->first();

                 if(isset($bank_name)){
                  $bank_name=$bank_name->name_ar;
                 }else{
                     $bank_name= Bank::findorfail($bank->bank_name)->name_ar;
                 }*/


                if (!in_array($value->ministry_name->date, $array_date)) {
                    array_push($array_date, $value->ministry_name->date);
                }
                if ($bank) {
                    if (!in_array($bank->bank_name, $array_bank)){
                        array_push($array_bank, $bank->bank_name);
                    }
                }



            }



           // $value->min_id = Ministry::findORFail($value->installment->client->ministry_last)->date;
            $value->different_date = get_different_dates($value->date, date('Y-m-d'));

        }

      //  $ministries = $mins->unique();

       /* foreach ($ministries as $one) {
            $dates[$one] = Ministry::where('id', $one)->first()->date;
        }
        // dd($dates);
        $sortedArray = collect($dates)->sortBy(function ($date) {
            return strtotime($date);
        });


        $this->data['ministries'] = $sortedArray->unique()->toArray();
        // dd( count($this->data['ministries']));*/



 //dd($array_date);
        $this->data['dates']=$array_date;
        $this->data['banks']=$array_bank;
        $this->data['get_responsible'] = get_responsible();

        $this->data['view'] = 'military_affairs/Stop_bank/index';
        return view('layout', $this->data, compact('breadcrumb'));

    }


    public function archive(Request $request)
    {
        $governorate_id = $request->governorate_id;
        $message = "تم دخول صفحة  ارشيف حجز بنوك  ";
        $user_id = 1;
        //$user_id =  Auth::user()->id,
        // $this->log($user_id ,$message);
        // $user_id =  Auth::user()->id;
        $this->data['title'] = '    حجز بنوك';
        $this->data['items'] = Military_affair::where('archived', '=', 1)
            ->where([
                'military_affairs.status' => 'execute',
                'military_affairs.stop_bank' => 1,
            ])
            ->with('installment')
            ->with('status_all')
            ->get();
        $title = ' حجز بنوك';

        $breadcrumb = array();
        $breadcrumb[0]['title'] = " الرئيسية";
        $breadcrumb[0]['url'] = route("dashboard");
        $breadcrumb[1]['title'] = "الشئون القانونية";
        $breadcrumb[1]['url'] = route("military_affairs");
        $breadcrumb[2]['title'] = $title;
        $breadcrumb[2]['url'] = 'javascript:void(0);';

        $stop_type = $request->stop_bank_type;
        if (!$stop_type) {
            $stop_type = 'stop_bank_request';
        }

        if ($stop_type == 'stop_bank_command') {
            $new_type = 'stop_bank_researcher';
        } elseif ($stop_type == 'stop_bank_researcher') {
            $new_type = 'banks';
        } elseif ($stop_type == 'banks') {
            $new_type = 'stop_bank_doing';
        } elseif ($stop_type == 'stop_bank_cancel_request') {
            $new_type = 'stop_bank_cancel';
        } else {
            $new_type = 'stop_bank_command';

        }

        $this->data['item_type_time_old'] = Military_affairs_stop_bank_type::where(['type' => 'stop_bank', 'slug' => $stop_type])->first();
        $this->data['item_type_time_new'] = Military_affairs_stop_bank_type::where(['type' => 'stop_bank', 'slug' => $new_type])->first();

        foreach ($this->data['items'] as $value) {

            $value->item_old_data = Prev_cols_military_affairs::where('military_affairs_id', $value->id)->first();

            $value->different_date = get_different_dates($value->date, date('Y-m-d'));
            $value->adress = ($value->installment->client->client_address ? $value->installment->client->client_address->last() : '');
            $value->phone = ($value->installment->client->client_phone ? $value->installment->client->client_phone->last() : '');
            if ($value->eqrardain_date != NULL) {
                $value->type_papar = 'وصل امانة';
            } elseif ($value->qard_paper != NULL) {
                $value->type_papar = 'اقرار دين';
            } else
                $value->type_papar = 'لايوجد';
        }
        // dd($this->data['items']);

        $this->data['view'] = 'military_affairs/Stop_bank/archive';
        return view('layout', $this->data, compact('breadcrumb'));

    }

    public function print_archive(Request $request)
    {
        $governorate_id = $request->governorate_id;
        $message = "تم دخول صفحة  طباعة ارشيف حجز بنوك  ";
        $user_id = 1;
        //$user_id =  Auth::user()->id,
        // $this->log($user_id ,$message);
        // $user_id =  Auth::user()->id;
        $this->data['title'] = ' حجز بنوك';
        $this->data['items'] = Military_affair::where('archived', '=', 1)
            ->where([
                'military_affairs.status' => 'execute',
                'military_affairs.stop_bank' => 1,
            ])
            ->with('installment')
            ->with('status_all')
            ->get();
        $title = ' حجز بنوك';

        $breadcrumb = array();
        $breadcrumb[0]['title'] = " الرئيسية";
        $breadcrumb[0]['url'] = route("dashboard");
        $breadcrumb[1]['title'] = "الشئون القانونية";
        $breadcrumb[1]['url'] = route("military_affairs");
        $breadcrumb[2]['title'] = $title;
        $breadcrumb[2]['url'] = 'javascript:void(0);';

        $stop_type = $request->stop_bank_type;
        if (!$stop_type) {
            $stop_type = 'stop_bank_request';
        }

        if ($stop_type == 'stop_bank_command') {
            $new_type = 'stop_bank_researcher';
        } elseif ($stop_type == 'stop_bank_researcher') {
            $new_type = 'banks';
        } elseif ($stop_type == 'banks') {
            $new_type = 'stop_bank_doing';
        } elseif ($stop_type == 'stop_bank_cancel_request') {
            $new_type = 'stop_bank_cancel';
        } else {
            $new_type = 'stop_bank_command';

        }

        $this->data['item_type_time_old'] = Military_affairs_stop_bank_type::where(['type' => 'stop_bank', 'slug' => $stop_type])->first();
        $this->data['item_type_time_new'] = Military_affairs_stop_bank_type::where(['type' => 'stop_bank', 'slug' => $new_type])->first();

        foreach ($this->data['items'] as $value) {

            $value->item_old_data = Prev_cols_military_affairs::where('military_affairs_id', $value->id)->first();

            $value->different_date = get_different_dates($value->date, date('Y-m-d'));
            $value->adress = ($value->installment->client->client_address ? $value->installment->client->client_address->last() : '');
            $value->phone = ($value->installment->client->client_phone ? $value->installment->client->client_phone->last() : '');
            if ($value->eqrardain_date != NULL) {
                $value->type_papar = 'وصل امانة';
            } elseif ($value->qard_paper != NULL) {
                $value->type_papar = 'اقرار دين';
            } else
                $value->type_papar = 'لايوجد';
        }
        // dd($this->data['items']);

        $this->data['view'] = 'military_affairs/Stop_bank/print_archive';
        return view('military_affairs/Stop_bank/print_archive', $this->data);

    }

    public function check_info_in_banks($id)
    {
        $message = "تم دخول صفحة استعلام بنوك  ";
        $user_id = 1;
        //$user_id =  Auth::user()->id,
        // $this->log($user_id ,$message);
        // $user_id =  Auth::user()->id;
        $this->data['title'] = '    حجز بنوك';
        $this->data['items'] = DB::table('banks')
            ->where('active', '1')
            ->get();

        $Military = Military_affair::where('id', $id)
            ->with('installment')
            ->with('status_all')
            ->first();


        $title = ' حجز بنوك';

        $breadcrumb = array();
        $breadcrumb[0]['title'] = " الرئيسية";
        $breadcrumb[0]['url'] = route("dashboard");
        $breadcrumb[1]['title'] = "الشئون القانونية";
        $breadcrumb[1]['url'] = route("military_affairs");
        $breadcrumb[2]['title'] = $title;
        $breadcrumb[2]['url'] = 'javascript:void(0);';


        $this->data['view'] = 'military_affairs/Stop_bank/check-bank';
        return view('layout', $this->data, compact('breadcrumb', 'Military'));

    }


public function check_info_in_job  ( $id)
{
    $message ="تم دخول صفحة استعلام عمل  " ;
    $user_id = 1 ;
    //$user_id =  Auth::user()->id,
   // $this->log($user_id ,$message);
   // $user_id =  Auth::user()->id;
    $this->data['title']='    حجز بنوك';

    $this->data['items'] = array(
        0 => array('id' => '5', 'name' => 'وزارة الدفاع'),
        1 => array('id' => '14', 'name' => 'الحرس الوطنى'),
        2 => array('id' => '27', 'name' => 'وزارة الداخلية'),
        3 => array('id' => '46', 'name' => 'التأمينات'),
        4 => array('id' => '47', 'name' => 'ديوان الخدمة'),
    );

    $ids = [5, 27, 14, 46, 47];

    $Military = Military_affair::where('id', $id)
    ->with('installment')
    ->with('status_all')
    ->first();

    $title=' حجز بنوك';

    $breadcrumb = array();
    $breadcrumb[0]['title'] = " الرئيسية";
    $breadcrumb[0]['url'] = route("dashboard");
    $breadcrumb[1]['title'] = "الشئون القانونية";
    $breadcrumb[1]['url'] = route("military_affairs");
    $breadcrumb[2]['title'] = $title;
    $breadcrumb[2]['url'] = 'javascript:void(0);';

    $this->data['view']='military_affairs/Stop_bank/check-job';
    return view('layout',$this->data,compact('breadcrumb','Military'));

    }

    public function saveBanksInfo(Request $request)
    {
        $banksData = $request->input('banks');

        // Check if the user is authenticated
        $userId = Auth::check() ? Auth::user()->id : null;

        foreach ($banksData as $bankInfo) {

            if (isset($bankInfo['found'])) {

                DB::table('military_affairs_bank_info')->updateOrInsert(
                    [
                        'bank_id' => $bankInfo['bank_id'],
                        'military_affairs_id' => $bankInfo['military_affairs_id'],
                    ],
                    [
                        'found' => $bankInfo['found'] ?? null,
                        'bank_status' => $bankInfo['bank_status'] ?? null,
                        'note' => $bankInfo['note'] ?? null,
                        'created_by' => $userId,
                        'updated_by' => $userId,
                        'date' => now()->format('Y-m-d H:i:s'),
                    ]
                );
            }
        }

        return redirect()->route('stop_bank.archive')->with('success', 'تم حفظ البيانات بنجاح');
    }

    public function save_jobs_info(Request $request)
    {
        $banksData = $request->input('banks');

        // Check if the user is authenticated
        $userId = Auth::check() ? Auth::user()->id : null;

        foreach ($banksData as $bankInfo) {

            if (isset($bankInfo['found'])) {

                DB::table('military_affairs_job_info')->updateOrInsert(
                    [
                        'ministry_id' => $bankInfo['ministry_id'],
                        'military_affairs_id' => $bankInfo['military_affairs_id'],
                    ],
                    [
                        'found' => $bankInfo['found'] ?? null,
                        'note' => $bankInfo['note'] ?? null,
                        'created_by' => $userId,
                        'updated_by' => $userId,
                        'date' => now()->format('Y-m-d H:i:s'),
                    ]
                );
            }
        }

        return redirect()->route('stop_bank.archive')->with('success', 'تم حفظ البيانات بنجاح');
    }

    public function change_states_bank($id, $value)
    {

        $item_militry = Military_affair::findOrFail($id);
        $data['bank_account_status'] = $value;
        $update_value = $item_militry->update($data);
        if ($update_value) {
            return true;
        } else {
            return false;
        }


    }


    public function change_states(Request $request)
    {




        $item_law = Military_affair::findOrFail($request->military_affairs_id);
        $old_time_type = Military_affairs_stop_bank_type::findOrFail($request->old_stop_type);
        $new_time_type = Military_affairs_stop_bank_type::findOrFail($request->new_stop_type);
        $update_notes_date = Military_affairs_times::where(['times_type_id' => $old_time_type->id,'military_affairs_id'=>$request->military_affairs_id, 'date_end' => NULL]);

        if ($update_notes_date) {
            $data['date_end'] = date('Y-m-d');
            $update_notes_date->update($data);
        }
        $item_status=Military_affairs_status::where(['type_id'=>$old_time_type->slug,'military_affairs_id'=>$request->military_affairs_id])->orderBy('created_at', 'desc')->first();
        if($item_status){

            $data_status['flag']=1;

            $item_status->update($data_status);
        }


        Add_note($old_time_type, $new_time_type, $request->military_affairs_id);
        Add_note_time($new_time_type, $request->military_affairs_id);
        change_status($request, $request->military_affairs_id);

        return redirect()->route('stop_bank');

    }


    public function stop_bank_request_results(Request $request){

      $item =Military_affair::findorfail($request->military_affairs_id);

        $item_request =Military_affairs_bank_request::where(['military_affairs'=>$request->military_affairs_id,'status'=>''])->first();

        if (empty($item_request)) {
            $add_data_2['military_affairs_id'] = $request->military_affairs_id;
            $add_data_2['date'] = time();
             Military_affairs_bank_request::create($add_data_2);
            return redirect()->route('stop_bank')->with('error', '  عفوا يوجد خطأ');

        }

        $request->validate([
            'date' => 'required| date',
            'military_affairs_id'=>'required',
            'type'=>'required',
            'img_dir'=>'required',
            'amount'=>'required'
        ]);



            $item_request_id = $item_request->id;

            $add_data["status"] = $request->military_affairs_id;

            $add_data["amount"] = $request->amount;

            $add_data['date'] = $request->date;


            if ($request->hasFile('img_dir')) {

                $filename = time() . '-' . $request->file('img_dir')->getClientOriginalName();
                $path = $request->file('img_dir')->move(public_path('military_affairs'), $filename);
                $data['img_dir'] = 'military_affairs' . '/' . $filename;
            }




                if (!empty($data["item_request"]['id'])) {
                    $this->db_get->update_tb('military_affairs_bank_request', $item_request_id, $add_data);

                    if ($request->type == 'tahseel' or $request->type == 'not_found') {

                        $add_data343["stop_bank_request"] = 1;

                        $add_data343["stop_bank_doing"] = 0;

                        $add_data343["stop_bank_command"] = 0;

                        $this->db_get->update_tb('military_affairs', $id, $add_data343);

                    }



                    return redirect()->to(base_url() . 'military_affairs/stop_bank');
                }


    }

    ///////////////////////////////case_proof function


}
