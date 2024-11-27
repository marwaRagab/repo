<?php

namespace App\Repositories\HumanResources;


use Inertia\Inertia;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use App\Models\CommuncationMethod;
use App\Models\TransactionCompleted;
use Illuminate\Support\Facades\Auth;
use App\Interfaces\HumanResources\MemberRepositoryInterface;
use App\Models\member;
use App\Models\User;

class MemberRepository implements MemberRepositoryInterface
{
    public function index()
    {
        $members =  User::all();

        $title = "الموظفين";
        $breadcrumb = array();
        $breadcrumb[0]['title'] = " الرئيسية";
        $breadcrumb[0]['url'] = route("dashboard");
        $breadcrumb[1]['title'] = "الموارد البشرية";
        $breadcrumb[1]['url'] = route("dashboard");
        $breadcrumb[2]['title'] = $title;
        $breadcrumb[2]['url'] = 'javascript:void(0);';

        $view = 'HumanResources.members';
        return view(
            'layout',
            compact('title', 'view', 'breadcrumb', 'members')
        );
    }

    public function store(Request $request)
    {
        $request->validate([
            'name_ar' => 'required|string|max:255',
            'name_en' => 'required|string|max:255',
            'phone' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:' . User::class,
        ]);

        $member = new User();
        $member->name_ar = $request->name_ar;
        $member->name_en = $request->name_en;
        $member->phone =  $request->phone;
        $member->email = $request->email;
        $member->created_by = Auth::user()->id;
        $member->save();

        return redirect()->route('member.index')->with('success', 'تم إضافة عضو بنجاح');
    }


    public function update($id, Request $request)
    {
        $request->validate([
            'name_ar' => 'nullable|string|max:255',
            'name_en' => 'nullable|string|max:255',
            'phone' => 'nullable|string|max:255',
        ]);

        $member = User::findOrFail($id);
        $member->name_ar = $request->name_ar ?? $member->name_ar;
        $member->name_en = $request->name_en ?? $member->name_en;
        $member->phone =  $request->phone ?? $member->phone;
        $member->email = $request->email ?? $member->email;
        $member->updated_by = Auth::user()->id;
        $member->save();

        return redirect()->route('member.index')->with('success', 'تم تحديث العضو بنجاح');
    }

    public function destroy($id)
    {
        $data = User::findOrFail($id);
        $data->delete();

        return redirect()->route('member.index')->with('success', 'تم حذف العضو بنجاح');
    }
}
