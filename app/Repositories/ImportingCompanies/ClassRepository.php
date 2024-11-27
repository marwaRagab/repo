<?php

namespace App\Repositories\ImportingCompanies;


use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Interfaces\ImportingCompanies\ClassRepositoryInterface;
use App\Models\Company;
use App\Models\ProductClass;

class ClassRepository implements ClassRepositoryInterface
{
    public function index()
    {
        $classes = ProductClass::all();

        $title = "الاصناف";
        $breadcrumb = array();
        $breadcrumb[0]['title'] = " الرئيسية";
        $breadcrumb[0]['url'] = route("dashboard");
        $breadcrumb[1]['title'] = "الشركات الموردة";
        $breadcrumb[1]['url'] = route("dashboard");
        $breadcrumb[2]['title'] = $title;
        $breadcrumb[2]['url'] = 'javascript:void(0);';

        $view = 'importingCompanies.classes';
        return view(
            'layout',
            compact('title', 'view', 'breadcrumb', 'classes')
        );
    }

    public function store(Request $request)
    {
        $request->validate([
            'name_ar' => 'required|string|max:255',
            'name_en' => 'required|string|max:255',
        ]);

        $class = new ProductClass();
        $class->name_ar = $request->name_ar;
        $class->name_en = $request->name_en;
        $class->created_by = Auth::user()->id;
        $class->save();

        return redirect()->route('class.index')->with('success', 'تم إضافة صنف بنجاح');
    }


    public function update($id, Request $request)
    {
        $request->validate([
            'name_ar' => 'nullable|string|max:255',
            'name_en' => 'nullable|string|max:255',
        ]);

        $class = ProductClass::findOrFail($id);
        $class->name_ar = $request->name_ar;
        $class->name_en = $request->name_en;
        $class->updated_by = Auth::user()->id;
        $class->save();


        return redirect()->route('class.index')->with('success', 'تم تحديث الصنف بنجاح');
    }
}
