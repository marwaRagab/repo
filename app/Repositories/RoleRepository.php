<?php

namespace App\Repositories;

use App\Models\Role;
use Inertia\Inertia;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Interfaces\RoleRepositoryInterface;
use App\Models\Permission;

class RoleRepository implements RoleRepositoryInterface
{
    public function index()
    {
        $roles = Role::with('user')->get();
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

        $view = 'HumanResources.roles';
        // $view = 'setting.permission';
        return view(
            'layout',
            compact('title', 'view', 'breadcrumb', 'roles', 'Permissions','rolescount')
        );
    }


    public function show($id)
    {
        return Role::findOrFail($id);
    }

    public function  create()
    {

    }
    public function store(Request $request)
    {
        // dd($request);
        // $data = new Role;
        // $data->name_ar = $request->name_ar;
        // $data->name_en = $request->name_en;
        // $data->created_by = Auth::user()->id;
        // $data->updated_by = Auth::user()->id;
        // $data->save();

        // if($request->has('permissions'))
        // {
        //     foreach($request->permissions as $item)
        //     {
        //         DB::table('role_permissions')->insert([
        //             'role_id' => $data->id,  // assuming 1 is the role ID
        //             'permission_id' => $item,  // assuming 2 is the permission ID
        //         ]);
        //     }
        // }
        // return $data;
        $request->validate([
            'name_ar' => 'required|string|max:255',
            'name_en' => 'required|string|max:255',
            'permissions' => 'array', // Ensure permissions is an array
            'permissions.*' => 'exists:permissions,id', // Each permission should exist in the permissions table
        ]);

        // Create the role
        $role = Role::create([
            'name_ar' => $request->name_ar,
            'name_en' => $request->name_en,
            'created_by' => auth()->id() ?? null ,
        ]);

        // Attach the selected permissions
        if ($request->has('permissions')) {
            $role->permissions()->sync($request->permissions);
        }

        // Redirect or return response
        return redirect()->route('roles.index')->with('success', 'تم الاضافة بنجاح');
    }

    public function  edit($id)
    {
        $role = Role::with('permissions')->findOrFail($id);

    // Return the role data (you might want to return only specific fields if needed)
    return response()->json([
        'name_ar' => $role->name_ar,
        'name_en' => $role->name_en,
        'permissions' => $role->permissions->pluck('id')->toArray() // Assuming 'permissions' is a relationship in the Role model
    ]);
    }

    public function update($id, Request $request)
   {
    // dd($request);
    // Find the role by ID or fail
    $role = Role::findOrFail($id);

    // Update the role's name if provided
    $role->name_ar = $request->input('name_ar') ?? $role->name_ar;
    $role->name_en = $request->input('name_en') ?? $role->name_en;
    $role->updated_by = Auth::id() ?? null;
    $role->save();

    // Check if the request has permissions
    if ($request->filled('permissions')) {
        // Retrieve existing permission IDs for this role
        // $existingPermissions = $role->permissions()->pluck('id')->toArray();

        // Get the submitted permission IDs
        // $submittedPermissions = $request->permissions;

        // // Find permissions to add and to remove
        // $permissionsToAdd = array_diff($submittedPermissions, $existingPermissions);
        // $permissionsToRemove = array_diff($existingPermissions, $submittedPermissions);

        // // Add new permissions
        // foreach ($permissionsToAdd as $permissionId) {
        //     $role->permissions()->attach($permissionId);
        // }

        // // Remove permissions that are no longer assigned
        // foreach ($permissionsToRemove as $permissionId) {
        //     $role->permissions()->detach($permissionId);
        // }

        DB::table('role_permissions')->where('role_id',$role->id)->delete();
        if ($request->has('permissions')) {
            $role->permissions()->sync($request->permissions);
        }
    }

    // Return the updated role data
    return response()->json($role);
}

    public function destroy($id)
    {
        $data = Role::findOrFail($id);

        // Perform soft delete
        $data->delete();
        return $data;
    }
}
