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
use Illuminate\Http\Request;
use App\Models\Military_affairs\Military_affairs_stop_salary_type;
use App\Models\Military_affairs\Military_affairs_times;
use App\Models\Military_affairs\Military_affairs_status;

class Stop_salaryRepository implements Stop_salaryRepositoryInterface
{
    
    protected $data;
    protected $title;

    public function __construct()
    {
        $this->data['title']='حجز راتب';
        $this->data['governorates'] = Governorate::with('clients')->get();
        $this->data['courts'] = Court::with('government')->get();
        // $this->data['ministries'] = Ministry::get();
        $this->data['stop_types'] = Military_affairs_stop_salary_type::all();
        $color_array = ['bg-warning-subtle text-warning', 'bg-success-subtle text-success', 'bg-danger-subtle text-danger',
                        'px-4 bg-primary-subtle text-primary', 'bg-danger-subtle text-danger', 'me-1 mb-1  bg-warning-subtle text-warning',
                        'bg-warning-subtle text-warning','px-4 bg-primary-subtle text-primary','bg-success-subtle text-success'];

        for ($i = 0; $i < count($this->data['courts']); $i++) {
            $this->data['courts'][$i]['style'] = $color_array[$i];
        }

    }
    public function index(Request $request)
    {
        $message ="تم دخول صفحة  حجز راتب" ;
        $stop_type = $request->stop_type ?? 'stop_salary_request';
        $this->data['items'] = Military_affair::with('status_all')->with('mil_times.salaryType')
                                                ->with('installment','installment.client.court')
                                                ->when(request()->has('court'), function ($query)  {
                                                    return $query->with('installment.client.court')
                                                             ->whereHas('installment.client.court', function ($q)  {
                                                              $q->where('governorate_id', request()->get('court'));
                                                            });
                                                })
                                                ->when(request()->has('minsitry_id'), function ($query)   {
                                                        $query->whereHas('installment.client.get_ministry', function ($q)  {
                                                            $q->where('id', request()->get('minsitry_id'));
                                                            });
                                                })
                                                ->when(request()->has('type'), function ($query) {
                                                     $query
                                                        ->whereHas('mil_times', function ($q){
                                                             $q->where('times_type_id',request()->get('type'))->latest();
                                                        })
                                                        
                                                        ->whereHas('mil_times.salaryType', function ($q)  {
                                                            $q->where('id', request()->get('type'))
                                                               ->where('mins_id',request()->get('minsitry_id'))
                                                               ->orwhere('mins_id','=','all')      
                                                        ;
                                                        })
                                                        
                                                    //     ->whereHas('status_all', function ($q){
                                                    //         $q->where('type','stop_salary')->where('flag',1);
                                                    //    })
                                                        ;                                                       
                                                })
                                                ->whereHas('installment', function ($q){
                                                    return $q->where('finished',0);
                                                })
                                                ->whereHas('installment.client', function ($q){
                                                    return $q->where('job_type','military');
                                                })
                                                ->where('archived',0)
                                                ->where(['military_affairs.status' => 'execute', 'military_affairs.stop_salary' => 1  ])
                                                ->orderBy('installment_id','asc')
                                                ->get()
                                                ;
            // dd( $this->data['items']->first());
        $this->data['item_type_time1'] = Military_affairs_stop_salary_type::where(['type'=> 'stop_salary','slug'=> $stop_type])->first();
        if(request()->has('minsitry_id') &&  request()->get('minsitry_id') == 5)
        {
            $this->data['item_type_time'] = Military_affairs_stop_salary_type::where('mins_id','!=',27)->orderBy('id','asc')->get();
        }
        else if(request()->has('minsitry_id') &&  request()->get('minsitry_id') == 27)
        {
            $this->data['item_type_time'] = Military_affairs_stop_salary_type::where('mins_id','!=',5)->orderBy('id','asc')->get();
        }
        else{
            $this->data['item_type_time'] = Military_affairs_stop_salary_type::where('mins_id','!=',5)->where('mins_id','!=',27)->orderBy('id','asc')->get();
        }

        $this->data['ministries'] = Ministry::whereIN('id',[5,14,27])->get();
        // $this->data['count'] = count($this->data['items']);
        // dd($this->data['item_type_time']);
        $this->data['stop_salary_type'] = '';                                        
        $breadcrumb = array();
        $breadcrumb[0]['title'] = " الرئيسية";
        $breadcrumb[0]['url'] = route("dashboard");
        $breadcrumb[1]['title'] = " الشئون القانونية";
        $breadcrumb[1]['url'] = route("military_affairs");
        $breadcrumb[2]['title'] = $this->data['title'];
        $breadcrumb[2]['url'] = 'javascript:void(0);';
        $view='military_affairs/stop_salary/index';
        $title=$this->title;
        return view('layout',compact(['title','view','breadcrumb']),$this->data);
    }

    public function stop_salary_convert(Request $request)
    {
        // dd($request->all());
        $request->validate([
            'date' => 'required| date',
            'img_dir' => 'required|image|mimes:jpg,png,jpeg,gif|max:2048',
        ]);
        $all_types = Military_affairs_stop_salary_type::all();
        for($i=0 ; $i < count($all_types ); $i++)
         {
            if($all_types[$i]['id'] == $request->item_type_old)
            {
                $array_new = Military_affairs_stop_salary_type::findorfail($all_types[$i]['id'] + 1);
            }
              
         }
        $array_old = Military_affairs_stop_salary_type::findorfail($request->item_type_old);
       
        // if($request->minist_id == 5 && $request->item_type_old == 10)
        //  {
        //     $array_new = Military_affairs_stop_salary_type::findorfail(11);
        //  }
        //  if($request->minist_id == 14 && $request->item_type_old == 12)
        //  {
        //     $array_new = Military_affairs_stop_salary_type::findorfail(13);
        //  }
        //  else
        //  {
        //     $array_new = Military_affairs_stop_salary_type::findorfail($array_old->id +1);
        //  }
        //  dd($array_new);

        $item_time = Military_affairs_times::where(['times_type_id'=>$request->item_type_old,'military_affairs_id'=>$request->military_affairs_id])->first();
        $item_status = Military_affairs_status::where(['type_id'=>$array_old->slug,'military_affairs_id'=>$request->military_affairs_id])->first();
        
        if($item_status){
            $data_status['flag']=1;
            $item_status->update($data_status);
        }
       // dd($item_status);
        if($item_time){
            $data['date_end'] = date('Y-m-d H:i:s');
            $item_time->update($data);
        }
        Add_note($array_old, $array_new, $request->military_affairs_id);
        Add_note_time($array_new, $request->military_affairs_id);
        change_status($request, $request->military_affairs_id);

        return redirect()->route('stop_salary')->with('success', 'تم حفظ البيانات بنجاح');

    }


    public function stop_salary_request_update($id)
    {

        $data['slug_page'] = $this->slug_page;

        $data["item"] = $this->db_get->get_by_id('military_affairs', $id);

        $data["client"] = $this->client_install_sql($data["item"]['installment_id']);

        //echo '<pre>';  print_r($data); exit;

        if (isset($_POST['btn_save'])) {

            $HTTP_REFERER = $this->request->getPost('HTTP_REFERER');
            $add_data["stop_salary_request"] = 1;

            $add_data['stop_car_request_date'] = strtotime($this->request->getPost('stop_car_request_date'));

            //echo '<pre>';  print_r($add_data); exit;

            $fieldname = 'img_dir';

            if ($_FILES[$fieldname]['name'] != "") {

                $upload_data = $this->upload_many_photos($fieldname);

                $add_data["stop_salary_request_img"] = "/uploads/new_photos/" . $upload_data;

            } else {
                set_msg('<div class="alert alert-danger">
                <button type="button" class="close" data-dismiss="alert"><i class="fa fa-times"></i></button>
                <strong>
                عفوا يوجد خطأ فى رفع الصورة.

               </strong>
              </div>');
                return redirect()->back()->withInput()->with('errors', 'هذا الحقل مطلوب');
            }

            helper(['form']);
            $rules = [
                'stop_car_request_date' => 'required|date',

            ];

            if (!$this->validate($rules)) {
                set_msg('<div class="alert alert-danger">
                <button type="button" class="close" data-dismiss="alert"><i class="fa fa-times"></i></button>
                <strong>
                عفوا التاريخ مطلوب
               </strong>
              </div>');

            } else {
                $this->db_get->update_tb('military_affairs', $id, $add_data);

                //$this->load->library('military_affairs/military_affairs_times');

                $this->update_time_with_date(9, $id, $add_data['stop_car_request_date']);
                $this->add_time_with_date(10, $id, $add_data['stop_car_request_date']);
                $this->add_note_time(9, 10, $id, $add_data["stop_salary_request_img"]);

                set_msg('<div class="alert alert-success">
                <button type="button" class="close" data-dismiss="alert"><i class="fa fa-times"></i></button>
                <strong>
                تمت العملية بنجاح .
               </strong>
              </div>');
                set_moving('move', 'تم  طلب حجز راتب ', $this->session->get('admin')['id']);
                return redirect()->to($HTTP_REFERER);
            }

            set_msg('<div class="alert alert-danger">
                <button type="button" class="close" data-dismiss="alert"><i class="fa fa-times"></i></button>
                <strong>
                عفوا يوجد خطأ
               </strong>
              </div>');

        }
        $breadcrumb = array();
        $breadcrumb[0]['title'] = " الرئيسية";
        $breadcrumb[0]['url'] = route("dashboard");
        $breadcrumb[1]['title'] = " الشئون القانونية";
        $breadcrumb[1]['url'] = route("military_affairs");
        $breadcrumb[2]['title'] = $this->data['title'];
        $breadcrumb[2]['url'] = 'javascript:void(0);';
        $view='military_affairs/stop_salary/index';
        $title=$this->title;
        return view('layout',compact(['title','view','breadcrumb']),$this->data);

    }
    public function index_old($governate_id=null,$stop_salary_type=null,$ministry=null)
    {
       // return dd('eeee');
        $message ="تم دخول صفحة  حجز راتب" ;

        $builder = $this->db->table('military_affairs')->select('installment.`id` as   installment_id ,military_affairs.issue_id, military_affairs.open_file_date')->
        select('clients.id as client_id ,clients.`name` as client_name , clients.`civil_id`,clients.`phone`,clients.`governate_id` ,installment.`qard_paper`,installment.`eqrardain_amount`,installment.`eqrardain_date`,installment.`amana_paper`,clients.`ministry`,ministries.`name` as ministry_name , military_affairs.`id` ,
         military_affairs.stop_salary_money_amount ,military_affairs_settlement.`date`, military_affairs_settlement.`stop_travel_cancel_request_date`,military_affairs.emp_id,installment.finished,military_affairs.stop_salary_request_date,military_affairs.stop_salary_doing_date')->
        select('(SELECT  COUNT(military_affairs_notes.id) FROM military_affairs_notes WHERE   military_affairs_notes.military_affairs_id  =  military_affairs.`id` AND  cat2 in("stop_salary","stop_salary_request","stop_salary_doing","stop_salary_military_judgement","stop_salary_sabah_salem","stop_salary_force_affairs","stop_salary_money","stop_salary_part","stop_salary_cancel_request","stop_salary_cancel") ) AS note_count', false)->
        select('(SELECT  COUNT(military_affairs_settlement.id) FROM military_affairs_settlement WHERE   military_affairs_settlement.military_affairs_id  =  military_affairs.`id` ) AS settlement_id', false)->
        select('(SELECT  date FROM military_affairs_notes WHERE   military_affairs_notes.military_affairs_id  =  military_affairs.`id` and cat2 ="'.$stop_salary_type_send.'" ORDER BY ID DESC LIMIT 1 ) AS  trans_date', false)->
        where("clients.job_type = 'military'   AND  military_affairs.status ='execute' AND tahseel=0  AND  installment.finished=0  $govern       $type_e   $my_ministry  $stop_salary_type  ")->
        join('installment', 'military_affairs.installment_id = installment.id', 'left')->
        join('clients', ' installment.client_id = clients.id', 'left')->
        join('ministries', 'clients.ministry = ministries.id', 'left')->
        join('military_affairs_settlement', 'military_affairs_settlement.military_affairs_id = military_affairs.id', 'left')->groupBy('installment.`id`')->
        orderBy('installment.id', 'asc');

       
        $args = func_get_args();

        if (!empty($args[0])) {
            $governate_id = $args[0];
            $data['governate_id'] = $args[0];
        } else {
            $governate_id = '';
            $data['governate_id'] = 0;
        }

        if (!empty($args[1])) {
            $data['ministry'] = $ministry = $args[1];
        } else {
            $data['ministry'] = $ministry = 0;
        }
        if (!empty($args[2])) {
            $stop_salary_type = $args[2];
        } else {
            $stop_salary_type = 0;
        }

        $data['slug_page'] = $this->slug_page;

        $data['title'] = "  حجز راتب  ";

        $data['add_title'] = $this->add_title;

        $data['stop_salary_type'] = $stop_salary_type;
        // print_r($stop_salary_type);exit;
        $data['items_count'] = $this->all_stop_salary_sql('stop_salary', $governate_id, $stop_salary_type, $ministry);

        $data['jahra_counter'] = $this->count_stop_salary_governate_sql('stop_salary', '6');
        $data['mubark_kabeer_counter'] = $this->count_stop_salary_governate_sql('stop_salary', '3');
        $data['ahmady_counter'] = $this->count_stop_salary_governate_sql('stop_salary', '4');
        $data['hawally_counter'] = $this->count_stop_salary_governate_sql('stop_salary', '2');
        $data['reqai_counter'] = $this->count_stop_salary_governate_sql('stop_salary', '5');
        $data['capital_counter'] = $this->count_stop_salary_governate_sql('stop_salary', '1');

        $data['stop_salary_request_counter'] = $this->count_stop_salary_sql('stop_salary', $governate_id, 'stop_salary_request');
        $data['stop_salary_doing_counter'] = $this->count_stop_salary_sql('stop_salary', $governate_id, 'stop_salary_doing');

        $data['stop_salary_money_counter'] = $this->count_stop_salary_sql('stop_salary', $governate_id, 'stop_salary_money');

        $data['stop_salary_part_counter'] = $this->count_stop_salary_sql('stop_salary', $governate_id, 'stop_salary_part');

        $data['stop_salary_cancel_request_counter'] = $this->count_stop_salary_sql('stop_salary', $governate_id, 'stop_salary_cancel_request', $ministry);
        $data['stop_salary_cancel_counter'] = $this->count_stop_salary_sql('stop_salary', $governate_id, 'stop_salary_cancel', $ministry);

        $data['stop_salary_defense_counter'] = $this->stop_salary_money_type_counter_sql('stop_salary', $governate_id, $stop_salary_type, '5');

        $data['stop_salary_internal_counter'] = $this->stop_salary_money_type_counter_sql('stop_salary', $governate_id, $stop_salary_type, '27');

        $data['stop_salary_watany_counter'] = $this->stop_salary_money_type_counter_sql('stop_salary', $governate_id, $stop_salary_type, '14');
        // echo $data['stop_salary_defense_counter'],  $data['stop_salary_watany_counter'],$data['stop_salary_internal_counter']; exit();

        if ($stop_salary_type == 'stop_salary_money') {

            $data['stop_salary_defense_counter'] = $this->stop_salary_money_type_counter_sql('stop_salary', $governate_id, $stop_salary_type, '5');

            $data['stop_salary_internal_counter'] = $this->stop_salary_money_type_counter_sql('stop_salary', $governate_id, $stop_salary_type, '27');

            $data['stop_salary_watany_counter'] = $this->stop_salary_money_type_counter_sql('stop_salary', $governate_id, $stop_salary_type, '14');
            // echo $data['stop_salary_defense_counter'],  $data['stop_salary_watany_counter'],$data['stop_salary_internal_counter']; exit();

        }

        if ($stop_salary_type == 'stop_salary_part') {
            $total_stop_salary_part_amount = 0;

            for ($k = 0; $k < count($data['items_count']); $k++) {
                $total_stop_salary_part_amount = $total_stop_salary_part_amount + $data["items_count"][$k]['stop_salary_money_amount'];
                //    echo $k.'<pre>';print_r($data["items"][$k]['stop_salary_money_amount']);
            }

            //  echo $total_stop_salary_part_amount.'<pre>';print_r($data["items"][$k]);exit;

            $data["total_stop_salary_part_amount"] = $total_stop_salary_part_amount;

        }

        $data['btn_colors'] = array('btn-default', 'btn-info', 'btn-primary', 'btn-success', 'btn-danger', 'btn-warning');
        //$data['govrnates']= $this->all_index_counters_2();

        $data["govrnates"] = $this->db_get->get_all('governorate');

        $data["minstries"] = $minstries = array(array('id' => 5, 'name' => 'الدفاع'), array('id' => 27, 'name' => 'الداخلية'), array('id' => 14, 'name' => 'الحرس الوطني', 'count' => $this->stop_salary_money_type_counter_sql('stop_salary', $governate_id, $stop_salary_type, '14
        ')));

        for ($i = 0; $i < count($data["govrnates"]); $i++) {

            $My_governate_id = $data["govrnates"][$i]['id'];

            $data["govrnates"][$i]['index_counter'] = $this->sql_counter->all_stop_salary_sql('stop_salary', $My_governate_id, '', '');
            if ($governate_id > 0 and $governate_id == $My_governate_id) {

                $data['The_minstries'] = $data["minstries"];
                for ($m = 0; $m < count($data['The_minstries']); $m++) {
                    $My_ministry = $data['The_minstries'][$m]['id'];
                    //$data['The_minstries'][$m]['minstry_counter']  = $this->stop_salary_money_type_counter_sql('stop_salary', $My_governate_id,$stop_salary_type,$data['The_minstries'][$m]['id']);
                    $data['The_minstries'][$m]['minstry_counter'] = count($this->all_stop_salary_sql('stop_salary', $My_governate_id, 0, $My_ministry));

                    if ($ministry > 0 and $ministry == $data['The_minstries'][$m]['id']) {

                        $where_465['minstry'] = $data['The_minstries'][$m]['id'];
                        $data['The_stop_salary_type_3'] = $this->db_get->get_conditions('military_affairs_stop_salary_types', $where_465);

                        for ($x = 0; $x < count($data['The_stop_salary_type_3']); $x++) {

                            $stop_salary_type_2 = $data['The_stop_salary_type_3'][$x]['slug'];
                            // $data["govrnates"][$i]['minstries'] =$minstries[$k];

                            $data['The_stop_salary_type_3'][$x]['counter'] = count($this->all_stop_salary_sql('stop_salary', $My_governate_id, $stop_salary_type_2, $My_ministry));

                        }

                    }

                }

            }
        }        

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