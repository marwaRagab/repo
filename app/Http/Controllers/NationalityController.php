<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use App\Models\Nationality;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Validator;
use App\Http\Requests\StoreNationalityRequest;
use App\Http\Requests\UpdateNationalityRequest;
use App\Interfaces\NationalityRepositoryInterface;
use Illuminate\Support\Facades\Auth;

class NationalityController extends Controller
{
    protected $NationalityRepository;

    public function __construct(NationalityRepositoryInterface $NationalityRepository)
    {
        $this->NationalityRepository = $NationalityRepository;
    }
    public function index()
    {
        // $user_id = 1;
          $user_id =  Auth::user()->id ?? null;
        $message = "تم الدخول لصفحة الجنسيات ";
        $this->log($user_id, $message);
        return $this->NationalityRepository->index();
        // return response()->json($permissions);
        // return $this->respondSuccess($data, 'Get Data successfully.');
        // return view('nationalities.index', compact(var_name: 'nationalities'));
    }

    

     
    // public function index(Request $request)
    // {
    //     $nationalities = $this->NationalityRepository->index($request);

    //     // dd($request->ajax());

    //     // if ($request->ajax() ) {
            
    //         // dd("true");
    //     //     return DataTables::of($nationalities)
    //     //     ->addColumn('action', function ($row) {
    //     //         return '<a href="#" class="btn btn-info" onclick="viewNationality(' . $row->id . ')">View</a>
    //     //                 <a href="/nationalities/' . $row->id . '/edit" class="btn btn-primary">Edit</a>
    //     //                 <button class="btn btn-danger" onclick="deleteNationality(' . $row->id . ')">Delete</button>';
    //     //     })
    //     //         ->rawColumns(['action'])
    //     //         ->make(true);
    //     // }
    
    //     // return Inertia::render('NationalityManager');
    //     return response()->json($nationalities);
    // }

    public function getall(Request $request)
    {
        if ($request->ajax()) {
            $data = $this->NationalityRepository->index(); // Or you can use Branch::select('*');
            return DataTables::of($data)->make(true);
            // $data = Nationality::select('*');
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
        return view('nationalities.create');
        
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreNationalityRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $messages = [
            'name_ar.required' => 'الاسم بالعربى  مطلوب.',
            'name_en.required' => 'الاسم بالانجليزية  مطلوب.',
        ];

        $validatedData = Validator::make($request->all(), [
            'name_ar' => 'required',
            'name_en' => 'required',
        ], $messages);

        if ($validatedData->fails()) {

            return redirect()->back()->withErrors($validatedData)->withInput();
        }
        return $this->NationalityRepository->store($request);
        // return response()->json($nationalities);
        return redirect()->route('nationality.index')->with('success', 'Nationality created successfully.');
        // return $this->respondSuccess(result: $data, message: 'Store Data successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Nationality  $nationality
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $nationalities = $this->NationalityRepository->show($id);
        // return response()->json($data);
        // return $this->respondSuccess($data, 'Get Data successfully.');
        return view('nationality.show', data: compact('nationalities'));

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Nationality  $nationality
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $nationalities = $this->NationalityRepository->edit($id);
        return view('nationality.edit', compact('nationalities'));
        // return response()->json($data);
        // return $this->respondSuccess($data, message: 'Get Data successfully.');

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateNationalityRequest  $request
     * @param  \App\Models\Nationality  $nationality
     * @return \Illuminate\Http\Response
     */
    
    public function update($id ,  Request $request)
    {
        
        $data = $this->NationalityRepository->update($id  ,$request);
        // return response()->json($data);
        // return $this->respondSuccess($data, 'Update Data successfully.');
        return redirect()->route('nationality.index')->with('success', 'Nationality updated successfully.');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Nationality  $nationality
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $data = $this->NationalityRepository->destroy($id);
        // return response()->json($data);
        return redirect()->route('nationality.index')->with('success', 'Nationality deleted successfully.');
        // return $this->respondSuccess($data, message: 'Delete Data successfully.');
    }
}
