<?php

namespace App\Http\Controllers\TechnicalSupport;

use App\Models\Department;
use Illuminate\Http\Request;
use App\Models\SubDepartment;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Interfaces\TechnicalSupport\ProblemRepositoryInterface;

class ProblemController extends Controller
{
    protected $problemRepository;

    public function __construct(ProblemRepositoryInterface $problemRepository)
    {
        $this->problemRepository = $problemRepository;
    }
    public function index(Request $request)
    {
        $data = $this->problemRepository->index($request);

        if ($data) {
            $user_id = Auth::user()->id ?? null;
            $message = "تم الدخول لصفحة الدعم الفني ";
            $this->log($user_id, $message);
        }

        return $data;
    }
    public function show($id)
    {

        $data = $this->problemRepository->show($id);

        if ($data) {
            $user_id = Auth::user()->id ?? null;
            $message = "تم الدخول لمشكلة {$id} ";
            $this->log($user_id, $message);
        }

        return $data;
    }

    public function store(Request $request)
    {
        $data = $this->problemRepository->store($request);

        if ($data) {
            $user_id = Auth::user()->id ?? null;
            $message = ":تم اضافة مشكلة {$request->title} ";
            $this->log($user_id, $message);
        }

        return $data;
    }

    public function updateStatus($id, Request $request)
    {
        $data = $this->problemRepository->updateStatus($id, $request);

        if ($data) {
            $user_id = Auth::user()->id ?? null;
            $message = ":تم تحديث مشكلة {$id} ";
            $this->log($user_id, $message);
        }

        return $data;
    }

    public function addReply(Request $request)
    {
        $data = $this->problemRepository->addReply($request);

        if ($data) {
            $user_id = Auth::user()->id ?? null;
            $message = "تم اضافة رد على مشكلة: {$request->problem_id}";
            $this->log($user_id, $message);
        }

        return $data;
    }
    
    public function getDepartment()
    {

        $title = "الدعم الفني";
        $breadcrumb = array();
        $breadcrumb[0]['title'] = " الرئيسية";
        $breadcrumb[0]['url'] = route("dashboard");
        $breadcrumb[1]['title'] = $title;
        $breadcrumb[1]['url'] = 'javascript:void(0);';

        $data = Department::all();

        $view = 'TechnicalSupport.Problem.department';
        return view(
            'layout',
            compact('title', 'view', 'breadcrumb', 'data')
        );
    }

    public function getSubDepartments($departmentId)
    {
        // Assuming you have a relationship between departments and sub-departments
        $subDepartments = SubDepartment::where('department_id', $departmentId)->get();

        // Return the sub-departments in a JSON response
        return response()->json([
            'subDepartments' => $subDepartments
        ]);
    }


    public function updatedeveloper($id, Request $request)
    {
        $data = $this->problemRepository->updatedeveloper($id, $request);

        if ($data) {
            $user_id = Auth::user()->id ?? null;
            $message = ":تم تحديث مشكلة {$id} ";
            $this->log($user_id, $message);
        }
        return $data;
    }
}
