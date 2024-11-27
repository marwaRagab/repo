<?php

namespace App\Repositories\HumanResources;


use Inertia\Inertia;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use App\Models\TransactionCompleted;
use Illuminate\Support\Facades\Auth;
use App\Interfaces\HumanResources\TransactionsCompletedRepositoryInterface;
use App\Models\Bank;
use App\Models\CommuncationMethod;
use App\Models\Court;
use App\Models\Log;

class TransactionsCompletedRepository implements TransactionsCompletedRepositoryInterface
{

    public function index()
    {
        $data = TransactionCompleted::with('user', 'communcation_method', 'banks', 'courts')->get();

        $methods = CommuncationMethod::all();
        $banks = Bank::all();
        $courts = Court::all();

        $title = "منجزين المعاملات";
        $breadcrumb = array();
        $breadcrumb[0]['title'] = " الرئيسية";
        $breadcrumb[0]['url'] = route("dashboard");
        $breadcrumb[1]['title'] = "الموارد البشرية";
        $breadcrumb[1]['url'] = route("dashboard");
        $breadcrumb[2]['title'] = $title;
        $breadcrumb[2]['url'] = 'javascript:void(0);';

        $view = 'HumanResources.transactions-done';
        return view(
            'layout',
            compact('title', 'view', 'breadcrumb', 'data', 'methods', 'banks', 'courts')
        );
    }


    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name_ar' => 'required|string|max:255',
            'name_en' => 'required|string|max:255',
            // 'email' => 'required|string|max:255',
            // 'whatsapp' => 'required|string|max:255',
            'Communication_method' => 'required|string|max:255',
            'communication_method_id' => 'required|exists:communcation_methods,id',
            'section_type' => 'required|in:bank,court',
            'bank_id' => 'nullable|exists:banks,id',
            'court_id' => 'nullable|exists:courts,id',
        ]);

        $person = new TransactionCompleted();
        $person->name_ar = $validatedData['name_ar'];
        $person->name_en = $validatedData['name_en'];
        // $person->email = $validatedData['email'];
        // $person->whatsapp = $validatedData['whatsapp'];
        $person->Communication_method = $validatedData['Communication_method'];
        $person->communcation_method_id = $validatedData['communication_method_id'];
        $person->section_type = $validatedData['section_type'];
        if ($request->filled('bank_id')) {
            $person->bank_id = $validatedData['bank_id'];
        }
        if ($request->filled(key: 'court_id')) {
            $person->court_id = $validatedData['court_id'];
        }
        $person->created_by = Auth::user()->id;
        $person->save();


        return redirect()->route('transactions.done.index')->with('success', 'تم إضافة منجز المعاملات بنجاح');
    }


    public function update($id, Request $request)
    {
        $request->validate([
            'name_ar' => 'nullable|string|max:255',
            'name_en' => 'nullable|string|max:255',
            // 'email' => 'nullable|string|max:255',
            // 'whatsapp' => 'nullable|string|max:255',
            'Communication_method' => 'nullable|string|max:255',
            'communication_method_id' => 'nullable|exists:communcation_methods,id',
        ]);
        $person = TransactionCompleted::findOrFail($id);
        $person->name_ar = $request->name_ar ?? $person->name_ar;
        $person->name_en = $request->name_en ?? $person->name_en;
        // $person->email = $request->email ?? $person->email;
        // $person->whatsapp = $request->whatsapp ?? $person->whatsapp;
        $person->Communication_method = $request->Communication_method;
        $person->communcation_method_id = $request->communication_method_id ?? $person->communcation_method_id;
        $person->updated_by = Auth::user()->id;
        $person->save();

        return redirect()->route('transactions.done.index')->with('success', 'تم تحديث منجز المعاملات بنجاح');
    }

    public function destroy($id)
    {
        $data = TransactionCompleted::findOrFail($id);
        $data->delete();

        return redirect()->route('transactions.done.index')->with('success', 'تم حذف منجز المعاملات بنجاح');
    }
}
