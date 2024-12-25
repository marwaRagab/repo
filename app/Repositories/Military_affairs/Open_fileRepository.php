<?php

namespace App\Repositories\Military_affairs;

use App\Models\Log;
use App\Models\Military_affairs\Military_affairs_times;
use Inertia\Inertia;
use App\Models\Court;
use App\Models\Ministry;
use App\Models\Governorate;
use App\Models\Installment;
use Illuminate\Http\Request;
use App\Models\InstallmentNote;
use Yajra\DataTables\DataTables;
use App\Models\Prev_cols_clients;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Validator;
use App\Models\Military_affairs\Military_affair;
use App\Models\Military_affairs\Stop_travel_types;
use App\Models\Military_affairs\Military_affairs_notes;
use App\Models\Military_affairs\Military_affairs_status;
use App\Models\Military_affairs\Military_affairs_jalasaat;
use App\Models\Military_affairs\Military_affairs_times_type;
use App\Models\Military_affairs\Military_affairs_stop_car_type;
use App\Models\Military_affairs\Military_affairs_stop_bank_type;
use App\Interfaces\Military_affairs\Open_fileRepositoryInterface;
use App\Models\Military_affairs\Military_affairs_certificate_type;
use App\Models\Military_affairs\Military_affairs_stop_salary_type;

class Open_fileRepository implements Open_fileRepositoryInterface
{
    protected $data;


    public function __construct()
    {
        //

        $this->data['governorates'] = Governorate::with('clients')->get();
        $this->data['courts'] = Court::with('government')->get();
        $color_array=['bg-warning-subtle text-warning','bg-success-subtle text-success','bg-danger-subtle text-danger','px-4 bg-primary-subtle text-primary','bg-danger-subtle text-danger','me-1 mb-1  bg-warning-subtle text-warning'];

         for($i=0;$i<count($this->data['courts']);$i++){
             $this->data['courts'][$i]['style'] =$color_array[$i] ;
        }
        // dd($this->data['courts']);

    }
    public function index(Request $request)
    {

        $governorate_id= $request->governorate_id;
        $message ="تم دخول صفحة   فتح الملف" ;

        $user_id =  Auth::user()->id;
         log_move($user_id ,$message);

        $this->data['title']='  فتح الملف';
        $this->data['items']= Military_affair::where('archived','=',0)
            ->where('military_affairs.status','=','military')->with('installment')->with('status_all')->get();
        $title='فتح ملف';

        $breadcrumb = array();
        $breadcrumb[0]['title'] = " الرئيسية";
        $breadcrumb[0]['url'] = route("dashboard");
        $breadcrumb[1]['title'] = "الشئون القانونية";
        $breadcrumb[1]['url'] = route("military_affairs");
        $breadcrumb[2]['title'] = $title;
        $breadcrumb[2]['url'] = 'javascript:void(0);';
        $this->data['item_type_time']=Military_affairs_times_type::where(['type'=> 'open_file','slug'=>'open_file'])->first();
        $this->data['item_type_time_new']=Military_affairs_times_type::where(['type'=> 'execute_alert','slug'=>'execute_alert'])->first();
        $x=1;
        foreach ( $this->data['items'] as $value){
            $value->i=$x;
            $value->final_data=  $item_data=explode(' ',$value->created_at);
            $value->different_date = get_different_date($item_data[0],date('Y-m-d'));
            if(count($value->installment->client->client_address)>=1) {

                $value->adress =$value->installment->client->client_address->last();
            }else{

                $value->adress = Prev_cols_clients::where('client_id',$value->installment->client->id)->first();


            }
            if(count($value->installment->client->client_phone)>=1){
                $value->phone_now=  $value->installment->client->client_phone->last()->phone  ;
            }else{
                $value->phone_now=  Prev_cols_clients::where('client_id',$value->installment->client->id)->first()->phone;

            }
            if($value->installment->eqrardain_date != NULL){
                $value->type_papar= 'وصل امانة';
            }if ($value->installment->qard_paper != NULL){
                $value->type_papar  ='اقرار دين';
            }if ($value->installment->eqrardain_date == null && $value->installment->qard_paper == null) {
                $value->type_papar='لايوجد';
            }
            if($value->installment->finished==0){
            $x=$x+1;
            }

        }


            // dd($this->data['items']);
        $this->data['get_responsible'] = get_responsible();

        $this->data['view']='military_affairs/Open_file/index';
        return view('layout',$this->data,compact('breadcrumb'));

    }



      public function add_notes(Request $request)
       {

           Add_note_general($request);
           return redirect()->back();

       }

    public function convert_ex_alert(Request $request)
    {
        $request->validate([
            'date' => 'required| date',
            'place'=>'required',
            'issue_id'=>'required|numeric|min:9',
        ]);

        $old_time_type=Military_affairs_times_type::findOrFail($request->id_time_type_old);
        $new_time_type=Military_affairs_times_type::findOrFail($request->id_time_type_new);

       //
        // $update_notes_date= Military_affairs_notes::where(['times_type_id'=>$old_time_type->id, 'date_end' =>NULL]);
        $update_notes_date=Military_affairs_times::where(['military_affairs_id' =>$request->military_affairs_id ,'date_end' =>NULL,'times_type_id'=>$old_time_type->id ])->first();

        if($update_notes_date){
            $data['date_end']= date('Y-m-d');
            $update_notes_date->update($data);
        }

        Add_note($old_time_type,$new_time_type,$request->military_affairs_id);
        Add_note_time($new_time_type, $request->military_affairs_id);

        change_status($request,$request->military_affairs_id);
        $id=$request->military_affairs_id;


        $military_affair = Military_affair::findOrFail($id);
        $data = [
            'issue_id'=> $request->issue_id,
            'status'=>'execute_alert',
            'place'=>$request->place,
            'open_file_date'=>$request->date,
        ];
        // $data['userEdit'] = auth()->user()->id;

        $military_affair->update($data);



        return redirect()->route('open_file');
    }


    public function return_to_lated(Request $request)
    {

        $request->validate([

            'return_reason'=>'required',

        ]);


        $item_law=Military_affair::findOrFail($request->military_affairs_id);
        $item_installment=Installment::findOrFail($request->installment_id);
        $data['return_reason']=$request->return_reason;
        $data['laws']=0;
        $data['last_note_date']=date('Y-m-d H:i:s');
        $item_installment->update($data);
        $item_law->delete();
        $notesData=[
            'connect'=> 'تم التحويل من قسم فتح الملف الى قسم  العملاء المتاخرين',
            'date'=>date('Y-m-d H:i:s'),
            'installment_clients_id'=>$item_law->installment_id,
            'created_at'=>date('Y-m-d H:i:s'),
        ];

         InstallmentNote::create($notesData);
        return redirect()->route('open_file');

    }

    ///////////////////////////////case_proof function



    public function index_case_proof(Request $request)
    {

        $governorate_id= $request->governorate_id;
        $message ="تم دخول صفحة   اثبات الحالة   " ;

        $user_id =  Auth::user()->id;
         log_move($user_id ,$message);
        $this->data['title']='  اثبات الحالة ';
        $this->data['items']= Military_affair::where('archived','=',0)
            ->where(['military_affairs.status'=>'case_proof','jalasat_alert_status'=>'accepted'])
            ->with('installment')->with('status_all')->get();
        $title=' اثبات الحالة';
        $breadcrumb = array();
        $breadcrumb[0]['title'] = " الرئيسية";
        $breadcrumb[0]['url'] = route("dashboard");
        $breadcrumb[1]['title'] = "الشئون القانونية";
        $breadcrumb[1]['url'] = route("military_affairs");
        $breadcrumb[2]['title'] = $title;
        $breadcrumb[2]['url'] = 'javascript:void(0);';
        $this->data['item_type_time']=Military_affairs_times_type::where(['type'=> 'case_proof','slug'=>'case_proof'])->first();
        $this->data['item_type_travel']=Stop_travel_types::where(['type'=> 'stop_travel','slug'=>'request'])->first();
        $this->data['item_type_car']=Military_affairs_stop_car_type::where(['type'=> 'stop_cars','slug'=>'stop_car_request'])->first();

        $this->data['item_type_bank']=Military_affairs_stop_bank_type::where(['type'=> 'stop_bank','slug'=>'stop_bank_request'])->first();
        $this->data['item_type_salary']=Military_affairs_stop_salary_type::where(['type'=> 'stop_salary','slug'=>'stop_salary_request'])->first();
        $this->data['item_type_certificate']=Military_affairs_certificate_type::where(['type'=> 'Military_certificate','slug'=>'info_request'])->first();

        foreach ( $this->data['items'] as $value) {
            $value->final_data=  $item_data=explode(' ',$value->created_at);
            $value->different_date = get_diff_date($item_data[0],date('Y-m-d'));
            $value->different_date_open = get_diff_date($value->open_file_date,date('Y-m-d'));

              //  $value->different_date = get_different_dates($value->open_file_date, date('Y-m-d'));
                $value->jalasaat_date =$value->jalasaat_all->where('status','accepted')->first();


        }

        //dd($this->data['items']);
        $this->data['get_responsible'] = get_responsible();

        $this->data['view']='military_affairs/Case_proof/index';
        return view('layout',$this->data,compact('breadcrumb'));

    }
    public function convert_to_execute(Request $request){


        $request->validate([
            'date' => 'required| date',
            'img_dir'=>'required|image|mimes:jpg,png,jpeg,gif|max:2048',


        ]);

          // dd($request->all());
        change_status($request,$request->military_affairs_id);
        // Military_affairs_status::create($statusData);

        $item_military= Military_affair::findOrFail($request->military_affairs_id);
        $miltray_data['stop_car']=1;
        $miltray_data['stop_travel']=1;
        $miltray_data['stop_bank']=1;
        $miltray_data['status'] = 'execute';
        if($request->client_job=='military'){

            $miltray_data['certificate'] = 1;
        }

        $item_military->update($miltray_data);




        $old_time_type=Military_affairs_times_type::findOrFail($request->type_id);
        $new_time_type1=Stop_travel_types::findOrFail($request->item_type_travel);
        $new_time_type2=Military_affairs_stop_car_type::findOrFail($request->item_type_car);
        $new_time_type3=Military_affairs_stop_bank_type::findOrFail($request->item_type_bank);
        $new_time_type4=Military_affairs_certificate_type::findOrFail($request->item_type_certificate);

        if($request->client_job=='military'){

            Add_note($old_time_type,$new_time_type4,$request->military_affairs_id);
            Add_note_time($new_time_type4, $request->military_affairs_id);


        }
        $update_notes_date= Military_affairs_notes::where(['times_type_id'=>$old_time_type->id, 'date_end' =>NULL,'military_affairs_id' =>$request->military_affairs_id])->first();

        if($update_notes_date){
            $data['date_end']= date('Y-m-d');
            $update_notes_date->update($data);
        }

        Add_note($old_time_type,$new_time_type1,$request->military_affairs_id);
        Add_note_time($new_time_type1, $request->military_affairs_id);

        Add_note($old_time_type,$new_time_type2,$request->military_affairs_id);
        Add_note_time($new_time_type2, $request->military_affairs_id);

        Add_note($old_time_type,$new_time_type3,$request->military_affairs_id);
        Add_note_time($new_time_type3, $request->military_affairs_id);

        return redirect()->route('case_proof');

    }



    public function update_responsible(Request $request)
    {
        $user_id = $request->input('user_id');
        $military_id = $request->input('military_id');
        $status = $request->input('status');
        if (function_exists('update_responsible')) {
            $result = update_responsible($user_id, $military_id, $status);
            return back();
        }
        return response()->json(['success' => false, 'message' => 'Function not found.']);
    }





}
