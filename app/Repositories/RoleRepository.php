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
//dd($roles[0]);

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

        $users = $query->get();



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
        $permissionsTableHTML = $this->buildPermissionTreeHTML();

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

    private function buildPermissionTreeHTML($parentId = null, $selectedPermissions = [])
    {
    //    dd($parentId);
        $permissions = Permission::where('parent_id', $parentId)->get();

        if ($permissions->isEmpty()) {
            return '';
        }

        $html = '<ul class="tree">';

        foreach ($permissions as $permission) {
            $hasChildren = Permission::where('parent_id', $permission->id)->exists();

            $isChecked = in_array($permission->id, $selectedPermissions) ? 'checked' : '';

            $html .= '<li style="background: #f8f9fa;">';

            if ($hasChildren) {
                $html .= '<span class="toggle-arrow">⮟</span>';
            }

            $html .= '<input type="checkbox" class="parent-checkbox" name="permissions[]" value="' . $permission->id . '" ' . $isChecked . '> ' . $permission->name;

            if ($hasChildren) {
                $html .= '<ul class="child-tree">';
                $html .= $this->buildPermissionTreeHTML($permission->id, $selectedPermissions);
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
            'name_ar' => 'required|string|unique:roles,name',
            'name_en' => 'required|string|unique:roles,name',
            'permissions' => 'array|required'
        ]);

        // Create Role
        $role = Role::create(['name' => $request->name_en,'name_ar' => $request->name_ar]);

        // Assign Permissions
        $permissions = Permission::whereIn('id', $request->permissions)->pluck('name');
        $role->givePermissionTo($permissions);

        // Redirect or return response
        return redirect()->route('roles.index')->with('success', 'تم الاضافة بنجاح');
    }

    public function edit($id)
    {
        $role = Role::with('permissions')->findOrFail($id);

        // Pass selected permission IDs to highlight the checked permissions
        $selectedPermissions = $role->permissions->pluck('id')->toArray();

        // Build the permission tree with selected permissions
        $permissionsTableHTML = $this->buildPermissionTreeHTML(null, $selectedPermissions);

        $title = "تعديل مجموعة العمل";
        $breadcrumb = [
            ['title' => "الرئيسية", 'url' => route('roles.index')],
            ['title' => "الموارد البشرية", 'url' => route('roles.index')],
            ['title' => "مجموعات العمل", 'url' => route('roles.index')],
            ['title' => $title, 'url' => 'javascript:void(0);']
        ];
$view='role.edit';
        return view('layout', compact('title','view', 'breadcrumb', 'role', 'permissionsTableHTML'));
    }


    public function update($id, Request $request)
    {
        $role = Role::findOrFail($id);



        $role->update([
            'name_ar' => $request->name_ar,
            'name' => $request->name_en,
            'updated_by' => Auth::id()
        ]);

        // Sync permissions
        $permissions = Permission::whereIn('id', $request->permissions)->pluck('name');
        $role->syncPermissions($permissions);

        return redirect()->route('roles.index')->with('success', 'تم تحديث المجموعة بنجاح');
    }


   
    public function destroy($id)
    {
        $Role = Role::findOrFail($id);

        try {
            $Role->delete();
            return redirect()->route('roles.index')->with('success', '✅ تم حذف المجموعة بنجاح.');

        } catch (\Exception $e) {
            return redirect()->route('roles.index')->with('error', '❌ حدث خطأ أثناء الحذف.');

        }
    }
}
