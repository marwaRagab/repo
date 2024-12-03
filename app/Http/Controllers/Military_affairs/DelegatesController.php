<?php

namespace App\Http\Controllers\Military_affairs;

use Carbon\Carbon;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\military_affairs_notes;
use App\Models\military_affairs_deligation;
use App\Models\Military_affairs\Military_affair;
use App\Models\Military_affairs\Military_affairs_amount;


class DelegatesController extends Controller
{
    public function index()
    {
        $title = 'المسئولين ';

        $breadcrumb = array();
        $breadcrumb[0]['title'] = " الرئيسية";
        $breadcrumb[0]['url'] = route("dashboard");
        $breadcrumb[1]['title'] = "المسئولين";
        $breadcrumb[1]['url'] = route("military_affairs.delegates");
        $breadcrumb[2]['title'] = $title;
        $breadcrumb[2]['url'] = 'javascript:void(0);';

        $data = User::where('type' , 'emp')->get();
        //  $data = Installment::with(['user','client','eqrar_not_recieve','installment_months','militay_affairs'])->get();
        // if ($data) {
        //     $user_id = 1;
        //     //   $user_id =  Auth::user()->id,
        //     $message = "تم دخول صفحة الوسطاء";
        //     $this->log($user_id, $message);
        // }

        $view = 'military_affairs.delegates.index';
        return view(
            'layout',
            compact('title', 'view', 'breadcrumb', 'data')
        );
    }
    
    public function update(Request $request, $id)
    {
        // Find the item by its ID
        $item = User::findOrFail($id);

        // Update the set_delegate field
        $item->set_delegate = $request->input('set_delegate');
        $item->save();

        // Redirect or return a response as needed
        return redirect()->back()->with('success', 'Delegate status updated successfully.');
    }

    public function get_statistics()
    {
        $title = 'احصائيات المسئولين ';

        $breadcrumb = array();
        $breadcrumb[0]['title'] = " الرئيسية";
        $breadcrumb[0]['url'] = route("dashboard");
        $breadcrumb[1]['title'] = "المسئولين";
        $breadcrumb[1]['url'] = route("military_affairs.delegates.get_statistics");
        $breadcrumb[2]['title'] = $title;
        $breadcrumb[2]['url'] = 'javascript:void(0);';

        $data['users'] = User::where('type' , 'emp')->get();

        $data['delegates'] = military_affairs_deligation::get();
        //  $data = Installment::with(['user','client','eqrar_not_recieve','installment_months','militay_affairs'])->get();
        // if ($data) {
        //     $user_id = 1;
        //     //   $user_id =  Auth::user()->id,
        //     $message = "تم دخول صفحة الوسطاء";
        //     $this->log($user_id, $message);
        // }

        $view = 'military_affairs.delegates.get_statistics';
        return view(
            'layout',
            compact('title', 'view', 'breadcrumb', 'data')
        );
    }

    public function get_statistics_details($user_id)
    {
        $title = 'الملفات المفتوحة ';

        $breadcrumb = array();
        $breadcrumb[0]['title'] = " الرئيسية";
        $breadcrumb[0]['url'] = route("dashboard");
        $breadcrumb[1]['title'] = "الملفات المفتوحة";
        $breadcrumb[1]['url'] = route("military_affairs.delegates.get_statistics");
        $breadcrumb[2]['title'] = $title;
        $breadcrumb[2]['url'] = 'javascript:void(0);';

        $data['users'] = User::where('type' , 'emp')->get();

        $data['delegates'] = military_affairs_deligation::where('emp_id', $user_id)->where('end_date' , null)->with('militaryAffair')->get();
        // dd($data['delegates'] );
        // $data['delegates'] = Military_affair::where('emp_id', $data['delegate_user']->emp_id)->with('installment')->get();
        //  $data = Installment::with(['user','client','eqrar_not_recieve','installment_months','militay_affairs'])->get();
        // if ($data) {
        //     $user_id = 1;
        //     //   $user_id =  Auth::user()->id,
        //     $message = "تم دخول صفحة الوسطاء";
        //     $this->log($user_id, $message);
        // }

        $view = 'military_affairs.delegates.get-statistics-details';
        return view(
            'layout',
            compact('title', 'view', 'breadcrumb', 'data')
        );
    }

    public function get_statistics_deligations($user_id)
    {
        $title = 'الملفات المغلقة ';

        $breadcrumb = array();
        $breadcrumb[0]['title'] = " الرئيسية";
        $breadcrumb[0]['url'] = route("dashboard");
        $breadcrumb[1]['title'] = "الاحصائيات";
        $breadcrumb[1]['url'] = route("military_affairs.delegates.get_statistics");
        $breadcrumb[2]['title'] = $title;
        $breadcrumb[2]['url'] = 'javascript:void(0);';

        $data['users'] = User::where('type' , 'emp')->get();

        $data['delegates'] = military_affairs_deligation::where('emp_id', $user_id)->whereNotNull('end_date')->with('militaryAffair')->get();
        // dd($data['delegates'] );
        // $data['delegates'] = Military_affair::where('emp_id', $data['delegate_user']->emp_id)->with('installment')->get();
        //  $data = Installment::with(['user','client','eqrar_not_recieve','installment_months','militay_affairs'])->get();
        // if ($data) {
        //     $user_id = 1;
        //     //   $user_id =  Auth::user()->id,
        //     $message = "تم دخول صفحة الوسطاء";
        //     $this->log($user_id, $message);
        // }

        $view = 'military_affairs.delegates.get-statistics-deligations';
        return view(
            'layout',
            compact('title', 'view', 'breadcrumb', 'data')
        );
    }
    public function get_statistics_notes_details($user_id)
    {
        $title = 'الملاحظات ';

        $breadcrumb = array();
        $breadcrumb[0]['title'] = " الرئيسية";
        $breadcrumb[0]['url'] = route("dashboard");
        $breadcrumb[1]['title'] = "الاحصائيات";
        $breadcrumb[1]['url'] = route("military_affairs.delegates.get_statistics");
        $breadcrumb[2]['title'] = $title;
        $breadcrumb[2]['url'] = 'javascript:void(0);';

        $data['users'] = User::where('type' , 'emp')->get();

        $data['delegates'] = military_affairs_notes::where('created_by', $user_id)->get();
        // dd($data['delegates'] );
        // $data['delegates'] = Military_affair::where('emp_id', $data['delegate_user']->emp_id)->with('installment')->get();
        //  $data = Installment::with(['user','client','eqrar_not_recieve','installment_months','militay_affairs'])->get();
        // if ($data) {
        //     $user_id = 1;
        //     //   $user_id =  Auth::user()->id,
        //     $message = "تم دخول صفحة الوسطاء";
        //     $this->log($user_id, $message);
        // }

        $view = 'military_affairs.delegates.get-statistics-notes-details';
        return view(
            'layout',
            compact('title', 'view', 'breadcrumb', 'data')
        );
    }

    public function get_statistics_lawaffaires($user_id)
    {
        $title = 'الملاحظات ';

        $breadcrumb = array();
        $breadcrumb[0]['title'] = " الرئيسية";
        $breadcrumb[0]['url'] = route("dashboard");
        $breadcrumb[1]['title'] = "الاحصائيات";
        $breadcrumb[1]['url'] = route("military_affairs.delegates.get_statistics");
        $breadcrumb[2]['title'] = $title;
        $breadcrumb[2]['url'] = 'javascript:void(0);';
        
        // Iterate through the Military_affairs collection to get each id
        $data['delegates'] = Military_affairs_amount::where('user_id', $user_id)->get();
        // dd($data['delegates'] );
        // $data['delegates'] = Military_affair::where('emp_id', $data['delegate_user']->emp_id)->with('installment')->get();
        //  $data = Installment::with(['user','client','eqrar_not_recieve','installment_months','militay_affairs'])->get();
        if ($data) {
            // $user_id = 1;
              $user_id =  Auth::user()->id;
            $message = "تم دخول صفحة احصائيات استعلام رصيد التنفيذ";
            $this->log($user_id, $message);
        }

        $view = 'military_affairs.delegates.get-statistics-lawaffaires';
        return view(
            'layout',
            compact('title', 'view', 'breadcrumb', 'data')
        );
    }
    public function get_statistics_emp($user_id)
    {
        $title = 'إحصائيات المستخدم';
        $breadcrumb = [
            ['title' => "الرئيسية", 'url' => route("dashboard")],
            ['title' => "الإحصائيات", 'url' => route("military_affairs.delegates.get_statistics")],
            ['title' => $title, 'url' => 'javascript:void(0);']
        ];

        $month = request('month');
        $monthRange = request('month_range');
        $currentDate = now();
        $startDate = null;

        if ($monthRange) {
            $startDate = $currentDate->copy()->subMonths($monthRange);
        } elseif ($month) {
            $monthStart = \Carbon\Carbon::createFromFormat('Y-m', $month)->startOfMonth();
            $monthEnd = $monthStart->copy()->endOfMonth();
            $startDate = $monthStart;
            $currentDate = $monthEnd;
        }

        $delegations = military_affairs_deligation::where('emp_id', $user_id)
            ->when($startDate, function ($query) use ($startDate, $currentDate) {
                $query->whereBetween('assign_date', [$startDate->format('Y-m-d'), $currentDate->format('Y-m-d')]);
            })
            ->get();

        $departments = [
            'open_file' => 'فتح ملف',
            'execute_alert' => 'إعلان تنفيذ',
            'images' => 'الصور',
            'Military_certificate' => 'شهادة عسكرية',
            'case_proof' => 'إثبات حالة',
            'stop_travel' => 'منع سفر',
            'stop_car' => 'حجز سيارات',
            'stop_bank' => 'حجز بنوك',
            'stop_salary' => 'حجز راتب',
        ];

        $statistics = [];
        foreach ($departments as $key => $name) {
            $count = $this->countFilesType($user_id, $key, []);
            $countDays = $this->getCountDays($user_id, $key, []);
            $noteCountDays = $this->countNotesType($user_id, $key, []);
        
            // Calculate the average (you can adjust this calculation as needed)
            $average = $countDays > 0 ? $count / $countDays : 0;
        
            $statistics[$key] = [
                'department' => $name,
                'count' => $count,
                'count_days' => $countDays,
                'note_count_days' => $noteCountDays,
                'average' => number_format($average, 2), // Format the average to 2 decimal places
            ];
        }

        $this->log(Auth::id(), "تم دخول صفحة إحصائيات المستخدم ID: $user_id");

        $user = $user_id;
        $view = 'military_affairs.delegates.get-statistics-emp';
        return view(
            'layout',
            compact('title', 'view', 'breadcrumb', 'statistics','user')
        );
    }
    
    public function countFilesType($id, $type, $where)
{
    $baseQuery = DB::table('military_affairs')
        ->join('installment', 'military_affairs.installment_id', '=', 'installment.id')
        ->join('clients', 'installment.client_id', '=', 'clients.id')
        ->join('military_affairs_deligations', 'military_affairs.id', '=', 'military_affairs_deligations.military_affairs_id')
        ->where('military_affairs_deligations.emp_id', $id)
        ->where('military_affairs.archived', 0)
        ->where('installment.finished', 0);

    switch ($type) {
        case 'open_file':
            $baseQuery->whereNotNull('military_affairs_deligations.open_file_date')
                ->whereNull('end_date')
                ->where('military_affairs.status', 'military');
            break;
        case 'execute_alert':
            $baseQuery->whereNotNull('execute_date')
                ->where('military_affairs.status', 'execute_alert')
                ->where('military_affairs.jalasat_alert_status', '!=', 'accepted')
                ->whereNull('end_date');
            break;
        // Add similar conditions for other types as needed
    }

    return $baseQuery->where($where)->count();
}

public function countNotesType($id, $type, $where2)
{
    $count = DB::table('military_affairs')
        ->join('installment', 'military_affairs.installment_id', '=', 'installment.id')
        ->join('clients', 'installment.client_id', '=', 'clients.id')
        ->join('military_affairs_notes', 'military_affairs.id', '=', 'military_affairs_notes.military_affairs_id')
        ->where('military_affairs_notes.user_id', $id)
        ->whereIn('military_affairs_notes.replay', ['note', 'answered', 'refused'])
        ->where('military_affairs_notes.cat2', $type)
        ->where('military_affairs.archived', 0)
        ->where('installment.finished', 0)
        ->count();

    return $count ?: 0; // Return 0 if count is null
}

public function getCountDays($emp_id, $type, $where2)
{
    $items = DB::table('military_affairs')
        ->join('installment', 'military_affairs.installment_id', '=', 'installment.id')
        ->join('clients', 'installment.client_id', '=', 'clients.id')
        ->join('military_affairs_deligations', 'military_affairs.id', '=', 'military_affairs_deligations.military_affairs_id')
        ->whereNull('military_affairs_deligations.end_date')
        ->where('military_affairs_deligations.emp_id', $emp_id)
        ->select('military_affairs_deligations.*', 'clients.job_type')
        ->get();

    $totalDays = 0;
    $currentTime = now();

    foreach ($items as $item) {
        $dateField = match ($type) {
            'open_file' => $item->open_file_date,
            'execute_alert' => $item->execute_date,
            'images' => $item->image_date,
            'case_proof' => $item->case_proof_date,
            'Military_certificate' => $item->certificate_date,
            'stop_travel' => $item->travel_date,
            'stop_car' => $item->car_date,
            'stop_bank' => $item->bank_date,
            'stop_salary' => $item->salary_date,
            default => $item->assign_date,
        };

        if ($dateField && !$item->end_date) {
            $totalDays += Carbon::createFromTimestamp($dateField)->diffInDays($currentTime);
        }
    }

    return $totalDays;
}

}
