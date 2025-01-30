<?php

namespace App\Http\Controllers;

use App\Models\Permission;
use Illuminate\Http\Request;
// use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Validator;
use App\Http\Requests\StorePermissionRequest;
use App\Http\Requests\UpdatePermissionRequest;
use App\Interfaces\PermissionRepositoryInterface;

class PermissionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    protected $PermissionRepository;

    public function __construct(PermissionRepositoryInterface $PermissionRepository)
    {
        $this->PermissionRepository = $PermissionRepository;
    }
    public function index()
    {

        // dd("dd");
        // $permissions = $this->PermissionRepository->index();
        $title='الفروع';
        $breadcrumb = array();
        $breadcrumb[0]['title'] = " الرئيسية";
        $breadcrumb[0]['url'] = route("dashboard");
        $breadcrumb[1]['title'] = "الصلاحيات";
        $breadcrumb[1]['url'] = route("branch.index");
        $breadcrumb[2]['title'] = $title;
        $breadcrumb[2]['url'] = 'javascript:void(0);';

        $data['permission']= Permission::all();

        if ($data['permission']) {
            // $user_id = 1;
              $user_id =  Auth::user()->id ?? null;
            $message = "تم الدخول لصفحة  الصلاحيات";
            $this->log($user_id, $message);
        }


        $data['view'] = 'setting/permission';
        return view('layout', $data, compact('breadcrumb','data'));
        // return response()->json($permissions);
        // return $this->respondSuccess($permissions, 'Get Data successfully.');
    }

    public function getall(Request $request)
    {
        if ($request->ajax()) {
            $data = Permission::select('*');
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
     * @param  \App\Http\Requests\StorePermissionRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $messages = [
            'name.required' => ' الاختيار  مطلوب.',
            'perant_id.required' => 'الرئيسى مطلوب.',
        ];

        $validatedData = Validator::make($request->all(), [
            'name' => 'required',
            'perant_id' => 'required',
        ], $messages);

        if ($validatedData->fails()) {

            return redirect()->back()->withErrors($validatedData)->withInput();
        }

        $data = $this->PermissionRepository->store($request);
        if ($data) {
            // $user_id = 1;
              $user_id =  Auth::user()->id ?? null;
            $message = "تم اضافة صلاخية {$data->title_ar} ";
            $this->log($user_id, $message);
        }
        // return response()->json($data);
        return redirect()->back()->with('success','تم الاضافة بنجاخ');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Permission  $permission
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $data = $this->PermissionRepository->show($id);
        if ($data) {
            // $user_id = 1;
              $user_id =  Auth::user()->id ?? null;
            $message = "تم عرض صلاخية {$data->title_ar} ";
            $this->log($user_id, $message);
        }
        return response()->json($data);
        // return $this->respondSuccess( $data, 'Get Data successfully.');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Permission  $permission
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $data = $this->PermissionRepository->show($id);
        if ($data) {
            // $user_id = 1;
            $user_id =  Auth::user()->id ?? null;
            $message = "تم عرض صلاخية {$data->title_ar} ";
            $this->log($user_id, $message);
        }
        return response()->json($data);

        // return $this->respondSuccess($data, message: 'Get Data successfully.');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdatePermissionRequest  $request
     * @param  \App\Models\Permission  $permission
     * @return \Illuminate\Http\Response
     */
    public function update($id ,  Request $request)
    {
        //
        $data = $this->PermissionRepository->update($id  ,$request);
        if ($data) {
            // $user_id = 1;
              $user_id =  Auth::user()->id ?? null;
            $message = "تم تعديل صلاخية {$data->title_ar} ";
            $this->log($user_id, $message);
        }
        // return response()->json($data);
        return $this->respondSuccess($data, 'Update Data successfully.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Permission  $permission
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
        $data = $this->PermissionRepository->destroy($id);
        if ($data) {
            // $user_id = 1;
              $user_id =  Auth::user()->id ?? null;
            $message = "تم مسح صلاخية {$data->title_ar} ";
            $this->log($user_id, $message);
        }
        // return response()->json($data);
        // return $this->respondSuccess($data, message: 'Delete Data successfully.');
        return redirect()->back()->with('success','تم المسح بنجاخ');
    }
}