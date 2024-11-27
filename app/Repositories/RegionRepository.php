<?php

namespace App\Repositories;

use Inertia\Inertia;
use App\Models\Region;
use App\Models\Governorate;
use App\Models\Nationality;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\Auth;
use App\Interfaces\RegionRepositoryInterface;


class RegionRepository implements RegionRepositoryInterface
{
    

    public function index()
    {
        return Region::with('government', 'police_station' , 'user')->get();
       
    }

    public function show($id)
    {
        return Region::findOrFail($id);
    }

    public function  create()
    {

    }
    public function store(Request $request)
    {
        $data = new Region;
        $data->name_ar = $request->name_ar;
        $data->name_en = $request->name_en;
        $data->police_station_id = $request->police_station_id;
        $data->created_by = Auth::user()->id ?? null;
        $data->updated_by = Auth::user()->id ?? null;
        $data->save();
        // return Nationality::create($request->all());
        return $data;
    }

    public function  edit($id)
    {
        return Region::findOrFail($id);
    }

    public function update($id, Request $request)
    {
        $data = Region::findOrFail($id);
        // $user->update($request->all());
        $data->name_ar = $request->name_ar;
        $data->name_en = $request->name_en;
        $data->police_station_id = $request->police_station_id;
        $data->updated_by = Auth::user()->id ?? null;
        $data->save();

        return $data;
    }

    public function destroy($id)
    {
        // return Nationality::destroy($id);
        $data = Region::findOrFail($id);

        // Perform soft delete
        $data->delete();
        return $data;
    }
}
