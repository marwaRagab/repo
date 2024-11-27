<?php

namespace App\Http\Controllers\ImportingCompanies;

use App\Http\Controllers\Controller;
use App\Interfaces\ImportingCompanies\ClassRepositoryInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ClassController extends Controller
{
    protected $ClassRepository;

    public function __construct(ClassRepositoryInterface $ClassRepository)
    {
        $this->ClassRepository = $ClassRepository;
    }
    public function index()
    {
        $data = $this->ClassRepository->index();

        if ($data) {
            $user_id =  Auth::user()->id ?? null;
            $message = "تم الدخول لصفحة الاصناف ";
            $this->log($user_id, $message);
        }

        return $data;
    }

    public function store(Request $request)
    {
        $data = $this->ClassRepository->store($request);

        if ($data) {
            $user_id =  Auth::user()->id ?? null;
            $message = "تم اضافة صنف {$request->name_ar} ";
            $this->log($user_id, $message);
        }

        return $data;
    }


    public function update($id,  Request $request)
    {
        $data = $this->ClassRepository->update($id, $request);

        if ($data) {
            $user_id =  Auth::user()->id ?? null;
            $message = "تم تحديث صنف {$request->name_ar} ";
            $this->log($user_id, $message);
        }

        return $data;
    }
}
