<?php

namespace App\Repositories;

use Inertia\Inertia;
use App\Models\Governorate;
use App\Models\Nationality;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\Auth;
use App\Interfaces\GovernorateRepositoryInterface;

class GovernorateRepository implements GovernorateRepositoryInterface
{
    // public function index(Request $request)
    // {
    //     return Nationality::all();

    // }

    public function index()
    {
        return Governorate::with('user')->withCount('region')->get();

    }

    public function show($id)
    {
        return Governorate::with('user')->withCount('region')->findOrFail($id);
    }

    public function  create()
    {

    }
    public function store(Request $request)
    {
        $data = new Governorate;
        $data->name_ar = $request->name_ar;
        $data->name_en = $request->name_en;
        $data->created_by = Auth::user()->id ?? null;
        $data->updated_by = Auth::user()->id ?? null;
        $data->save();
        // return Nationality::create($request->all());
        return $data;
    }

    public function  edit($id)
    {
        return Governorate::with('user')->withCount('region')->findOrFail($id);
    }

    public function update($id, Request $request)
    {
        $data = Governorate::findOrFail($id);
        // $user->update($request->all());
        $data->name_ar = $request->name_ar;
        $data->name_en = $request->name_en;
        $data->updated_by = Auth::user()->id ?? null;
        $data->save();

        return $data;
    }

    public function destroy($id)
    {
        // return Nationality::destroy($id);
        $data = Governorate::findOrFail($id);

        // Perform soft delete
        $data->delete();
        return $data;
    }
}
