<?php

namespace App\Http\Controllers\HumanResources;

use App\Http\Controllers\Controller;
use App\Models\Log;
use Illuminate\Http\Request;
use App\Models\TransactionCompleted;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Validator;
use App\Interfaces\HumanResources\TransactionsCompletedRepositoryInterface;
use Illuminate\Support\Facades\Auth;

class TransactionsCompletedController extends Controller
{
    protected $transactionsCompletedRepository;

    public function __construct(TransactionsCompletedRepositoryInterface $transactionsCompletedRepository)
    {
        $this->transactionsCompletedRepository = $transactionsCompletedRepository;
    }

    public function index()
    {
        $data = $this->transactionsCompletedRepository->index();

        if ($data) {
            $user_id =  Auth::user()->id ?? null;
            $message = "تم الدخول لصفحة منجزين المعاملات ";
            $this->log($user_id, $message);
        }

        return $data;
    }

    public function store(Request $request)
    {

        $data = $this->transactionsCompletedRepository->store($request);

        if ($data) {
            $user_id =  Auth::user()->id ?? null;
            $message = "تم اضافة منجز معاملة {$request->name_ar} ";
            $this->log($user_id, $message);
        }

        return $data;
    }

    public function update($id,  Request $request)
    {

        $data = $this->transactionsCompletedRepository->update($id, $request);

        if ($data) {
            $user_id =  Auth::user()->id ?? null;
            $message = "تم تحديث منجز معاملة {$request->name_ar} ";
            $this->log($user_id, $message);
        }

        return $data;
    }


    public function destroy($id)
    {
        $data = $this->transactionsCompletedRepository->destroy($id);

        if ($data) {
            $user_id =  Auth::user()->id ?? null;
            $message = "تم حذف منجز معاملة";
            $this->log($user_id, $message);
        }

        return $data;
    }
}
