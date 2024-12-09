<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\InstallmentIssue;
use App\Models\InstallmentClientNote;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Validator;
use App\Http\Requests\StoreInstallmentIssueRequest;
use App\Http\Requests\UpdateInstallmentIssueRequest;
use App\Interfaces\InstallmentIssueRepositoryInterface;

class InstallmentIssueController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    protected $InstallmentIssueRepository;

    public function __construct(InstallmentIssueRepositoryInterface $InstallmentIssueRepository)
    {
        $this->InstallmentIssueRepository = $InstallmentIssueRepository;
    }
   public function index($id)
   {
       //
       $data = $this->InstallmentIssueRepository->index($id);
       if($data)
       {
                //   $user_id = 1 ;
              $user_id =  Auth::user()->id ?? null;
               $message ="تم الدخول الى صفحة  استعلام  قضائى  ";
               $this->log($user_id,$message);
               $this->installment_notes($id, $message);
       }
       // return response()->json($permissions);
    //    return $this->respondSuccess($data, 'Get Data successfully.');
    return view('installmentClient.installment_issue',compact('data'));
   }

   public function getall(Request $request)
   {
       if ($request->ajax()) {
           $data = InstallmentIssue::select('*');
           return DataTables::of($data)->toJson();
       }
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

   public function store(Request $request)
   {

    // dd($request);
    //    $messages = [
    //     //    'number_issue.required' => 'رقم القضية  مطلوب.',
    //     //    'date.required' => 'التاريخ  مطلوب.',
    //     //    'image.required' => 'صورة القضية   مطلوب.',
    //     //    'opening_amount.required' => 'مبلغ المفتوح  مطلوب.',
    //     //    'closing_amount.required' => 'مبلغ المغلق  مطلوب.',
    //     //    'working_company.required' => 'الجهة   مطلوب.',
    //     //    'issue_pdf.required' => 'pdf , ملف القضية مطلوب.',
    //        'installment_clients_id.required' => ' رقم التعريف مطلوب.',
    //    ];

    //    $validatedData = Validator::make($request->all(), [
    //     //    'number_issue' => 'required',
    //     //    'date' => 'required',
    //     //    'image' =>'required',
    //     //    'opening_amount' => 'required',
    //     //    'closing_amount' => 'required',
    //     //    'working_company' =>'required',
    //     // 'issue_pdf' =>'required|mimes:pdf',

    //     'installment_issue' => 'required|array', // Ensure installment_issue is an array
    //     'installment_issue.*.number_issue' => 'required|integer', // Validate number_issue as required integer
    //     'installment_issue.*.date' => 'required|date', // Validate date as required date
    //     // 'installment_issue.*.opening_amount' => 'required|numeric|min:0', // Validate opening_amount as required non-negative number
    //     // 'installment_issue.*.closing_amount' => 'required|numeric|min:0', // Validate closing_amount as required non-negative number
    //     'installment_issue.*.working_company' => 'required|string|max:255', // Validate working_company as required string
    //     'installment_issue.*.status' => 'required', // Validate status as required string with specific options
    //     'installment_issue.*.image' => 'nullable|file|max:2048', // Validate image as optional string
    //    ], $messages);

    //    if ($validatedData->fails()) {

    //     return redirect()->back()->withErrors($validatedData)->withInput();
    //    }

    //    dd("dd");
       $data = $this->InstallmentIssueRepository->store($request);
    //    dd($data);
    //    if($data)
    //    {

            if($request->exist1 == "notexist")
            {
                $message = "تم استعلام القضايا  ولا يوجد قضايا ";
                // dd("dd");


            }
            else
            {
                $message ="  جديد  تم اضافة  استعلام  قضائى ".count($data);
                // dd(vars: "dddd");
            }

            $this->log(user_id: Auth::user()->id ?? null, message:$message);
            //    $this->installment_notes($request->installment_clients_id, $message);
            $data = new InstallmentClientNote;
            $data->reply = "note";
            $data->date = now()->format('Y-m-d');
            $data->time = now()->format('h:i:s');
            $data->installment_clients_id  = $request->installment_clients_id ;
            $data->note = $message;
            $data->created_by = Auth::user()->id ?? null;
            $data->updated_by = Auth::user()->id ?? null;
            $data->save();



    //    }
       // return response()->json($nationalities);
    //    return $this->respondSuccess(result: $data, message: 'Store Data successfully.');
    return redirect()->route('myinstall.index', ['status' => 'under_inquiry']);
    // return redirect()->back();
   }




   /**
    * Display the specified resource.
    *
    * @param  \App\Models\Region  $Region
    * @return \Illuminate\Http\Response
    */
   public function show($id)
   {
       $data = $this->InstallmentIssueRepository->show($id);
       if($data)
       {
               $message ="تم عرض  استعلام  قضائى {$data->number_issue} ";
               $this->log(Auth::user()->id ?? null,$message);
               $this->installment_notes($id, $message);
       }
       // return response()->json($data);
       return $this->respondSuccess($data, 'Get Data successfully.');

   }

   /**
    * Show the form for editing the specified resource.
    *
    * @param  \App\Models\Region  $Region
    * @return \Illuminate\Http\Response
    */
   public function edit($id)
   {
       $data = $this->InstallmentIssueRepository->show($id);
       if($data)
       {
               $message ="تم عرض  استعلام  قضائى {$data->number_issue} ";
               $this->log(Auth::user()->id ?? null,$message);
               $this->installment_notes($id, $message);
       }
       // return response()->json($data);
       return $this->respondSuccess($data, message: 'Get Data successfully.');

   }

   /**
    * Update the specified resource in storage.
    *
    * @param  \App\Http\Requests\UpdateRegionRequest  $request
    * @param  \App\Models\Region  $Region
    * @return \Illuminate\Http\Response
    */
   public function update($id ,  Request $request)
   {
       //
       $data = $this->InstallmentIssueRepository->update($id  ,$request);
       if($data)
       {
               $message ="تم تعديل على استعلام  قضائى {$data->number_issue} ";
               $this->log(Auth::user()->id ?? null,$message);
               $this->installment_notes($id, $message);
       }
       // return response()->json($data);
       return $this->respondSuccess($data, 'Update Data successfully.');

   }

   /**
    * Remove the specified resource from storage.
    *
    * @param  \App\Models\Region  $Region
    * @return \Illuminate\Http\Response
    */
   public function destroy($id)
   {
       //
       $data = $this->InstallmentIssueRepository->destroy($id);
       if($data)
       {
               $message ="تم مسح استعلام  قضائى {$data->number_issue} ";
               $this->log(Auth::user()->id ?? null,$message);
               $this->installment_notes($id, $message);
       }
       // return response()->json($data);
       return $this->respondSuccess($data, message: 'Delete Data successfully.');
   }
}
