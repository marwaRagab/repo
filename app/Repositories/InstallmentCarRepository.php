<?php

namespace App\Repositories;

use Inertia\Inertia;
use App\Models\Region;
use App\Models\Governorate;
use App\Models\Nationality;
use Illuminate\Http\Request;
use App\Models\InstallmentCar;
use Yajra\DataTables\DataTables;
use App\Models\Installment_Client;
use Illuminate\Support\Facades\Auth;
use App\Interfaces\RegionRepositoryInterface;
use App\Interfaces\InstallmentCarRepositoryInterface;


class InstallmentCarRepository implements InstallmentCarRepositoryInterface
{


    public function index()
    {
        return InstallmentCar::with( 'user')->get();

    }

    public function show($id)
    {
        return InstallmentCar::findOrFail($id);
    }

    public function  create()
    {

    }
    public function store(Request $request)
{

    // dd($request);
    $savedCars = [];
    foreach($request->installment_car as $index => $item)
    {
        $data = new InstallmentCar;
        $data->exist = $request->exist ?? null;
        $data->type_car = $item['type_car'] ?? null;
        $data->model_year = $item['model_year'] ?? null;
        $data->average_price = $item['average_price'] ?? null;
        $data->installment_clients_id = $request->installment_clients_id ?? null;
        $data->created_by = Auth::user()->id ?? null;
        $data->updated_by = Auth::user()->id ?? null;
        $data->save();
        
        // $Installment_Client = Installment_Client::find($request->installment_clients_id);
        //     // dd($Installment_Client);
        
        //     $Installment_Client->status  = "auditing";
        //     $Installment_Client->save();

        // Handle image upload if it exists for this item
        if (isset($item['image']) && $request->hasFile("installment_car.$index.image")) {
            $file = $request->file("installment_car.$index.image");
            $path = 'InstallmentClients/car/images';
            UploadImage($path, 'image', $data, $file);
        }

        $savedCars[] = $data;
    }

    return $savedCars;
}

    public function  edit($id)
    {
        return InstallmentCar::findOrFail($id);
    }

    public function update($id, Request $request)
    {
        $data = InstallmentCar::findOrFail($id);
        // $user->update($request->all());
        $data->type_car = $request->type_car ?? null;
        $data->model_year = $request->model_year ?? null;
        $data->average_price = $request->average_price ?? null;
        // $data->image = $request->image;
        $data->installment_clients_id = $request->installment_clients_id ?? null;
        $data->updated_by = Auth::user()->id ?? null;
        $data->save();

        if ($request->hasFile('image')) {
            $file = $request->image;
            $path = 'InstallmentClients/car/images';

            UploadImage($path, 'image', $data, $file);
        }

        return $data;
    }

    public function destroy($id)
    {
        // return Nationality::destroy($id);
        $data = InstallmentCar::findOrFail($id);

        // Perform soft delete
        $data->delete();
        return $data;
    }
}
