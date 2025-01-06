<?php

namespace App\Repositories\Military_affairs;

use App\Interfaces\Military_affairs\ImageRepositoryInterface;
use App\Models\Court;
use App\Models\Governorate;
use App\Models\Military_affairs\Military_affair;
use App\Models\Military_affairs\Military_affairs_jalasaat;
use App\Models\Military_affairs\Military_affairs_times;
use App\Models\Military_affairs\Military_affairs_times_type;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ImageRepository implements ImageRepositoryInterface
{
    protected $data;
    protected $title;
    public function __construct()
    {

        $this->data['governorates'] = Governorate::with('clients')->get();
        $this->data['courts'] = Court::with('government')->get();
        $this->title = 'الايمج';
    }
    public function index(Request $request)
    {
        // dd($request->governorate_id);
        if($request->governorate_id){
            $governorate_id =Court::findorfail($request->governorate_id)->governorate_id  ;

        }else{
            $governorate_id='';
        }

        // dd($governorate_id);
        $message = "تم دخول صفحة  الايمج";
        $user_id =  Auth::user()->id;

        log_move($user_id,$message);
        $fun_status = ['military_affairs.status' => 'images', 'military_affairs.jalasat_alert_status' => 'accepted'];
        $count_total = $this->count_image('', $fun_status);
        foreach ($this->data['governorates'] as $one) {
            $count['counter_' . $one->id] = $this->count_image($one->id, $fun_status);
        }

        $this->data['item_type_time'] = Military_affairs_times_type::where(['type' => 'images', 'slug' => 'images'])->first();
        $this->data['item_type_time_new'] = Military_affairs_times_type::where(['type' => 'case_proof', 'slug' => 'case_proof'])->first();

        $jalasat_dd = Military_affairs_jalasaat::where(['type' => 'images', 'military_affairs_id' => $request->military_affairs_id, 'status' => 'accepted'])->first();

        // $governorate_id = $request->governorate_id;

      /*  $transactions = Military_affair::where('archived', '=', 0)
            ->where(['military_affairs.status' => 'execute'])
            ->with('installment')->with('status_all')->with('jalasaat_all')->get();
        foreach ($transactions as $value) {
            if ($value->status_all->where('type', 'execute')->first()) {
                $open_file_date = $value->status_all->where('type', 'execute')->first()->date;
                $value->open_file_date = explode(' ', $open_file_date)[0];

            } else {
                $value->open_file_date = '';
            }
            $value->different_date = get_different_dates($value->date, date('Y-m-d'));

        }*/

        $transactions= Military_affair::where('archived','=',0)
            ->where(['military_affairs.status' =>'images','jalasat_alert_status'=> 'accepted'])
            ->with('installment', function ($query) {
                return $query->where('finished','=', 0);
            })->with('jalasaat_all', function ($query) {
                return $query->where('status', '=', 'accepted');
            })
            ->when(request()->has('governorate_id'), function ($query) use ($governorate_id) {
                $query->whereHas('installment.client', function ($q) use ($governorate_id) {
                    $q->where('governorate_id', $governorate_id);
                });
            }
            )->get();

          

        foreach ( $transactions as $value) {




            $value->final_data =$item_data=explode(' ',$value->created_at);

            $value->phone= $value->installment ?  $value->installment->client->client_phone->last()->phone : ''   ;


            $value->different_date = get_different_dates($item_data[0], date('Y-m-d'));

        }


        /*
        $govern = [];
        if (!empty($governorate_id)) {
        $govern = ['clients.governorate_id' => $governorate_id];
        }
        if ($governorate_id == 0) {
        $govern = [];
        }

        // Define fixed conditions for the type of note and other filters
        $type_notes = 'images';
        $type = [
        'military_affairs.status' => 'execute_alert',
        'military_affairs.jalasat_alert_status' => 'accepted'
        ];

        $case_type = 21;  // This variable is defined but not used directly. It's likely for future use.

        // Conditions to filter
        $arr = ['tahseel' => 0, 'installment.finished' => 0, 'military_affairs.archived' => 0];

        // Merge all conditions (arrays)
        $concat = array_merge($arr, $type, $govern);

        // Build the query
        $transactions = DB::table('military_affairs')
        ->select(
        'installment.id as installment_id',
        'military_affairs.issue_id',
        'military_affairs.open_file_date',
        'clients.id as client_id',
        'clients.name_ar as client_name',
        'clients.civil_number',
        'clients.phone_ids',
        'clients.governorate_id',
        'installment.qard_paper',
        'installment.eqrardain_amount',
        'installment.eqrardain_date',
        'installment.amana_paper',
        'clients.job_type',
        'military_affairs.id',
        'military_affairs.date as my_date',
        'military_affairs.emp_id',
        'installment.finished',
        DB::raw('(SELECT COUNT(military_affairs_notes.id) FROM military_affairs_notes WHERE military_affairs_notes.military_affairs_id = military_affairs.id AND cat2 = "images") AS note_count'),
        DB::raw('(SELECT military_affairs_notes.date_start FROM military_affairs_notes WHERE military_affairs_notes.military_affairs_id = military_affairs.id AND military_affairs_notes.times_type_id = 18 ORDER BY ID DESC LIMIT 1) AS data_start')
        )
        ->when(!empty($concat), function ($query) use ($concat) {
        return $query->where($concat);
        })
        ->leftJoin('installment', 'military_affairs.installment_id', '=', 'installment.id')
        ->leftJoin('clients', 'installment.client_id', '=', 'clients.id')
        ->orderBy('installment_id', 'asc')
        ->get();
         */

        $breadcrumb = array();
        $breadcrumb[0]['title'] = " الرئيسية";
        $breadcrumb[0]['url'] = route("dashboard");
        $breadcrumb[1]['title'] = " الشئون القانونية";
        $breadcrumb[1]['url'] = route("military_affairs");
        $breadcrumb[2]['title'] = $this->title;
        $breadcrumb[2]['url'] = 'javascript:void(0);';
        $view = 'military_affairs/image/index';
        $title = $this->title;
        $this->data['get_responsible'] = get_responsible();


        return view('layout', compact(['title', 'view', 'count', 'transactions', 'count_total', 'breadcrumb']), $this->data);

    }
    public function to_a3lan_eda3(Request $request)
    {
        dd($request->all());
    }
    public function athbat_7ala($id)
    {

      //  $data['item'] = $this->one_lawaffaires_items_sql($id);

      //  $data["client"] = $this->db_get->get_by_id('clients', $data['item']['client_id']);


        $old_time_type=Military_affairs_times_type::where(['type' => 'images', 'slug' => 'images'])->first();
        $new_time_type=Military_affairs_times_type::where(['type' => 'case_proof', 'slug' => 'case_proof'])->first();
        $item_time=Military_affairs_times::where(['times_type_id'=>$old_time_type->id,'military_affairs_id'=>$id])->first();

        Add_note($old_time_type, $new_time_type, $id);
        Add_note_time($new_time_type, $id);
        if($item_time){
            $data['date_end']=date('Y-m-d H:i:s');

            $item_time->update($data);
        }

        $add_data['status'] = 'case_proof';
        $item_military=Military_affair::findorfail($id);
        $item_military->update($add_data);
        $message = "تم التحويل من الصور الى اثبات الحالة";
        $user_id =  Auth::user()->id;

        log_move($user_id,$message);


        return view("military_affairs/image/print_data");



    }
    public function count_image($governate_id, $fun_status, $type = null)
    {

        if (!empty($governate_id)) {
            $govern = ['clients.governorate_id' => $governate_id];
        } else {
            $govern = [];
        }
        if (!empty($type)) {
            $status = ['military_affairs.status' => 'case_proof'];
        } else {
            $status = ['military_affairs.status' => 'execute_alert'];
        }

        $item = DB::table('military_affairs')->select(DB::raw('COUNT(military_affairs.id) as the_counter'))
            ->where(['military_affairs.installment_id' => 0, 'tahseel' => 0, 'installment.finished' => 0])
            ->where($govern)
            ->where($fun_status)
            ->where($status)
            ->leftJoin('installment', 'military_affairs.installment_id', '=', 'installment.id')
            ->leftJoin('clients', 'installment.client_id', '=', 'clients.id')
            ->groupBy('installment.id')->first();

        if (empty($item)) {
            $the_counter = 0;
        } else { $the_counter = $item->the_counter;}
        return $the_counter;

    }
}
