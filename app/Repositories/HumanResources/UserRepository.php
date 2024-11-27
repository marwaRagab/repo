<?php

namespace App\Repositories\HumanResources;

use App\Interfaces\HumanResources\UserRepositoryInterface;
use App\Models\Branch;
use App\Models\Role;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class UserRepository implements UserRepositoryInterface
{
    public function index()
    {
        $users = User::with('roles', 'branches')->get();

        $branches = Branch::all();
        $roles = Role::all();

        $title = "المستخدمين";
        $breadcrumb = array();
        $breadcrumb[0]['title'] = " الرئيسية";
        $breadcrumb[0]['url'] = route("dashboard");
        $breadcrumb[1]['title'] = "الموارد البشرية";
        $breadcrumb[1]['url'] = route("dashboard");
        $breadcrumb[2]['title'] = $title;
        $breadcrumb[2]['url'] = 'javascript:void(0);';

        $view = 'HumanResources.users';
        return view(
            'layout',
            compact('title', 'view', 'breadcrumb', 'users', 'branches', 'roles')
        );
    }

    public function store($request)
    {

        $validatedData = $request->validate([
            'username' => 'required|string|max:255|unique:users',
            'name' => 'required|string|max:255',
            'branch_id' => 'required|exists:branches,id',
            'role_id' => 'required|exists:roles,id',
            'password' => 'required|string|min:6|confirmed',
            'type' => 'required|in:emp,user',
            'active' => 'required|boolean',
        ]);

        // Create the new user
        $user = User::where('name_ar', $request->name)->firstOrFail();
        $user->username = $validatedData['username'];
        $user->branch_id = $validatedData['branch_id'];
        $user->role_id = $validatedData['role_id'];
        $user->password = Hash::make($validatedData['password']);
        $user->type = $request->type;
        $user->active = $request->active;
        $user->created_by = Auth::user()->id;
        $user->save();

        return redirect()->route('users.index')->with('success', 'تم إضافة المستخدم بنجاح');
    }

    public function update($request, $id)
    {
        $request->validate([
            'role_id' => 'nullable|exists:roles,id',
            'branch_id' => 'nullable|exists:branches,id',
            'password' => 'nullable|string|min:6|confirmed',
            'type' => 'nullable|in:emp,user',
            'active' => 'nullable|boolean',
        ]);

        $user = User::findOrFail($id);
        $user->role_id = $request->role_id;
        $user->branch_id = $request->branch_id;
        $user->type = $request->type;
        $user->active = $request->active;
        $user->updated_by = Auth::user()->id;

        if ($request->filled('password')) {
            Hash::make($request->password);
        }

        $user->save();

        return redirect()->route('users.index')->with('success', 'تم تحديث المستخدم بنجاح');
    }
}
