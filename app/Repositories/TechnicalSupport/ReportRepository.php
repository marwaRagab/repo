<?php
namespace App\Repositories\TechnicalSupport;

use App\Interfaces\TechnicalSupport\ReportRepositoryInterface;
use App\Models\TechnicalSupport\Problem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ReportRepository implements ReportRepositoryInterface
{
    public function index()
    {
        // Add logic to handle the index action

        $statuses = [
            1 => 'جديد',
            2 => 'قيد التدقيق',
            3 => 'قيد العمل',
            4 => 'بانتظار الرد',
            5 => 'قيد المراجعة',
            6 => 'تم الانتهاء منها',
            7 => 'منجزة',
        ];

        $problemsByStatus = [];
        foreach ($statuses as $statusId => $statusName) {
            $problemsByStatus[$statusId] = Problem::where('status', $statusId)->get();
        }
        $title = 'تقارير الدعم الفني';

        $breadcrumb             = [];
        $breadcrumb[0]['title'] = " الرئيسية";
        $breadcrumb[0]['url']   = route("dashboard");

        $breadcrumb[1]['title'] = $title;
        $breadcrumb[1]['url']   = 'javascript:void(0);';
        $view                   = 'TechnicalSupport.Report.index';
        return view(
            'layout',
            compact('title', 'view', 'breadcrumb', 'problemsByStatus', 'statuses')
        );
    }

    public function prbs_num(Request $request)
    {
        // Add logic to handle the prbs_num action

        $statuses = [
            1 => 'جديد',
            2 => 'قيد التدقيق',
            3 => 'قيد العمل',
            4 => 'بانتظار الرد',
            5 => 'قيد المراجعة',
            6 => 'تم الانتهاء منها',
            7 => 'منجزة',
        ];
        $priorities = [
            'high'   => 'عالية',
            'medium' => 'متوسطة',
            'low'    => 'منخفضة',
        ];
        // Count problems grouped by status

        $query = DB::table('problem_solving');

        // Apply date range filtering if provided
        if ($request->start_date && $request->end_date) {
            $query->whereBetween('created_at', [$request->start_date, $request->end_date]);
        }
        // Apply priority filtering if provided
        if ($request->priority) {
            $query->where('priority', $request->priority);
        }

       

        $problemsByStatus = $query
            ->select('status', DB::raw('COUNT(*) as total'))
            ->groupBy('status')
            ->pluck('total', 'status');
        $totalOpen = $problemsByStatus->only([1, 2, 3, 4, 5, 6, 7])->sum();
        //   $totalClosed = $problemsByStatus->only([6, 7])->sum();

        $title = 'تقرير';

        $breadcrumb             = [];
        $breadcrumb[0]['title'] = " الرئيسية";
        $breadcrumb[0]['url']   = route("dashboard");
        $breadcrumb[1]['title'] = " الدعم الفني";
        $breadcrumb[1]['url']   = route("supportProblem.index");
        $breadcrumb[2]['title'] = $title;
        $breadcrumb[2]['url']   = 'javascript:void(0);';
        $view                   = 'TechnicalSupport.Report.prbs_num';
        return view(
            'layout',
            compact('title', 'view', 'breadcrumb', 'statuses', 'problemsByStatus', 'totalOpen', 'priorities')
        );

    }

    public function timeline(Request $request)
    {
        $statuses = [
            1 => 'جديد',
            2 => 'قيد التدقيق',
            3 => 'قيد العمل',
            4 => 'بانتظار الرد',
            5 => 'قيد المراجعة',
            6 => 'تم الانتهاء منها',
            7 => 'منجزة',
        ];
        $priorities = [
            'high'   => 'عالية',
            'medium' => 'متوسطة',
            'low'    => 'منخفضة',
        ];

        $query = DB::table('problem_solving')
            ->select(
                'id as ticket_id',
                'created_at as start_date',
                'end_task as end_date',
                'priority',
                DB::raw('FLOOR(TIMESTAMPDIFF(MINUTE, created_at, end_task) / 1440) AS days'),
                DB::raw('FLOOR(MOD(TIMESTAMPDIFF(MINUTE, created_at, end_task), 1440) / 60) AS hours'),
                DB::raw('MOD(TIMESTAMPDIFF(MINUTE, created_at, end_task), 60) AS minutes')
            )
            ->whereNotNull('end_task');

        // Apply date filters
        if ($request->start_date) {
            $query->whereDate('created_at', '>=', $request->start_date);
        }
        if ($request->end_date) {
            $query->whereDate('created_at', '<=', $request->end_date);
        }

        // Apply priority filter
        if ($request->priority) {
            $query->where('priority', $request->priority);
        }

        $issues = $query->get();

        $title      = 'تقرير  ';
        $breadcrumb = [
            ['title' => "الرئيسية", 'url' => route("dashboard")],
            ['title' => "الدعم الفني", 'url' => route("supportProblem.index")],
            ['title' => $title, 'url' => 'javascript:void(0);'],
        ];
        $view = 'TechnicalSupport.Report.timeline';

        return view(
            'layout',
            compact('title', 'view', 'breadcrumb', 'statuses', 'priorities', 'issues')
        );
    }
    public function progress(Request $request)
    {
        $statuses = [
            1 => 'جديد',
            2 => 'قيد التدقيق',
            3 => 'قيد العمل',
            4 => 'بانتظار الرد',
            5 => 'قيد المراجعة',
            6 => 'تم الانتهاء منها',
            7 => 'منجزة',
        ];

        $priorities = [
            'high'   => 'عالية',
            'medium' => 'متوسطة',
            'low'    => 'منخفضة',
        ];

        // Query for completed issues and average resolution time per developer
        $completedIssues = DB::table('problem_solving')
            ->select(
                'developer_id',
                DB::raw('COUNT(id) AS completed_count'),
                DB::raw('AVG(TIMESTAMPDIFF(MINUTE, created_at, updated_at)) AS avg_resolution_time')
            )
            ->whereIn('status', [6, 7]) // Status indicating "completed"
            ->groupBy('developer_id');

        // Apply date range filtering if provided
        if ($request->start_date && $request->end_date) {
            $completedIssues->whereBetween('created_at', [$request->start_date, $request->end_date]);
        }

        $completedIssues = $completedIssues->get();

        // Query for pending issues per developer
        $pendingIssues = DB::table('problem_solving')
            ->select(
                'developer_id',
                DB::raw('COUNT(id) AS pending_count')
            )
            ->whereNotIn('status', [6, 7]) // Exclude completed statuses
            ->groupBy('developer_id');

        // Apply date range filtering if provided
        if ($request->start_date && $request->end_date) {
            $pendingIssues->whereBetween('created_at', [$request->start_date, $request->end_date]);
        }

        $pendingIssues = $pendingIssues->get();

        // Combine the data
        $userPerformance = [];
        foreach ($completedIssues as $completed) {
            $userPerformance[$completed->developer_id] = [
                'completed_count'     => $completed->completed_count,
                'avg_resolution_time' => $completed->avg_resolution_time,
                'pending_count'       => 0, // Default for pending count
            ];
        }

        foreach ($pendingIssues as $pending) {
            if (isset($userPerformance[$pending->developer_id])) {
                $userPerformance[$pending->developer_id]['pending_count'] = $pending->pending_count;
            } else {
                $userPerformance[$pending->developer_id] = [
                    'completed_count'     => 0,
                    'avg_resolution_time' => 0,
                    'pending_count'       => $pending->pending_count,
                ];
            }
        }

        // Add developer names
        foreach ($userPerformance as $developerId => &$data) {
            $developer                     = \App\Models\User::find($developerId); // Fetch developer details
            $data['name_ar']               = $developer ? $developer->name_ar : 'غير معروف';
            $userPerformance[$developerId] = $data;
        }

        $title = 'تقرير  ';

        $breadcrumb = [
            ['title' => "الرئيسية", 'url' => route("dashboard")],
            ['title' => "الدعم الفني", 'url' => route("supportProblem.index")],
            ['title' => $title, 'url' => 'javascript:void(0);'],
        ];
        $view = 'TechnicalSupport.Report.progress';

        return view(
            'layout',
            compact('title', 'breadcrumb', 'statuses', 'priorities', 'view', 'userPerformance')
        );
    }
}