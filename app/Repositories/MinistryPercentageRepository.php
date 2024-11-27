<?php

namespace App\Repositories;

use Inertia\Inertia;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use App\Models\Ministry_Percentage;
use Illuminate\Support\Facades\Auth;
use App\Interfaces\MinistryPercentageRepositoryInterface;


class MinistryPercentageRepository implements MinistryPercentageRepositoryInterface
{
    
    public function index()
    {

        $ministry_percentages = Ministry_Percentage::with('user')->get();

        $title = "نسب الوزارات ";

        $breadcrumb = array();
        $breadcrumb[0]['title'] = " الرئيسية";
        $breadcrumb[0]['url'] = route("dashboard");
 $breadcrumb[1]['title'] = $title;
        $breadcrumb[1]['url'] = 'javascript:void(0);';

        $view = 'setting.ministry_percentages';
        return view(
            'layout',
            compact('title', 'view', 'breadcrumb', 'ministry_percentages')
        );
       
    }

    public function show($id)
    {
        return Ministry_Percentage::findOrFail($id);
    }

    public function  create()
    {

    }
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'percent' => 'required|numeric|between:0,100',
        ]); 
        
        $data = new Ministry_Percentage;
        $data->name = $request->name;
        $data->percent = $request->percent;
        $data->created_by = Auth::user()->id ?? null;
        $data->updated_by = Auth::user()->id ?? null;
        $data->save();
        // return Permission::create($request->all());
        return redirect()->route('ministry_percentages.index')->with('success', 'ministry percentages created successfully .');
    }

    public function  edit($id)
    {
        return Ministry_Percentage::findOrFail($id);
    }

    public function update($id, Request $request)
    {
        $data = Ministry_Percentage::findOrFail($id);
        // dd($request->name_ar);
        $data->name = $request->name;
        $data->percent = $request->percent;
        $data->updated_by = Auth::user()->id ?? null;
        $data->save();
        return redirect()->route('ministry_percentages.index')->with('success', 'ministry percentages updated successfully .');    }

    public function destroy($id)
    {
        $data = Ministry_Percentage::findOrFail($id);

        $data->delete();
        return redirect()->route('ministry_percentages.index')->with('success', 'ministry percentages deleted successfully .');    }
}
