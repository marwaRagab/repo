<?php

namespace App\Repositories;

use App\Interfaces\InstallmentClientsRepositoryInterface;
use App\Models\Installment_Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class InstallmentClientRepository implements InstallmentClientsRepositoryInterface
{

    public function index($status)
    {

        $counts= [
            'advancedCount' => Installment_Client::where('status', 'advanced')->count(),
            'under_inquiryCount' => Installment_Client::where('status', 'under_inquiry')->count(),
            'auditingCount' => Installment_Client::where('status', 'auditing')->count(),
            'car_inquiryCount' => Installment_Client::where('status', 'car_inquiry')->count(),
            'acceptedCount' => Installment_Client::where('status', 'accepted')->count(),
            'accepted_conditionCount' => Installment_Client::where('status', 'accepted_condition')->count(),
            'rejectedCount' => Installment_Client::where('status', 'rejected')->count(),
            'inquiry_doneCount' => Installment_Client::where('status', 'inquiry_done')->count(),
            'total' => Installment_Client::count(),
            'transaction_submitedCount' => Installment_Client::where('status', 'transaction_submited')->count(),
            'transaction_acceptedCount' => Installment_Client::where('status', 'transaction_accepted')->count(),
            'submit_archiveCount' => Installment_Client::where('status', 'submit_archive')->count(),
            // 'transaction_refusedCount' => Installment_Client::where('status', 'transaction_refused')->count(),
            'accepted_archiveCount' => Installment_Client::where('status', 'accepted_archive')->count(),
        ];

        if ($status == 0) {
            $Installment= Installment_Client::with([
              'bank',
                'installmentBroker',
            ])->withCount(['installment_car', 'installment_issue'])->orderBy('created_at', 'asc')->get();
        } elseif ($status == "refused") {
            $Installment = Installment_Client::with([
               'bank',
                'installmentBroker',
            ])->withCount(['installment_car', 'installment_issue'])->orderBy('created_at', 'asc')->where('status', "rejected")->get();
        } else {
            $Installment = Installment_Client::with([
                'bank',
                'installmentBroker',
            ])->withCount(['installment_car', 'installment_issue'])->orderBy('created_at', 'asc')->where('status', $status)->get();
        }

        
        // Retrieving the main data with eager loading and count of relationships

        return compact( 'Installment','counts');
    }

    public function show($id)
    {
        return Installment_Client::findOrFail($id);
    }

    public function create()
    {

    }
    public function store(Request $request)
    {
        // dd($request);
        $data = new Installment_Client;
        $data->name_ar = $request->name_ar;
        // $data->name_en = $request->name_en;
        $data->salary = $request->salary;
        $data->civil_number = $request->civil_number;
        $data->phone = $request->phone;
        $data->notes = $request->notes ?? null;
        $data->status = $request->status ?? "advanced";
        $data->bank_id = $request->bank_id ?? null;
        $data->area_id = $request->area_id ?? null;
        $data->ministry_id = $request->ministry_id ?? null;
        $data->governorate_id = $request->governorate_id ?? null;
        $data->boker_id = $request->boker_id ?? null;
        $data->installment_total = $request->installment_total ?? null;
        $data->created_by = Auth::user()->id ?? null;
        $data->updated_by = Auth::user()->id ?? null;
        $data->save();

        return $data;
    }

    public function edit($id)
    {
        return Installment_Client::findOrFail($id);
    }

    public function update($id, Request $request)
    {
        // if($status =)
        // dd($request);
        // $mesaage = 
        $data = Installment_Client::findOrFail($id);
        $data->status = $request->status ?? null;
        if($request->status == "accepted_condition")
        {
            $data->accept_condtion = $request->reason ?? null;
        }
        elseif($request->status == "accepted")
        {
            $data->reason = $request->reason ?? null;
        }
        elseif($request->status == "rejected")
        {
            $data->refuse_reason = $request->reason ?? null;
        }
        elseif($request->status == "archive")
        {
            $data->archive_reason = $request->reason ?? null;
        }
       
        $data->accept_cost = $request->accept_cost ?? null;
        $data->updated_by = Auth::user()->id ?? null;
        $data->save();

        // $res = Installment_Client::where('status',$request->status)->get();
        return $data;
    }

    public function destroy($id)
    {
        $data = Installment_Client::findOrFail($id);

        // Perform soft delete
        $data->delete();
        return $data;
    }

}
