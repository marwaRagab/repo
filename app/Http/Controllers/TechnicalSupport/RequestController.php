<?php

namespace App\Http\Controllers\TechnicalSupport;

use App\Http\Controllers\Controller;
use App\Interfaces\TechnicalSupport\RequestRepositoryInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RequestController extends Controller
{
    protected $requestRepository;

    public function __construct(RequestRepositoryInterface $requestRepository)
    {
        $this->requestRepository = $requestRepository;
    }
    public function index(Request $request)
    {
        $data = $this->requestRepository->index($request);

        if ($data) {
            $user_id =  Auth::user()->id ?? null;
            $message = "تم الدخول لصفحة التطوير بالدعم الفني ";
            $this->log($user_id, $message);
        }

        return $data;
    }

    public function show($id)
    {
        $data = $this->requestRepository->show($id);

        if ($data) {
            $user_id =  Auth::user()->id ?? null;
            $message = ":تم الدخول لطلب {$id} ";
            $this->log($user_id, $message);
        }

        return $data;
    }

    public function store(Request $request)
    {
        $data = $this->requestRepository->store($request);

        if ($data) {
            $user_id =  Auth::user()->id ?? null;
            $message = ":تم اضافة طلب {$request->title} ";
            $this->log($user_id, $message);
        }

        return $data;
    }


    public function updateStatus($id,  Request $request)
    {
        $data = $this->requestRepository->updateStatus($id, $request);

        if ($data) {
            $user_id =  Auth::user()->id ?? null;
            $message = "تم تحديث طلب: {$id} ";
            $this->log($user_id, $message);
        }

        return $data;
    }

    public function addReply(Request $request)
    {
        $data = $this->requestRepository->addReply($request);

        if ($data) {
            $user_id =  Auth::user()->id ?? null;
            $message = "تم اضافة رد على طلب: {$request->problem_id}";
            $this->log($user_id, $message);
        }

        return $data;
    }
}
