<?php

namespace App\Repositories;

use Log;
use Inertia\Inertia;
use App\Models\Permission;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\Auth;
use App\Interfaces\PermissionRepositoryInterface;

class PermissionRepository implements PermissionRepositoryInterface
{

    public function index()
    {
        $data = Permission::whereNull('parent_id')->with('children')->get();
        // foreach ($data as $item) {
        //     return $item->with('children');
        //     // $data = $data->with('childrenRecursive');
        //     // Check if the item has children_recursive
        //     // if (isset($item['children_recursive'])) {
        //     //     // Move children_recursive to a new 'children' key
        //     //     $item['children'] = $item['children_recursive'];
        //     //     // Remove the old children_recursive key
        //     //     unset($item['children_recursive']);
        //     // }
        // }
        // dd($data);
        return $data;
        // return Permission::with('children')->get();
    }


    public function show($id)
    {
        // return Permission::with('children')->get();
        // childrenRecursive
        // return Permission::with('childrenRecursive')->get();
        return  Permission::with('childrenRecursive')->findOrFail($id);
    }

    public function  create()
    {
        
    }
    public function store(Request $request)
    {

        // dd($request);
        $data = new Permission;
        $data->title_ar = $request->name;
        $data->title_en = $request->name;
        $data->parent_id  = $request->perant_id ?? null;
        $data->created_by = Auth::user()->id ?? null;
        $data->updated_by = Auth::user()->id ?? null;
        $data->save();
        // return Permission::create($request->all());
        return $data;
    }

    public function  edit($id)
    {

        return Permission::with('childrenRecursive')->findOrFail($id);
    }

    public function update($id, Request $request)
    {



        $data = Permission::findOrFail($id);
        $data->title_ar = $request->name ?? $data->title_ar;
        $data->title_en = $request->name ?? $data->title_en;
        $data->parent_id  = $request->parent_id ?? null;
        $data->updated_by = Auth::user()->id ?? null;
        $data->save();
        return $data;
    }

    public function destroy($id)
    {
        $data = Permission::findOrFail($id);

        // Perform soft delete
        $data->delete();
        return $data;
    }
}