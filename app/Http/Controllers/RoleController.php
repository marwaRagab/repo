<?php

namespace App\Http\Controllers;

use App\Models\Role;
use App\Models\Permission;
use Illuminate\Http\Request;
use App\Http\Requests\StoreRoleRequest;
use App\Http\Requests\UpdateRoleRequest;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Validator;
use App\Interfaces\RoleRepositoryInterface;

class RoleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    protected $RoleRepository;

    public function __construct(RoleRepositoryInterface $RoleRepository)
    {
        $this->RoleRepository = $RoleRepository;
    }

    public function index(Request $request)
    {
        // $permissions = $this->RoleRepository->index();
        // return response()->json($permissions);
        return $this->RoleRepository->index($request);
        // return $this->respondSuccess($permissions, 'Get Data successfully.');
    }

    public function getall(Request $request)
    {
        if ($request->ajax()) {
            $data = Role::select('*');
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
        return $this->RoleRepository->create();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StorePermissionRequest  $request
     * @return \Illuminate\Http\Response
     */

    public function store(Request $request)
    {

        // dd($request);
        $messages = [
            'name_ar.required' => 'الاسم بالعربى  مطلوب.',
            'name_en.required' => 'الاسم بالانجليزية  مطلوب.',
            'permissions' => 'array'
        ];

        $validatedData = Validator::make($request->all(), [
            'name_ar' => 'required',
            'name_en' => 'required',
            'permissions' => 'array'
        ], $messages);

        if ($validatedData->fails()) {

            return $this->respondError('Validation Error.', $validatedData->errors(), 400);
        }

        return $this->RoleRepository->store($request);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Permission  $permission
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        // $data = $this->RoleRepository->show($id);
        // return response()->json($data);
        // return $this->respondSuccess($data, 'Get Data successfully.');

        $roles =  Role::with('permissions')->findOrFail($id);
        $rolescount = Role::with('user')->count();
        $Permissions = Permission::whereNull('parent_id')->with('childrenRecursive')->get();
        $title = "مجموعات العمل";
        $breadcrumb = array();
        $breadcrumb[0]['title'] = " الرئيسية";
        $breadcrumb[0]['url'] = route('roles.index');
        $breadcrumb[1]['title'] = "الموارد البشرية";
        $breadcrumb[1]['url'] = route('roles.index');
        $breadcrumb[2]['title'] = $title;
        $breadcrumb[2]['url'] = 'javascript:void(0);';

        $view = 'role.view';
        $assignedPermissions = $roles->permissions->pluck('id')->toArray();
        // $view = 'setting.permission';
        return view(
            'layout',
            compact('title', 'view', 'breadcrumb', 'roles', 'Permissions','rolescount','assignedPermissions')
        );
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Permission  $permission
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        return $this->RoleRepository->edit($id);
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
        // dd($request);

        // return redirect()->back();
        return $this->RoleRepository->update($id  ,$request);
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Permission  $permission
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {

        $data = $this->RoleRepository->destroy($id);
        // return response()->json($data);
        // return response()->json(['success' => true, 'message' => 'تم حذف العنصر بنجاح']);
        return redirect()->back()->with(['success' => true, 'message' => 'تم حذف العنصر بنجاح']);
    }
}