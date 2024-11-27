<?php

namespace App\Http\Controllers;

use App\Models\Governorate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Validator;
use App\Http\Requests\StoreGovernorateRequest;
use App\Http\Requests\UpdateGovernorateRequest;
use App\Interfaces\GovernorateRepositoryInterface;

class GovernorateController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

     protected $GovernorateRepository;

     public function __construct(GovernorateRepositoryInterface $GovernorateRepository)
     {
         $this->GovernorateRepository = $GovernorateRepository;
     }
    public function index()
    {

        $title='المحافظات';
        $breadcrumb = array();
        $breadcrumb[0]['title'] = " الرئيسية";
        $breadcrumb[0]['url'] = route("dashboard");
       
        $breadcrumb[1]['title'] = $title;
        $breadcrumb[1]['url'] = 'javascript:void(0);';

        $data['government']=$this->GovernorateRepository->index();

        if ($data['government']) {
            // $user_id = 1;
              $user_id =  Auth::user()->id ?? null;
            $message = "تم الدخول لصفحة المحافظات ";
            $this->log($user_id, $message);
        }

        // dd($data['government']);

        $data['view'] = 'setting/government';
        return view('layout', $data, compact('breadcrumb','data'));
        // $data = $this->GovernorateRepository->index();
        // return response()->json($permissions);
        // return $this->respondSuccess($data, 'Get Data successfully.');
    }
    public function getall(Request $request)
    {
        if ($request->ajax()) {
            $data = Governorate::select('*');
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

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreGovernorateRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $messages = [
            'name_ar.required' => 'الاسم بالعربى  مطلوب.',
            'name_en.required' => 'الاسم بالانجليزية  مطلوب.',
        ];

        $validatedData = Validator::make($request->all(), [
            'name_ar' => 'required',
            'name_en' => 'required',
        ], $messages);

        if ($validatedData->fails()) {

            return redirect()->back()->withErrors($validatedData)->withInput();
        }
        $data = $this->GovernorateRepository->store($request);

        if ($data) {
            $user_id = 1;
            //   $user_id =  Auth::user()->id,
            $message = "تم اضافة محافظة جديدة ";
            $this->log($user_id, $message);
        }

        return redirect()->back()->with('success', 'Bank created successfully.');
        // return response()->json($nationalities);
        // return $this->respondSuccess(result: $data, message: 'Store Data successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Governorate  $governorate
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $data = $this->GovernorateRepository->show($id);
        if ($data) {
            $user_id = 1;
            //   $user_id =  Auth::user()->id,
            $message = "تم عرض مخافظة {$data->name_ar} ";
            $this->log($user_id, $message);
        }
        return response()->json($data);
        // return $this->respondSuccess($data, 'Get Data successfully.');

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Governorate  $governorate
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $data = $this->GovernorateRepository->show($id);

        if ($data) {
            $user_id = 1;
            //   $user_id =  Auth::user()->id,
            $message = "تم عرض مخافظة {$data->name_ar} ";
            $this->log($user_id, $message);
        }
        return response()->json($data);
        // return $this->respondSuccess($data, message: 'Get Data successfully.');

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateGovernorateRequest  $request
     * @param  \App\Models\Governorate  $governorate
     * @return \Illuminate\Http\Response
     */
    public function update($id ,  Request $request)
    {
        //
        $data = $this->GovernorateRepository->update($id  ,$request);
        if ($data) {
            $user_id = 1;
            //   $user_id =  Auth::user()->id,
            $message = "تم تعديل مخافظة {$data->name_ar} ";
            $this->log($user_id, $message);
        }
        // return response()->json($data);
        // return $this->respondSuccess($data, 'Update Data successfully.');
        return redirect()->back()->with('success', 'Bank created successfully.');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Governorate  $governorate
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
        $data = $this->GovernorateRepository->destroy($id);
        if ($data) {
            $user_id = 1;
            //   $user_id =  Auth::user()->id,
            $message = "تم مسح مخافظة {$data->name_ar} ";
            $this->log($user_id, $message);
        }
        // return response()->json($data);
        // return $this->respondSuccess($data, message: 'Delete Data successfully.');
        return redirect()->back()->with('success', 'Bank created successfully.');
    }
}
