<?php

namespace App\Repositories;

use Inertia\Inertia;
use App\Models\Region;
use App\Models\Governorate;
use App\Models\Nationality;
use Illuminate\Http\Request;
use App\Models\Police_station;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\Auth;
use App\Interfaces\PoliceStationRepositoryInterface;

class PoliceStationRepository implements PoliceStationRepositoryInterface
{
    

    public function index()
    {
        $police_stations = Police_station::with('government' , 'user')->get();
        $governments = Governorate::all();

        $title = "المخافر ";

        $breadcrumb = array();
        $breadcrumb[0]['title'] = " الرئيسية";
        $breadcrumb[0]['url'] = route("dashboard");
         $breadcrumb[1]['title'] = $title;
        $breadcrumb[1]['url'] = 'javascript:void(0);';

        $view = 'setting.police_stations';
        return view(
            'layout',
            compact('title', 'view', 'breadcrumb', 'police_stations','governments')
        );
       
    }
    
    public function show($id)
    {
        return Police_station::findOrFail($id);
    }

    public function  create()
    {

    }
    public function store(Request $request)
    {
        $data = new Police_station;
        $data->name_ar = $request->name_ar;
        $data->name_en = $request->name_en;
        $data->governorate_id = $request->governorate_id;
        $data->created_by = Auth::user()->id ?? null;
        $data->updated_by = Auth::user()->id ?? null;
        $data->save();
        // return Nationality::create($request->all());
        return redirect()->route('police_stations.index')->with('success', 'police stations created successfully .');
    }

    public function  edit($id)
    {
        return Police_station::findOrFail($id);
    }

    public function update($id, Request $request)
    {
        $data = Police_station::findOrFail($id);
        // $user->update($request->all());
        $data->name_ar = $request->name_ar;
        $data->name_en = $request->name_en;
        $data->governorate_id = $request->governorate_id;
        $data->updated_by = Auth::user()->id ?? null;
        $data->save();

        return redirect()->route('police_stations.index')->with('success', 'police stations updated successfully .');
    }

    public function destroy($id)
    {
        // return Nationality::destroy($id);
        $data = Police_station::findOrFail($id);

        // Perform soft delete
        $data->delete();
        return redirect()->route('police_stations.index')->with('success', 'police stations deleted successfully .');
    }
}
