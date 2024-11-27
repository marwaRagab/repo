<?php

namespace App\Http\Controllers;

use App\Models\Bank;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreBankRequest;
use App\Http\Requests\UpdateBankRequest;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Validator;
use App\Interfaces\BankRepositoryInterface;

class BankController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    protected $BankRepository;

    public function __construct(BankRepositoryInterface $BankRepository)
    {
        $this->BankRepository = $BankRepository;
    }
    public function index()
    {
        // dd("dd");
        // $banks = $this->BankRepository->index();
        // // return response()->json($permissions);
        // return view('banks.index', compact('banks'));
        $title='البنوك';

        $breadcrumb = array();
        $breadcrumb[0]['title'] = " الرئيسية";
        $breadcrumb[0]['url'] = route("dashboard");
   
        $breadcrumb[1]['title'] = $title;
        $breadcrumb[1]['url'] = 'javascript:void(0);';

        $data['bank']=Bank::with('user')->get();

        if ($data) {
            $user_id = 1;
            //   $user_id =  Auth::user()->id,
            $message = "تم الدخول لصفحة البنوك ";
            $this->log($user_id, $message);
        }

        // dd($data);

        $data['view'] = 'setting/bank';
        return view('layout', $data, compact('breadcrumb','data'));
    }

    public function getall(Request $request)
    {
        if ($request->ajax()) {

            $data = $this->BankRepository->index(); // Or you can use Branch::select('*');
            return DataTables::of($data)->make(true);
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('banks.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StorePermissionRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $messages = [
            'name_ar.required' => 'الاسم بالعربى  مطلوب.',
            'name_en.required' => 'الاسم بالانجليزية  مطلوب.',
            'bank_account_number.required'=>'رقم حساب البنك مطلوب' ,
            'bank_account_date.required'=>'تاريخ حساب البنك مطلوب' ,
            'iban.required'=>'مطلوب',
            'branch.required'=>'مطلوب',
            'authorized_signatory_1.required'=>'مطلوب',
            'authorized_signatory_2.required'=>'مطلوب',
            'authorized_signatory_3.required'=>'مطلوب',
        ];

        $validatedData = Validator::make($request->all(), [
            'name_ar' => 'required',
            'name_en' => 'required',
            'bank_account_number' => 'required',
            'bank_account_date' => 'required',
            'iban' => 'required',
            'branch' => 'required',
            'authorized_signatory_1' => 'required',
            'authorized_signatory_2' => 'required',
            'authorized_signatory_3' => 'required',
        ], $messages);

        if ($validatedData->fails()) {

            return redirect()->back()->withErrors($validatedData)->withInput();
        }

        $data = $this->BankRepository->store($request);

        if ($data) {
            $user_id = 1;
            //   $user_id =  Auth::user()->id,
            $message = "تم اضافة  بنك بنجاح";
            $this->log($user_id, $message);
        }
        // return response()->json($data);
        return redirect()->back()->with('success', 'Bank created successfully.');
        // return $this->respondSuccess($data, 'Store Data successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Permission  $permission
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $data = $this->BankRepository->show($id);
        // return view('banks.show', compact('bank'));

        if ($data) {
            $user_id = 1;
            //   $user_id =  Auth::user()->id,
            $message = "تم عرض  بنك {$data->name_ar}";
            $this->log($user_id, $message);
        }

        // $data = $this->BankRepository->show($id);
        return response()->json($data);
        // return $this->respondSuccess($data, 'Get Data successfully.');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Permission  $permission
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $data = $this->BankRepository->edit($id);
        // return view('banks.edit', compact('bank'));
        // $data = $this->BankRepository->show($id);
        if ($data) {
            $user_id = 1;
            //   $user_id =  Auth::user()->id,
            $message = "تم عرض  بنك {$data->name_ar}";
            $this->log($user_id, $message);
        }
        return response()->json($data);
        // return $this->respondSuccess($data, 'Get Data successfully.');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdatePermissionRequest  $request
     * @param  \App\Models\Permission  $permission
     * @return \Illuminate\Http\Response
     */
    public function update($id ,  Request $request)
    {
        //
        // dd($request-);
        $data = $this->BankRepository->update($id  ,$request);

        if ($data) {
            $user_id = 1;
            //   $user_id =  Auth::user()->id,
            $message = "تم تعديل  بنك {$data->name_ar}";
            $this->log($user_id, $message);
        }
        // return response()->json($data);
        return redirect()->route('banks.index')->with('success', 'Bank updated successfully.');
        // return $this->respondSuccess($data, 'Update Data successfully.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Permission  $permission
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
        $data = $this->BankRepository->destroy($id);

        if ($data) {
            $user_id = 1;
            //   $user_id =  Auth::user()->id,
            $message = "تم مسح  بنك {$data->name_ar}";
            $this->log($user_id, $message);
        }
        // return response()->json($data);
        return redirect()->back()->with('success', 'Bank deleted successfully.');
        // return $this->respondSuccess($data, 'Delete Data successfully.');
    }
}
