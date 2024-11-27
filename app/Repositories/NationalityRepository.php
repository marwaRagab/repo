<?php

namespace App\Repositories;

use Inertia\Inertia;
use App\Models\Nationality;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\Auth;
use App\Interfaces\NationalityRepositoryInterface;

class NationalityRepository implements NationalityRepositoryInterface
{
    // public function index(Request $request)
    // {
    //     return Nationality::all();
       
    // }

    public function index()
    {
        $nationalities = Nationality::with('user')->get();

        $title = "الجنسيات ";

        $breadcrumb = array();
        $breadcrumb[0]['title'] = " الرئيسية";
        $breadcrumb[0]['url'] = route("dashboard");
        $breadcrumb[1]['title'] = $title;
        $breadcrumb[1]['url'] = 'javascript:void(0);';

        $view = 'setting.nationality';
        return view(
            'layout',
            compact('title', 'view', 'breadcrumb', 'nationalities')
        );
       
    }

    public function show($id)
    {
        return Nationality::findOrFail($id);
    }

    public function  create()
    {

    }
    public function store(Request $request)
    {
        $request->validate([
            'name_ar' => 'required|string|max:255',
            'name_en' => 'required|string|max:255',
        ]);

        $data = new Nationality;
        $data->name_ar = $request->name_ar;
        $data->name_en = $request->name_en;
        $data->created_by = Auth::user()->id ?? null;
        $data->updated_by = Auth::user()->id ?? null;
        $data->save();
       
        return redirect()->route('nationality.index')->with('success', 'Nationality created successfully .');
    }

    public function  edit($id)
    {
        return Nationality::findOrFail($id);
    }

    public function update($id, Request $request)
    {

        $data = Nationality::findOrFail($id);
        // $user->update($request->all());
        $data->name_ar = $request->name_ar;
        $data->name_en = $request->name_en;
        $data->updated_by = Auth::user()->id ?? null;
        $data->save();
        return redirect()->route('nationality.index')->with('success', 'Nationality updated successfully .');
    }

    public function destroy($id)
    {
        $data = Nationality::findOrFail($id);

        $data->delete();
        return redirect()->route('nationality.index')->with('success', 'Nationality deleted successfully .');
    }
}
