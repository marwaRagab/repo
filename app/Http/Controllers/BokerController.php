<?php

namespace App\Http\Controllers;

use App\Models\Log;
use App\Models\Boker;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use App\Models\Installment_Client;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
// use Yajra\DataTables\Facades\DataTables;
use App\Http\Requests\StoreBokerRequest;
use App\Http\Requests\UpdateBokerRequest;
use Illuminate\Support\Facades\Validator;
use App\Interfaces\BokerRepositoryInterface;

class BokerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    protected $BokerRepository;

    public function __construct(BokerRepositoryInterface $BokerRepository)
    {
        $this->BokerRepository = $BokerRepository;
    }
    public function index()
    {
        return $this->BokerRepository->index();
        $user_id =  Auth::user()->id ?? null;
        $message = "تم الدخول لصفحة الوسطاء ";
        $this->log($user_id, $message);
        //
        // $title = 'الوسطاء ';

        // $breadcrumb = array();
        // $breadcrumb[0]['title'] = " الرئيسية";
        // $breadcrumb[0]['url'] = route("dashboard");
        // $breadcrumb[1]['title'] = "المعاملات";
        // $breadcrumb[1]['url'] = route("myinstall.index", ['status' => 'advanced']);
        // $breadcrumb[2]['title'] = $title;
        // $breadcrumb[2]['url'] = 'javascript:void(0);';

        // $data['Boker'] = Boker::with(['user'])->get();
        // //  $data = Installment::with(['user','client','eqrar_not_recieve','installment_months','militay_affairs'])->get();

        // if ($data) {
        //     $user_id = 1;
        //     //   $user_id =  Auth::user()->id,
        //     $message = "تم دخول صفحة الوسطاء";
        //     $this->log($user_id, $message);
        // }

        // $data['view'] = 'broker/index';
        // return view('layout', $data, compact('breadcrumb', 'data'));
    }


    // public function getAll()
    // {
    //     $brokers = Boker::with('user')->select(['*']);

    //     return DataTables::of($brokers)
    //         ->addColumn('created_by', function ($row) {
    //             return $row->user ? $row->user->name_ar : 'لا يوجد';
    //         })
    //         ->addColumn('Number_transaction', function ($row) {
    //             return Installment_Client::where('boker_id', $row->id)->count();
    //         })
    //         ->addColumn('percentage', function ($row) {
    //             $p = "";
    //             if ($row->percentage_amount == "percentage") {
    //                 $p = "%";
    //             }

    //             return $row->percentage ? $row->percentage . $p : 'لا يوجد';
    //         })
    //         ->addColumn('connect', function ($row) {
    //             // Ensure you return valid HTML for the button
    //             return '<button class="btn btn-sm btn-primary">ارسال رابط</button>';
    //         })
    //         // Number_visted
    //         ->addColumn('Number_visted', function ($row) {
    //             // Ensure you return valid HTML for the button
    //             return '0';
    //         })
    //         ->addColumn('action', function ($row) {
    //             $editUrl = route('broker.edit', $row->id);
    //             $deleteUrl = route('broker.delete', $row->id);

    //             return '<a href="' . $editUrl . '" class=""><i class="fa-solid fa-pen-to-square"></i></a>
    //             <a href="' . $deleteUrl . '" class="" onclick="return confirm(\'Are you sure you want to delete this broker?\');"><i class="fa-solid fa-trash text-danger"></i></a>
    //                     ';
    //         })
    //         ->rawColumns(['action', 'connect'])
    //         ->make(true);
    // }

    // 

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    // public function getbroker()
    // {
    //     // dd($status);
    //     //
    //     $title = 'الوسطاء ';

    //     $breadcrumb = array();
    //     $breadcrumb[0]['title'] = " الرئيسية";
    //     $breadcrumb[0]['url'] = route("dashboard");
    //     $breadcrumb[1]['title'] = "المعاملات";
    //     $breadcrumb[1]['url'] = route("myinstall.index", ['status' => 'advanced']);
    //     $breadcrumb[2]['title'] = $title;
    //     $breadcrumb[2]['url'] = 'javascript:void(0);';

    //     $data['Boker'] = Boker::with(['user'])->get();
    //     //  $data = Installment::with(['user','client','eqrar_not_recieve','installment_months','militay_affairs'])->get();

    //     if ($data) {
    //         $user_id = 1;
    //         //   $user_id =  Auth::user()->id,
    //         $message = "تم دخول صفحة الوسطاء";
    //         $this->log($user_id, $message);
    //     }

    //     $data['view'] = 'broker/index';
    //     return view('layout', $data, compact('breadcrumb', 'data'));
    // }
    // public function create()
    // {
    //     //
    // }

    public function store(Request $request)
    {
        $messages = [
            'name_ar.required' => 'الاسم بالعربى  مطلوب.',
            'name_en.required' => 'الاسم بالانجليزية  مطلوب.',
            'phone.required' => 'رقم الهاتف مطلوب.',
            'percentage.required' => 'النسبة  مطلوب.',
            //    'percentage_amount.required' => 'نوع النسبة مطلوب'
        ];

        $validatedData = Validator::make($request->all(), [
            'name_ar' => 'required',
            'name_en' => 'required',
            'phone' => 'required',
            'percentage' => 'required',
            //    'percentage_amount' =>'required'
        ], $messages);

        if ($validatedData->fails()) {

            return redirect()->back()->withErrors($validatedData)->withInput();
        }
        //    dd($request);
        $data = $this->BokerRepository->store($request);

        if ($data) {

            $user_id = 1;
            //   $user_id =  Auth::user()->id,
            $message = "تم اضافة وسيط  جديد فى صفحة الوسطاء";
            $this->log($user_id, $message);
        }
        // return response()->json($nationalities);
        //    return $this->respondSuccess(result: $data, message: 'Store Data successfully.');
        session()->flash('success', 'Store Data successfully.');
        return redirect()->back();
    }




    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Boker  $Boker
     * @return \Illuminate\Http\Response
     */
    // public function show($id)
    // {
    //     $data = $this->BokerRepository->show($id);

    //     if ($data) {
    //         $user_id = 1;
    //         //   $user_id =  Auth::user()->id,
    //         $message = "تم عرض  وسيط  {$data->name_ar} فى صفحة الوسطاء";
    //         $this->log($user_id, $message);
    //     }
    //     // return response()->json($data);
    //     return $this->respondSuccess($data, 'Get Data successfully.');
    // }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Boker  $Boker
     * @return \Illuminate\Http\Response
     */
    // public function edit($id)
    // {
    //     $data = $this->BokerRepository->show($id);


    //     if ($data) {
    //         $user_id = 1;
    //         //   $user_id =  Auth::user()->id,
    //         $message = "تم الدخول  لتعديل  وسيط  {$data->name_ar}   ";
    //         $this->log($user_id, $message);
    //     }
    //     return response()->json($data);
    //     //    return $this->respondSuccess($data, message: 'Get Data successfully.');

    // }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateBokerRequest  $request
     * @param  \App\Models\Boker  $Boker
     * @return \Illuminate\Http\Response
     */
    public function update($id,  Request $request)
    {

        return $this->BokerRepository->update($request, $id);


        // $validatedData = Validator::make($request->all(), [
        //     'name_ar' => 'nullable',
        //     'name_en' => 'nullable',
        //     'phone' => 'nullable',
        //     'percentage' => 'nullable',
        //     //    'percentage_amount' =>'required'
        // ]);

        // if ($validatedData->fails()) {

        //     return $this->respondError('Validation Error.', $validatedData->errors(), 400);
        // }
        //    dd($request);

        // if ($data) {

        //     $user_id = 1;
        //     //   $user_id =  Auth::user()->id,
        //     $message = "تم اضافة وسيط  جديد فى صفحة الوسطاء";
        //     $this->log($user_id, $message);
        // }
        // // return response()->json($nationalities);
        // //    return $this->respondSuccess(result: $data, message: 'Store Data successfully.');
        // session()->flash('success', 'Update Data successfully.');
        // return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Boker  $Boker
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
        return $this->BokerRepository->destroy($id);

        // if ($data) {
        //     $user_id = 1;
        //     //   $user_id =  Auth::user()->id,
        //     $message = "تم   مسح  وسيط  {$data->name_ar}   ";
        //     $this->log($user_id, $message);
        // }
        // return response()->json($data);
        //    return $this->respondSuccess($data, message: 'Delete Data successfully.');
        // return redirect()->back();
    }
}
