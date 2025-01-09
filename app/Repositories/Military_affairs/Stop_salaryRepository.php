<?php

namespace App\Repositories\Military_affairs;

use App\Models\Log;
use App\Models\Court;
use App\Models\Client;
use App\Models\Ministry;
use App\Models\Governorate;
use App\Models\Installment;
use Illuminate\Http\Request;

use App\Models\InstallmentNote;
use App\Models\Installment_month;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use App\Models\Military_affairs\Military_affair;
use App\Models\Military_affairs\Military_affairs_notes;
use App\Models\Military_affairs\Military_affairs_times;
use App\Models\Military_affairs\Military_affairs_status;
use App\Models\Military_affairs\Military_affairs_times_type;
use App\Models\Military_affairs\Military_affairs_stop_salary_type;
use App\Interfaces\Military_affairs\Stop_salaryRepositoryInterface;

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
                                                ->with(['installment','installment.client.court'])
                                                ->when(request()->has('court'), function ($query)  {
                                                    return $query
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
                                                        ->whereHas('status_all', function ($q){
                                                           return $q->where('type','stop_salary')
                                                                    ->where('type_id',request()->get('type'))
                                                                    ->where('flag',0)
                                                                    ->where('ministry', request()->get('minsitry_id'));
                                                       });
                                                })
                                                ->whereHas('installment', function ($q){
                                                    return $q->where('finished',0);
                                                })
                                                ->whereHas('installment.client', function ($q){
                                                    return $q->where('job_type','military')->whereIN('ministry_last',[5,14,27]);
                                                })

                                                ->where('archived',0)
                                                ->where(['military_affairs.status' => 'execute', 'military_affairs.stop_salary' => 1  ])
                                                ->orderBy('installment_id','asc')
                                                ->get()
                                                ;
        $this->data['ministries'] = Ministry::whereIN('id',[5,14,27])->get();
        $total_count =0;
        foreach($this->data['courts'] as $court)
            {
                
                $court->counter = count_court($court->id,'stop_salary','','');
                $total_count = count_court('','stop_salary','','') ;
            }
        foreach($this->data['ministries'] as $minist)
            {           
                 $minist->counter = count_minstry(request()->get('court'),'stop_salary',$minist->id);
            }
                
        // dd($this->data['courts']);
        $this->data['total_count'] =  $total_count ;
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
        foreach($this->data['item_type_time'] as $item_type)
        {          
             $item_type->counter = count_court(request()->get('court'),'stop_salary',request()->get('minsitry_id'),$item_type->slug);
        }
        
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
        $this->data['get_responsible'] = get_responsible();
        return view('layout',compact(['title','view','breadcrumb']),$this->data);
    }

    public function stop_salary_convert(Request $request)
    {
        // dd($request->all());
        $request->validate([
            'date' => 'required| date',
            'img_dir' => 'required|image|mimes:jpg,png,jpeg,gif|max:2048',
        ],
        [
            'date.required' => 'التاريخ مطلوب',
            'img_dir.required' => 'الصورة مطلوبة',
        ]);
        // $all_types = Military_affairs_stop_salary_type::all();
        // for($i=0 ; $i < count($all_types ); $i++)
        //  {
        //     if($all_types[$i]['slug'] == $request->item_type_old)
        //     {
        //         // dd($all_types[$i]['id']);
        //         $array_new = Military_affairs_stop_salary_type::findorfail($all_types[$i]['id'] + 1);
        //         $request->type_id = $array_new->slug;
        //     }

        //  }

        $array_old = Military_affairs_stop_salary_type::where('slug', $request->item_type_old)->first();

          if($request->ministry_id == 5 )
         {
            if( $request->item_type_old == 'stop_salary_doing')
            {
                $array_new = Military_affairs_stop_salary_type::where('slug', 'stop_salary_military_judgement')->first();
            }
            else if($request->item_type_old == 'stop_salary_military_judgement' )
            {
                $array_new = Military_affairs_stop_salary_type::where('slug', 'stop_salary_money')->first();
            }
           
         }
        
         if($request->ministry_id == 14 && $request->item_type_old == 'stop_salary_doing')
         {
            $array_new = Military_affairs_stop_salary_type::where('slug', 'stop_salary_sabah_salem')->first();
            // $request->type_id = $array_new->slug;
         }
         if($request->ministry_id == 27 && $request->item_type_old == 'stop_salary_doing')
         {
            $array_new = Military_affairs_stop_salary_type::where('slug', 'stop_salary_money')->first();
            // $request->type_id = $array_new->slug;
         }
         $request->type_id = $array_new->slug;
        //  dd($array_new);
        //  dd($array_new);

        $item_time = Military_affairs_times::where(['times_type_id'=>$array_old->id,'military_affairs_id'=>$request->military_affairs_id])->first();
        // dd($item_time);
        $item_status = Military_affairs_status::where(['type_id'=>$array_old->slug,'military_affairs_id'=>$request->military_affairs_id])->first();
        if($item_status){
            $data_status['flag']=1;
            $item_status->update($data_status);
        }
        if($item_time){
            $data['date_end'] = date('Y-m-d H:i:s');
            $item_time->update($data);
        }
        Add_note($array_old, $array_new, $request->military_affairs_id);
        Add_note_time($array_new, $request->military_affairs_id);
        change_status($request, $request->military_affairs_id);

        return redirect()->back()->with('success', 'تم حفظ البيانات بنجاح');

    }

   

}