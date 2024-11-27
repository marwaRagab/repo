<?php

namespace App\Repositories\HumanResources;


use Inertia\Inertia;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use App\Models\CommuncationMethod;
use App\Models\TransactionCompleted;
use Illuminate\Support\Facades\Auth;
use App\Interfaces\HumanResources\CommuncationMethodRepositoryInterface;

class CommuncationMethodRepository implements CommuncationMethodRepositoryInterface
{

    public function index()
    {
        $data =  CommuncationMethod::with('user')->get();

        $title = "طرق التواصل";
        $breadcrumb = array();
        $breadcrumb[0]['title'] = " الرئيسية";
        $breadcrumb[0]['url'] = route("dashboard");
        $breadcrumb[1]['title'] = "الموارد البشرية";
        $breadcrumb[1]['url'] = route("dashboard");
        $breadcrumb[2]['title'] = $title;
        $breadcrumb[2]['url'] = 'javascript:void(0);';

        $view = 'HumanResources.communication';
        return view(
            'layout',
            compact('title', 'view', 'breadcrumb', 'data')
        );
    }

    public function store(Request $request)
    {
        $request->validate([
            'name_ar' => 'required|string|max:255',
            'name_en' => 'required|string|max:255',
        ]);

        $data = new CommuncationMethod();
        $data->name_ar = $request->name_ar;
        $data->name_en = $request->name_en;
        $data->created_by = Auth::user()->id;
        $data->save();

        return redirect()->route('communication.index')->with('success', 'تم إضافة طريقة تواصل بنجاح');
    }


    public function update($id, Request $request)
    {
        $request->validate([
            'name_ar' => 'nullable|string|max:255',
            'name_en' => 'nullable|string|max:255',
        ]);

        $data = CommuncationMethod::findOrFail($id);
        $data->name_ar = $request->name_ar ?? $data->name_ar;
        $data->name_en = $request->name_en ?? $data->name_en;
        $data->updated_by = Auth::user()->id;

        $data->save();

        return redirect()->route('communication.index')->with('success', 'تم تحديث طريقة التواصل بنجاح');
    }

    public function destroy($id)
    {
        $data = CommuncationMethod::findOrFail($id);
        $data->delete();

        return redirect()->route('communication.index')->with('success', 'تم حذف طريقة التواصل بنجاح');
    }
}
