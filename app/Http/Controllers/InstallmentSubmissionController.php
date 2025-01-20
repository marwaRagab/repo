<?php

namespace App\Http\Controllers;

use App\Models\Bank;
use App\Models\Boker;
use App\Models\Region;
use App\Models\Ministry;
use App\Models\Governorate;
use App\Models\Nationality;
use Illuminate\Http\Request;
use App\Models\ClientWorking;
use App\Models\Installment_Client;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class InstallmentSubmissionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($id)
    {
        $title='تقديم الاقساط';

        $breadcrumb = array();
        $breadcrumb[0]['title'] = " الرئيسية";
        $breadcrumb[0]['url'] = route("dashboard");
        $breadcrumb[1]['title'] = "المعاملات";
        $breadcrumb[1]['url'] = route("myinstall.index" , ['status' => 'advanced']);
        $breadcrumb[2]['title'] = $title;
        $breadcrumb[2]['url'] = 'javascript:void(0);';

        $data['Installment_Client'] = Installment_Client::find($id);
        $ministry = Ministry::where('id', $data['Installment_Client']->ministry_id)->first();
        $data['ministry'] = Ministry::where('type','working')->get();
        $data['boker'] = Boker::all();
        $data['nationality'] = Nationality::all();
        $data['government'] = Governorate::all();
        $data['region'] = Region::all();
        $data['bank'] = Bank::all();

        if($data)
        {       
    // $user_id = 1 ;
          $user_id =  Auth::user()->id ?? null;
            $message ="تم دخول صفحة تقديم الاقساط" ;
            $this->log($user_id ,$message);
        }
             $data['view'] = 'installmentClient/installment_submission';

        return view('layout',$data,compact('breadcrumb','data'));

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // dd($request);
        $data = Installment_Client::find($request->installment_clients);
        $data->name_ar = $request->name_ar;
        $data->civil_number = $request->civil_number;
        $data->phone = $request->phone;
        $data->ministry_id = $request->ministry_id;
        // $data->boker_id = $request->boker_id;
        $data->nationality = $request->nationality_id;
        $data->governorate_id = $request->government_id;
        $data->area_id = $request->region_id;
        $data->salary_certificate_less_than_5_days = $request->salary_certificate_less_than_5_days;
        $data->notes = $request->note;
        $data->status = "transaction_submited";
        $data->legal_indicator = $request->legal_indicator;
        $data->dead_loan = $request->dead_loan;
        $data->cinet_total_income = $request->cinet_total_income;
        $data->installment_total = $request->installment_total;
        $data->total_lated_installments = $request->total_lated_installments;
        $data->cinet_amount_limit = $request->cinet_amount_limit;
        $data->cinet_amount_limit_safi = $request->cinet_amount_limit_safi;
        $data->save();


        if (isset($request->cinet_pdf) &&  $request->hasFile("cinet_pdf")) {
            // dd("ss");
            $file = $request->file("cinet_pdf");
            $path = 'cinet_pdf';

            UploadImage($path, 'cinet_pdf', $data, $file);
        }

        if (isset($request->upload_img_2) &&  $request->hasFile("upload_img_2")) {
            // dd("ss");
            $file = $request->file("upload_img_2");
            $path = 'personal_image/images';

            UploadImage($path, 'upload_img_2', $data, $file);
        }
        // installment_client_cinet
        if($request->has('installment'))
        {
            foreach($request->installment as $index =>$item)
            {
                $item = (object) $item;
                $work = new ClientWorking;
                $work->installment_clients_id = $request->installment_clients;
                $work->ministry_id  = $item->working_compang;
                $work->bank_id  = $item->bank ;
                $work->salary = $item->salary;
                $work->net_salary = $item->netSalary ?? null;
                $work->created_by = Auth::user()->id ?? null;
                $work->updated_by = Auth::user()->id ?? null;
                $work->save();

                if (isset($item->image) &&  $request->hasFile("installment.$index.image")) {
                    // dd("ss");
                    $file = $request->file("installment.$index.image");
                    $path = 'client_working/images';

                    UploadImage($path, 'image', $work, $file);
                }
            }

        }

        // dd($request->has('installment_client_cinet'));
        if($request->has('installment_client_cinet'))
        {
            foreach($request->installment_client_cinet as $index =>$item)
            {
                $item = (object) $item;
                DB::table('installment_client_cinet')->insert([
                    'installment_clients_id' => $request->installment_clients,
                    'file_dis_1' => $item->file_dis_1,
                    'file_date_1' => $item->file_date_1,
                    'file_remindes_amount_1' => $item->file_remindes_amount_1,
                    'file_installment_amount_1' => $item->file_installment_amount_1,
                    'file_debit_amount_1' => $item->file_debit_amount_1,
                    'file_all_times_1' => $item->file_all_times_1,
                    'new_loan_date_1' => $item->new_loan_date_1,
                    'new_loan_amount_1' => $item->new_loan_amount_1,
                ]);
            }
        }

            $user_id =  Auth::user()->id ?? null;
            $message =" {$data->name_ar}تم اضافة تقديم الاقساط" ;
            $this->log($user_id ,$message);
            $this->installment_notes($data->id ,$message);
            
        return redirect()->route('myinstall.index', ['status' => "transaction_submited"]);

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
