<?php

namespace App\Http\Controllers\HumanResources;

use App\Http\Controllers\Controller;
use App\Interfaces\HumanResources\ClientRepositoryInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ClientController extends Controller
{
    protected $clientRepository;

    public function __construct(ClientRepositoryInterface $clientRepository)
    {
        $this->clientRepository = $clientRepository;
    }
    public function index()
    {
        $data = $this->clientRepository->index();

        if ($data) {
            $user_id =  Auth::user()->id ?? null;
            $message = "تم الدخول لصفحة العملاء ";
            $this->log($user_id, $message);
        }

        return $data;
    }

    public function store(Request $request)
    {
        $data = $this->clientRepository->store($request);

        if ($data) {
            $user_id =  Auth::user()->id ?? null;
            $message = "تم اضافة عميل {$request->name_ar} ";
            $this->log($user_id, $message);
        }

        return $data;
    }
    public function update(Request $request, $id)
    {
        $data = $this->clientRepository->update($request, $id);

        if ($data) {
            $user_id =  Auth::user()->id ?? null;
            $message = "تم تحديث عميل {$request->name_ar} ";
            $this->log($user_id, $message);
        }

        return $data;
    }

    public function destroy($id)
    {
        $data = $this->clientRepository->destroy($id);

        if ($data) {
            $user_id =  Auth::user()->id ?? null;
            $message = "تم حذف عميل";
            $this->log($user_id, $message);
        }

        return $data;
    }

    public function show_client($id)
    {
        $data = $this->clientRepository->show_client($id);

        if ($data) {
            $user_id =  Auth::user()->id ?? null;
            $message = "تم الدخول الى صفحة تعدبل عميل";
            $this->log($user_id, $message);
        }

        return $data;
    }
}
