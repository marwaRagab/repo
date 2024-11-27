<?php

namespace App\Repositories;

use Carbon\Carbon;
use Inertia\Inertia;
use App\Models\Ministry;
use Illuminate\Http\Request;
// use App\Interfaces\MinistryRepositoryInterface;
use Yajra\DataTables\DataTables;
use App\Models\Ministry_Percentage;
use Illuminate\Support\Facades\Auth;
use App\Interfaces\MinistryRepositoryInterface;

class MinistryRepository implements MinistryRepositoryInterface
{
    
    public function index()
    {
        $ministry = Ministry::with('ministryPercentage' , 'user')->get();
        $ministryPercentages = Ministry_Percentage::all();

        $title = "الوزارات ";

        $breadcrumb = array();
        $breadcrumb[0]['title'] = " الرئيسية";
        $breadcrumb[0]['url'] = route("dashboard");
     $breadcrumb[1]['title'] = $title;
        $breadcrumb[1]['url'] = 'javascript:void(0);';

        $view = 'setting.ministry';
        return view(
            'layout',
            compact('title', 'view', 'breadcrumb', 'ministry','ministryPercentages')
        );
       
    }

    public function show($id)
    {
        return Ministry::findOrFail($id);
    }

    public function  create()
    {

    }
    public function store(Request $request)
    {
        $data = new Ministry;
        $data->name_ar = $request->name_ar;
        $data->name_en = $request->name_en;
        // $data->date = Carbon::createFromFormat('d-m-Y', )->format('Y-m-d H:i:s');
        $data->date = Carbon::parse(time: $request->date)->format('Y-m-d H:i:s');
        // $data->percent = $request->percent;
        $data->type = $request->type;
        $data->ministry_percentage_id = $request->ministry_percentage_id;
        $data->created_by = Auth::user()->id ?? null;
        $data->updated_by = Auth::user()->id ?? null;
        $data->save();
        // return Permission::create($request->all());
        return redirect()->route('ministry.index')->with('success', 'ministry created successfully .');    }

    public function  edit($id)
    {
        return Ministry::findOrFail($id);
    }

    public function update($id, Request $request)
    {
        $data = Ministry::findOrFail($id);
        // dd($request->name_ar);
        $data->name_ar = $request->name_ar;
        $data->name_en = $request->name_en;
        $data->date = $request->date;
        $data->type= $request->type;
        $data->ministry_percentage_id = $request->ministry_percentage_id;
        $data->updated_by = Auth::user()->id ?? null;
        $data->save();

        return redirect()->route('ministry.index')->with('success', 'ministry updated successfully .'); 
    }

    public function destroy($id)
    {
        $data = Ministry::findOrFail($id);

        $data->delete();

        return redirect()->route('ministry.index')->with('success', 'ministry deleted successfully .');       }
}
