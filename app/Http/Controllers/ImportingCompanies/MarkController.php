<?php

namespace App\Http\Controllers\ImportingCompanies;

use App\Http\Controllers\Controller;
use App\Interfaces\ImportingCompanies\MarkRepositoryInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MarkController extends Controller
{
    protected $markRepository;

    public function __construct(MarkRepositoryInterface $markRepository)
    {
        $this->markRepository = $markRepository;
    }
    public function index()
    {
        $data = $this->markRepository->index();

        if ($data) {
            $user_id =  Auth::user()->id ?? null;
            $message = "تم الدخول لصفحة الماركات ";
            $this->log($user_id, $message);
        }

        return $data;
    }

    public function store(Request $request)
    {
        $data = $this->markRepository->store($request);

        if ($data) {
            $user_id =  Auth::user()->id ?? null;
            $message = "تم اضافة ماركة {$request->name_ar} ";
            $this->log($user_id, $message);
        }

        return $data;
    }


    public function update($id,  Request $request)
    {
        $data = $this->markRepository->update($id, $request);

        if ($data) {
            $user_id =  Auth::user()->id ?? null;
            $message = "تم تحديث ماركة {$request->name_ar} ";
            $this->log($user_id, $message);
        }

        return $data;
    }
}
