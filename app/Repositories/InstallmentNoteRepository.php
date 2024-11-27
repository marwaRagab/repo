<?php

namespace App\Repositories;

use Inertia\Inertia;
use App\Models\Region;
use App\Models\Governorate;
use App\Models\Nationality;
use Illuminate\Http\Request;
use App\Models\InstallmentCar;
use App\Models\InstallmentNote;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\Auth;
use App\Interfaces\InstallmentNoteRepositoryInterface;


class InstallmentNoteRepository implements InstallmentNoteRepositoryInterface
{
    

    public function index()
    {
        return InstallmentNote::with( 'user')->get();
       
    }

    public function show($id)
    {
        return InstallmentNote::findOrFail($id);
    }

    public function  create()
    {

    }
    public function store(Request $request)
    {

            $data = new InstallmentNote;
            $data->connect = $request->connect;
            $data->time = $request->time;
            $data->date = $request->date;
            $data->installment_clients_id  = $request->installment_clients_id;
            $data->note = $request->note;
            $data->created_by = Auth::user()->id;
            $data->updated_by = Auth::user()->id;
            $data->save();
            // return Nationality::create($request->all());
            return $data;
    }

    public function  edit($id)
    {
        return InstallmentNote::findOrFail($id);
    }

    public function update($id, Request $request)
    {
        $data = InstallmentNote::findOrFail($id);
        // $user->update($request->all());
        $data->connect = $request->connect;
        $data->time = $request->time;
        $data->date = $request->date;
        $data->installment_clients_id = $request->installment_clients_id;
        $data->note = $request->note;
        $data->updated_by = Auth::user()->id;
        $data->save();

        return $data;
    }

    public function destroy($id)
    {
        // return Nationality::destroy($id);
        $data = InstallmentNote::findOrFail($id);

        // Perform soft delete
        $data->delete();
        return $data;
    }
}
