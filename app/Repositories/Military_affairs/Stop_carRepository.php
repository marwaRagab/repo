<?php

namespace App\Repositories\Military_affairs;

use App\Interfaces\Military_affairs\Stop_carRepositoryInterface;
use App\Models\InstallmentNote;
use App\Models\Client;
use App\Models\Installment;
use App\Models\Installment_month;
use App\Models\Log;
use Illuminate\Support\Facades\DB;

use App\Models\Military_affairs\Military_affairs_notes;
use App\Models\Military_affairs\Military_affairs_times_type;
use App\Models\Military_affairs\Military_affair;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use App\Models\Governorate;
use App\Models\Court;
class Stop_carRepository implements Stop_carRepositoryInterface
{
    protected $data;
    protected $title;

    public function __construct()
    {
        $this->data['title']='حجز السيارات';
        $this->data['governorates'] = Governorate::with('clients')->get();
        $this->data['courts'] = Court::with('government')->get();
    }
    public function index($governate_id=null,$stop_car_type=null,$police_station_id=null)
    {
        $message ="تم دخول صفحة  حجز السيارات" ;
      
        $this->data['govern_count_total'] = $this->count_stop_car_governate_sql('execute','stop_car', '');
        foreach( $this->data['governorates'] as $one){
           $count['govern_counter_'.$one->id] =$this->count_stop_car_governate_sql('execute','stop_car', $one->id);
        }
        $this->data['item_type_time']=Military_affairs_times_type::where(['type'=> 'stop_car','slug'=>'stop_car'])->first();
        $this->data['item_type_time_new']=Military_affairs_times_type::where(['type'=> 'stop_car','slug'=>'stop_car'])->first();


        if (!empty($governate_id)) {
            $governate_id = $governate_id;
            $this->data['governate_id'] = $governate_id;
        } else {
            $governate_id = '';
            $this->data['governate_id'] = 0;
        }

        // echo $governate_id; exit();

        if (!empty($stop_car_type)) {
            $stop_car_type = $stop_car_type;
        } else {
            $stop_car_type = '';
        }
       
        
        if (!empty($police_station_id)) {
            $this->data['police_station_id'] = $police_station_id ;
        } else {
            $this->data['police_station_id'] = $police_station_id = '';
        }
       
        $this->data['stop_car_request_counter'] = $this->count_stop_car_sql('execute', 'stop_car', $governate_id, 'stop_car_request');
        $this->data['stop_car_info_counter'] = $this->count_stop_car_sql('execute', 'stop_car', $governate_id, 'stop_car_info');
        $this->data['stop_car_catch_counter'] = $this->count_stop_car_sql('execute', 'stop_car', $governate_id, 'stop_car_catch');
        $this->data['stop_car_police_counter'] = $this->count_stop_car_sql('execute', 'stop_car', $governate_id, 'stop_car_police');
        $this->data['stop_car_doing_counter'] = $this->count_stop_car_sql('execute', 'stop_car', $governate_id, 'stop_car_doing');
        $this->data['stop_car_police_station'] = $this->count_stop_car_sql('execute', 'stop_car', $governate_id, 'stop_car_police_station');
        $this->data['stop_car_finished_counter'] = $this->count_stop_car_sql('execute', 'stop_car', $governate_id, 'stop_car_finished');
        $this->data['stop_car_cancel_request_counter'] = $this->count_stop_car_sql('execute', 'stop_car', $governate_id, 'stop_car_cancel_request');
        $this->data['stop_car_cancel_counter'] = $this->count_stop_car_sql('execute', 'stop_car', $governate_id, 'stop_car_cancel');

        $transactions =$this->get_all_stop_car($governate_id,$stop_car_type,$police_station_id);
   
     //   $transactions=[];
        $breadcrumb = array();
        $breadcrumb[0]['title'] = " الرئيسية";
        $breadcrumb[0]['url'] = route("dashboard");
        $breadcrumb[1]['title'] = " الشئون القانونية";
        $breadcrumb[1]['url'] = route("military_affairs");
        $breadcrumb[2]['title'] = $this->data['title'];
        $breadcrumb[2]['url'] = 'javascript:void(0);';
        $view='military_affairs/stop_car/index';
        $title=$this->title;
        return view('layout',compact(['title','view','transactions','breadcrumb','count']),$this->data);
       
    
   

}

public function get_all_stop_car($governate_id, $stop_car_type_send = null, $police_station_id = null)
{


    $status = 'execute';
    $type = 'stop_car';


    if (!empty($type)) {
        $type_e = ['military_affairs.'.$type=>1];
    }
    if ( $governate_id !=0 && $governate_id !='') {
        $govern = ['clients.governorate_id'=>$governate_id];
    } else {
        $govern = [];
    }


    if (!empty($stop_car_type_send)) {
        if ($stop_car_type == 'stop_car_request') {
            $stop_car_type = ["military_affairs.stop_car_info"=>0
                ,"military_affairs.stop_car_catch"=>0,"military_affairs.stop_car_police"=>0,
                "military_affairs.stop_car_doing"=>0,"military_affairs.stop_car_police_station"=>0,
                  "military_affairs.stop_car_finished"=>0];
        } elseif ($stop_car_type_send == 'stop_car_info') {
            $stop_car_type =[ "military_affairs.stop_car_request"=>1,"military_affairs.stop_car_info"=>1
                ,"military_affairs.stop_car_catch"=>0,"military_affairs.stop_car_police"=>0
                ,"military_affairs.stop_car_doing"=>0,"military_affairs.stop_car_police_station"=>0 
                ,"military_affairs.stop_car_finished"=>0];

        } elseif ($stop_car_type_send == 'stop_car_police') {
            $stop_car_type =["military_affairs.stop_car_request"=>1,"military_affairs.stop_car_info"=>1
                ,"military_affairs.stop_car_police"=>1,"military_affairs.stop_car_catch"=>0,
                "military_affairs.stop_car_police_station"=>0,
                "military_affairs.stop_car_doing"=>0,"military_affairs.stop_car_finished"=>0];

        } elseif ($stop_car_type_send == 'stop_car_catch') {
            $stop_car_type = ["military_affairs.stop_car_request"=>1,"military_affairs.stop_car_info"=>1
                ,"military_affairs.stop_car_police"=>1,"military_affairs.stop_car_catch"=>1
                ,"military_affairs.stop_car_doing"=>0,"military_affairs.stop_car_police_station"=>0,
                "military_affairs.stop_car_finished"=>0];

        } elseif ($stop_car_type_send == 'stop_car_police_station') {
            $stop_car_type = ["military_affairs.stop_car_request"=>1,"military_affairs.stop_car_info"=>1,
                "military_affairs.stop_car_catch"=>1,"military_affairs.stop_car_police"=>1,
                "military_affairs.stop_car_doing"=>0,"military_affairs.stop_car_police_station"=>1,
                "military_affairs.stop_car_finished"=>0];

            // echo $stop_car_type; exit();


        } elseif ($stop_car_type_send == 'stop_car_doing') {
            $stop_car_type = ["military_affairs.stop_car_request"=>1,"military_affairs.stop_car_info"=>1
                , "military_affairs.stop_car_catch"=>1,"military_affairs.stop_car_police"=>1,
                "military_affairs.stop_car_doing"=>1,"military_affairs.stop_car_police_station"=>1
                 ,"military_affairs.stop_car_finished"=>0 ];

        } elseif ($stop_car_type_send == 'stop_car_finished') {
            $stop_car_type = ['military_affairs.stop_car_request'=>1,'military_affairs.stop_car_info'=>1,
                'military_affairs.stop_car_catch'=>1,'military_affairs.stop_car_police'=>1,
                'military_affairs.stop_car_doing'=>1,'military_affairs.stop_car_police_station'=>1,
                'military_affairs.stop_car_finished'=>1];

        } elseif ($stop_car_type_send == 'stop_car_cancel_request') {
            $stop_car_type =['military_affairs.cancel_stop_car'=>1];

        } elseif ($stop_car_type == 'stop_car_cancel') {
            $stop_car_type_send = ['military_affairs.cancel_stop_car'=>'done'];

        } else {
            $stop_car_type = "";
        }


    } else {
        $stop_car_type = "";
        $stop_car_type_send='stop_car_request';

    }


    if (!empty($police_station_id)) {
        $police_station = ['military_affairs_areas_police_st.police_station_id'=>$police_station_id];
    } else {
        $police_station = [];
    }

    if ($stop_car_type_send == 'stop_car_police_station') {

        $items = DB::table('military_affairs')->select( "installment.`id` as   installment_id", "military_affairs.issue_id", "military_affairs.open_file_date")->
        select("clients.id as client_id", "clients.`name` as client_name", "clients.`civil_id`", "clients.`phone`",
        "clients.`governate_id`", "installment.`qard_paper`", "military_affairs.`eqrar_dain_amount`", "installment.`eqrardain_date`", "installment.`amana_paper`",
"military_affairs.`id`", "military_affairs.`date` as my_date", "military_affairs.`command_img`", 
"military_affairs.`command_date`", "military_affairs.`stop_travel_finished_date`", "military_affairs.`stop_travel_finished_img`",
 "military_affairs.`execute_do_img`", "military_affairs.stop_car_recieve_date", "clients.location",
    "installment.installment_clients", "military_affairs_settlement.`date`", " military_affairs_settlement.`stop_travel_cancel_request_date`",
     " military_affairs.emp_id", "installment.finished")
     ->select('(SELECT  COUNT(military_affairs_notes.id) FROM military_affairs_notes WHERE   military_affairs_notes.military_affairs_id  =  military_affairs.`id` AND  cat2 in("stop_cars","stop_car_amr_hajz","stop_car_request","stop_car_info","stop_car_police","stop_car_catch","stop_car_police_station","stop_car_doing","stop_car_finished","stop_car_cancel_request","stop_car_cancel","carfinder") ) AS note_count', false)->
     select('(SELECT  COUNT(military_affairs_settlement.id) FROM military_affairs_settlement WHERE   military_affairs_settlement.military_affairs_id  =  military_affairs.`id` ) AS settlement_id', false)->
     select('(SELECT  date FROM military_affairs_notes WHERE   military_affairs_notes.military_affairs_id  =  military_affairs.`id` and cat2="'.$stop_car_type_send.'"  ORDER BY ID DESC LIMIT 1 ) AS  trans_date', false)
    
        ->where(['stop_car_archive_type'=> 'not_archived','tahseel'=>0,'installment.finished'=>0
        ,'military_affairs.archived'=>0 , 'military_affairs.stop_car_archive'=>0,'military_affairs.status' =>$status])

        ->when(!empty($govern), function ($query) use ($govern) {
            return $query->where($govern);
         })
         ->when($stop_car_type !=0 && $stop_car_type !='' , function ($query) use ($stop_car_type) {
            return $query->where($stop_car_type);
         })
         ->when(!empty($type_e), function ($query) use ($type_e) {
            return $query->where($type_e);
         })
         ->when(!empty($type_e), function ($query) use ($police_station) {
           return $query->where($police_station);
        })
        ->leftJoin('installment', 'military_affairs.installment_id', '=', 'installment.id')  
        ->leftJoin('clients', 'installment.client_id', '=', 'clients.id')
        ->leftJoin('military_affairs_settlement', 'military_affairs_settlement.military_affairs_id' ,"=", 'military_affairs.id')
        ->leftJoin('governorate_areas', 'clients.area_id',"=","governorate_areas.id")
        ->leftJoin('military_affairs_areas_police_st', 'clients.area_id','=','military_affairs_areas_police_st.area_id')
        ->leftJoin('military_affairs_govern_police_stations', 'military_affairs_areas_police_st.police_station_id','=','military_affairs_govern_police_stations.id')
        ->groupBy('installment.id')
        ->orderBy('military_affairs_govern_police_stations.name', 'asc')->get();
        

    } else {


         $items = DB::table('military_affairs')->select( "installment.`id` as   installment_id", "military_affairs.issue_id", "military_affairs.open_file_date")->
         select("clients.id as client_id", "clients.name_ar as client_name", "clients.civil_number", "clients.phone_ids",
         "clients.governorate_id", "installment.qard_paper", "military_affairs.eqrar_dain_amount", "installment.eqrardain_date", "installment.amana_paper",
         "military_affairs.id", "military_affairs.date as my_date", "military_affairs.command_img", 
         "military_affairs.command_date", "military_affairs.stop_travel_finished_date", "military_affairs.stop_travel_finished_img",
         "military_affairs.execute_do_img", "military_affairs.stop_car_recieve_date", "clients.location",
         "installment.installment_clients", "military_affairs_settlement.date", "military_affairs_settlement.stop_travel_cancel_request_date",
         "military_affairs.emp_id", "installment.finished")->
         select( DB::raw('COUNT(military_affairs_notes.id) FROM "military_affairs_notes" WHERE  
         "military_affairs_notes.military_affairs_id"  =  "military_affairs.`id`" AND  
         cat2 in("stop_cars","stop_car_amr_hajz","stop_car_request","stop_car_info","stop_car_police"
         ,"stop_car_catch","stop_car_police_station","stop_car_doing","stop_car_finished","stop_car_cancel_request"
         ,"stop_car_cancel","carfinder") AS note_count'))->
          select( DB::raw('(SELECT  COUNT(military_affairs_settlement.id) FROM military_affairs_settlement WHERE   military_affairs_settlement.military_affairs_id  =  military_affairs.`id` ) AS settlement_id'))->
         select( DB::raw('(SELECT  date FROM military_affairs_notes WHERE   military_affairs_notes.military_affairs_id  =  military_affairs.`id` and cat2="'.$stop_car_type_send.'"  ORDER BY ID DESC LIMIT 1 ) AS  trans_date'))
         ->
         where(['stop_car_archive_type'=> 'not_archived','tahseel'=>0,'installment.finished'=>0
         ,'military_affairs.archived'=>0 , 'military_affairs.stop_car_archive'=>0,'military_affairs.status' =>$status])

         ->when(!empty($govern)  , function ($query) use ($govern) {
             return $query->where($govern);
          })
          ->when($stop_car_type !=0 && $stop_car_type !='' , function ($query) use ($stop_car_type) {
             return $query->where($stop_car_type);
          })
          ->when(!empty($type_e), function ($query) use ($type_e) {
             return $query->where($type_e);
          })
         ->leftJoin('installment', 'military_affairs.installment_id', '=', 'installment.id')  
         ->leftJoin('clients', 'installment.client_id', '=', 'clients.id')
         ->leftJoin('military_affairs_settlement', 'military_affairs_settlement.military_affairs_id' ,"=", 'military_affairs.id')
         ->groupBy('installment.id')->get();
         
    }


return $items;

}

public function count_stop_car_sql($status, $type, $governate_id, $stop_car_type)
{
    if (!empty($type)) {
        $type_e = ['military_affairs.'.$type=>1];
    } 
 
    if (!empty($governate_id)) {
        $govern = ['clients.governorate_id'=>$governate_id];
    } else {
        $govern =[];
    }
    if (!empty($stop_car_type)) {
        if ($stop_car_type == 'stop_car_request') {
            $stop_car_type = ["military_affairs.stop_car_info"=>0
                ,"military_affairs.stop_car_catch"=>0,"military_affairs.stop_car_police"=>0,
                "military_affairs.stop_car_doing"=>0,"military_affairs.stop_car_police_station"=>0,
                  "military_affairs.stop_car_finished"=>0];
        } elseif ($stop_car_type == 'stop_car_info') {
            $stop_car_type =[ "military_affairs.stop_car_request"=>1,"military_affairs.stop_car_info"=>1
                ,"military_affairs.stop_car_catch"=>0,"military_affairs.stop_car_police"=>0
                ,"military_affairs.stop_car_doing"=>0,"military_affairs.stop_car_police_station"=>0 
                ,"military_affairs.stop_car_finished"=>0];

        } elseif ($stop_car_type == 'stop_car_police') {
            $stop_car_type =["military_affairs.stop_car_request"=>1,"military_affairs.stop_car_info"=>1
                ,"military_affairs.stop_car_police"=>1,"military_affairs.stop_car_catch"=>0,
                "military_affairs.stop_car_police_station"=>0,
                "military_affairs.stop_car_doing"=>0,"military_affairs.stop_car_finished"=>0];

        } elseif ($stop_car_type == 'stop_car_catch') {
            $stop_car_type = ["military_affairs.stop_car_request"=>1,"military_affairs.stop_car_info"=>1
                ,"military_affairs.stop_car_police"=>1,"military_affairs.stop_car_catch"=>1
                ,"military_affairs.stop_car_doing"=>0,"military_affairs.stop_car_police_station"=>0,
                "military_affairs.stop_car_finished"=>0];

        } elseif ($stop_car_type == 'stop_car_police_station') {
            $stop_car_type = ["military_affairs.stop_car_request"=>1,"military_affairs.stop_car_info"=>1,
                "military_affairs.stop_car_catch"=>1,"military_affairs.stop_car_police"=>1,
                "military_affairs.stop_car_doing"=>0,"military_affairs.stop_car_police_station"=>1,
                "military_affairs.stop_car_finished"=>0];

            // echo $stop_car_type; exit();


        } elseif ($stop_car_type == 'stop_car_doing') {
            $stop_car_type = ["military_affairs.stop_car_request"=>1,"military_affairs.stop_car_info"=>1
                , "military_affairs.stop_car_catch"=>1,"military_affairs.stop_car_police"=>1,
                "military_affairs.stop_car_doing"=>1,"military_affairs.stop_car_police_station"=>1
                 ,"military_affairs.stop_car_finished"=>0 ];

        } elseif ($stop_car_type == 'stop_car_finished') {
            $stop_car_type = ['military_affairs.stop_car_request'=>1,'military_affairs.stop_car_info'=>1,
                'military_affairs.stop_car_catch'=>1,'military_affairs.stop_car_police'=>1,
                'military_affairs.stop_car_doing'=>1,'military_affairs.stop_car_police_station'=>1,
                'military_affairs.stop_car_finished'=>1];

        } elseif ($stop_car_type == 'stop_car_cancel_request') {
            $stop_car_type =['military_affairs.cancel_stop_car'=>1];

        } elseif ($stop_car_type == 'stop_car_cancel') {
            $stop_car_type = ['military_affairs.cancel_stop_car'=>'done'];

        } else {
            $stop_car_type = "";
        }


    } else {
        $stop_car_type = "";
    }

   
    
    $item = DB::table('military_affairs')->select( DB::raw('COUNT(military_affairs.id) as the_counter'))
    ->where(['stop_car_archive_type'=> 'not_archived','tahseel'=>0,'installment.finished'=>0
    ,'military_affairs.archived'=>0 , 'military_affairs.stop_car_archive'=>0,'military_affairs.status' =>$status])
    ->when(!empty($govern), function ($query) use ($govern) {
        return $query->where($govern);
     })
     ->when($stop_car_type !=0 && $stop_car_type !='' , function ($query) use ($stop_car_type) {
        return $query->where($stop_car_type);
     })
     ->when(!empty($type_e), function ($query) use ($type_e) {
        return $query->where($type_e);
     })
    ->leftJoin('installment', 'military_affairs.installment_id', '=', 'installment.id')  
    ->leftJoin('clients', 'installment.client_id', '=', 'clients.id')
    ->first();
    

    if (empty($item)) {
        $the_counter = 0;
    }
else {$the_counter=$item->the_counter;}
    return $the_counter;

}


public function count_stop_car_governate_sql($status, $type, $governate_id)
{

    //echo $governate_id; exit();
    //echo  $status ,'<pre>',$type,'<pre>' ,$governate_id; exit();
  
    if (!empty($type)) {
        $type_e = ['military_affairs.'.$type=>1];
    } 
 
    if (!empty($type)) {
        $govern = ['clients.governorate_id'=>$governate_id];
    } else {
        $govern =[];
    }
   
    $item = DB::table('military_affairs')->select( DB::raw('COUNT(military_affairs.id) as the_counter'))
    ->where(['stop_car_archive_type'=> 'not_archived','tahseel'=>0,'installment.finished'=>0
    ,'military_affairs.archived'=>0 , 'military_affairs.stop_car_archive'=>0,'military_affairs.status' =>$status])
    ->where($type_e)
    ->where($govern)
  //  ->where($status)
    ->leftJoin('installment', 'military_affairs.installment_id', '=', 'installment.id')  
    ->leftJoin('clients', 'installment.client_id', '=', 'clients.id')
    ->first();
    
    if (empty($item)) {
        $the_counter = 0;
    }
else {$the_counter=$item->the_counter;}
    return $the_counter;
   
}




}