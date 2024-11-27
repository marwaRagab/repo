<?php

namespace App\Repositories;


use Inertia\Inertia;
use App\Models\Branch;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\Auth;
use App\Interfaces\BranchRepositoryInterface;

class BranchRepository implements BranchRepositoryInterface
{

    public function index()
    {
        return Branch::with('user')->get();

    }

    public function show($id)
    {
        return Branch::findOrFail($id);
    }

    public function  create()
    {

    }
    public function store(Request $request)
    {
        $data = new Branch;
        $data->name_ar = $request->name_ar;
        $data->name_en = $request->name_en;
        $data->created_by = Auth::user()->id ?? null;
        $data->updated_by = Auth::user()->id ?? null;
        $data->save();
        // return Permission::create($request->all());
        return $data;
    }

    public function  edit($id)
    {
        return Branch::findOrFail($id);
    }

    public function update($id, Request $request)
    {
        $data = Branch::findOrFail($id);
        // dd($request->name_ar);
        $data->name_ar = $request->name_ar ?? $data->name_ar;
        $data->name_en = $request->name_en ?? $data->name_en;
        $data->updated_by = Auth::user()->id ?? null;
        $data->save();
        return $data;
    }

    public function destroy($id)
    {
        $data = Branch::findOrFail($id);

        // Perform soft delete
        $data->delete();
        return $data;
    }
}
