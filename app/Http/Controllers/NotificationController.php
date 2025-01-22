<?php

namespace App\Http\Controllers;

use Illuminate\Support\Str;
use App\Models\Notification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\TechnicalSupport\Problem;
use App\Models\TechnicalSupport\ProblemReply;
use App\Interfaces\NotificationRepositoryInterface;

class NotificationController extends Controller
{
    protected $notificationRepository;

    public function __construct(NotificationRepositoryInterface $notificationRepository)
    {
        $this->notificationRepository = $notificationRepository;
    }
    public function index()
    {
        $data = $this->notificationRepository->index();

        if ($data) {
            $user_id = Auth::user()->id ?? null;
            $message = "تم الدخول على الاشعارات ";
            $this->log($user_id, $message);
        }

        return $data;
    }

    public function updateTab(Request $request)
    {
        // Validate the tab ID
        $request->validate([
            'tab_id' => 'required|string',
        ]);
        $substring = Str::afterLast($request->tab_id, '-');

        DB::table('notifications') // Replace 'users' with your table name
            ->where('id', $substring) // Assuming you want to update for the logged-in user
            ->update(['show' => 1]);

        return response()->json(['message' => 'Tab updated successfully']);

    }

    public function show($id)
    {
        $notification = Notification::find($id);
        $pr = Problem::with(['user','developer','department','subdepartment'])->where('id', $notification->problem_id)->first();
        if ($pr == null) {
            return redirect()->back()->withErrors(['error' => 'تم حذف المشكلة!!']);

        }
        $data = Problem::with('user')->findOrFail($notification->problem_id);
        $replies = ProblemReply::with('user')->where('problem_id', $notification->problem_id)->get();

        $statusMapping = [
            1 => 'جديد',
            2 => 'قيد التدقيق',
            3 => 'قيد العمل',
            4 => 'بانتظار الرد',
            5 => 'قيد المراجعة',
            6 => 'تم الانتهاء منها',
            7 => 'منجزة',
            // 8 => 'تم الانتهاء منها',
        ];

        $notification->update(['show' => 1]);
        
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
}
