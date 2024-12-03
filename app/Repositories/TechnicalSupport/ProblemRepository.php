<?php

namespace App\Repositories\TechnicalSupport;

use App\Interfaces\TechnicalSupport\ProblemRepositoryInterface;
use App\Models\Notification;
use App\Models\TechnicalSupport\Problem;
use App\Models\TechnicalSupport\ProblemReply;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProblemRepository implements ProblemRepositoryInterface
{

    public function index($request)
    {
        $status = $request->input('status', '1');

        $data = ($status === 'all')

        ? Problem::with('user')->orderBy('created_at', 'desc')->get()
        : Problem::with('user')->where('status', $status)
            ->orderBy('created_at', 'desc')->get();

        $statusMapping = [
            1 => 'جديد',
            2 => 'قيد التدقيق',
            3 => 'قيد العمل',
            4 => 'بانتظار الرد',
            5 => 'قيد المراجعة',
            6 => 'منجزة',
            7 => 'مغلقة',
        ];

        $statusCounts = [];
        foreach ($statusMapping as $status => $label) {
            $statusCounts[$status] = Problem::where('status', $status)->count();
        }

        $title = "الدعم الفني";
        $breadcrumb = array();
        $breadcrumb[0]['title'] = " الرئيسية";
        $breadcrumb[0]['url'] = route("dashboard");
        // $breadcrumb[1]['title'] = "الموارد البشرية";
        // $breadcrumb[1]['url'] = route("dashboard");
        $breadcrumb[1]['title'] = $title;
        $breadcrumb[1]['url'] = 'javascript:void(0);';

        $view = 'TechnicalSupport.Problem.index';
        return view(
            'layout',
            compact('title', 'view', 'breadcrumb', 'data', 'statusMapping', 'statusCounts', 'status')
        );
    }

    public function show($id)
    {
        $data = Problem::with('user')->findOrFail($id);

        $replies = ProblemReply::with('user')->where('problem_id', $id)->get();

        $statusMapping = [
            1 => 'جديد',
            2 => 'قيد التدقيق',
            3 => 'قيد العمل',
            4 => 'بانتظار الرد',
            5 => 'قيد المراجعة',
            6 => 'منجزة',
            7 => 'مغلقة',
        ];
        $title = "مشاهدة المشكلة";
        $breadcrumb = array();
        $breadcrumb[0]['title'] = " الرئيسية";
        $breadcrumb[0]['url'] = route("dashboard");
        $breadcrumb[1]['title'] = "الدعم الفني";
        $breadcrumb[1]['url'] = route("supportProblem.index");
        $breadcrumb[2]['title'] = $title;
        $breadcrumb[2]['url'] = 'javascript:void(0);';

        $view = 'TechnicalSupport.Problem.show';
        return view(
            'layout',
            compact('title', 'view', 'breadcrumb', 'data', 'statusMapping', 'replies')
        );
    }

    public function store($request)
    {

        $request->validate([
            'installement_id' => 'required|exists:installment,id',
            'title' => 'required|string|max:255',
            'link' => 'required|string|max:255',
            'descr' => 'required|string|max:255',
            'file' => 'required|file|mimes:jpeg,jpg,png,gif,mp4,mov,avi,pdf|max:10240',
        ]);

        $data = new Problem();
        $data->installement_id = $request->installement_id;
        $data->title = $request->title;
        $data->link = $request->link;
        $data->descr = $request->descr;
        if ($request->hasFile('file')) {
            $data->file = $request->file('file')->store('uploads/new_photos', 'public');
        }
        $data->user_id = Auth::user()->id;
        $data->save();

        $support_users = User::where('support', 1)->get();

        foreach ($support_users as $one) {

            $notification = new Notification();
            $notification->title = 'تم اضافة مشكلة جديدة بالدعم الفني';
            $notification->descr = '';
            $notification->user_id = $one->id;
            $notification->problem_id = $data->id;
            if ($request->hasFile('file')) {
                $notification->attachment = $request->file('file')->store('uploads/new_photos', 'public');
            }
            $notification->created_at = now();
            $notification->save();

        }
        return redirect()->route('supportProblem.index')->with('success', 'تم إضافة المشكلة بنجاح');
    }

    public function updateStatus($id, Request $request)
    {
        $request->validate([
            'status' => 'required|in:1,2,3,4,5,6,7',
        ]);

        $data = Problem::findOrFail($id);
        $data->status = $request->status;
        $data->updated_at = now();
        $data->save();

        return redirect()->route('supportProblem.show', $data->id)->with('success', 'تم تحديث حالة المشكلة بنجاح');
    }

    public function addReply($request)
    {
        $request->validate([
            'problem_id' => 'required|exists:problem_solving,id',
            'descr' => 'required|string|max:255',
            'file' => 'required|file|mimes:jpeg,jpg,png,gif,mp4,mov,avi,pdf|max:10240',
        ]);

        $data = new ProblemReply();
        $data->problem_id = $request->problem_id;
        $data->descr = $request->descr;
        if ($request->hasFile('file')) {
            $data->file = $request->file('file')->store('uploads/new_photos', 'public');
        }
        $data->user_id = Auth::user()->id;
        $data->save();

        $notification = new Notification();
        $notification->title = "تعليق جديد على مشكلة في الدعم الفني";
        $notification->descr = $request->descr;
        $notification->user_id = Auth::user()->id;
        $notification->problem_id = $data->problem_id;
        if ($request->hasFile('file')) {
            $notification->attachment = $request->file('file')->store('uploads/new_photos', 'public');
        }
        $notification->created_at = now();
        $notification->save();

        return redirect()->route('supportProblem.show', ['id' => $request->problem_id])
            ->with('success', 'تم إضافة رد على المشكلة بنجاح');
    }
}
