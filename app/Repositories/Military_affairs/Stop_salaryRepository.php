<?php

namespace App\Repositories\Military_affairs;

use App\Interfaces\Military_affairs\Stop_salaryRepositoryInterface;
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
use App\Models\Ministry;
class Stop_salaryRepository implements Stop_salaryRepositoryInterface
{
    
    protected $data;
    protected $title;

    public function __construct()
    {
        $this->data['title']='حجز راتب';
        $this->data['governorates'] = Governorate::with('clients')->get();
        $this->data['courts'] = Court::with('government')->get();
        $this->data['ministries'] = Ministry::get();

    }
    public function index(Request $request)
    {
        $message ="تم دخول صفحة  حجز راتب" ;

        $breadcrumb = array();
        $breadcrumb[0]['title'] = " الرئيسية";
        $breadcrumb[0]['url'] = route("dashboard");
        $breadcrumb[1]['title'] = " الشئون القانونية";
        $breadcrumb[1]['url'] = route("military_affairs");
        $breadcrumb[2]['title'] = $this->data['title'];
        $breadcrumb[2]['url'] = 'javascript:void(0);';
        $view='military_affairs/stop_salary/index';
        $title=$this->title;
        return view('layout',compact(['title','view','breadcrumb','count']),$this->data);
    }
    public function index_old($governate_id=null,$stop_salary_type=null,$ministry=null)
    {
       // return dd('eeee');
        $message ="تم دخول صفحة  حجز راتب" ;
        if (!empty($governate_id)) {
            $governate_id = $governate_id;
            $this->data['governate_id'] = $governate_id;
        } else {
            $governate_id = '';
            $this->data['governate_id'] = 0;
        }
        $this->data["govrnates"]=$this->data['governorates'] ;
        if (!empty($stop_salary_type)) {
            $stop_salary_type = $stop_salary_type;
        } else {
            $stop_salary_type = '';
        }
       
        $this->data['stop_salary_type'] = $stop_salary_type;
       
        if (!empty($ministry)) {
            $this->data['ministry'] = $ministry ;
        } else {
            $this->data['ministry'] = $ministry = '';
        }

        $this->data['items_count'] = $this->all_stop_salary_sql('stop_salary', $governate_id, $stop_salary_type, $ministry);

        $this->data['govern_count_total'] = $this->all_stop_salary_sql('stop_salary', $governate_id, $stop_salary_type, $ministry);;
        foreach( $this->data['governorates'] as $one){
           $count['govern_counter_'.$one->id] =$this->count_stop_salary_governate_sql('stop_salary', $one->id);
        }

        $this->data['item_type_time']=Military_affairs_times_type::where(['type'=> 'stop_car','slug'=>'stop_car'])->first();
        $this->data['item_type_time_new']=Military_affairs_times_type::where(['type'=> 'stop_car','slug'=>'stop_car'])->first();

      
       
        $this->data['stop_salary_request_counter'] = $this->count_stop_salary_sql('stop_salary', $governate_id, 'stop_salary_request');
      
        $this->data['stop_salary_doing_counter'] = $this->count_stop_salary_sql('stop_salary', $governate_id, 'stop_salary_doing');

        $this->data['stop_salary_money_counter'] = $this->count_stop_salary_sql('stop_salary', $governate_id, 'stop_salary_money');

        $this->data['stop_salary_part_counter'] = $this->count_stop_salary_sql('stop_salary', $governate_id, 'stop_salary_part');

        $this->data['stop_salary_cancel_request_counter'] = $this->count_stop_salary_sql('stop_salary', $governate_id, 'stop_salary_cancel_request', $ministry);
        $this->data['stop_salary_cancel_counter'] = $this->count_stop_salary_sql('stop_salary', $governate_id, 'stop_salary_cancel', $ministry);

        foreach($this->data['ministries'] as $one_minitry){
            $this->data['stop_ministry_'.$one_minitry->id.'_counter'] = $this->stop_salary_money_type_counter_sql('stop_salary', $governate_id, $stop_salary_type, $one_minitry->id);
        
        }

        if ($stop_salary_type == 'stop_salary_money') {
            foreach($this->data['ministries'] as $one_minitry){
                if($one_minitry->id==1 || $one_minitry==2 || $one_minitry==3){
                $this->data['stop_ministry_'.$one_minitry->id.'_counter'] = $this->stop_salary_money_type_counter_sql('stop_salary', $governate_id, $stop_salary_type, $one_minitry->id);
            }
            else {
                continue;
            }
            }
        }
        if ($stop_salary_type == 'stop_salary_part') {
            $total_stop_salary_part_amount = 0;

            for ($k = 0; $k < count($this->data['items_count']); $k++) {
                $total_stop_salary_part_amount = $total_stop_salary_part_amount + $this->data["items_count"][$k]['stop_salary_money_amount'];
            }


            $data["total_stop_salary_part_amount"] = $total_stop_salary_part_amount;

        }

        $this->data['btn_colors'] = array('btn-default', 'btn-info', 'btn-primary', 'btn-success', 'btn-danger', 'btn-warning');

        $this->data["minstries"] = $minstries = array(array('id' => 1, 'name' => 'الدفاع'), array('id' => 2, 'name' => 'الداخلية'), array('id' => 3, 'name' => 'الحرس الوطني', 'count' => $this->stop_salary_money_type_counter_sql('stop_salary', $governate_id, $stop_salary_type, '3
        ')));

        for ($i = 0; $i < count($this->data["govrnates"]); $i++) {

            $My_governate_id = $this->data["govrnates"][$i]['id'];

            $this->data["govrnates"][$i]['index_counter'] = count($this->all_stop_salary_sql('stop_salary', $My_governate_id, '', ''));
            if ($governate_id > 0 and $governate_id == $My_governate_id) {

                $this->data['The_minstries'] = $this->data["minstries"];
                for ($m = 0; $m < count($this->data['The_minstries']); $m++) {
                    $My_ministry = $this->data['The_minstries'][$m]['id'];

                    $this->data['The_minstries'][$m]['minstry_counter'] = count($this->all_stop_salary_sql('stop_salary', $My_governate_id, 0, $My_ministry));

                    if ($ministry > 0 and $ministry == $this->data['The_minstries'][$m]['id']) {

                        $where_465['minstry'] = $this->data['The_minstries'][$m]['id'];
                        $this->data['The_stop_salary_type_3'] = $this->db_get->get_conditions('military_affairs_stop_salary_types', $where_465);

                        for ($x = 0; $x < count($this->data['The_stop_salary_type_3']); $x++) {

                            $stop_salary_type_2 = $this->data['The_stop_salary_type_3'][$x]['slug'];
                            // $this->data["govrnates"][$i]['minstries'] =$minstries[$k];

                            $this->data['The_stop_salary_type_3'][$x]['counter'] = count($this->all_stop_salary_sql('stop_salary', $My_governate_id, $stop_salary_type_2, $My_ministry));

                        }

                    }

                }

            }
        }
     //   $this->data['transactions']=$this->get_all_stop_salary_data('stop_salary', $governate_id, $stop_salary_type, $ministry);
     $this->data['transactions']=array();
   
     //dd($this->data['transactions']);
     
        $breadcrumb = array();
        $breadcrumb[0]['title'] = " الرئيسية";
        $breadcrumb[0]['url'] = route("dashboard");
        $breadcrumb[1]['title'] = " الشئون القانونية";
        $breadcrumb[1]['url'] = route("military_affairs");
        $breadcrumb[2]['title'] = $this->data['title'];
        $breadcrumb[2]['url'] = 'javascript:void(0);';
        $view='military_affairs/stop_salary/index';
        $title=$this->title;
        return view('layout',compact(['title','view','breadcrumb','count']),$this->data);

}
       
public function get_all_stop_salary_data($governate_id, $stop_salary_type, $ministry){
    $type = 'stop_salary';
    $stop_salary_type_send=$stop_salary_type;

    if ($stop_salary_type == 0) {
        $stop_salary_type = '';
        $stop_salary_type_send  =  ['stop_salary_request'];
        
    } else {
        if (!empty($stop_salary_type)) {
            if ($stop_salary_type == 'stop_salary_request') {
                $stop_salary_type = ['military_affairs.stop_salary_request'=>0];

            } elseif ($stop_salary_type == 'stop_salary_doing') {
                $stop_salary_type = ['military_affairs.stop_salary_request'=>1,"military_affairs.stop_salary_doing"=>0];

            } elseif ($stop_salary_type == 'stop_salary_military_judgement') {
                $stop_salary_type = ['military_affairs.stop_salary_request'=>1,'military_affairs.stop_salary_doing'=>1,
                 'stop_salary_military_judgement'=>0];

            } elseif ($stop_salary_type == 'stop_salary_sabah_salem') {
                $stop_salary_type = ['military_affairs.stop_salary_request'=>1,'military_affairs.stop_salary_doing'=>1,
                 'stop_salary_sabah_salem'=>0];

            } elseif ($stop_salary_type == 'stop_salary_force_affairs') {
                $stop_salary_type = ['military_affairs.stop_salary_request'=>1,'military_affairs.stop_salary_doing'=>1,
                 'stop_salary_sabah_salem' =>1,'stop_salary_force_affairs'=>0];

            } elseif ($stop_salary_type == 'stop_salary_money') {
                if ($ministry == 5) {
                    $stop_salary_type = ['military_affairs.stop_salary_request'=>1,"military_affairs.stop_salary_doing"=>1,
                     'stop_salary_military_judgement'=>1,'military_affairs.stop_salary_money'=>0];

                } elseif ($ministry == 27) {
                    $stop_salary_type = ['military_affairs.stop_salary_request'=>1,'military_affairs.stop_salary_doing'=>1,
                     'stop_salary_sabah_salem'=>1,'stop_salary_force_affairs'=>1,'military_affairs.stop_salary_money'=>0];

                } elseif ($ministry == 14) {
                    $stop_salary_type = ['military_affairs.stop_salary_request'=>1,'military_affairs.stop_salary_doin'=>1,
                      'military_affairs.stop_salary_money'=>0];

                }

            } elseif ($stop_salary_type == 'stop_salary_part') {
                if ($ministry == 5) {
                    $stop_salary_type = ['military_affairs.stop_salary_request'=>1,'military_affairs.stop_salary_doing'=>1,
                     'stop_salary_military_judgement'=>1,'military_affairs.stop_salary_money'=>1,'stop_salary_part'=>0];

                } elseif ($ministry == 27) {
                    $stop_salary_type = ['military_affairs.stop_salary_request'=>1,'military_affairs.stop_salary_doing'=>1,
                     'stop_salary_sabah_salem'=>1,'stop_salary_force_affairs'=>1,'military_affairs.stop_salary_money'=>1,
                      'stop_salary_part'=>0];

                } elseif ($ministry == 14) {
                    $stop_salary_type = ['military_affairs.stop_salary_request'=>1,'military_affairs.stop_salary_doing'=>1,
                      'military_affairs.stop_salary_money'=>1,'stop_salary_part'=>0];

                }

            } elseif ($stop_salary_type == 'stop_salary_cancel_request') {
                if ($ministry == 5) {
                    $stop_salary_type = ['military_affairs.cancel_stop_salary'=>1];

                } elseif ($ministry == 27) {
                    $stop_salary_type = ['military_affairs.cancel_stop_salary'=>1];

                } elseif ($ministry == 14) {
                    $stop_salary_type = ['military_affairs.cancel_stop_salary'=>1];

                }

            } elseif ($stop_salary_type == 'stop_salary_cancel') {
                if ($ministry == 1) {
                    $stop_salary_type = ['military_affairs.cancel_stop_salary'=>'done'];

                } elseif ($ministry == 2) {
                    $stop_salary_type = ['military_affairs.cancel_stop_salary'=>'done'];

                } elseif ($ministry == 3) {
                    $stop_salary_type = ['military_affairs.cancel_stop_salary'=>'done'];

                }

            } else {
                $stop_salary_type = ['military_affairs.stop_salary_request'=>1,'military_affairs.stop_salary_doing'=>1,
                    'military_affairs.stop_salary_money'=>1,'military_affairs.stop_salary_part'=>1];

            }
            //

        }

    }
    if (!empty($type)) {
        $type_e = ['military_affairs.'.$type=>1];
    } 
 
    if (!empty($governate_id)) {
        $govern = ['clients.governorate_id'=>$governate_id];
    } else {
        $govern =[];
    }

    $my_ministry ='';
    if (!empty($ministry)) {
        $my_ministry = ['clients.ministry_ids'=>$ministry,
                          'clients.job_type'=>'military'];

    }
    if ($ministry == 0) {
     //   $my_ministry = [1,2,3];
    }


// $type_e   $my_ministry  $stop_salary_type )->

    $result = DB::table('military_affairs')->
    select('installment.id as installment_id' ,'military_affairs.issue_id',
     'military_affairs.open_file_date')->
    select('clients.id as client_id' ,'clients.name_ar as client_name','clients.civil_number','clients.phone_ids','clients.governorate_id' ,
    'installment.qard_paper','installment.eqrardain_amount','installment.eqrardain_date','installment.amana_paper',
    'clients.ministry_ids','ministries.name_ar as ministry_name' , 'military_affairs.id' ,'military_affairs.stop_salary_money_amount'
     ,'military_affairs_settlement.date', 'military_affairs_settlement.stop_travel_cancel_request_date',
     'military_affairs.emp_id','installment.finished','military_affairs.stop_salary_request_date','military_affairs.stop_salary_doing_date')->
    where(["clients.job_type" => 'military' ,"military_affairs.status" =>'execute','tahseel'=> 0,"installment.finished"=> 0] )->
    when(!empty($govern), function ($query) use ($govern) {
        return $query->where($govern);
     })->
     when(!empty($type_e), function ($query) use ($type_e) {
        return $query->where($type_e);
     })->
     when(!empty($ministry), function ($query) use ($ministry) {
        if (!empty($ministry)) {  
        return $query->where(['clients.ministry_ids'=>$ministry,
        'clients.job_type'=>'military']);
        }

      if ($ministry == 0) {
        return $query->whereIn('clients.ministry_ids', [1, 2, 3]);
      }
     })->
     when(!empty($stop_salary_type), function ($query) use ($stop_salary_type) {
        return $query->where($stop_salary_type);
     })->
     leftJoin('installment', 'military_affairs.installment_id', '=', 'installment.id')->
     leftJoin('clients', 'installment.client_id' ,'=', 'clients.id')->
     leftJoin('ministries', 'clients.ministry_ids', '=', 'ministries.id')->
     leftJoin('military_affairs_settlement', 'military_affairs_settlement.military_affairs_id','=','military_affairs.id')->
    groupBy('installment.id')->
    orderBy('installment.id', 'asc')->get();
    return $result;
 
 //   dd($result);

}

public function stop_salary_money_type_counter_sql($type, $governate_id, $stop_salary_type, $ministry)
{
   
    $stop_salary_type = " and military_affairs.stop_salary_request=1 and military_affairs.stop_salary_doing=1"
        . " and  military_affairs.stop_salary_money=1 and military_affairs.stop_salary_part=0";

    if (!empty($type)) {
        $type_e = "and military_affairs.$type=1";
    }

    if (!empty($governate_id)) {
        $govern = "and clients.governorate_id=$governate_id";
    } else {
        $govern = '';
    }
    if ($governate_id == 0) {
        $govern = " ";
    }

    if (!empty($ministry)) {

        $my_ministry = "and clients.ministry_ids=$ministry and clients.job_type='military'";
    }
    if ($ministry == 0) {
        //echo '<pre>';print_r($ministry);exit;
        $my_ministry = "and clients.ministry_ids in('1','2','3') ";
    }

    $sql = "SELECT COUNT(military_affairs.id) as the_counter
FROM military_affairs, installment, clients
WHERE
clients.job_type='military'
and
military_affairs.installment_id=installment.id
and   military_affairs.status ='execute'
$type_e
$govern
$stop_salary_type
$my_ministry
AND installment.client_id=clients.id    and tahseel=0 ";
  
  $result= DB::select($sql);
  if (empty($result->the_counter)) {
      $the_counter= 0;     
   }
   return $the_counter;
}

public function count_stop_salary_sql($type, $governate_id, $stop_salary_type, $ministry = null)
{

    if (!empty($stop_salary_type)) {
        if ($stop_salary_type == 'stop_salary_request') {
            $stop_salary_type = " and military_affairs.stop_salary_request=0 and military_affairs.stop_salary_doing=0"
                . " and  military_affairs.stop_salary_money=0 and military_affairs.stop_salary_part=0";

        } elseif ($stop_salary_type == 'stop_salary_doing') {
            $stop_salary_type = " and military_affairs.stop_salary_request=1 and military_affairs.stop_salary_doing=1"
                . " and  military_affairs.stop_salary_money=0 and military_affairs.stop_salary_part=0";

        } elseif ($stop_salary_type == 'stop_salary_money') {
            $stop_salary_type = " and military_affairs.stop_salary_request=1 and military_affairs.stop_salary_doing=1"
                . " and  military_affairs.stop_salary_money=1 and military_affairs.stop_salary_part=0";

        } elseif ($stop_salary_type == 'stop_salary_cancel_request') {
            $stop_salary_type = " and military_affairs.cancel_stop_salary=1 ";

        } elseif ($stop_salary_type == 'stop_salary_cancel') {
            $stop_salary_type = "and military_affairs.cancel_stop_salary='done' ";

        } else {
            $stop_salary_type = " and military_affairs.stop_salary_request=1 and military_affairs.stop_salary_doing=1"
                . " and  military_affairs.stop_salary_money=1 and military_affairs.stop_salary_part=1";

        }

    }

    if (!empty($type)) {
        $type_e = "and military_affairs.$type=1";
    }

    if (!empty($governate_id)) {
        $govern = "and clients.governorate_id=$governate_id";
    } else {
        $govern = '';
    }
    if ($governate_id == 0) {
        $govern = " ";
    }

    $my_ministry ='';
    if (!empty($ministry) && $ministry != '') {

        $my_ministry = "and clients.ministry_ids=$ministry and clients.job_type='military'";
    }
    if ($ministry == 0) {
        //echo '<pre>';print_r($ministry);exit;
        $my_ministry = "and clients.ministry_ids in('1','2','3') ";
    }

    $sql = "SELECT  COUNT(military_affairs.id) as the_counter
        FROM military_affairs, installment, clients
WHERE
clients.job_type='military'
and
military_affairs.installment_id=installment.id

and   military_affairs.status ='execute'
$type_e
$govern
$stop_salary_type
$my_ministry
AND installment.client_id=clients.id    and tahseel=0   and installment.finished=0 ";

    //  echo $sql;exit;
    $the_counter= 0;
   /* $result= DB::select($sql);
   
    if (empty($result->the_counter)) {
       $the_counter= 0;
        
    }
*/

    return $the_counter;

}


public function all_stop_salary_sql($type, $governate_id, $stop_salary_type, $ministry)

{ 
   // dd($ministry);
         if ($stop_salary_type === 0) {
    $stop_salary_type = '';
} else {
    if (!empty($stop_salary_type)) {
        if ($stop_salary_type == 'stop_salary_request') {
            $stop_salary_type = " and military_affairs.stop_salary_request=0  ";

        } elseif ($stop_salary_type == 'stop_salary_doing') {
            $stop_salary_type = " and military_affairs.stop_salary_request=1 and military_affairs.stop_salary_doing=0";

        } elseif ($stop_salary_type == 'stop_salary_military_judgement') {
            $stop_salary_type = " and military_affairs.stop_salary_request=1 and military_affairs.stop_salary_doing=1 and stop_salary_military_judgement=0";

        } elseif ($stop_salary_type == 'stop_salary_sabah_salem') {
            $stop_salary_type = " and military_affairs.stop_salary_request=1 and military_affairs.stop_salary_doing=1 and stop_salary_sabah_salem=0";

        } elseif ($stop_salary_type == 'stop_salary_force_affairs') {
            $stop_salary_type = " and military_affairs.stop_salary_request=1 and military_affairs.stop_salary_doing=1 and stop_salary_sabah_salem=1 and stop_salary_force_affairs=0";

        } elseif ($stop_salary_type == 'stop_salary_money') {
            if ($ministry == 5) {
                $stop_salary_type = " and military_affairs.stop_salary_request=1 and military_affairs.stop_salary_doing=1 and stop_salary_military_judgement=1 and  military_affairs.stop_salary_money=0 ";

            } elseif ($ministry == 27) {
                $stop_salary_type = " and military_affairs.stop_salary_request=1 and military_affairs.stop_salary_doing=1 and stop_salary_sabah_salem=1 and stop_salary_force_affairs=1 and military_affairs.stop_salary_money=0 ";

            } elseif ($ministry == 14) {
                $stop_salary_type = " and military_affairs.stop_salary_request=1 and military_affairs.stop_salary_doing=1  and military_affairs.stop_salary_money=0 ";

            }

        } elseif ($stop_salary_type == 'stop_salary_part') {
            if ($ministry == 5) {
                $stop_salary_type = " and military_affairs.stop_salary_request=1 and military_affairs.stop_salary_doing=1 and stop_salary_military_judgement=1 and  military_affairs.stop_salary_money=1 and stop_salary_part=0 ";

            } elseif ($ministry == 27) {
                $stop_salary_type = "  and military_affairs.stop_salary_request=1 and military_affairs.stop_salary_doing=1 and stop_salary_sabah_salem=1 and stop_salary_force_affairs=1 and military_affairs.stop_salary_money=1 and stop_salary_part=0   ";

            } elseif ($ministry == 14) {
                $stop_salary_type = " and military_affairs.stop_salary_request=1 and military_affairs.stop_salary_doing=1  and military_affairs.stop_salary_money=1 and stop_salary_part=0  ";

            }

        } else {
            $stop_salary_type = " and military_affairs.stop_salary_request=1 and military_affairs.stop_salary_doing=1"
                . " and  military_affairs.stop_salary_money=1 and military_affairs.stop_salary_part=1";

        }
        //

    }

}

if (!empty($type)) {
    $type_e = "and military_affairs.$type=1";
}

if (!empty($governate_id)) {
    $govern = "and clients.governorate_id=$governate_id";
} else {
    $govern = '';
}
if ($governate_id == 0) {
    $govern = " ";
}
$my_ministry ='';
if (!empty($ministry) && $ministry != '') {

    $my_ministry = "and clients.ministry=$ministry and clients.job_type='military'";
}
if ($ministry == 0) {
    $my_ministry = "and clients.ministry in('1','2','3') ";
}

$sql = "SELECT military_affairs.* ,clients.id as client_id,clients.name_ar as client_name ,clients.civil_number , clients.phone_ids,clients.governorate_id
    ,  installment.qard_paper  , installment.eqrardain_amount ,installment.eqrardain_date ,  installment.amana_paper  ,installment.id as installment_id,clients.ministry_ids,ministries.name_ar as ministry_name
FROM military_affairs, installment, clients,ministries
WHERE
clients.job_type='military'
and military_affairs.installment_id=installment.id
and   military_affairs.status ='execute'
$type_e
$govern
$stop_salary_type
$my_ministry

and clients.ministry_ids=ministries.id
AND installment.client_id=clients.id    and tahseel=0  and installment.finished=0";

   $result= DB::select($sql);
   
   return $result;
  
}
public function count_stop_salary_governate_sql($type, $governate_id)
    {
        if (!empty($type)) {
            $type_e = "and military_affairs.$type=1";
        }
        if (!empty($governate_id)) {
            $govern = "and clients.governorate_id=$governate_id";
        } else {
            $govern = '';
        }
        $my_ministry = "and clients.ministry_ids in('1','2','3') ";


        $sql = "SELECT  COUNT(military_affairs.id) as the_counter
            FROM military_affairs, installment, clients,ministries
WHERE
clients.job_type='military'
and
military_affairs.installment_id=installment.id
and   military_affairs.status ='execute'
and clients.ministry_ids=ministries.id

$type_e
$govern

  $my_ministry
AND installment.client_id=clients.id    and tahseel=0 and installment.finished=0 ";
        $result= DB::select($sql);

   
        return $result;

    }


}