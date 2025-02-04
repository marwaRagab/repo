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


        $permissions = Permission::with('parent')->orderBy('created_at', 'desc')->get();

        $data['view'] = 'permissions.index';
        return view('layout', $data, compact('breadcrumb','data','permissions'));

    }
    public function search(Request $request)
{
    $search = $request->input('q');

    // Fetch permissions (all if no search query is provided)
    $permissions = Permission::when($search, function ($query, $search) {
        return $query->where('name', 'LIKE', "%{$search}%")
                     ->orWhere('name_ar', 'LIKE', "%{$search}%")
                     ->orWhere('id', $search);
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
        $breadcrumb[1]['url'] = route("permissions.index");
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
            'name' => 'required|string|min:2|max:255|unique:permissions,name',
            'name_ar' => 'required|string|min:2|max:255|unique:permissions,name_ar',
            'parent_id' => 'nullable|exists:permissions,id'
        ]);

        try {
            Permission::create([
                'name' => trim($request->name),
                'name_ar' => trim($request->name_ar),
                'guard_name' => 'web',
                'parent_id' => $request->parent_id
            ]);

            return redirect()->route('permissions.index')->with('success', 'تمت إضافة الصلاحية بنجاح.');
        } catch (\Exception $e) {
            return redirect()->route('permissions.index')->with('error', '⚠️ فشلت الإضافة، الصلاحية موجودة بالفعل.');
        }
    }



    public function edit($id)
    {
        $title='تعديل صلاحية';
        $breadcrumb = array();
        $breadcrumb[0]['title'] = " الرئيسية";
        $breadcrumb[0]['url'] = route("dashboard");
        $breadcrumb[1]['title'] = "الصلاحيات";
        $breadcrumb[1]['url'] = route("permissions.index");
        $breadcrumb[2]['title'] = $title;
        $breadcrumb[2]['url'] = 'javascript:void(0);';
        $view = 'permissions.edit';

        $permission = Permission::findOrFail($id);
        return view('layout', compact('permission','breadcrumb','view'));
    }

    public function update(Request $request, $id)
    {
        $permission = Permission::findOrFail($id);

        $request->validate([
            'name' => 'required|string|min:2|max:255|unique:permissions,name,' . $id,
            'name_ar' => 'required|string|min:2|max:255|unique:permissions,name_ar,' . $id,
            'parent_id' => 'nullable|exists:permissions,id'
        ]);

        try {
            $permission->update([
                'name' => trim($request->name),
                'name_ar' => trim($request->name_ar),
                'parent_id' => $request->parent_id
            ]);

            return redirect()->route('permissions.index')->with('success', '✅ تم تحديث الصلاحية بنجاح.');
        } catch (\Exception $e) {
            return redirect()->route('permissions.index')->with('error', '⚠️ فشل التحديث، الصلاحية موجودة بالفعل.');
        }
    }
    public function destroy($id)
    {
        $permission = Permission::findOrFail($id);

        try {
            $permission->delete();
            return redirect()->route('permissions.index')->with('success', '✅ تم حذف الصلاحية بنجاح.');

        } catch (\Exception $e) {
            return redirect()->route('permissions.index')->with('error', '❌ حدث خطأ أثناء الحذف.');

        }
    }
}
