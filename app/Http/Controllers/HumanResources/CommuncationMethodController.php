<?php

namespace App\Http\Controllers\HumanResources;

use App\Http\Controllers\Controller;
use App\Models\Log;
use Illuminate\Http\Request;
use App\Models\CommuncationMethod;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\Facades\DataTables;
use App\Http\Requests\StoreCommuncationMethodRequest;
use App\Http\Requests\UpdateCommuncationMethodRequest;
use App\Interfaces\HumanResources\CommuncationMethodRepositoryInterface;
use Illuminate\Support\Facades\Validator;


class CommuncationMethodController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    protected $CommuncationMethodRepository;

    public function __construct(CommuncationMethodRepositoryInterface $CommuncationMethodRepository)
    {
        $this->CommuncationMethodRepository = $CommuncationMethodRepository;
    }

    public function index()
    {
        $data = $this->CommuncationMethodRepository->index();

        if ($data) {
            $user_id =  Auth::user()->id ?? null;
            $message = "تم الدخول لصفحة طرق التواصل ";
            $this->log($user_id, $message);
        }

        return $data;
    }


    public function store(Request $request)
    {
        $data = $this->CommuncationMethodRepository->store($request);

        if ($data) {
            $user_id =  Auth::user()->id ?? null;
            $message = "تم اضافة طريقة تواصل {$request->name_ar} ";
            $this->log($user_id, $message);
        }

        return $data;
    }

    public function update($id,  Request $request)
    {
        $data = $this->CommuncationMethodRepository->update($id, $request);

        if ($data) {
            $user_id =  Auth::user()->id ?? null;
            $message = "تم تحديث طريقة تواصل {$request->name_ar} ";
            $this->log($user_id, $message);
        }

        return $data;
    }


    public function destroy($id)
    {
        $data = $this->CommuncationMethodRepository->destroy($id);

        if ($data) {
            $user_id =  Auth::user()->id ?? null;
            $message = "تم حذف طريقة تواصل";
            $this->log($user_id, $message);
        }

        return $data;
    }
}
