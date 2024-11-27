<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Validator;
use App\Interfaces\WorkingIncomeRepositoryInterface;
use App\Models\Log;
use Illuminate\Support\Facades\Auth;

class WorkingIncomeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    protected $WorkingIncomeRepository;

    public function __construct(WorkingIncomeRepositoryInterface $WorkingIncomeRepository)
    {
        $log = new Log;
        $log->user_id = Auth::user()->id ?? null;
        $log->date = now()->format('Y-m-d');
        $log->time = now()->format('h:i:s');
        $log->description ="تم دخول صفحة جهات العمل" ;
        $log->save();
        $this->WorkingIncomeRepository = $WorkingIncomeRepository;
    }
    public function index()
    {
        // dd("dd");
        return $this->WorkingIncomeRepository->index();
        // return response()->json($permissions);
        // return view('ministries.index', compact('ministries'));
        // return $this->respondSuccess($data, 'Get Data successfully.');
    }

    public function getall(Request $request)
    {
        if ($request->ajax()) {
            $data = $this->WorkingIncomeRepository->index(); // Or you can use Branch::select('*');
            return DataTables::of($data)->make(true);
            // $data = Ministry::select('*');
            // return DataTables::of($data)->toJson();
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('ministries.create');
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
            'name_ar.required' => 'الاسم بالعربى  مطلوب.',
            'name_en.required' => 'الاسم بالانجليزية  مطلوب.',
            'date.required' => 'التاريخ   مطلوب.',
            // 'percent.required' => 'النسب   مطلوب.',
        ];

        $validatedData = Validator::make($request->all(), [
            'name_ar' => 'required',
            'name_en' => 'required',
            'date'=>'required',
            // 'percent'=>'required',
        ], $messages);

        if ($validatedData->fails()) {

            return redirect()->back()->withErrors($validatedData)->withInput();
        }
        
        $data = $this->WorkingIncomeRepository->store($request);
        // return response()->json($data);
        return redirect()->route('WorkingIncome.index')->with('success', 'Working Income created successfully .'); 
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
        $ministries = $this->WorkingIncomeRepository->show($id);
        return view(view: 'WorkingIncome.show', data: compact('ministries'));

        // return response()->json($data);
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
        $data = $this->WorkingIncomeRepository->show($id);
        // return response()->json($data);
        // return $this->respondSuccess($data, 'Get Data successfully.');

        return view('ministries.edit', compact('ministries'));
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
        $data = $this->WorkingIncomeRepository->update($id  ,$request);
        // return response()->json($data);
        // return $this->respondSuccess($data, 'Update Data successfully.');
        return redirect()->route('WorkingIncome.index')->with('success', 'Working Income updated successfully .'); 
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
        $data = $this->WorkingIncomeRepository->destroy($id);
        // return response()->json($data);
        // return $this->respondSuccess($data, 'Delete Data successfully.');
        return redirect()->route('WorkingIncome.index')->with('success', 'Working Income deleted successfully .'); 
    }
}
