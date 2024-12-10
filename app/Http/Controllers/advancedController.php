<?php

namespace App\Http\Controllers;

use App\Models\Bank;
use App\Models\Client;
use App\Models\Region;
use App\Models\Ministry;
use App\Models\Governorate;
use Illuminate\Http\Request;
use App\Models\InstallmentBroker;
use Illuminate\Support\Facades\Auth;
use App\Models\Installment_Client;

class advancedController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {  
        $title='اضافة جديد';

        $breadcrumb = array();
        $breadcrumb[0]['title'] = " الرئيسية";
        $breadcrumb[0]['url'] = route("dashboard");
   
        $breadcrumb[1]['title'] = $title;
        $breadcrumb[1]['url'] = 'javascript:void(0);';

        $data['bank'] = Bank::all();
        $data['government'] = Governorate::all();
        $data['region'] = Region::all();

        $data['ministry']= Ministry::where('type','working')->get();

        // dd( $data['ministry']);

        $data['boker'] = InstallmentBroker::all();

     
        $user_id =  Auth::user()->id;
        $message = "تم الدخول لصفحة اضافة معاملة جديدة ";
        $this->log($user_id, $message);
    

        $data['view'] = 'advanced/addNew';
        return view('layout', $data, compact('breadcrumb','data'));
    }

    public function Notesindex($id)
    {  
        $title='الملاحظات';

        $breadcrumb = array();
        $breadcrumb[0]['title'] = " الرئيسية";
        $breadcrumb[0]['url'] = route("dashboard");
   
        $breadcrumb[1]['title'] = $title;
        $breadcrumb[1]['url'] = 'javascript:void(0);';

        $data['Installment_client'] = Installment_Client::with([
            'user',
            'region',
            'ministry_working',
            'bank',
            'installmentBroker',
            'governorate',
            'installment_issue',
            'installment_car',
            'installment_note',
        ])->find($id);


        $data['opening_amount'] = $data['Installment_client']->installment_issue->sum('opening_amount');
        $data['closing_amount'] = $data['Installment_client']->installment_issue->sum('closing_amount');
        $data['totalissue'] = $data['opening_amount'] + $data['closing_amount'] ;
     
        // dd($data['Installment_client']);
        $user_id =  Auth::user()->id;
        $message = "تم الدخول لصفحة الملاحظات فى المعاملات ". $id;
        $this->log($user_id, $message);
    

        $data['view'] = 'advanced/notes';
        return view('layout', $data, compact('breadcrumb','data'));
    }

    public function Issueindex($id)
    {  
        $title='اضافة استعلام قضائى';

        $breadcrumb = array();
        $breadcrumb[0]['title'] = " الرئيسية";
        $breadcrumb[0]['url'] = route("dashboard");
   
        $breadcrumb[1]['title'] = $title;
        $breadcrumb[1]['url'] = 'javascript:void(0);';

     
     $data['Installment_client'] = $id;
        $user_id =  Auth::user()->id;
        $message = "تم الدخول لصفحة استعلام قضائى فى المعاملات ". $id;
        $this->log($user_id, $message);
    

        $data['view'] = 'advanced/issue';
        return view('layout', $data, compact('breadcrumb','data'));
    }

    public function Carindex($id)
    {  
        $title='اضافة استعلام سيارات';

        $breadcrumb = array();
        $breadcrumb[0]['title'] = " الرئيسية";
        $breadcrumb[0]['url'] = route("dashboard");
   
        $breadcrumb[1]['title'] = $title;
        $breadcrumb[1]['url'] = 'javascript:void(0);';

     
     $data['Installment_client'] = $id;
        $user_id =  Auth::user()->id;
        $message = "تم الدخول لصفحة استعلام سيارات فى المعاملات ". $id;
        $this->log($user_id, $message);
    

        $data['view'] = 'advanced/car';
        return view('layout', $data, compact('breadcrumb','data'));
    }
    
    public function acceptCondationindex($id)
    {  
        $title='اضافة سبب';

        $breadcrumb = array();
        $breadcrumb[0]['title'] = " الرئيسية";
        $breadcrumb[0]['url'] = route("dashboard");
   
        $breadcrumb[1]['title'] = $title;
        $breadcrumb[1]['url'] = 'javascript:void(0);';

     
     $data['Installment_client'] = $id;
       
        $data['view'] = 'advanced/acceptCondition';
        return view('layout', $data, compact('breadcrumb','data'));
    }

    public function acceptindex($id)
    {  
        $title='اضافة سبب';

        $breadcrumb = array();
        $breadcrumb[0]['title'] = " الرئيسية";
        $breadcrumb[0]['url'] = route("dashboard");
   
        $breadcrumb[1]['title'] = $title;
        $breadcrumb[1]['url'] = 'javascript:void(0);';

     
     $data['Installment_client'] = $id;
      
    

        $data['view'] = 'advanced/accept';
        return view('layout', $data, compact('breadcrumb','data'));
    }
    // 

    public function rejectindex($id)
    {  
        $title='اضافة سبب رفض'  ;

        $breadcrumb = array();
        $breadcrumb[0]['title'] = " الرئيسية";
        $breadcrumb[0]['url'] = route("dashboard");
   
        $breadcrumb[1]['title'] = $title;
        $breadcrumb[1]['url'] = 'javascript:void(0);';

     
     $data['Installment_client'] = $id;
     
        $data['view'] = 'advanced/reject';
        return view('layout', $data, compact('breadcrumb','data'));
    }
}
