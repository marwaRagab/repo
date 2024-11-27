<?php

namespace App\Repositories;

use Inertia\Inertia;
use App\Models\Region;
use App\Models\Governorate;
use App\Models\Nationality;
use Illuminate\Http\Request;
use App\Models\InstallmentCar;
use App\Models\InstallmentIssue;
use Yajra\DataTables\DataTables;
use App\Models\Installment_Client;
use Illuminate\Support\Facades\Auth;
use App\Interfaces\InstallmentIssueRepositoryInterface;

class InstallmentIssueRepository implements InstallmentIssueRepositoryInterface
{


    public function index($id)
    {
        // return InstallmentIssue::with( 'user')->get();

        return $id;

    }

    public function show($id)
    {
        return InstallmentIssue::findOrFail($id);
    }

    public function  create()
    {

    }
    public function store(Request $request)
    {

        // dd($request);
        
        $filename = time() . '-' . $request->file('issue_pdf')->getClientOriginalName();
        $path = $request->file('issue_pdf')->move(public_path('issue_pdf'), $filename);
        // update table installment _client
        $Installment_Client = Installment_Client::find($request->installment_clients_id);
        // dd($Installment_Client);
        $Installment_Client->opening_amount_issue += $request->opening_total ?? 0;
        $Installment_Client->closing_amount_issue += $request->closing_total ?? 0;
        $Installment_Client->total_amount_issue  += $request->total_IC ?? 0;
        // $Installment_Client->issue_pdf  = asset('issue_pdf') . '/' . $filename;
         $Installment_Client->issue_pdf  = 'issue_pdf' . '/' . $filename;
        // $Installment_Client->issue_pdf = asset('storage/issue_pdf/' . $filename);
        $Installment_Client->save();
        $savedIssues = [];
        if($request->exist1 != "notexist")
        {
            foreach($request->installment_issue as $index => $item)
            {
                $item = (object) $item;
                if ($item->status == "on") {
                    $status = 'open';
                } else {
                    $status = 'close';
                }
                // dd($item->image);
                $data = new InstallmentIssue;
                $data->number_issue = $item->number_issue;
                $data->opening_amount = $item->opening_amount ?? 0;
                $data->closing_amount = $item->closing_amount ?? 0;
                $data->date = $item->date;
                $data->status = $status;
                $data->installment_clients_id = $request->installment_clients_id;
                $data->working_company = $item->working_company;
                $data->created_by = Auth::user()->id ?? null;
                $data->updated_by = Auth::user()->id ?? null;
                $data->save();
    
                if (isset($item->image) &&  $request->hasFile("installment_issue.$index.image")) {
                    // dd("ss");
                    $file = $request->file("installment_issue.$index.image");
                    $path = 'InstallmentClients/issue/images';
    
                    UploadImage($path, 'image', $data, $file);
                }
    
    
                $savedIssues[] = $data;
            }
        }
        else{
            $data = new InstallmentIssue;
            $data->installment_clients_id = $request->installment_clients_id;
            $data->exist1 = $request->exist1 ?? 'exist';
            $data->number_issue = null;
                $data->opening_amount = null;
                $data->closing_amount = null;
                $data->date = null;
                $data->status = 'close';
                $data->working_company = null;
                $data->created_by = Auth::user()->id ?? null;
                $data->updated_by = Auth::user()->id ?? null;
                $data->save();

        }
        
        // dd($savedIssues);
        // return Nationality::create($request->all());
        return $savedIssues;
    }

    public function  edit($id)
    {
        return InstallmentIssue::findOrFail($id);
    }

    public function update($id, Request $request)
    {
        $data = InstallmentIssue::findOrFail($id);
        // $user->update($request->all());
        $data->number_issue = $request->number_issue;
        $data->opening_amount = $request->opening_amount;
        $data->closing_amount = $request->closing_amount;
        $data->date = $request->date;
        // $data->image = $request->image;
        $data->status = $request->status;
        $data->installment_clients_id = $request->installment_clients_id;
        $data->working_company = $request->working_company;
        $data->updated_by = Auth::user()->id;
        $data->save();


        if ($request->hasFile('image')) {
            $file = $request->image;
            $path = 'InstallmentClients/issue/images';

            UploadImage($path, 'image', $data, $file);
        }
        return $data;
    }

    public function destroy($id)
    {
        // return Nationality::destroy($id);
        $data = InstallmentIssue::findOrFail($id);

        // Perform soft delete
        $data->delete();
        return $data;
    }
}
