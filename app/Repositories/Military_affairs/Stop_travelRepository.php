<?php

namespace App\Repositories\Military_affairs;

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

class Stop_travelRepository implements Stop_travelRepositoryInterface
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

        $governorate_id= $request->governorate_id;
        $message ="تم دخول صفحة فتح ملف" ;

        $user_id =  Auth::user()->id;
        log_move($user_id ,$message);

        $this->data['title']='   منع سفر';
        $this->data['items']= Military_affair::where('archived','=',0)
            ->where(['military_affairs.status' =>'execute', 'military_affairs.stop_travel' =>1  ])->with('installment', function ($query) {
                return $query->where('finished', '=', 0);
            })->with('status_all')->get();

        $title=' منع السفر';

        $breadcrumb = array();
        $breadcrumb[0]['title'] = " الرئيسية";
        $breadcrumb[0]['url'] = route("dashboard");
        $breadcrumb[1]['title'] = "الشئون القانونية";
        $breadcrumb[1]['url'] = route("military_affairs");
        $breadcrumb[2]['title'] = $title;
        $breadcrumb[2]['url'] = 'javascript:void(0);';
        $this->data['item_type_time1']=Stop_travel_types::where(['type'=> 'stop_travel','slug'=>'request'])->first();

        $this->data['item_type_time2']=Stop_travel_types::where(['type'=> 'stop_travel','slug'=>'command'])->first();
        $this->data['item_type_time3']=Stop_travel_types::where(['type'=> 'stop_travel','slug'=>'stop_travel_finished'])->first();
        $this->data['item_type_time4']=Stop_travel_types::where(['type'=> 'stop_travel','slug'=>'stop_travel_cancel_request'])->first();
        $this->data['item_type_time5']=Stop_travel_types::where(['type'=> 'stop_travel','slug'=>'stop_travel_cancel'])->first();

        foreach ( $this->data['items'] as $value) {
            if ($value->status_all->where('type', 'open_file')->first()) {
                $open_file_date = $value->status_all->where('type', 'open_file')->first()->date;
                $value->open_file_date = explode(' ', $open_file_date)[0];

            } else {
                $value->open_file_date = '';
            }

            $value->different_date = get_different_dates($value->date, date('Y-m-d'));

            // dd($this->data['items']);
        }
        $this->data['view']='military_affairs/Stop_travel/index';
        return view('layout',$this->data,compact('breadcrumb'));

    }







    public function stop_travel_convert(Request $request)
    {

        $request->validate([
            'date' => 'required| date',
            'img_dir'=>'required|image|mimes:jpg,png,jpeg,gif|max:2048',
        ]);

        $array_old=Stop_travel_types::findorfail($request->item_type_old);
        $array_new=Stop_travel_types::findorfail($request->item_type_new);
        $data['end_date']=date('Y-m-d');
        $array_old->update($data);
        Add_note($array_old,$array_new,$request->military_affairs_id);
        change_status($request,$request->military_affairs_id);


        return redirect()->route('stop_travel');

    }

    ///////////////////////////////case_proof function















}
