<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Permission;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\NotFoundExceptionInterface;

class LoginController extends Controller
{

    public function getall()
    {
        // dd("dd");
        $data = User::all();
        // return response()->json($permissions);
        return $this->respondSuccess($data, 'Get Data successfully.');
    }

    public function show_login()
    {
        return view('login');

    }

    public function dasboard()
    {
        $breadcrumb = array();
        $title = '';
        $breadcrumb[0]['title'] = " الرئيسية";
        $breadcrumb[0]['url'] = 'javascript:void(0);';

        $view = 'index';

        return view('layout', compact('breadcrumb', 'view'));

    }

    /**
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    public function login(Request $request)
    {
        //  dd('dd');
        $messages = [
            // 'email.required' => 'الايميل  مطلوب.',
            'username.required' => 'اسم المستخدم  مطلوب.',
            'password.required' => 'كلمة المرور مطلوبة.',
        ];

        $validatedData = Validator::make($request->all(), [
            // 'email' => 'required|email',
            'username' => 'required',
            'password' => 'required',
        ], $messages);

        if ($validatedData->fails()) {
            // return $this->respondError('Validation Error.', $validatedData->errors(), 400);
            return back()->withErrors($validatedData->errors())->withInput();
        }
        $email = $request->username;
        $password = $request->password;
        // Check if the user exists
        $user = User::where('username', $request->username)->first();

        if (!$user || !Hash::check($password, hashedValue: $user->password)) {
            // dd("s");
            // return response()->json(['error' => 'Invalid credentials'], 401);
            return back()->withErrors(['error' => 'خطأ فى اسم المستخدم او كلمة المرور'])->withInput();
        }
        // Check if the user is active
        if ($user->active !== '1') {
            // return $this->respondError('Validation Error.', ['not authorized' => ['لا يسمح لك بدخول النظام']], 400);
            return back()->withErrors(['error' => 'لا يسمح لك بدخول النظام'])->withInput();
        }
        $credentials = $request->only('username', 'password');
        // Check if the user has logged in within the last two hours
        // $sixHoursAgo = now()->subHours(6);
        if (Auth::attempt($credentials)) {

            // If the user has logged in within the last two hours, do not set the code
            // if ($user->updated_at >= $sixHoursAgo) {
            //   $token=$user->createToken('auth_token')->accessToken;
            $token = $user->createToken('auth_token')->plainTextToken;
            Auth::login($user); // Log the user in
            // $user->device_token = $request->device_token;
            $user->token = $token; //->token;
            $user->on = 1;
            $user->save();
            $success['token'] = $token; //->token;
            $success['user'] = $user;

            // return redirect()->to('/');

            //        $user = Auth::user();
      Auth::user()->id;

            $role = Role::findOrFail($user->role_id);

            $permission_ids = $role->permissions->pluck('id')->toArray(); // Get IDs of the permissions
//        dd($permission_ids);
            $allPermissions = Permission::whereIn('id', $permission_ids)->with('parent')->get();
//            dd($allPermissions);
//            session()->put('user_permission', $allPermissions);
            // Create an array to store concatenated titles
            $permissionsWithParentTitles = $allPermissions->map(function ($permission) {
                // Concatenate title_ar of permission and parent (if exists)
                $parentTitle = $permission->parent ? $permission->parent->title_ar : '';
                $permissionTitle = $permission->title_ar;

                // Concatenate titles
                return $permissionTitle . '_' . $parentTitle;
            })->toArray();

// Store the concatenated results in the session
            session()->put('user_permission', $permissionsWithParentTitles);
//         dd(session()->get('user_permission'));
            // return $this->respondSuccess($success, 'User login successfully.');
            return redirect()->route('dasboard');
            //}
            /*else {

        $set = '123456789';
        $code = substr(str_shuffle($set), 0, 4);
        $input['code'] = $code;
        $msg = "يرجى التحقق من حسابك\nتفعيل الكود\n" . $code;

        send_sms_code($msg, $user->phone, $user->country_code);
        $user->code = $code;
        $user->save();
        $success['user'] = $user->only(['id', 'firstname', 'email', 'lastname', 'phone', 'country_code', 'code','image']);
        return $this->respondwarning($success, trans('message.account not verified'), ['account' => trans('message.account not verified')], 402);
        }*/
        }
        /*$breadcrumb = array();
        $breadcrumb[0]['title'] = " الرئيسية";
        $breadcrumb[0]['url'] = route("dashboard");
        $breadcrumb[1]['title'] = " ";
        $breadcrumb[1]['url'] = '';
        $breadcrumb[2]['title'] = '';
        $breadcrumb[2]['url'] = 'javascript:void(0);';
        $view='/index';
        return view('layout',compact('breadcrumb','view'));*/
        return redirect()->route('login');
        // return view('index');
        // return redirect()->route('dasboard');

        //return $this->respondError('password error', ['crediential' => ['كلمة المرور لا تتطابق مع سجلاتنا']], 403);
    }

    public function show_reset()
    {
        return view('reset');

    }
    public function reset_password(Request $request)
    {

        $messages = [
            'username.required' => 'اسم المستخدم  مطلوب.',
            'password.required' => 'كلمة المرور مطلوبة.',
            'password.confirmed' => 'كلمة المرور لا تتطابق.',

        ];

        $validatedData = Validator::make($request->all(), [
            'username' => 'required',
            'password' => 'required|confirmed',
        ], $messages);

        if ($validatedData->fails()) {
            return back()->withErrors($validatedData->errors())->withInput();
            // return $this->respondError('Validation Error.', $validatedData->errors(), 400);
        }

        $user = User::where('username', $request->username)->first();

        if (!$user) {
            return back()->withErrors(['error' => 'الاسم لا يتطابق مع سجلاتنا'])->withInput();
            // return $this->respondError('Validation Error.', ['email' => [' الايميل لا يتطابق مع سجلاتنا']], 400);
        }
        // dd($user);
        // can't use current password
        // if (Hash::check($request->password, hashedValue: $user->password) == true) {
        //     return $this->respondError('Validation Error.', ['password' => ['لا يمكن أن تكون كلمة المرور الجديدة هي نفس كلمة المرور الحالية']], 400);
        // }

        // Update password and set token for first login if applicable
        $token = $user->createToken('auth_token')->plainTextToken;
        Auth::login($user); // Log the user in
        // $user->remember_token = $request->device_token;
        $user->token = $token; //->token;
        $user->password = Hash::make($request->password);
        $user->save();

        // $success['token'] = $token;
        // // $user->image = $user->image;
        // $success['user'] = $user;

        // return $this->respondSuccess($success, 'reset password successfully.');
        return redirect()->route('dasboard');

    }

    // public function checkCode(Request $request)
    // {
    //     $validator = Validator::make($request->all(), [
    //         'email' => 'required_without:userId',
    //         'code' => 'required|min:3',
    //     ]);

    //     if ($validator->fails()) {
    //         return $this->respondError('Validation Error.', $validator->errors(), 400);
    //     }
    //     $code = $request->code;
    //     $email = $request->email;
    //     // $userId = $request->military_number;
    //     $user = User::where(function ($query) use ($email, $code) {
    //         $query->where('email', $email)->where('code', $code);
    //     })->orWhere([
    //         ['id', $userId],
    //         ['code', $code]
    //     ])->first();
    //     if ($user) {
    //         return $this->respondSuccess(json_decode('{}'), 'الكود صحيح');
    //     } else {
    //         return $this->respondError('الكود غير صحيح', ['code' => ['الكود غير صحيح']], 401);
    //     }
    // }

    // public function resendCode(Request $request)
    // {
    //     $validator = Validator::make($request->all(), [
    //         'email' => 'required_without:userId',
    //     ]);

    //     if ($validator->fails()) {
    //         return $this->respondError('Validation Error.', $validator->errors(), 400);
    //     }
    //     $email = $request->email;
    //     $user = User::where(function ($query) use ($email) {
    //         if ($email) {
    //             $query->where('email', $email);
    //         }
    //     })->orWhere('id', $request->userId)->first();
    //     if ($user) {
    //         $set = '123456789';
    //         $code = substr(str_shuffle($set), 0, 4);
    //         $msg = "يرجى التحقق من حسابك\nتفعيل الكود\n" . $code;

    //         send_sms_code($msg, $user->phone, $user->country_code);
    //         $user->code = $code;
    //         $user->save();
    //         return $this->respondSuccess(json_decode('{}'), 'تم ارسال الرسالة بنجاح');
    //     } else {
    //         return $this->respondError('user not found', ['military_number' => ['مستخدم غير مسجل لدينا']], 400);
    //     }
    // }

    public function logout()
    {

        // dd(Auth::user());
        // Auth::user()->tokens()->delete();
        // // $request->user()->tokens()->delete();
        // return $this->respondSuccess(null, trans('تسجيل خروج'));
        $user = User::where('id', Auth::user()->id)->first();
        $user->on = 0;
        $user->save();

        Auth::logout();
        return redirect('/login');
    }

    // register

    public function register(Request $request)
    {
        $messages = [
            'email.required' => 'الايميل  مطلوب.',
            'password.required' => 'كلمة المرور مطلوبة.',
        ];

        $validatedData = Validator::make($request->all(), [
            'name_ar' => 'required',
            'name_en' => 'required',
            'phone' => 'required',
            // 'role_id' =>'required',
            // 'branch_id' =>'required',
            'email' => 'required|email',
            'password' => 'required',
        ], $messages);

        if ($validatedData->fails()) {
            return $this->respondError('Validation Error.', $validatedData->errors(), 400);
        }

        $data = new User;
        $data->name_ar = $request->name_ar;
        $data->name_en = $request->name_en;
        $data->username = $request->username ?? null;
        $data->phone = $request->phone;
        $data->email = $request->email;
        $data->notes = $request->notes ?? null;
        $data->active = 1;
        $data->password = Hash::make($request->password);
        // $data->role_id = $request->role_id ?? null;
        // $data->branch_id = $request->branch_id ?? null;
        $data->created_by = Auth::user()->id ?? null;
        $data->updated_by = Auth::user()->id ?? null;
        $data->save();

        return $this->respondSuccess($data, 'insert user successfully.');
    }
    public function show($id)
    {
        $data = User::findOrFail($id);
        return $this->respondSuccess($data, 'Get Data successfully.');
    }

    public function edit($id)
    {
        // return User::findOrFail($id);
        $data = User::findOrFail($id);
        return $this->respondSuccess($data, 'Get Data successfully.');
    }

    public function update($id, Request $request)
    {
        $data = User::findOrFail($id);
        $data->name_ar = $request->name_ar;
        $data->name_en = $request->name_en;
        $data->username = $request->username ?? null;
        $data->phone = $request->phone;
        $data->email = $request->email;
        $data->notes = $request->notes ?? null;
        $data->active = $request->active;
        $data->password = Hash::make($request->password);
        $data->role_id = $request->role_id;
        $data->branch_id = $request->branch_id;
        $data->updated_by = Auth::user()->id;
        $data->save();

        return $this->respondSuccess($data, 'update user successfully.');
    }

    public function destroy($id)
    {
        $data = user::findOrFail($id);

        // Perform soft delete
        $data->delete();
        // return $data;
        return $this->respondSuccess($data, 'delete user successfully.');
    }
}
