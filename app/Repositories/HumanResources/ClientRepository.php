<?php

namespace App\Repositories\HumanResources;

use App\Interfaces\HumanResources\ClientRepositoryInterface;
use App\Models\Bank;
use App\Models\Branch;
use App\Models\Client;
use App\Models\ClientAddress;
use App\Models\ClientBank;
use App\Models\ClientImg;
use App\Models\ClientMinistry;
use App\Models\ClientPhone;
use App\Models\ClientWorking;
use App\Models\Governorate;
use App\Models\Ministry;
use App\Models\Nationality;
use App\Models\Prev_cols_clients;
use App\Models\Region;
use Illuminate\Support\Facades\Auth;

class ClientRepository implements ClientRepositoryInterface
{
    protected $data;
    public function __construct()
    {
        //

        $this->data['nationalities'] = Nationality::all();
        $this->data['governorates']    = Governorate::all();
       $this->data['areas']  = Region::all();
       $this->data['branches']  = Branch::all();
       $this->data['banks']  = Bank::all();
       $this->data['ministries']  = Ministry::all();




    }

    public function index()
    {
        $clients = Client::with('branch', 'ministry', 'bank', 'area', 'nationality', 'client_phone', 'client_address', 'client_image', 'court')->get();
        //$clients = Client::with('client_old')->get();
       // $clients = Client::with('client_phone',)->get();




        $title = "العملاء";
        $breadcrumb = array();
        $breadcrumb[0]['title'] = " الرئيسية";
        $breadcrumb[0]['url'] = route("dashboard");
        $breadcrumb[1]['title'] = "الموارد البشرية";
        $breadcrumb[1]['url'] = route("dashboard");
        $breadcrumb[2]['title'] = $title;
        $breadcrumb[2]['url'] = 'javascript:void(0);';

        $view = 'HumanResources.clients';
        return view(
            'layout',
            compact(
                'title',
                'view',
                'breadcrumb',
                'clients',

            ),$this->data
        );
    }

    public function store($request)
    {
        $request->validate([
            'name_ar' => 'required|string|max:255',
            'name_en' => 'required|string|max:255',
            'civil_number' => 'required|string|max:255|unique:clients',
            'email' => 'nullable|email|max:255|unique:clients,email',
            'ministry_id' => 'nullable|exists:ministries,id',
            'gender' => 'required|in:male,female',
            'nationality_id' => 'required|exists:nationalities,id',
            'birth_date' => 'required|date',
            'governorate_id' => 'required|exists:governorates,id',
            'area_id' => 'required|exists:regions,id',
            'branch_id' => 'nullable|exists:branches,id',
            'salary' => 'nullable|string|max:255',
            'bank_id' => 'required|exists:banks,id',
            'iban' => 'nullable|string|max:255',
            'bank_account_number' => 'nullable|string|max:255',
            // Client phones fields
            'phone' => 'required|string|max:255',
            'phone_land' => 'nullable|string|max:255',
            'nearist_phone' => 'nullable|string|max:255',
            'phone_work' => 'nullable|string|max:255',
            // Client address fields
            'block' => 'nullable|string|max:255',
            'street' => 'nullable|string|max:255',
            'jada' => 'nullable|string|max:255',
            'building' => 'nullable|string|max:255',
            'floor' => 'nullable|string|max:255',
            'flat' => 'nullable|string|max:255',
            'house_id' => 'nullable|string|max:255',
            // Client image fields
            'images.*.path' => 'required|file|mimes:jpg,jpeg,png|max:2048',
            'images.*.type' => 'required|in:contract,personal,working',
        ]);

        // Create client entry
        $client = new Client();
        $client->name_ar = $request->name_ar;
        $client->name_en = $request->name_en;
        $client->email = $request->email;
        $client->civil_number = $request->civil_number;
        $client->job_type = $request->job_type;
        $client->gender = $request->gender;
        $client->nationality_id = $request->nationality_id;
        $client->birth_date = $request->birth_date;
        $client->governorate_id = $request->governorate_id;
        $client->area_id = $request->area_id;
        $client->branch_id = $request->branch_id;
        $client->house_id = $request->house_id;
        $client->salary = $request->salary;
        $client->bank_ids = $request->bank_id;
        $client->ipan = $request->iban;
        $client->created_by = Auth::id();
        $client->save();

        $phones = new ClientPhone();
        $phones->client_id = $client->id;
        $phones->phone = $request->phone;
        $phones->phone_land = $request->phone_land;
        $phones->nearist_phone = $request->nearist_phone;
        $phones->phone_work = $request->phone_work;
        $phones->created_by = Auth::id();
        $phones->save();

        $address = new ClientAddress();
        $address->client_id = $client->id;
        $address->block = $request->block;
        $address->street = $request->street;
        $address->jada = $request->jada;
        $address->building = $request->building;
        $address->floor = $request->floor;
        $address->flat = $request->flat;
        $address->governorate_id = $request->governorate_id;
        $address->area_id = $request->area_id;
        $address->house_id = $request->house_id;
        $address->created_by = Auth::id();
        $address->save();

        $banks = new ClientBank();
        $banks->bank_id = $request->bank_id;
        $banks->client_id = $client->id;
        $banks->bank_account_number = $request->bank_account_number;
        $banks->iban = $request->iban;
        $banks->save();

        $ministries = new ClientMinistry();
        $ministries->ministry_id = $request->ministry_id;
        $ministries->client_id = $client->id;
        $ministries->save();

        if ($request->has('images')) {
            foreach ($request->input('images') as $key => $imageData) {
                if ($request->hasFile("images.$key.path")) {
                    // Store the uploaded image and get its path
                    $imagePath = $request->file("images.$key.path")->store('uploads/new_photos', 'public');

                    $image = new ClientImg([
                        'path' => $imagePath,
                        'type' => $imageData['type'],
                        'created_by' => Auth::id(),
                    ]);
                    $image->client_id = $client->id;

                    $image->save();
                }
            }
        }

        return redirect()->route('clients.index')->with('success', 'تم إضافة العميل بنجاح');
    }

    public function update($request, $id)
    {
        $request->validate([
            'name_ar' => 'nullable|string|max:255',
            'name_en' => 'nullable|string|max:255',
            'civil_number' => 'nullable|string|max:255|unique:clients,email,' . $id,
            'email' => 'nullable|email|max:255|unique:clients,civil_number,' . $id,
            'ministry_id' => 'nullable|exists:ministries,id',
            'gender' => 'nullable|in:male,female',
            'nationality_id' => 'nullable|exists:nationalities,id',
            'birth_date' => 'nullable|date',
            'governorate_id' => 'nullable|exists:governorates,id',
            'area_id' => 'nullable|exists:regions,id',
            'branch_id' => 'nullable|exists:branches,id',
            'salary' => 'nullable|string|max:255',
            'bank_id' => 'nullable|exists:banks,id',
            'iban' => 'nullable|string|max:255',
            'bank_account_number' => 'nullable|string|max:255',
            // Client phones fields
            'phone' => 'nullable|string|max:255',
            'phone_land' => 'nullable|string|max:255',
            'nearist_phone' => 'nullable|string|max:255',
            'phone_work' => 'nullable|string|max:255',
            // Client address fields
            'block' => 'nullable|string|max:255',
            'street' => 'nullable|string|max:255',
            'jada' => 'nullable|string|max:255',
            'building' => 'nullable|string|max:255',
            'floor' => 'nullable|string|max:255',
            'flat' => 'nullable|string|max:255',
            'house_id' => 'nullable|string|max:255',
            // Client image fields
            'images.*.path' => 'nullable|file|mimes:jpg,jpeg,png|max:2048',
            'images.*.type' => 'nullable|in:contract,personal,working',
        ]);

        $client = Client::findOrFail($id);
        $client->name_ar = $request->name_ar ?? $client->name_ar;
        $client->name_en = $request->name_en ?? $client->name_en;
        $client->email = $request->email ?? $client->email;
        $client->civil_number = $request->civil_number ?? $client->civil_number;
        $client->job_type = $request->job_type ?? $client->job_type;
        $client->gender = $request->gender ?? $client->gender;
        $client->nationality_id = $request->nationality_id ?? $client->nationality_id;
        $client->birth_date = $request->birth_date ?? $client->birth_date;
        $client->governorate_id = $request->governorate_id ?? $client->governorate_id;
        $client->area_id = $request->area_id ?? $client->area_id;
        $client->branch_id = $request->branch_id ?? $client->branch_id;
        $client->house_id = $request->house_id ?? $client->house_id;
        $client->salary = $request->salary ?? $client->salary;
        $client->bank_ids = $request->bank_id ?? $client->bank_ids;
        $client->ipan = $request->iban ?? $client->ipan;
        $client->updated_by = Auth::id();
        $client->save();

        if (
            $request->filled('block') || $request->filled('street') || $request->filled('jada') ||
            $request->filled('building') || $request->filled('floor') || $request->filled('flat') || $request->filled('house_id')
        ) {
            $addressData = new ClientAddress();
            $addressData->client_id = $client->id;
            $addressData->block = $request->block ?? $addressData->block;
            $addressData->street = $request->street ?? $addressData->street;
            $addressData->jada = $request->jada ?? $addressData->jada;
            $addressData->floor = $request->floor ?? $addressData->floor;
            $addressData->flat = $request->flat ?? $addressData->flat;
            $addressData->governorate_id = $request->governorate_id ?? $addressData->governorate_id;
            $addressData->area_id = $request->area_id ?? $addressData->area_id;
            $addressData->house_id = $request->house_id ?? $addressData->house_id;
            $addressData->building = $request->building ?? $addressData->building;
            $addressData->created_by = Auth::id();
            $addressData->save();
        }

        if ($request->filled('phone') || $request->filled('phone_land') || $request->filled('phone_work') || $request->filled('nearest_phone')) {
            $phones = new ClientPhone();
            $phones->client_id = $client->id;
            $phones->phone = $request->phone ?? $phones->phone;
            $phones->phone_land = $request->phone_land ?? $phones->phone_land;
            $phones->nearist_phone = $request->nearist_phone ?? $phones->nearist_phone;
            $phones->phone_work = $request->phone_work ?? $phones->phone_work;
            $phones->created_by = Auth::id();
            $phones->save();

            $client->phone_ids = $phones->id;
            $client->save();
        }

        if ($request->filled('bank_id') || $request->filled('bank_account_number') || $request->filled('iban')) {
            $banks = new ClientBank();
            $banks->bank_id = $request->bank_id ?? $banks->bank_id;
            $banks->client_id = $client->id;
            $banks->bank_account_number = $request->bank_account_number ?? $banks->bank_account_number;
            $banks->iban = $request->iban ?? $banks->iban;
            $banks->save();
        }

        if ($request->filled('ministry_id')) {
            $ministries = new ClientMinistry();
            $ministries->ministry_id = $request->ministry_id ?? $ministries->ministry_id;
            $ministries->client_id = $client->id ?? $ministries->client_id;
            $ministries->save();
        }

        // Handle image uploads
        if ($request->has('images')) {
            foreach ($request->input('images') as $key => $imageData) {
                if ($request->hasFile("images.$key.path")) {
                    $imagePath = $request->file("images.$key.path")->store('uploads/new_photos', 'public');

                    ClientImg::create([
                        'path' => $imagePath,
                        'type' => $imageData['type'],
                        'client_id' => $client->id,
                        'created_by' => Auth::id(),
                    ]);
                }
            }
        }

        return redirect()->route('clients.index')->with('success', 'تم تحديث العميل بنجاح');
    }

    public function destroy($id)
    {
        $data = Client::findOrFail($id);
        $data->delete();
        return redirect()->route('clients.index')->with('success', 'تم حذف العميل بنجاح');
    }





    public function show_client($id)
    {
             // dd($id);
          $client=Prev_cols_clients::where('client_id',$id)->first();




        $title = "العملاء";
        $breadcrumb = array();
        $breadcrumb[0]['title'] = " الرئيسية";
        $breadcrumb[0]['url'] = route("dashboard");
        $breadcrumb[1]['title'] = "الموارد البشرية";
        $breadcrumb[1]['url'] = route("dashboard");
        $breadcrumb[2]['title'] = $title;
        $breadcrumb[2]['url'] = route("clients.index");
        $breadcrumb[3]['title'] = 'تعديل العملاء';
        $breadcrumb[3]['url'] = 'javascript:void(0);';

        $view = 'HumanResources.edit_clients';
        return view(
            'layout',
            compact(
                'title',
                'view',
                'breadcrumb',
                'client',

            ),$this->data
        );







    }
}
