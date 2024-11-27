<?php

namespace App\Http\Controllers\ImportingCompanies;

use App\Http\Controllers\Controller;
use App\Interfaces\ImportingCompanies\CompanyRepositoryInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CompanyController extends Controller
{
    protected $companyRepository;

    public function __construct(CompanyRepositoryInterface $companyRepository)
    {
        $this->companyRepository = $companyRepository;
    }
    public function index()
    {
        $data = $this->companyRepository->index();

        if ($data) {
            $user_id =  Auth::user()->id ?? null;
            $message = "تم الدخول لصفحة الشركات الموردة ";
            $this->log($user_id, $message);
        }

        return $data;
    }
    public function create()
    {
        $data = $this->companyRepository->create();

        if ($data) {
            $user_id =  Auth::user()->id ?? null;
            $message = "تم الدخول لصفحة اضافة الشركات الموردة ";
            $this->log($user_id, $message);
        }

        return $data;
    }

    public function store(Request $request)
    {
        $data = $this->companyRepository->store($request);

        if ($data) {
            $user_id =  Auth::user()->id ?? null;
            $message = "تم اضافة شركة {$request->name_ar} ";
            $this->log($user_id, $message);
        }

        return $data;
    }

    public function edit($id)
    {
        $data = $this->companyRepository->edit($id);

        if ($data) {
            $user_id =  Auth::user()->id ?? null;
            $message = "تم الدخول لصفحة تعديل الشركات الموردة ";
            $this->log($user_id, $message);
        }

        return $data;
    }
    public function update($id, Request $request)
    {
        $data = $this->companyRepository->update($id, $request);

        if ($data) {
            $user_id =  Auth::user()->id ?? null;
            $message = "تم تحديث شركة {$request->name_ar} ";
            $this->log($user_id, $message);
        }

        return $data;
    }
}
