<?php

namespace App\Repositories\TechnicalSupport;

use App\Models\User;
use App\Models\Department;
use Illuminate\Support\Str;
use App\Models\Notification;
use Illuminate\Http\Request;
use App\Models\SubDepartment;
use Illuminate\Support\Facades\Auth;
use App\Models\TechnicalSupport\Problem;
use Illuminate\Support\Facades\Validator;
use App\Models\TechnicalSupport\ProblemReply;
use App\Interfaces\TechnicalSupport\ProblemRepositoryInterface;

class ProblemRepository implements ProblemRepositoryInterface
{

    public function index($request)
    {
        // dd($request);
        $status = $request->input('status', '1');
        // dd($status);
        // $data = ($status === 'all')

        // ? Problem::with('user')->when($request->has('department_id') && $request->has('sub_department_id'),function($q) use ($request){
        //   return  $q->where('department_id','=',$request->department_id)->where('sub_department_id','=',$request->sub_department_id);
        // })->orderBy('created_at', 'desc')->get()
        // : Problem::with('user')->where('status', $status)
        //     ->orderBy('created_at', 'desc')->get();

    $query = Problem::with(['user', 'department'])
    ->when($status !== 'all', function ($q) use ($status) {
        $q->where('status', $status);
    })
    ->when(
        $request->filled('department_id') ,
        function ($q) use ($request) {
            $q->where('department_id', $request->department_id);
        }
    )->when(
         $request->filled('sub_department_id'),
        function ($q) use ($request) {
            $q->where('sub_department_id', $request->sub_department_id);
        }
    );

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

         $statusCounts = [];
    
         if($request->filled('sub_department_id') || $request->filled('department_id'))
         {
            $d = Problem::with('user')
            ->when(
                $request->filled('department_id') ,
                function ($q) use ($request) {
                    $q->where('department_id', $request->department_id);
                }
            )->when(
                $request->filled('sub_department_id'),
                function ($q) use ($request) {
                    $q->where('sub_department_id', $request->sub_department_id);
                }
            );
            foreach ($statusMapping as $status => $label) {
                $statusCounts[$status] = (clone $d)->where('status', $status)->count();
            }
         }
         else
         {
            foreach ($statusMapping as $status => $label) {
                $statusCounts[$status] = Problem::where('status', $status)->count();
            }
         }
       

     $data = $query->orderBy('created_at', 'desc')->get();

     $dpart = '';
    $subdpart = '';

    if ($request->filled('department_id')) {
        $dpart = ' - '. Department::find($request->department_id)?->name_ar ;
    }

    if ($request->filled('sub_department_id')) {
        $subdpart = ' - '.SubDepartment::find($request->sub_department_id)?->name_ar ;
    }


    $title = "الدعم الفني $dpart $subdpart";

        
        $breadcrumb = array();
        $breadcrumb[0]['title'] = " الرئيسية";
        $breadcrumb[0]['url'] = route("dashboard");
        // $breadcrumb[1]['title'] = "الموارد البشرية";
        // $breadcrumb[1]['url'] = route("dashboard");
        $breadcrumb[1]['title'] = $title;
        $breadcrumb[1]['url'] = 'javascript:void(0);';

        $department = Department::all();
        $developer = User::where('developer','=','1')->get();

        $view = 'TechnicalSupport.Problem.index';
        return view(
            'layout',
            compact('title', 'view', 'breadcrumb', 'data', 'statusMapping', 'statusCounts', 'status','department','developer' ,'request')
        );
    }

    public function show($id)
    {
        $pr = Problem::with(['user','developer','department','subdepartment'])->where('id', $id)->first();
        
        if ($pr == null) {
            return redirect()->back()->withErrors(['error' => 'تم حذف المشكلة!!']);

        }
        $data = Problem::with('user')->findOrFail($id);
        $replies = ProblemReply::with('user')->where('problem_id', $id)->get();

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

        // dd($request);
        $messages = [
            'title.required' => 'عنوان المشكلة اجباري.',
            'link.required' => 'رابط المشكلة اجباري',
            'descr.required' => 'وصف المشكلة اجباري',
        ];

        $validator = Validator::make($request->all(), [
            //   'installement_id' => 'exists:installment,id',
            'title' => 'required|string|max:255',
            'link' => 'required|string|max:255',
            'descr' => 'required|string|max:255',
            'file' => 'file|mimes:jpeg,jpg,png,gif,mp4,mov,avi,pdf|max:10240',
        ], $messages);
        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        } else {
            $data = new Problem();
            $data->installement_id = $request->installement_id;
            $data->title = $request->title;
            $data->link = $request->link;
            $data->descr = $request->descr;
            if ($request->hasFile('file')) {
                
                $fileName = time() . '_' . $request->file('file')->getClientOriginalName();
                $filePath = 'techical_support/' . $fileName;
                $request->file('file')->move(public_path('techical_support'), $fileName);
                $data->file = $filePath; // Save the relative path to the database
                
            }
            $data->department_id = $request->department;
            $data->sub_department_id = $request->sub_department;
            $data->priority =  $request->priority;
            $data->user_id = Auth::user()->id;
            $data->save();
        }

        $support_users = User::where('support', 1)->get();

        foreach ($support_users as $one) {

            $notification = new Notification();
            $notification->title = 'تم اضافة مشكلة جديدة بالدعم الفني';
            $notification->descr = '';
            $notification->user_id = $one->id;
            $notification->problem_id = $data->id;
            $notification->action = 'create';
            if ($request->hasFile('file')) {
                // $notification->attachment = $request->file('file')->store('uploads/new_photos', 'public');
                $notification->attachment = $data->file;
            }
            $notification->created_at = now();
            $notification->save();

        }
        return redirect()->route('supportProblem.index')->with('success', 'تم إضافة المشكلة بنجاح');
    }

    public function updateStatus($id, Request $request)
    {
        $request->validate([
            'status' => 'required|in:1,2,3,4,5,6,7,8',
        ]);

        $data = Problem::findOrFail($id);
        $data->status = $request->status;
        $data->updated_at = now();
        if($request->status == "6")
        {
            $data->end_task = now();
        }
        $data->save();

        $support_users = User::where('support', 1)->get();

        foreach ($support_users as $one) {
            $shortTitle = Str::limit($data->title, 20);
            $notification = new Notification();
            $notification->title = 'تم تحديث حالة المشكلة  ' . $shortTitle;
            $notification->descr = '';
            $notification->user_id = Auth::user()->id;
            $notification->problem_id = $data->id;
            $notification->action = 'status_change';
            if ($request->hasFile('file')) {
                // $notification->attachment = $request->file('file')->store('uploads/new_photos', 'public');
                $notification->attachment = $data->file;
            }
            $notification->created_at = now();
            $notification->save();
        }

        return redirect()->route('supportProblem.show', $data->id)->with('success', 'تم تحديث حالة المشكلة بنجاح');
    }

    public function addReply($request)
    {
        $request->validate([
            'problem_id' => 'required',
            'descr' => 'required|string',
            'file' => 'file|mimes:jpeg,jpg,png,gif,mp4,mov,avi,pdf|max:10240',
        ]);

        $data = new ProblemReply();
        $data->problem_id = $request->problem_id;
        $data->descr = $request->descr;
        if ($request->hasFile('file')) {
            // $data->file = $request->file('file')->store('uploads/new_photos', 'public');
            $fileName = time() . '_' . $request->file('file')->getClientOriginalName();
            $filePath = 'techical_support/' . $fileName;
            $request->file('file')->move(public_path('techical_support'), $fileName);
            $data->file = $filePath; // Save the relative path to the database
            
        }
        $data->user_id = Auth::user()->id;
        $data->save();

        if (Auth::user()->support == 1) {

            $pr = Problem::with('user')->where('id', $request->problem_id)->first();
            $notification = new Notification();
            $notification->title = "تعليق جديد على مشكلة في الدعم الفني";
            $notification->descr = $request->descr;
            $notification->user_id = $data->user_id;
            $notification->problem_id = $data->problem_id;
            $notification->action = 'reply';
            /* if ($request->hasFile('file')) {
            $notification->attachment = $request->file('file')->store('uploads/new_photos', 'public');
            }
             */
            $notification->created_at = now();
            $notification->save();
        } else {
            $support_users = User::where('support', 1)->get();

            foreach ($support_users as $one) {

                $notification = new Notification();
                $notification->title = 'تعليق جديد على مشكلة في الدعم الفني';
                $notification->descr = $request->descr ;
                $notification->user_id = $one->id;
                $notification->problem_id = $data->id;
                $notification->action = 'reply';
                if ($request->hasFile('file')) {
                    $notification->attachment = $data->file;
                }
                $notification->created_at = now();
                $notification->save();
            }
        }

        return redirect()->route('supportProblem.show', ['id' => $request->problem_id])
            ->with('success', 'تم إضافة رد على المشكلة بنجاح');
    }


    public function updatedeveloper($id, Request $request)
    {
        $request->validate([
            'dev' => 'required',
        ]);

        $data = Problem::findOrFail($id);
        $data->developer_id = $request->dev;
        $data->assign_date = now();
        $data->save();

        return redirect()->back()->with('success', 'تم تحديث   بنجاح');
    }
}