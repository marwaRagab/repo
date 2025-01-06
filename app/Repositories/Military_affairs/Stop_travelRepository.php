<?php

namespace App\Repositories\Military_affairs;

use App\Models\Log;
use Inertia\Inertia;
use App\Models\Court;
use App\Models\Ministry;
use App\Models\Governorate;
use App\Models\Installment;
use Illuminate\Http\Request;
use App\Models\InstallmentNote;
use Yajra\DataTables\DataTables;
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
use App\Models\Military_affairs\Military_affairs_times_type;
use App\Interfaces\Military_affairs\Open_fileRepositoryInterface;
use App\Models\Military_affairs\Military_affairs_certificate_type;
use App\Interfaces\Military_affairs\Stop_travelRepositoryInterface;

class Stop_travelRepository implements Stop_travelRepositoryInterface
{
    protected $data;


    public function __construct()
    {
        //


        $this->data['governorates'] = Governorate::with('clients')->get();
        $this->data['courts'] = Court::with('government')->get();
        $this->data['stop_travel_types'] = Stop_travel_types::all();
        $color_array = ['bg-warning-subtle text-warning', 'bg-success-subtle text-success', 'bg-danger-subtle text-danger', 'px-4 bg-primary-subtle text-primary', 'bg-danger-subtle text-danger', 'me-1 mb-1  bg-warning-subtle text-warning'];

        for ($i = 0; $i < count($this->data['courts']); $i++) {
            $this->data['courts'][$i]['style'] = $color_array[$i];
        }

        for ($i = 0; $i < count($this->data['stop_travel_types']); $i++) {
            $this->data['stop_travel_types'][$i]['style'] = $color_array[$i];
        }

    }

    public function index(Request $request)
    {

        if($request->governorate_id){
            $governorate_id =Court::findorfail($request->governorate_id)->governorate_id  ;

        }else{
            $governorate_id ='';
        }


        $message = "تم دخول صفحة فتح ملف";
        $stop_travel_type = $request->stop_travel_type;

        $user_id = Auth::user()->id;
        log_move($user_id, $message);

        $this->data['title'] = '   منع سفر';
        $this->data['items'] = Military_affair::where('archived', '=', 0)
            ->where(['military_affairs.status' => 'execute', 'military_affairs.stop_travel' => 1])
            ->with('installment', function ($query) {
                return $query->where('finished', '=', 0);
            })
            ->with('status_all', function ($query) {
                return $query->where('type', '=', 'stop_travel');
            })
            ->when($governorate_id, function ($query) use ($governorate_id) {
                $query->whereHas('installment.client', function ($q) use ($governorate_id) {
                    $q->where('governorate_id', $governorate_id);
                });
            })->when(request()->has('stop_travel_type'), function ($query) use ($request) {
                $query->whereHas('status_all', function ($q) use ($request) {

                  return  $q->where('type_id','=', $request->stop_travel_type)->where('flag',0);
                });
})
            ->get();

     //   dd( $this->data['items']);

        $title = ' منع السفر';

        $breadcrumb = array();
        $breadcrumb[0]['title'] = " الرئيسية";
        $breadcrumb[0]['url'] = route("dashboard");
        $breadcrumb[1]['title'] = "الشئون القانونية";
        $breadcrumb[1]['url'] = route("military_affairs");
        $breadcrumb[2]['title'] = $title;
        $breadcrumb[2]['url'] = 'javascript:void(0);';
        $this->data['item_type_time1'] = Stop_travel_types::where(['type' => 'stop_travel', 'slug' => 'request'])->first();

        $this->data['item_type_time2'] = Stop_travel_types::where(['type' => 'stop_travel', 'slug' => 'command'])->first();
        $this->data['item_type_time3'] = Stop_travel_types::where(['type' => 'stop_travel', 'slug' => 'stop_travel_finished'])->first();
        $this->data['item_type_time4'] = Stop_travel_types::where(['type' => 'stop_travel', 'slug' => 'stop_travel_cancel_request'])->first();
        $this->data['item_type_time5'] = Stop_travel_types::where(['type' => 'stop_travel', 'slug' => 'stop_travel_cancel'])->first();
           $x=1;
        foreach ($this->data['items'] as $value) {
            if($value->installment){
                $value->all_notes=$value->notes->where('type','stop_travel');
                $value->all_actions=get_all_actions($value->id);
                $value->get_all_delegations=get_all_delegations($value->id);
                $value->i=$x;
                $value->different_date_tranfer = get_different_date($value->date, date('Y-m-d'));
                if ($stop_travel_type == 'command') {
                    $value->item_command = $value->status_all->where('type_id', 'command')->where('flag', 0)->first();
                    $date_command =$value->item_command   ?  $value->item_command->date : '';
                    $value->final_date_command  =$value->item_command ?    explode(' ', $date_command) : '';
                    $value->different_date_command  =$value->item_command ?  get_different_date($value->final_date_command[0], date('Y-m-d')) : '';
                }
                if ($stop_travel_type == 'stop_travel_finished') {
                    $value->item_finished_command = $value->status_all->where('type_id', 'command')->where('flag', 1)->first();
                    $date_finished_command = $value->item_finished_command ?  $value->item_finished_command->date : '';
                    $value->final_date_finished_command = $value->item_finished_command ?  explode(' ', $date_finished_command) : '';
                    $value->different_date_finshied_command =  $value->item_finished_command ? get_different_date($value->final_date_finished_command[0], date('Y-m-d')) : '';
                    $value->item_finished = $value->status_all->where('type_id', 'stop_travel_finished')->first();
                    $date_finished = $value->item_finished ? $value->item_finished->date : '';
                    $value->final_date_finished = $value->item_finished ?  explode(' ', $date_finished) : '';
                    $value->different_date_finshied = $value->item_finished ?  get_different_date($value->final_date_finished[0], date('Y-m-d')) : '';

                }
                $x++;
            }

        }
        $this->data['get_responsible'] = get_responsible();
        $this->data['view'] = 'military_affairs/Stop_travel/index';
        return view('layout', $this->data, compact('breadcrumb'));

    }


    public function stop_travel_convert(Request $request)
    {


        $request->validate([
            'date' => 'required| date',
            'img_dir' => 'required|image|mimes:jpg,png,jpeg,gif|max:2048',
        ]);

        $array_old = Stop_travel_types::findorfail($request->item_type_old);
        $array_new = Stop_travel_types::findorfail($request->item_type_new);

        // $array_old->update($data);
        $item_time=Military_affairs_times::where(['times_type_id'=>$request->item_type_old,'military_affairs_id'=>$request->military_affairs_id])->orderBy('created_at', 'desc')->first();
        $item_status=Military_affairs_status::where(['type_id'=>$array_old->slug,'military_affairs_id'=>$request->military_affairs_id])->orderBy('created_at', 'desc')->first();


        if($item_status){

            $data_status['flag']=1;

            $item_status->update($data_status);
        }
        // dd($item_status);
        if($item_time){
            $data['date_end']=date('Y-m-d H:i:s');

            $item_time->update($data);
        }
        Add_note($array_old, $array_new, $request->military_affairs_id);
        Add_note_time($array_new, $request->military_affairs_id);
        change_status($request, $request->military_affairs_id);


        return redirect()->route('stop_travel');

    }

    ///////////////////////////////case_proof function


}
