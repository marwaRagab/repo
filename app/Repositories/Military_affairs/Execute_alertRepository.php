<?php

namespace App\Repositories\Military_affairs;

use App\Interfaces\Military_affairs\Execute_alertRepositoryInterface;
use App\Models\Client;
use App\Models\Court;
use App\Models\Governorate;
use App\Models\Installment;
use App\Models\InstallmentNote;
use App\Models\Military_affairs\Military_affair;
use App\Models\Military_affairs\Military_affairs_jalasaat;
use App\Models\Military_affairs\Military_affairs_notes;
use App\Models\Military_affairs\Military_affairs_status;
use App\Models\Military_affairs\Military_affairs_times_type;
use App\Models\Ministry;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Validator;
use Inertia\Inertia;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\Auth;
use App\Models\Log;

class Execute_alertRepository implements Execute_alertRepositoryInterface
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


    }
    public function index(Request $request)
    {

        $message ="تم دخول صفحة    اعلان التنفيذ" ;

        $user_id =  Auth::user()->id;
         log_move($user_id ,$message);

        $this->data['item_type_time']=Military_affairs_times_type::where(['type'=> 'execute_alert','slug'=>'execute_alert'])->first();
        $this->data['item_type_time_new']=Military_affairs_times_type::where(['type'=> 'images','slug'=>'images'])->first();

        $jalasat_dd=Military_affairs_jalasaat::where(['type'=> 'execute_alert','military_affairs_id'=>$request->military_affairs_id,'status'=>NULL ])->first();



        //dd($this->data['item_type_time']);
        $governorate_id= $request->governorate_id;


        $items= Military_affair::where('archived','=',0)
            ->where(['military_affairs.status' =>'execute_alert'])
            ->with('installment')->with('status_all')->with('jalasaat_all')->get();
        foreach ( $items as $value) {




                $value->final_data =$item_data=explode(' ',$value->created_at);



            $value->different_date = get_different_dates($item_data[0], date('Y-m-d'));

        }



        $title=' اعلان تنفيذ';

        $breadcrumb = array();
        $breadcrumb[0]['title'] = " الرئيسية";
        $breadcrumb[0]['url'] = route("dashboard");
        $breadcrumb[1]['title'] = "الشئون القانونية";
        $breadcrumb[1]['url'] = route("military_affairs");
        $breadcrumb[2]['title'] = $title;
        $breadcrumb[2]['url'] = 'javascript:void(0);';





       /* $data = Client::when($governorate_id, function ($q) use ($governorate_id) {
            return $q->where('governorate_id', $governorate_id);
        })->with('client_address')->with('court')->with('area')
            ->with('military_clients', function ($query) {
                $query->where('archived','=',0);
                $query->where('military_affairs.jalasat_alert_status','!=','accepted');
                $query->where('military_affairs.status','=','execute_alert');
            })->with('installments', function ($query) {
                $query->where('finished','=',0);
            })

            ->get();*/



        $view='military_affairs/Execute_alert/index';
        return view('layout',compact('items','view','breadcrumb'),$this->data);


       // return view('military_affairs/Execute_alert/index',$this->data );



    }



      public function add_a3lan_date(Request $request)

      {
          $request->validate([
              'a3lan_paper_date' => 'required| date',
              'military_affairs_id'=>'required|exists:marks,id',
              'type'=>'required'
          ]);
          $jalasat_dd=Military_affairs_jalasaat::where(['type'=> 'execute_alert','military_affairs_id'=>$request->military_affairs_id,'status'=> "NULL" ])->first();


            if(!$jalasat_dd && !$request->status){
                $data['a3lan_paper_date'] =$request->a3lan_paper_date;
               // dd( $data['a3lan_paper_date']);
                $data['military_affairs_id'] =$request->military_affairs_id;
                $data['date'] = date('Y-m-d H:i:s');
                $data['type'] =$request->type;
                $data['created_by']= Auth::user() ? Auth::user()->id : null;
                $data['created_at'] = date(' Y-m-d H:i:s');
              //  dd($data);

                Military_affairs_jalasaat::create($data);

                return redirect()->back();
            }else{

                if($request->status){


                    $military_affairs_id=$request->military_affairs_id;
                    $jalasat_id=$request->jalasat_id;

                    $item_military= Military_affair::findOrFail($military_affairs_id);

                    $request->validate([
                        'a3lan_paper_date' => 'required| date',
                        'military_affairs_id'=>'required',
                        'type'=>'required',
                        'jalasat_alert_date'=>'required|date',
                        'jalasat_alert_reason'=>'required|string',
                        'jalasat_alert_img'=>'nullable|image|mimes:jpg,png,jpeg,gif|max:2048',
                    ]);

                    $data['a3lan_paper_date'] = $request->a3lan_paper_date;
                    if($request->status=='accepted'){
                        $data['a3lan_jalsa_done_date'] = $request->jalasat_alert_date;
                    }else{
                        $data['jalasat_alert_date'] = $request->jalasat_alert_date;
                    }
                    $data['jalasat_alert_date'] = $request->jalasat_alert_date;
                    if ($request->hasFile('jalasat_alert_img')) {
                        $data['jalasat_alert_img'] = $request->file('jalasat_alert_img')->store('military_affairs', 'public'); // Store in the 'products' directory
                    }
                    $data['jalasat_alert_reason'] = $request->jalasat_alert_reason;

                    $data['updated_at'] = date('Y-m-d H:i:s');

                    $data['type'] =$request->type;
                    $data['status'] =$request->status;
                    if($jalasat_id){

                        $jalasat_dd->update($data);
                    }else{
                        $data['military_affairs_id'] =$request->military_affairs_id;
                        $data['date'] = date('Y-m-d H:i:s');
                        $data['created_by']= Auth::user() ? Auth::user()->id : null;

                        Military_affairs_jalasaat::create($data);
                    }




                    $data_military['jalasat_alert_status']=$request->status;

                    if($request->status=='accepted'){
                        $old_time_type=Military_affairs_times_type::findOrFail($request->id_time_type_old);
                        $new_time_type=Military_affairs_times_type::findOrFail($request->id_time_type_new);
                        Add_note($old_time_type,$new_time_type,$request->military_affairs_id);
                        $note_item=Military_affairs_notes::where(['military_affairs_id' =>$military_affairs_id, 'type'=>'execute_alert','date_end' =>NULL,'times_type_id'=>$old_time_type->id ])->first();
                        $update_note['date_end']= date(' Y-m-d H:i:s');
                     //   $update_note['times_type_id']=$request->id_time_type_new;
                        $update_note['updated_at']= date('Y-m-d H:i:s');
                        $data_military['status']='images';
                        $data_military['a3lan_jalsa_done_date']=$request->jalasat_alert_date;

                        //  $update_note['updated_by']=Auth::user()->id ;
                        $note_item->update($update_note);

                    }

                    $item_military->update($data_military);
                    return redirect()->back();




                }else{
                    return redirect()->back();
                }


            }



      }





}
