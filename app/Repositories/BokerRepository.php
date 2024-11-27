<?php

namespace App\Repositories;

use Inertia\Inertia;
use App\Models\Boker;
use App\Models\Governorate;
use App\Models\Nationality;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\Auth;
use App\Interfaces\BokerRepositoryInterface;
use App\Models\Client;
use App\Models\Installment_Client;

class BokerRepository implements BokerRepositoryInterface
{


    public function index()
    {
        $title = 'الوسطاء ';

        $breadcrumb = array();
        $breadcrumb[0]['title'] = " الرئيسية";
        $breadcrumb[0]['url'] = route("dashboard");
        $breadcrumb[1]['title'] = "المعاملات";
        $breadcrumb[1]['url'] = route("myinstall.index", ['status' => 'advanced']);
        $breadcrumb[2]['title'] = $title;
        $breadcrumb[2]['url'] = 'javascript:void(0);';

        $data = Boker::with('user', 'installmentClient', 'clients')->get();
        //  $data = Installment::with(['user','client','eqrar_not_recieve','installment_months','militay_affairs'])->get();
        // if ($data) {
        //     $user_id = 1;
        //     //   $user_id =  Auth::user()->id,
        //     $message = "تم دخول صفحة الوسطاء";
        //     $this->log($user_id, $message);
        // }

        $view = 'HumanResources.brokers';
        return view(
            'layout',
            compact('title', 'view', 'breadcrumb', 'data')
        );
    }

    // public function show($id)
    // {
    //     return Boker::findOrFail($id);
    // }

    // public function  create()
    // {

    // }
    public function store(Request $request)
    {
        $data = new Boker;
        $data->name_ar = $request->name_ar;
        $data->name_en = $request->name_en;
        $data->phone = $request->phone;
        $data->percentage = $request->percentage;
        $data->percentage_amount = $request->percentage_amount;
        $data->created_by = Auth::user()->id ?? null;
        $data->updated_by = Auth::user()->id ?? null;
        $data->save();
        // return Nationality::create($request->all());
        return $data;
    }

    // public function  edit($id)
    // {
    //     return Boker::findOrFail($id);
    // }

    public function update($request, $id)
    {
        $request->validate([
            'name_ar' => 'nullable',
            'name_en' => 'nullable',
            'phone' => 'nullable',
            'percentage' => 'nullable',
            'percentage_amount' => 'required|in:percentage,amount',
        ]);

        $data = Boker::findOrFail($id);
        // $user->update($request->all());
        $data->name_ar = $request->name_ar;
        $data->name_en = $request->name_en;
        $data->phone = $request->phone;
        $data->percentage = $request->percentage;
        $data->percentage_amount = $request->percentage_amount;
        $data->updated_by = Auth::user()->id ?? null;
        $data->save();

        return redirect()->route('broker.index')->with('success', 'تم تحديث الوسيط بنجاح');
    }

    public function destroy($id)
    {
        // return Nationality::destroy($id);
        $data = Boker::findOrFail($id);

        // Perform soft delete
        $data->delete();
        return redirect()->route('broker.index')->with('success', 'تم حذف الوسيط بنجاح');
    }
}
