<?php

namespace App\Repositories;

use Inertia\Inertia;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\Auth;
use App\Models\Installment_Percentage;
use App\Interfaces\InstallmentPercentageRepositoryInterface;


class InstallmentPercentageRepository implements InstallmentPercentageRepositoryInterface
{
    
    public function index()
    {
        
        $installment__percentages = Installment_Percentage::with('user')->get();

        $title = "نسب التقسيط ";

        $breadcrumb = array();
        $breadcrumb[0]['title'] = " الرئيسية";
        $breadcrumb[0]['url'] = route("dashboard");
       $breadcrumb[1]['title'] = $title;
        $breadcrumb[1]['url'] = 'javascript:void(0);';

        $view = 'setting.installment__percentages';
        return view(
            'layout',
            compact('title', 'view', 'breadcrumb', 'installment__percentages')
        );
       
    }

    public function show($id)
    {
        return Installment_Percentage::findOrFail($id);
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
        
        $data = new Installment_Percentage;
        $data->name = $request->name;
        $data->percent = $request->percent;
        $data->created_by = Auth::user()->id ?? null;
        $data->updated_by = Auth::user()->id ?? null;
        $data->save();
        // return Permission::create($request->all());
        return redirect()->route('installment__percentages.index')->with('success', 'Installment Percentage created successfully .');
    }

    public function  edit($id)
    {
        return Installment_Percentage::findOrFail($id);
    }

    public function update($id, Request $request)
    {
        $data = Installment_Percentage::findOrFail($id);
        // dd($request->name_ar);
        $data->name = $request->name;
        $data->percent = $request->percent;
        $data->updated_by = Auth::user()->id ?? null;
        $data->save();
        return redirect()->route('installment__percentages.index')->with('success', 'Installment Percentage updated successfully .');
    }

    public function destroy($id)
    {
        $data = Installment_Percentage::findOrFail($id);

        // Perform soft delete
        $data->delete();
        return redirect()->route('installment__percentages.index')->with('success', 'Installment Percentage deleted successfully .');
    }
}
