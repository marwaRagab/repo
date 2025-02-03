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
        $breadcrumb = array();
        $breadcrumb[0]['title'] = " الرئيسية";
        $breadcrumb[0]['url'] = route("dashboard");
        $breadcrumb[1]['title'] = "الصلاحيات";
        $breadcrumb[1]['url'] = route("branch.index");


        $permissions = Permission::with('parent')->get();

        $data['view'] = 'permissions.index';
        return view('layout', $data, compact('breadcrumb','data','permissions'));

    }
    public function search(Request $request)
{
    $search = $request->input('q');

    // Fetch permissions (all if no search query is provided)
    $permissions = Permission::when($search, function ($query, $search) {
        return $query->where('name', 'LIKE', "%{$search}%")->orWhere('id', $search);
    })->limit(20)->get();

    return response()->json($permissions);
}

    public function create()
    {
        $title='إضافة صلاحية';
        $breadcrumb = array();
        $breadcrumb[0]['title'] = " الرئيسية";
        $breadcrumb[0]['url'] = route("dashboard");
        $breadcrumb[1]['title'] = "الصلاحيات";
        $breadcrumb[1]['url'] = route("branch.index");
        $breadcrumb[2]['title'] = $title;
        $breadcrumb[2]['url'] = 'javascript:void(0);';
        $view = 'permissions.create';
        $permissions = Permission::all(); // Fetch existing permissions for dropdown
     //   dd($permissions);
        return view('layout', compact('permissions','breadcrumb','view'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|unique:permissions,name',
            'parent_id' => 'nullable|exists:permissions,id'
        ]);

        Permission::create([
            'name' => $request->name,
            'guard_name' => 'web',
            'parent_id' => $request->parent_id
        ]);

        return redirect()->route('permissions.index')->with('success', 'تمت إضافة الصلاحية بنجاح');
    }

    public function edit($id)
    {
        $permission = Permission::findOrFail($id);
        $permissions = Permission::where('id', '!=', $id)->get(); // Exclude current permission to avoid self-parenting
        return view('permissions.edit', compact('permission', 'permissions'));
    }

    public function update(Request $request, $id)
    {
        $permission = Permission::findOrFail($id);

        $request->validate([
            'name' => 'required|string|unique:permissions,name,' . $id,
            'parent_id' => 'nullable|exists:permissions,id'
        ]);

        $permission->update([
            'name' => $request->name,
            'parent_id' => $request->parent_id
        ]);

        return redirect()->route('permissions.index')->with('success', 'تم تحديث الصلاحية بنجاح');
    }

    public function destroy($id)
    {
        Permission::findOrFail($id)->delete();
        return redirect()->route('permissions.index')->with('success', 'تم حذف الصلاحية بنجاح');
    }
}