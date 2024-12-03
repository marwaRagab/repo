<?php

namespace App\Repositories\TechnicalSupport;

use App\Interfaces\TechnicalSupport\RequestRepositoryInterface;
use App\Models\Notification;
use App\Models\TechnicalSupport\RequestReply;
use App\Models\TechnicalSupport\SupportRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RequestRepository implements RequestRepositoryInterface
{

    public function index($request)
    {
        $status = $request->input('status', 1);

        $data = ($status === 'all')

            ? SupportRequest::with('user')->orderBy('created_at', 'desc')->get()
            : SupportRequest::with('user')->where('status', $status)
            ->orderBy('created_at', 'desc')->get();

        $statusMapping = [
            1 => 'جديد',
            2 => 'قيد التدقيق',
            3 => 'موافق عليها',
            4 => 'مرفوضة',
            5 => 'قيد العمل',
            6 => 'قيد المراجعة',
            7 => 'تم الانتهاء منها',
            8 => 'مغلقة',
        ];

        $statusCounts = [];
        foreach ($statusMapping as $status => $label) {
            $statusCounts[$status] = SupportRequest::where('status', $status)->count();
        }

        $title = "الطلبات";
        $breadcrumb = array();
        $breadcrumb[0]['title'] = " الرئيسية";
        $breadcrumb[0]['url'] = route("dashboard");
        // $breadcrumb[1]['title'] = "الموارد البشرية";
        // $breadcrumb[1]['url'] = route("dashboard");
        $breadcrumb[1]['title'] = $title;
        $breadcrumb[1]['url'] = 'javascript:void(0);';

        $view = 'TechnicalSupport.Request.index';
        return view(
            'layout',
            compact('title', 'view', 'breadcrumb', 'data', 'statusMapping', 'statusCounts', 'status')
        );
    }

    public function show($id)
    {
        $data = SupportRequest::with('user')->findOrFail($id);

        $replies = RequestReply::with('user')->where('problem_id', $id)->get();

        $statusMapping = [
            1 => 'جديد',
            2 => 'قيد التدقيق',
            3 => 'موافق عليها',
            4 => 'مرفوضة',
            5 => 'قيد العمل',
            6 => 'قيد المراجعة',
            7 => 'تم الانتهاء منها',
            8 => 'مغلقة',
        ];

        $title = "مشاهدة الطلب";
        $breadcrumb = array();
        $breadcrumb[0]['title'] = " الرئيسية";
        $breadcrumb[0]['url'] = route("dashboard");
        $breadcrumb[1]['title'] = "الطلبات";
        $breadcrumb[1]['url'] = route("supportRequest.index");
        $breadcrumb[2]['title'] = $title;
        $breadcrumb[2]['url'] = 'javascript:void(0);';

        $view = 'TechnicalSupport.Request.show';
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

        $data = new SupportRequest();
        $data->installement_id = $request->installement_id;
        $data->title = $request->title;
        $data->link = $request->link;
        $data->descr = $request->descr;
        if ($request->hasFile('file')) {
            $data->file = $request->file('file')->store('uploads/new_photos', 'public');
        }
        $data->user_id = Auth::user()->id;
        $data->save();

        // $notification = new Notification();
        // $notification->title = $request->title;
        // $notification->descr = $request->descr;
        // $notification->user_id = Auth::user()->id;
        // $notification->problem_id = $data->id;
        // if ($request->hasFile('file')) {
        //     $notification->attachment = $request->file('file')->store('uploads/new_photos', 'public');
        // }
        // $notification->created_at = now();
        // $notification->save();

        return redirect()->route('supportRequest.index')->with('success', 'تم إضافة الطلب بنجاح');
    }

    public function updateStatus($id, Request $request)
    {
        $request->validate([
            'status' => 'required|in:1,2,3,4,5,6,7,8',
        ]);

        $data = SupportRequest::findOrFail($id);
        $data->status = $request->status;
        $data->updated_at = now();
        $data->save();

        return redirect()->route('supportRequest.index', $data->id)->with('success', 'تم تحديث حالة الطلب بنجاح');
    }

    public function addReply($request)
    {
        $request->validate([
            'problem_id' => 'required|exists:prev_table_requests,id',
            'descr' => 'required|string|max:255',
            'file' => 'required|file|mimes:jpeg,jpg,png,gif,mp4,mov,avi,pdf|max:10240',
        ]);

        $data = new RequestReply();
        $data->problem_id = $request->problem_id;
        $data->descr = $request->descr;
        if ($request->hasFile('file')) {
            $data->file = $request->file('file')->store('uploads/new_photos', 'public');
        }
        $data->user_id = Auth::user()->id;
        $data->save();

        // $notification = new Notification();
        // $notification->title = "تعليق جديد على طلب في الدعم الفني";
        // $notification->descr = $request->descr;
        // $notification->user_id = Auth::user()->id;
        // $notification->problem_id = $data->problem_id;
        // if ($request->hasFile('file')) {
        //     $notification->attachment = $request->file('file')->store('uploads/new_photos', 'public');
        // }
        // $notification->created_at = now();
        // $notification->save();

        return redirect()->route('supportRequest.show', ['id' => $request->problem_id])
            ->with('success', 'تم إضافة رد على الطلب بنجاح');
    }
}
