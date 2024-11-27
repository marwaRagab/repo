<?php

namespace App\Repositories\ImportingCompanies;


use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Interfaces\ImportingCompanies\MarkRepositoryInterface;
use App\Models\Company;
use App\Models\Mark;

class MarkRepository implements MarkRepositoryInterface
{
    public function index()
    {
        $marks = Mark::with('company')->orderBy('id', 'desc')->get();
        $companies = Company::all();
  
        $title = "الماركات";
        $breadcrumb = array();
        $breadcrumb[0]['title'] = " الرئيسية";
        $breadcrumb[0]['url'] = route("dashboard");
        $breadcrumb[1]['title'] = "الشركات الموردة";
        $breadcrumb[1]['url'] = route("dashboard");
        $breadcrumb[2]['title'] = $title;
        $breadcrumb[2]['url'] = 'javascript:void(0);';

        $view = 'importingCompanies.marks';
        return view(
            'layout',
            compact('title', 'view', 'breadcrumb', 'marks', 'companies')
        );
    }

    public function store(Request $request)
    {
        $request->validate([
            'name_ar' => 'required|string|max:255',
            'name_en' => 'required|string|max:255',
            'company_id' => 'required|exists:companies,id',
            'img' => 'required|file|mimes:jpeg,png,jpg|max:2048',
            'discount' => 'required|int|max:100',
        ]);

        $mark = new Mark();
        $mark->name_ar = $request->name_ar;
        $mark->name_en = $request->name_en;
        $mark->company_id =  $request->company_id;
        $mark->discount = $request->discount;
        if ($request->hasFile('img')) {
            $mark->img = $request->file('img')->store('uploads/new_photos', 'public');
        }
        $mark->created_by = Auth::user()->id;
        $mark->save();

        return redirect()->route('mark.index')->with('success', 'تم إضافة ماركة بنجاح');
    }


    public function update($id, Request $request)
    {
        $request->validate([
            'name_ar' => 'nullable|string|max:255',
            'name_en' => 'nullable|string|max:255',
            'company_id' => 'nullable|exists:companies,id',
            'img' => 'nullable|file|mimes:jpeg,png,jpg|max:2048',
            'discount' => 'nullable|int|max:100',
        ]);

        $mark = Mark::findOrFail($id);
        $mark->name_ar = $request->name_ar;
        $mark->name_en = $request->name_en;
        $mark->company_id =  $request->company_id;
        $mark->discount = $request->discount;
        if ($request->hasFile('img')) {
            $mark->img = $request->file('img')->store('uploads/new_photos', 'public');
        }
        $mark->updated_by = Auth::user()->id;
        $mark->save();


        return redirect()->route('mark.index')->with('success', 'تم تحديث الماركة بنجاح');
    }
}
