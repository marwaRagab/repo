<?php

namespace App\Repositories\HumanResources;

use App\Interfaces\HumanResources\UserRepositoryInterface;
use App\Models\Branch;
use App\Models\Role;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Crypt;

class UserRepository implements UserRepositoryInterface
{
    public function index()
    {
        $users = User::with('roles', 'branches')->get();
        $avatars = File::files(public_path('avatars'));

        // dd($avatars);exit;

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
            compact('title', 'view', 'breadcrumb', 'users', 'avatars', 'branches', 'roles')
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
        //dd($request->name);
        $user = User::where('name_ar', $request->name)->firstOrFail();
        $user->username = $validatedData['username'];
        $user->branch_id = $validatedData['branch_id'];
        $user->role_id = $validatedData['role_id'];
        $user->password = Hash::make($validatedData['password']);
        $user->type = $request->type;
        $user->active = $request->active;
        $user->created_by = Auth::user()->id;

        /* if ($request->hasFile('image')) {
        $filename = time() . '-' . $request->file('image')->getClientOriginalName();
        $personalImagePath = $request->file('image')->move(public_path('user_profile'), $filename);
        $user->img = $filename;
        }
         */
        /* if ($request->avatar) {
             $originalPath = $request->avatar;
             $newDirectory = public_path('user_profile'); // Specify the new directory

             $originalName = pathinfo($originalPath, PATHINFO_FILENAME);
             $extension = pathinfo($originalPath, PATHINFO_EXTENSION);
             $encryptedName = Str::random(20) . '.' . $extension;

             $newPath = $newDirectory . '/' . $encryptedName;

             if (!File::exists($newDirectory)) {
                 File::makeDirectory($newDirectory, 0755, true);
             }

              File::copy($originalPath, $newPath);

             $user->img = $encryptedName;
         }
         */
        if ($request->hasFile('avatar')) {
            $avatar = $request->file('avatar');
            $extension = $avatar->getClientOriginalExtension();
            $filename = Str::random(20) . '.' . $extension;
            $path = public_path('user_profile/' . $filename);

            // Make sure the directory exists
            if (!File::exists(public_path('user_profile'))) {
                File::makeDirectory(public_path('user_profile'), 0755, true);
            }

            // Move the uploaded file
            $avatar->move(public_path('user_profile'), $filename);

            // Save the filename to the user record
            $user->img = $filename;
        }


        $user->save();

        // url('qr-code/generate/'.$user->id);

        return redirect()->to('qr-code/generate/'.$user->id);
    }
    public function edit($id)
    {

        $branches = Branch::all();
        $roles = Role::all();
        $avatars = File::files(public_path('avatars'));

        try {
            // فك التشفير
            $userId = Crypt::decryptString($id);
        } catch (\Exception $e) {
            abort(404, 'الرابط غير صالح');
        }
  $user = User::findOrFail($userId);


        $title = "المستخدمين";
        $breadcrumb = array();
        $breadcrumb[0]['title'] = " الرئيسية";
        $breadcrumb[0]['url'] = route("dashboard");
        $breadcrumb[1]['title'] = "الموارد البشرية";
        $breadcrumb[1]['url'] = route("dashboard");
        $breadcrumb[2]['title'] = $title;
        $breadcrumb[2]['url'] = 'javascript:void(0);';

        $view = 'HumanResources.users.edit';
        return view(
            'layout',
            compact('title', 'view', 'breadcrumb', 'user', 'avatars', 'branches', 'roles')
        );
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
/*
if ($request->hasFile('image')) {
$filename = time() . '-' . $request->file('image')->getClientOriginalName();
$personalImagePath = $request->file('image')->move(public_path('user_profile'), $filename);
$user->img = $filename;
}
 */
        if ($request->avatar) {
            $originalPath = $request->avatar;
            $newDirectory = public_path('user_profile'); // Specify the new directory

            $originalName = pathinfo($originalPath, PATHINFO_FILENAME);
            $extension = pathinfo($originalPath, PATHINFO_EXTENSION);
            $encryptedName = Str::random(20) . '.' . $extension;

            $newPath = $newDirectory . '/' . $encryptedName;

            if (!File::exists($newDirectory)) {
                File::makeDirectory($newDirectory, 0755, true);
            }

            File::copy($originalPath, $newPath);

            $user->img = $encryptedName;
        }
        $user->save();

        return redirect()->route('users.index')->with('success', 'تم تحديث المستخدم بنجاح');
    }
}
