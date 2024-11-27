<?php

namespace App\Repositories;

use Carbon\Carbon;
use Inertia\Inertia;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\Auth;
use App\Models\InstallmentClientNote;
use App\Interfaces\InstallmentClientNoteRepositoryInterface;

class InstallmentClientNoteRepository implements InstallmentClientNoteRepositoryInterface
{


    public function index($id)
    {
        if($id == 0)
        {
            $data = InstallmentClientNote::with('user')->get();
        }
        else
        {
            $data = InstallmentClientNote::with('user')->where('installment_clients_id',$id)->get();
        }

        // Retrieving the main data with eager loading and count of relationships


        return compact('data');
    }

    public function show($id)
    {
        return InstallmentClientNote::findOrFail($id);
    }

    public function  create()
    {

    }
    public function store(Request $request)
    {
        // dd($request);
        $data = new InstallmentClientNote;
        $data->reply = $request->reply ?? null;
        $data->note = $request->note ?? null;
        $data->time = $request->time ?? Carbon::now()->format('H:i:s');
        $data->date = $request->date ?? Carbon::now()->format('Y-m-d');
        $data->installment_clients_id = $request->installment_clients_id ?? null;
        $data->created_by = Auth::user()->id ?? null;
        $data->updated_by = Auth::user()->id ?? null;
        $data->save();
        // return Nationality::create($request->all());
        return $data;
    }

    public function  edit($id)
    {
        return InstallmentClientNote::findOrFail($id);
    }

    public function update($id, Request $request)
    {
        $data = InstallmentClientNote::findOrFail($id);
        // $user->update($request->all());
        $data->reply = $request->reply ?? null;
        $data->time = $request->time ?? null;
        $data->date = $request->date ?? null;
        $data->installment_clients_id = $request->installment_clients_id ?? null;
        $data->updated_by = Auth::user()->id ?? null;
        $data->save();

        return $data;
    }

    public function destroy($id)
    {
        // return Nationality::destroy($id);
        $data = InstallmentClientNote::findOrFail($id);

        // Perform soft delete
        $data->delete();
        return $data;
    }
}
