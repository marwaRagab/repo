<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Installment_Percentage;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Validator;
use App\Http\Requests\StoreInstallment_PercentageRequest;
use App\Http\Requests\UpdateInstallment_PercentageRequest;
use App\Interfaces\InstallmentPercentageRepositoryInterface;

class InstallmentPercentageController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    protected $InstallmentPercentageRepository;

    public function __construct(InstallmentPercentageRepositoryInterface $InstallmentPercentageRepository)
    {
        $this->InstallmentPercentageRepository = $InstallmentPercentageRepository;
    }
    public function index()
    {
        // $user_id = 1;
          $user_id =  Auth::user()->id ?? null;
        $message = "تم الدخول لصفحة نسب التقسيط ";
        $this->log($user_id, $message);
        return $this->InstallmentPercentageRepository->index();
        // return response()->json($permissions);
    }

    public function getall(Request $request)
    {
        if ($request->ajax()) {
            $data = Installment_Percentage::select('*');
            return DataTables::of($data)->toJson();
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StorePermissionRequest  $request
     * @return Response
     */
    public function store(Request $request)
    {
        $messages = [
            'name.required' => 'الاسم   مطلوب.',
            'percent.required' => 'النسب   مطلوب.',
        ];

        $validatedData = Validator::make($request->all(), [
            'name' => 'required',
            'percent'=>'required',
        ], $messages);

        if ($validatedData->fails()) {

            return redirect()->back()->withErrors($validatedData)->withInput();
        }
        
        $data = $this->InstallmentPercentageRepository->store($request);
        $user_id =  Auth::user()->id ?? null;
        $message = "تم اضافة نسبة تقسيط جديدة ";
        $this->log($user_id, $message);
        // return response()->json($data);
        return redirect()->route('installment__percentages.index')->with('success', 'Installment Percentage created successfully .');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Permission  $permission
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $data = $this->InstallmentPercentageRepository->show($id);
        $user_id =  Auth::user()->id ?? null;
        $message = "تم عرض نسبة تقسيط  ";
        $this->log($user_id, $message);
        // return response()->json($data);
        return $this->respondSuccess($data, 'Get Data successfully.');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Permission  $permission
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $data = $this->InstallmentPercentageRepository->show($id);
        $user_id =  Auth::user()->id ?? null;
        $message = "تم عرض نسبة تقسيط  ";
        $this->log($user_id, $message);
        // return response()->json($data);
        return $this->respondSuccess($data, 'Get Data successfully.');
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
        $data = $this->InstallmentPercentageRepository->update($id  ,$request);
        $user_id =  Auth::user()->id ?? null;
        $message = " تم تعديل  نسبة تقسيط {$data->name} ";
        $this->log($user_id, $message);
        // return response()->json($data);
        return redirect()->route('installment__percentages.index')->with('success', 'Installment Percentage updated successfully .');
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
        $data = $this->InstallmentPercentageRepository->destroy($id);
        $user_id =  Auth::user()->id ?? null;
        $message = " تم مسح  نسبة تقسيط {$data->name} ";
        $this->log($user_id, $message);
        // return response()->json($data);
        return redirect()->route('installment__percentages.index')->with('success', 'Installment Percentage deleted successfully .');
    }
}
