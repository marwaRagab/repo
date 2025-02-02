<?php

namespace App\Repositories;

use Inertia\Inertia;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Interfaces\RoleRepositoryInterface;
use App\Models\User;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RoleRepository implements RoleRepositoryInterface
{


    public function index(Request $request)
    {
      /*
        $role = Role::where('name', 'sales manager')->first();
        User::where('id', '!=', 1)->each(function ($user) use ($role) {
            $user->assignRole($role);
        });
        */


        $rolesWithUsers = Role::with('users')->get();
      //  dd($rolesWithUsers);
        // Ensure $roles is a collection
        $roles = Role::all();
        $query = User::with('roles');

        // Search by user name or civil number
        if ($request->has('search') && !empty($request->search)) {
            $query->where(function ($q) use ($request) {
                $q->where('name_ar', 'LIKE', '%' . $request->search . '%')
                  ->orWhere('phone', 'LIKE', '%' . $request->search . '%');
            });
        }

        // Filter by role
        if ($request->has('role') && !empty($request->role)) {
            $query->whereHas('roles', function ($q) use ($request) {
                $q->where('name', $request->role);
            });
        }

        $users = $query->get(); // Paginate results

     //   dd($users[0]->roles);
        // Removed the call to undefined method 'map'
        // $roles->map(function ($role) use ($user) {
        //     $user->assignRole($role); // Assign role
        // });

        // ...existing code...
      //  $rolescount = $roles->count();
       // $Permissions = Permission::whereNull('parent_id')->with('childrenRecursive')->get();

        $title = "مجموعات العمل";
        $breadcrumb = array();
        $breadcrumb[0]['title'] = " الرئيسية";
        $breadcrumb[0]['url'] = route('roles.index');
        $breadcrumb[1]['title'] = "الموارد البشرية";
        $breadcrumb[1]['url'] = route('roles.index');
        $breadcrumb[2]['title'] = $title;
        $breadcrumb[2]['url'] = 'javascript:void(0);';

        $view = 'HumanResources.roles_updated';
        // $view = 'setting.permission';
        return view(
            'layout',
            compact('title', 'view', 'breadcrumb', 'roles','users')
        );
    }

    public function show($id)
    {
        return Role::findOrFail($id);
    }

    public function create()
    {
        $permissionsTableHTML = $this->buildPermissionTreeHTML(); // Manually construct the tree
//dd($permissionsTreeHTML);
        $title = "إضافة مجموعة عمل";
        $breadcrumb = [
            ['title' => "الرئيسية", 'url' => route('roles.index')],
            ['title' => "الموارد البشرية", 'url' => route('roles.index')],
            ['title' => "مجموعات العمل", 'url' => route('roles.index')],
            ['title' => $title, 'url' => 'javascript:void(0);']
        ];

        $view = 'role.create';

        return view('layout', compact('title', 'view', 'breadcrumb', 'permissionsTableHTML'));
    }

    private function buildPermissionTreeHTML($parentId = null)
    {
        $permissions = Permission::where('parent_id', $parentId)->get();

        if ($permissions->isEmpty()) {
            return '';
        }

        $html = '<ul class="tree">';

        foreach ($permissions as $permission) {
            $hasChildren = Permission::where('parent_id', $permission->id)->exists();

            $html .= '<li>';

            // Toggle Arrow (Only if this permission has children)
            if ($hasChildren) {
                $html .= '<span class="toggle-arrow">⮟</span>';
            }

            // Checkbox for permission
            $html .= '<input type="checkbox" class="parent-checkbox" name="permissions[]" value="' . $permission->id . '"> ' . $permission->name;

            // Recursively call function for child permissions
            if ($hasChildren) {
                $html .= '<ul class="child-tree">';
                $html .= $this->buildPermissionTreeHTML($permission->id);
                $html .= '</ul>';
            }

            $html .= '</li>';
        }

        $html .= '</ul>';
        return $html;
    }

    public function store(Request $request)
    {
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
            'created_by' => auth()->id() ?? null,
        ]);

        // Attach the selected permissions
        if ($request->has('permissions')) {
            $role->permissions()->sync($request->permissions);
        }

        // Redirect or return response
        return redirect()->route('roles.index')->with('success', 'تم الاضافة بنجاح');
    }

    public function edit($id)
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
        // Find the role by ID or fail
        $role = Role::findOrFail($id);

        // Update the role's name if provided
        $role->name_ar = $request->input('name_ar') ?? $role->name_ar;
        $role->name_en = $request->input('name_en') ?? $role->name_en;
        $role->updated_by = Auth::id() ?? null;
        $role->save();

        // Check if the request has permissions
        if ($request->filled('permissions')) {
            DB::table('role_permissions')->where('role_id', $role->id)->delete();
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