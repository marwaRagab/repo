<?php

namespace App\Http\Controllers\HumanResources;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Interfaces\HumanResources\MemberRepositoryInterface;
use Illuminate\Support\Facades\Auth;

class MemberController extends Controller
{
    protected $MemberRepository;

    public function __construct(MemberRepositoryInterface $MemberRepository)
    {
        $this->MemberRepository = $MemberRepository;
    }
    public function index()
    {
        $data = $this->MemberRepository->index();

        if ($data) {
            $user_id =  Auth::user()->id ?? null;
            $message = "تم الدخول لصفحة الأعضاء ";
            $this->log($user_id, $message);
        }

        return $data;
    }

    public function store(Request $request)
    {
        $data = $this->MemberRepository->store($request);

        if ($data) {
            $user_id =  Auth::user()->id ?? null;
            $message = "تم اضافة عضو {$request->name_ar} ";
            $this->log($user_id, $message);
        }

        return $data;
    }


    public function update($id,  Request $request)
    {
        $data = $this->MemberRepository->update($id, $request);

        if ($data) {
            $user_id =  Auth::user()->id ?? null;
            $message = "تم تحديث عضو {$request->name_ar} ";
            $this->log($user_id, $message);
        }

        return $data;
    }

    public function destroy($id)
    {
        $data = $this->MemberRepository->destroy($id);

        if ($data) {
            $user_id =  Auth::user()->id ?? null;
            $message = "تم حذف عضو";
            $this->log($user_id, $message);
        }

        return $data;
    }
}
