<?php

namespace App\Http\Controllers\HumanResources;

use App\Http\Controllers\Controller;
use App\Interfaces\HumanResources\UserRepositoryInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    protected $userRepository;

    public function __construct(UserRepositoryInterface $userRepository)
    {
        $this->userRepository = $userRepository;
    }
    public function index()
    {
        $data = $this->userRepository->index();

        if ($data) {
            $user_id =  Auth::user()->id ?? null;
            $message = "تم الدخول لصفحة المستخدمين ";
            $this->log($user_id, $message);
        }

        return $data;
    }

    public function store(Request $request)
    {
        $data = $this->userRepository->store($request);

        if ($data) {
            $user_id =  Auth::user()->id ?? null;
            $message = "تم اضافة مستخدم {$request->name_ar} ";
            $this->log($user_id, $message);
        }

        return $data;
    }
    public function update(Request $request, $id)
    {
        $data = $this->userRepository->update($request, $id);

        if ($data) {
            $user_id =  Auth::user()->id ?? null;
            $message = "تم تحديث مستخدم {$request->name_ar} ";
            $this->log($user_id, $message);
        }

        return $data;
    }
}
