<?php

namespace App\Repositories;

use Carbon\Carbon;
use Inertia\Inertia;
use App\Models\WorkingIncome;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use App\Models\Ministry_Percentage;
use Illuminate\Support\Facades\Auth;
use App\Interfaces\WorkingIncomeRepositoryInterface;

class WorkingIncomeRepository implements WorkingIncomeRepositoryInterface
{
    
    public function index()
    {
        $WorkingIncome = WorkingIncome::with('ministryPercentage' , 'user')->get();
        $ministryPercentages = Ministry_Percentage::all();

        $title = "جهات العمل ";

        $breadcrumb = array();
        $breadcrumb[0]['title'] = " الرئيسية";
        $breadcrumb[0]['url'] = route("dashboard");
      $breadcrumb[1]['title'] = $title;
        $breadcrumb[1]['url'] = 'javascript:void(0);';

        $view = 'setting.working_income';
        return view(
            'layout',
            compact('title', 'view', 'breadcrumb', 'WorkingIncome','ministryPercentages')
        );
       
    }

    public function show($id)
    {
        return WorkingIncome::findOrFail($id);
    }

    public function  create()
    {

    }
    public function store(Request $request)
    {
        $data = new WorkingIncome;
        $data->name_ar = $request->name_ar;
        $data->name_en = $request->name_en;
        // $data->date = Carbon::createFromFormat('d-m-Y', )->format('Y-m-d H:i:s');
        $data->date = Carbon::parse(time: $request->date)->format('Y-m-d H:i:s');
        // $data->percent = $request->percent;
        $data->ministry_percentage_id = $request->ministry_percentage_id;
        $data->created_by = Auth::user()->id ?? null;
        $data->updated_by = Auth::user()->id ?? null;
        $data->save();
        // return Permission::create($request->all());
        return redirect()->route('WorkingIncome.index')->with('success', 'Working Income created successfully .');    }

    public function  edit($id)
    {
        return WorkingIncome::findOrFail($id);
    }

    public function update($id, Request $request)
    {
        $data = WorkingIncome::findOrFail($id);
        // dd($request->name_ar);
        $data->name_ar = $request->name_ar;
        $data->name_en = $request->name_en;
        $data->date = $request->date;
        $data->ministry_percentage_id = $request->ministry_percentage_id;
        $data->updated_by = Auth::user()->id ?? null;
        $data->save();

        return redirect()->route('WorkingIncome.index')->with('success', 'Working Income updated successfully .'); 
    }

    public function destroy($id)
    {
        $data = WorkingIncome::findOrFail($id);

        $data->delete();

        return redirect()->route('WorkingIncome.index')->with('success', 'Working Income deleted successfully .');       }
}
