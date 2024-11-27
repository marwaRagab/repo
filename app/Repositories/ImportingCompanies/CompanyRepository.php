<?php

namespace App\Repositories\ImportingCompanies;


use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Interfaces\ImportingCompanies\CompanyRepositoryInterface;
use App\Models\Company;
use App\Models\ImportingCompanies\Tawreed\OrdersFiles;

class CompanyRepository implements CompanyRepositoryInterface
{
    public function index()
    {
        $companies = Company::with(['ordersFiles' => function ($query) {
            $query->where('send_status', 0);
        }])->get();

        $newOrdersCount = OrdersFiles::where('status', 'active')->count();
        // $total_dain = OrdersFiles::with('company')->where('status', 'active')->where('received',1)->sum('amount');
//   dd($companies);
        // $sql = " SELECT SUM(amount) AS sum_amount FROM orders_files where status='active' and 
        // received=1  and company_id='$company_id' $where";

        $title = " الشركات الموردة";
        $breadcrumb = array();
        $breadcrumb[0]['title'] = " الرئيسية";
        $breadcrumb[0]['url'] = route("dashboard");
        // $breadcrumb[1]['title'] = "الشركات الموردة";
        // $breadcrumb[1]['url'] = route("dashboard");
        $breadcrumb[1]['title'] = $title;
        $breadcrumb[1]['url'] = 'javascript:void(0);';

        $view = 'importingCompanies.Companies.index';
        return view(
            'layout',
            compact('title', 'view', 'breadcrumb', 'companies', 'newOrdersCount')
        );
    }

    public function create()
    {
        $title = " اضافة شركة موردة";
        $breadcrumb = array();
        $breadcrumb[0]['title'] = " الرئيسية";
        $breadcrumb[0]['url'] = route("dashboard");
        $breadcrumb[1]['title'] = "الشركات الموردة";
        $breadcrumb[1]['url'] = route("company.index");
        $breadcrumb[2]['title'] = $title;
        $breadcrumb[2]['url'] = 'javascript:void(0);';

        $view = 'importingCompanies.Companies.create';
        return view(
            'layout',
            compact('title', 'view', 'breadcrumb')
        );
    }

    public function store(Request $request)
    {
        $request->validate([
            'name_ar' => 'required|string|max:255',
            'name_en' => 'required|string|max:255',
            'phone' => 'required|string|max:255',
            'fax' => 'nullable|string|max:255',
            'email' => 'nullable|email|max:255',
            'address' => 'required|string|max:255',
            'store_phone' => 'nullable|string|max:255',
            'delegate_name' => 'nullable|string|max:255',
            'delegate_phone' => 'nullable|string|max:255',
            'delegate_email' => 'nullable|email|max:255',
            'active' => 'nullable|int',
            'employee1Name' => 'nullable|string|max:255',
            'employee1Phone' => 'nullable|string|max:15',
            'employee1Email' => 'nullable|email',
            'employee2Phone' => 'nullable|string|max:15',
            'employee2Email' => 'nullable|email',
            'maintenanceEmp1name' => 'nullable|string|max:255',
            'maintenanceEmp1phone' => 'nullable|string|max:15',
            'maintenanceEmp1email' => 'nullable|email',
            'maintenanceEmp2phone' => 'nullable|string|max:15',
            'maintenanceEmp2email' => 'nullable|email',
            'salesEmp1name' => 'nullable|string|max:255',
            'salesEmp1phone' => 'nullable|string|max:15',
            'salesEmp1email' => 'nullable|email',
            'salesEmp2phone' => 'nullable|string|max:15',
            'salesEmp2email' => 'nullable|email',
        ]);
        $deliveryInfo = "موظف 1: " . $request->employee1Name . "، هاتف: " . $request->employee1Phone . "، بريد: " . $request->employee1Email . " | ";
        $deliveryInfo .= "موظف 2: هاتف: " . $request->employee2Phone . "، بريد: " . $request->employee2Email;

        $maintenanceInfo = "موظف 1: " . $request->maintenanceEmp1name . "، هاتف: " . $request->maintenanceEmp1phone . "، بريد: " . $request->maintenanceEmp1email . " | ";
        $maintenanceInfo .= "موظف 2: هاتف: " . $request->maintenanceEmp2phone . "، بريد: " . $request->maintenanceEmp2email;

        $salesInfo = "موظف 1: " . $request->salesEmp1name . "، هاتف: " . $request->salesEmp1phone . "، بريد: " . $request->salesEmp1email . " | ";
        $salesInfo .= "موظف 2: هاتف: " . $request->salesEmp2phone . "، بريد: " . $request->salesEmp2email;

        $company = new Company();
        $company->name_ar = $request->name_ar;
        $company->name_en = $request->name_en;
        $company->phone = $request->phone;
        $company->fax = $request->fax;
        $company->email = $request->email;
        $company->address = $request->address;
        $company->store_phone = $request->store_phone;
        $company->delegate_name = $request->delegate_name;
        $company->delegate_email = $request->delegate_email;
        $company->delegate_phone = $request->delegate_phone;
        $company->active = $request->active;
        $company->delivery = $deliveryInfo;
        $company->maintenance = $maintenanceInfo;
        $company->sales = $salesInfo;
        $company->created_at = Auth::user()->id;
        $company->save();

        return redirect()->route('company.index')->with('success', 'تم إضافة الشركة بنجاح');
    }

    public function edit($id)
    {
        $company = Company::findOrFail($id);

        $title = " تعديل شركة موردة";
        $breadcrumb = array();
        $breadcrumb[0]['title'] = " الرئيسية";
        $breadcrumb[0]['url'] = route("dashboard");
        $breadcrumb[1]['title'] = "الشركات الموردة";
        $breadcrumb[1]['url'] = route("company.index");
        $breadcrumb[2]['title'] = $title;
        $breadcrumb[2]['url'] = 'javascript:void(0);';

        $view = 'importingCompanies.Companies.edit';
        return view(
            'layout',
            compact('title', 'view', 'breadcrumb', 'company')
        );
    }
    public function update($id, Request $request)
    {
        $request->validate([
            'name_ar' => 'nullable|string|max:255',
            'name_en' => 'nullable|string|max:255',
            'phone' => 'nullable|string|max:255',
            'fax' => 'nullable|string|max:255',
            'email' => 'nullable|email|max:255',
            'address' => 'nullable|string|max:255',
            'store_phone' => 'nullable|string|max:255',
            'delegate_name' => 'nullable|string|max:255',
            'delegate_phone' => 'nullable|string|max:255',
            'delegate_email' => 'nullable|email|max:255',
            'active' => 'nullable|int',
            'delivery' => 'nullable|string',
            'maintenance' => 'nullable|string',
            'sales' => 'nullable|string',
        ]);

        $company = Company::findOrFail($id);
        $company->name_ar = $request->name_ar;
        $company->name_en = $request->name_en;
        $company->phone = $request->phone;
        $company->fax = $request->fax;
        $company->email = $request->email;
        $company->address = $request->address;
        $company->store_phone = $request->store_phone;
        $company->delegate_name = $request->delegate_name;
        $company->delegate_email = $request->delegate_email;
        $company->delegate_phone = $request->delegate_phone;
        $company->active = $request->active;
        $company->delivery = $request->delivery;
        $company->maintenance = $request->maintenance;
        $company->sales = $request->sales;
        $company->updated_at = Auth::user()->id;
        $company->save();

        return redirect()->route('company.index')->with('success', 'تم نعديل الشركة بنجاح');
    }
}
