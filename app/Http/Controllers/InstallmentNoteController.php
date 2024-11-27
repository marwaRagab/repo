<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\InstallmentNote;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Validator;
use App\Http\Requests\StoreInstallmentNoteRequest;
use App\Http\Requests\UpdateInstallmentNoteRequest;
use App\Interfaces\InstallmentNoteRepositoryInterface;

class InstallmentNoteController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    protected $InstallmentNoteRepository;

    public function __construct(InstallmentNoteRepositoryInterface $InstallmentNoteRepository)
    {
        $this->InstallmentNoteRepository = $InstallmentNoteRepository;
    }
   public function index()
   {
       //
       $data = $this->InstallmentNoteRepository->index();
    //    if($data)
    //    {     $user_id =  Auth::user()->id ?? null;
    //            $message ="تم الدخول الى صفحة  استعلام  قضائى  ";
    //            $this->log($user_id,$message);
    //    }
       // return response()->json($permissions);
       return $this->respondSuccess($data, 'Get Data successfully.');
   }

   public function getall(Request $request)
   {
       if ($request->ajax()) {
           $data = InstallmentNote::select('*');
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
       $messages = [
        //    'number_issue.required' => 'رقم القضية  مطلوب.',
        //    'date.required' => 'التاريخ  مطلوب.',
        //    'image.required' => 'صورة القضية   مطلوب.',
        //    'opening_amount.required' => 'مبلغ المفتوح  مطلوب.',
        //    'closing_amount.required' => 'مبلغ المغلق  مطلوب.',
        //    'working_company.required' => 'الجهة   مطلوب.',
        //    'status.required' => 'الحالة   مطلوب.',
           'installment_clients_id.required' => ' رقم التعريف مطلوب.',
       ];

       $validatedData = Validator::make($request->all(), [
        //    'number_issue' => 'required',
        //    'date' => 'required',
        //    'image' =>'required',
        //    'opening_amount' => 'required',
        //    'closing_amount' => 'required',
        //    'working_company' =>'required',
        //    'status' =>'required',

        'installment_issue' => 'required|array', // Ensure installment_issue is an array
        'installment_issue.*.number_issue' => 'required|integer', // Validate number_issue as required integer
        'installment_issue.*.date' => 'required|date', // Validate date as required date
        'installment_issue.*.opening_amount' => 'required|numeric|min:0', // Validate opening_amount as required non-negative number
        'installment_issue.*.closing_amount' => 'required|numeric|min:0', // Validate closing_amount as required non-negative number
        'installment_issue.*.working_company' => 'required|string|max:255', // Validate working_company as required string
        'installment_issue.*.status' => 'required|string|in:open,close', // Validate status as required string with specific options
        'installment_issue.*.image' => 'nullable|string', // Validate image as optional string
       ], $messages);

       if ($validatedData->fails()) {

           return $this->respondError('Validation Error.', $validatedData->errors(), 400);
       }
       $data = $this->InstallmentNoteRepository->store($request);
    //    if($data)
    //    {
    //            $message ="  جديد  تم اضافة  استعلام  قضائى {data->number_issue} ";
    //            $this->log(Auth::user()->id,$message);
    //    }
       // return response()->json($nationalities);
       return $this->respondSuccess(result: $data, message: 'Store Data successfully.');
   }

   
  

   /**
    * Display the specified resource.
    *
    * @param  \App\Models\Region  $Region
    * @return \Illuminate\Http\Response
    */
   public function show($id)
   {
       $data = $this->InstallmentNoteRepository->show($id);
    //    if($data)
    //    {
    //            $message ="تم عرض  استعلام  قضائى {data->number_issue} ";
    //            $this->log(Auth::user()->id,$message);
    //    }
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
       $data = $this->InstallmentNoteRepository->show($id);
    //    if($data)
    //    {
    //            $message ="تم عرض  استعلام  قضائى {data->number_issue} ";
    //            $this->log(Auth::user()->id,$message);
    //    }
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
       $data = $this->InstallmentNoteRepository->update($id  ,$request);
    //    if($data)
    //    {
    //            $message ="تم تعديل على استعلام  قضائى {data->number_issue} ";
    //            $this->log(Auth::user()->id,$message);
    //    }
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
       $data = $this->InstallmentNoteRepository->destroy($id);
    //    if($data)
    //    {
    //            $message ="تم مسح استعلام  قضائى {data->number_issue} ";
    //            $this->log(Auth::user()->id,$message);
    //    }
       // return response()->json($data);
       return $this->respondSuccess($data, message: 'Delete Data successfully.');
   }

}
