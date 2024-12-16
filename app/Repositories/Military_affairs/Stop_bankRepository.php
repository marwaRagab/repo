<?php

namespace App\Repositories\Military_affairs;

use App\Models\Log;
use App\Models\Bank;
use Inertia\Inertia;
use App\Models\Court;
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
        $this->data['stop_bank_types'] = Military_affairs_stop_bank_type::all();
        $this->data['ministries'] = Ministry::get('date');
        $color_array=['bg-warning-subtle text-warning','bg-success-subtle text-success','bg-danger-subtle text-danger','px-4 bg-primary-subtle text-primary','bg-danger-subtle text-danger','me-1 mb-1  bg-warning-subtle text-warning','bg-warning-subtle text-warning'];

        $this->data['banks'] = Bank::all();
        for($i=0;$i<count($this->data['ministries']);$i++){
            $this->data['ministries'][$i]['ministries_dates'] =date('Y-m-'.$this->data['ministries'][$i]['date']) ;

        }


        for($i=0;$i<count($this->data['courts']);$i++){
            $this->data['courts'][$i]['style'] =$color_array[$i] ;
        }

        for($i=0;$i<count($this->data['stop_bank_types']);$i++){
            $this->data['stop_bank_types'][$i]['style'] =$color_array[$i] ;
        }
    }
    public function index(Request $request)
    {

        $governorate_id= $request->governorate_id;
        $message ="تم دخول صفحة  حجز بنوك  " ;
        $user_id = 1 ;
        //$user_id =  Auth::user()->id,
       // $this->log($user_id ,$message);
       // $user_id =  Auth::user()->id;
        $this->data['title']='    حجز بنوك';
        $this->data['items']= Military_affair::where('archived','=',0)
            ->where(['military_affairs.status' =>'execute', 'military_affairs.stop_bank' =>1  ])->with('installment')->with('status_all')->get();
        $title=' حجز بنوك';

        $breadcrumb = array();
        $breadcrumb[0]['title'] = " الرئيسية";
        $breadcrumb[0]['url'] = route("dashboard");
        $breadcrumb[1]['title'] = "الشئون القانونية";
        $breadcrumb[1]['url'] = route("military_affairs");
        $breadcrumb[2]['title'] = $title;
        $breadcrumb[2]['url'] = 'javascript:void(0);';
        $stop_type= $request->stop_bank_type;
        if(!$stop_type){
            $stop_type='stop_bank_request';
        }

        if($stop_type=='stop_bank_command'){
            $new_type='stop_bank_researcher';
        }elseif ($stop_type=='stop_bank_researcher'){
            $new_type='banks';
        }elseif ($stop_type=='banks'){
            $new_type='stop_bank_doing';
        }elseif ($stop_type=='stop_bank_cancel_request'){
            $new_type='stop_bank_cancel';
        }else{
            $new_type='stop_bank_command';

        }

        $this->data['item_type_time_old']=Military_affairs_stop_bank_type::where(['type'=> 'stop_bank','slug'=> $stop_type])->first();
        $this->data['item_type_time_new']=Military_affairs_stop_bank_type::where(['type'=> 'stop_bank','slug'=>$new_type])->first();

        foreach ( $this->data['items'] as $value){

            $value->item_old_data=Prev_cols_military_affairs::where('military_affairs_id',$value->id) ->first();

            $value->different_date = get_different_dates($value->date,date('Y-m-d'));
            $value->adress= ($value->installment->client->client_address ?  $value->installment->client->client_address->last() : '' );
            $value->phone= ($value->installment->client->client_phone ?  $value->installment->client->client_phone->last() : ''   );
            if($value->eqrardain_date != NULL){
                $value->type_papar= 'وصل امانة';
            }elseif ($value->qard_paper != NULL){
                $value->type_papar  ='اقرار دين';
            }else
                $value->type_papar='لايوجد';
        }
           // dd($this->data['items']);

        $this->data['view']='military_affairs/Stop_bank/index';
        return view('layout',$this->data,compact('breadcrumb'));

    }


    public function archive(Request $request)
{
    $governorate_id= $request->governorate_id;
    $message ="تم دخول صفحة  ارشيف حجز بنوك  " ;
    $user_id = 1 ;
    //$user_id =  Auth::user()->id,
   // $this->log($user_id ,$message);
   // $user_id =  Auth::user()->id;
    $this->data['title']='    حجز بنوك';
    $this->data['items'] = Military_affair::where('archived', '=', 1)
    ->where([
        'military_affairs.status' => 'execute',
        'military_affairs.stop_bank' => 1,
    ])
    ->with('installment')
    ->with('status_all')
    ->get();
    $title=' حجز بنوك';

    $breadcrumb = array();
    $breadcrumb[0]['title'] = " الرئيسية";
    $breadcrumb[0]['url'] = route("dashboard");
    $breadcrumb[1]['title'] = "الشئون القانونية";
    $breadcrumb[1]['url'] = route("military_affairs");
    $breadcrumb[2]['title'] = $title;
    $breadcrumb[2]['url'] = 'javascript:void(0);';

    $stop_type= $request->stop_bank_type;
    if(!$stop_type){
        $stop_type='stop_bank_request';
    }

    if($stop_type=='stop_bank_command'){
        $new_type='stop_bank_researcher';
    }elseif ($stop_type=='stop_bank_researcher'){
        $new_type='banks';
    }elseif ($stop_type=='banks'){
        $new_type='stop_bank_doing';
    }elseif ($stop_type=='stop_bank_cancel_request'){
        $new_type='stop_bank_cancel';
    }else{
        $new_type='stop_bank_command';

    }

    $this->data['item_type_time_old']=Military_affairs_stop_bank_type::where(['type'=> 'stop_bank','slug'=> $stop_type])->first();
    $this->data['item_type_time_new']=Military_affairs_stop_bank_type::where(['type'=> 'stop_bank','slug'=>$new_type])->first();

    foreach ( $this->data['items'] as $value){

        $value->item_old_data=Prev_cols_military_affairs::where('military_affairs_id',$value->id) ->first();

        $value->different_date = get_different_dates($value->date,date('Y-m-d'));
        $value->adress= ($value->installment->client->client_address ?  $value->installment->client->client_address->last() : '' );
        $value->phone= ($value->installment->client->client_phone ?  $value->installment->client->client_phone->last() : ''   );
        if($value->eqrardain_date != NULL){
            $value->type_papar= 'وصل امانة';
        }elseif ($value->qard_paper != NULL){
            $value->type_papar  ='اقرار دين';
        }else
            $value->type_papar='لايوجد';
    }
       // dd($this->data['items']);

    $this->data['view']='military_affairs/Stop_bank/archive';
    return view('layout',$this->data,compact('breadcrumb'));

}

public function print_archive(Request $request)
{
    $governorate_id= $request->governorate_id;
    $message ="تم دخول صفحة  طباعة ارشيف حجز بنوك  " ;
    $user_id = 1 ;
    //$user_id =  Auth::user()->id,
   // $this->log($user_id ,$message);
   // $user_id =  Auth::user()->id;
    $this->data['title']=' حجز بنوك';
    $this->data['items'] = Military_affair::where('archived', '=', 1)
    ->where([
        'military_affairs.status' => 'execute',
        'military_affairs.stop_bank' => 1,
    ])
    ->with('installment')
    ->with('status_all')
    ->get();
    $title=' حجز بنوك';

    $breadcrumb = array();
    $breadcrumb[0]['title'] = " الرئيسية";
    $breadcrumb[0]['url'] = route("dashboard");
    $breadcrumb[1]['title'] = "الشئون القانونية";
    $breadcrumb[1]['url'] = route("military_affairs");
    $breadcrumb[2]['title'] = $title;
    $breadcrumb[2]['url'] = 'javascript:void(0);';

    $stop_type= $request->stop_bank_type;
    if(!$stop_type){
        $stop_type='stop_bank_request';
    }

    if($stop_type=='stop_bank_command'){
        $new_type='stop_bank_researcher';
    }elseif ($stop_type=='stop_bank_researcher'){
        $new_type='banks';
    }elseif ($stop_type=='banks'){
        $new_type='stop_bank_doing';
    }elseif ($stop_type=='stop_bank_cancel_request'){
        $new_type='stop_bank_cancel';
    }else{
        $new_type='stop_bank_command';

    }

    $this->data['item_type_time_old']=Military_affairs_stop_bank_type::where(['type'=> 'stop_bank','slug'=> $stop_type])->first();
    $this->data['item_type_time_new']=Military_affairs_stop_bank_type::where(['type'=> 'stop_bank','slug'=>$new_type])->first();

    foreach ( $this->data['items'] as $value){

        $value->item_old_data=Prev_cols_military_affairs::where('military_affairs_id',$value->id) ->first();

        $value->different_date = get_different_dates($value->date,date('Y-m-d'));
        $value->adress= ($value->installment->client->client_address ?  $value->installment->client->client_address->last() : '' );
        $value->phone= ($value->installment->client->client_phone ?  $value->installment->client->client_phone->last() : ''   );
        if($value->eqrardain_date != NULL){
            $value->type_papar= 'وصل امانة';
        }elseif ($value->qard_paper != NULL){
            $value->type_papar  ='اقرار دين';
        }else
            $value->type_papar='لايوجد';
    }
       // dd($this->data['items']);

    $this->data['view']='military_affairs/Stop_bank/print_archive';
    return view('military_affairs/Stop_bank/print_archive',$this->data);

}

public function check_info_in_banks( $id)
{
    $message ="تم دخول صفحة استعلام بنوك  " ;
    $user_id = 1 ;
    //$user_id =  Auth::user()->id,
   // $this->log($user_id ,$message);
   // $user_id =  Auth::user()->id;
    $this->data['title']='    حجز بنوك';
    $this->data['items'] = DB::table('military_affairs_bank_info')
    ->join('banks', 'military_affairs_bank_info.bank_id', '=', 'banks.id')
    ->where('military_affairs_bank_info.military_affairs_id', $id)
    ->select('banks.*', 'military_affairs_bank_info.found', 'military_affairs_bank_info.note')
    ->get();
    // dd($this->data['items']);

    $this->data['Military_affair'] = Military_affair::where('id', '=')
    ->where([
        'military_affairs.status' => 'execute',
        'military_affairs.stop_bank' => 1,
    ])
    ->with('installment')
    ->with('status_all')
    ->get();

    $title=' حجز بنوك';

    $breadcrumb = array();
    $breadcrumb[0]['title'] = " الرئيسية";
    $breadcrumb[0]['url'] = route("dashboard");
    $breadcrumb[1]['title'] = "الشئون القانونية";
    $breadcrumb[1]['url'] = route("military_affairs");
    $breadcrumb[2]['title'] = $title;
    $breadcrumb[2]['url'] = 'javascript:void(0);';


    $this->data['view']='military_affairs/Stop_bank/check-bank';
    return view('layout',$this->data,compact('breadcrumb'));

}
    public function change_states_bank($id,$value)
    {

        $item_militry=Military_affair::findOrFail($id);
        $data['bank_account_status']=$value;
       $update_value =$item_militry->update($data);
        if($update_value){
            return true;
        }else{
            return false;
        }



    }



    public function change_states(Request $request)
    {



        change_status($request,$request->military_affairs_id);

        $item_law=Military_affair::findOrFail($request->military_affairs_id);
        $old_time_type=Military_affairs_stop_bank_type::findOrFail($request->old_stop_type);
        $new_time_type=Military_affairs_stop_bank_type::findOrFail($request->new_stop_type);
        $update_notes_date= Military_affairs_notes::where(['times_type_id'=>$old_time_type->id, 'date_end' =>NULL]);
        if($update_notes_date){
            $data['date_end']= date('Y-m-d');
            $update_notes_date->update($data);
        }


        Add_note($old_time_type,$new_time_type,$request->military_affairs_id);



        return redirect()->route('stop_bank');

    }

    ///////////////////////////////case_proof function















}