<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Ministry_Percentage;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Validator;
use App\Http\Requests\StoreMinistry_PercentageRequest;
use App\Http\Requests\UpdateMinistry_PercentageRequest;
use App\Interfaces\MinistryPercentageRepositoryInterface;
use Illuminate\Support\Facades\Auth;

class MinistryPercentageController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    protected $MinistryPercentageRepository;

    public function __construct(MinistryPercentageRepositoryInterface $MinistryPercentageRepository)
    {
        $this->MinistryPercentageRepository = $MinistryPercentageRepository;
    }
    public function index()
    {
        // $user_id = 1;
          $user_id =  Auth::user()->id ?? null;
        $message = "تم الدخول لصفحة نسب الوزاراء ";
        $this->log($user_id, $message);
        return $this->MinistryPercentageRepository->index();
        // return response()->json($permissions);
    }

    public function getall(Request $request)
    {
        if ($request->ajax()) {
            $data = Ministry_Percentage::select('*');
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
        
        $data = $this->MinistryPercentageRepository->store($request);
        // return response()->json($data);
        return redirect()->route('ministry_percentages.index')->with('success', 'ministry percentages created successfully .');   
     }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Permission  $permission
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $data = $this->MinistryPercentageRepository->show($id);
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
        $data = $this->MinistryPercentageRepository->show($id);
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
        $data = $this->MinistryPercentageRepository->update($id  ,$request);
        // return response()->json($data);
        return redirect()->route('ministry_percentages.index')->with('success', 'ministry percentages updated successfully .');   
     }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Permission  $permission
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $data = $this->MinistryPercentageRepository->destroy($id);
        // return response()->json($data);
        return redirect()->route('ministry_percentages.index')->with('success', 'ministry percentages deleted successfully .');
    }
}
