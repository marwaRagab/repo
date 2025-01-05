<?php

namespace App\Http\Controllers\Installment;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Installment;
use App\Models\Eqrars_details;

class PapersInstallController extends Controller
{
    public function index (Request $request, $status)
    {
        // عرض جميع الأوراق

        $title = 'المحفوظات';
        $all_counters = [
            'not_finished_counter' => Eqrars_details::where('paper_received_checked', 0)->count(),

            'received_counter' => Eqrars_details::where('paper_received_checked', 1)->count(),

            'tadqeeq_counter' => Installment::with(['client', 'paper','eqrarsDetail'])
            ->whereHas('paper', function ($query) {
                $query->where('slug', 'my_index');
            }) ->whereHas('eqrarsDetail', function ($query) {
                $query->where('paper_received_checked', 1);
            })
            ->where('type', 'installment')
            ->where('tadqeeq', 1)
            ->where('manage_review', 0)
            ->where('status', 'finished')->count(),

            'manage_review_counter' =>Installment::with(['client', 'paper', 'eqrarsDetail'])
            ->whereHas('paper', function ($query) {
                $query->where('slug', 'tadqeeq');
            })
            ->whereHas('eqrarsDetail', function ($query) {
                $query->where('paper_received_checked', 1);
            })
            ->where('type', 'installment')
            ->where('tadqeeq', 1)
            ->where('manage_review', 1)
            ->where('status', 'finished')
            ->where('tadqeeq_archive', 0)->count(),

            'archive_counter' => Installment::with(['client', 'paper', 'eqrarsDetail'])
            ->whereHas('paper', function ($query) {
                $query->where('slug', 'manage_review');
            })
            ->whereHas('eqrarsDetail', function ($query) {
                $query->where('paper_received_checked', 1)->where('paper_received', 1);
            })
            ->where('type', 'installment')
            ->where('status', 'finished')

            ->where('tadqeeq', 1)
            ->where('manage_review', 1)
            ->where('tadqeeq_archive', 1)
            ->where('archive_finished', 0)->count(),

            'archive_finished_counter' =>Installment::with(['client', 'paper', 'eqrarsDetail'])
            ->whereHas('paper', function ($query) {
                $query->where('slug', 'manage_review');
            })
            ->whereHas('eqrarsDetail', function ($query) {
                $query->where('paper_received_checked', 1)->where('paper_received', 1);
            })
            ->where('type', 'installment')
            ->where('status', 'finished')

            ->where('tadqeeq', 1)
            ->where('manage_review', 1)
            ->where('tadqeeq_archive', 1)
            ->where('archive_finished', 1)
            ->where('archive_received', 0)->count(),
        ];
        $papers = []; // Fetch data from the database

        $breadcrumb = array();
        $breadcrumb[0]['title'] = " الرئيسية";
        $breadcrumb[0]['url'] = route("dashboard");
        $breadcrumb[1]['title'] = $title;
        $breadcrumb[1]['url'] = 'javascript:void(0);';
        $data['view'] = 'installment.papers.index';

        return view('layout', $data, compact('breadcrumb','papers','title','all_counters'));
    }
    public function getAllData(Request $request, $slug = null)
    {
        // استعلام أساسي باستخدام العلاقة بين Eqrars_details و Installment
        $query = Eqrars_details::with(['installment.client'])
            ->when($slug === 'not_finished', function ($q) {
                $q->where('paper_received_checked', 0);
            })
            ->when($slug === 'received', function ($q) {
                $q->where('paper_received_checked', 1);
            })
            ->when($slug === 'tadqeeq', function ($q) {
                $q->whereHas('installment', function ($subQuery) {
                    $subQuery->where('slug', 'tadqeeq')->where('tadqeeq', 1);
                });
            })
            ->when($slug === 'manage_review', function ($q) {
                $q->whereHas('installment', function ($subQuery) {
                    $subQuery->where('slug', 'manage_review')->where('manage_review', 1);
                });
            })
            ->when($slug === 'archive', function ($q) {
                $q->whereHas('installment', function ($subQuery) {
                    $subQuery->where('slug', 'archive');
                });
            })
            ->when($slug === 'archive_finished', function ($q) {
                $q->whereHas('installment', function ($subQuery) {
                    $subQuery->where('slug', 'archive_finished');
                });
            });

        return DataTables::of($query)
            ->addIndexColumn()
            ->addColumn('transaction_number', function ($detail) {
                return $detail->installment->id ?? '-';
            })
            ->addColumn('client_name', function ($detail) {
                return $detail->installment->client->name ?? '-';
            })
            ->addColumn('received_date', function ($detail) {
                return $detail->installment->date ?? '-';
            })
            ->addColumn('paper_img_dir', function ($detail) {
                return $detail->img_dir;
            })
            ->addColumn('actions', function ($detail) {
                return '<a href="' . route('installment.papers.edit', $detail->id) . '" class="btn btn-primary">تعديل</a>';
            })
            ->rawColumns(['actions'])
            ->toJson();
    }

     /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('installment.papers.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
        ]);

        // Logic to store paper in the database
        // Example: Paper::create($validated);

        return redirect()->route('installment.papers.index')->with('success', 'Paper created successfully!');
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        // Example: Fetch specific paper data
        // $paper = Paper::findOrFail($id);
        return view('installment.papers.show');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        // Example: Fetch specific paper data
        // $paper = Paper::findOrFail($id);
        return view('installment.papers.edit');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
        ]);

        // Example: Update paper data
        // $paper = Paper::findOrFail($id);
        // $paper->update($validated);

        return redirect()->route('installment.papers.index')->with('success', 'Paper updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        // Example: Delete paper data
        // $paper = Paper::findOrFail($id);
        // $paper->delete();

        return redirect()->route('installment.papers.index')->with('success', 'Paper deleted successfully!');
    }
}