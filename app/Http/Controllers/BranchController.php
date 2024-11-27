<?php

namespace App\Http\Controllers;

use App\Models\Branch;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\Facades\DataTables;
use App\Http\Requests\StoreBranchRequest;
use Illuminate\Support\Facades\Validator;
use App\Http\Requests\UpdateBranchRequest;
use App\Interfaces\BranchRepositoryInterface;

class BranchController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    protected $BranchRepository;

    public function __construct(BranchRepositoryInterface $BranchRepository)
    {
        $this->BranchRepository = $BranchRepository;
    }
    public function index()
    {
        // dd("dd");
        // $branch = $this->BranchRepository->index();
        $title='الفروع';
        $breadcrumb = array();
        $breadcrumb[0]['title'] = " الرئيسية";
        $breadcrumb[0]['url'] = route("dashboard");
       $breadcrumb[1]['title'] = $title;
        $breadcrumb[1]['url'] = 'javascript:void(0);';

        $data['branch']=$this->BranchRepository->index();


        if ($data['branch']) {
            // $user_id = 1;
              $user_id =  Auth::user()->id ?? null;
            $message = "تم الدخول لصفحة  الفروع";
            $this->log($user_id, $message);
        }


        $data['view'] = 'setting/branch';
        return view('layout', $data, compact('breadcrumb','data'));
        // return view('branches.index', compact('branches'));

    }

    public function getall(Request $request)
    {
        if ($request->ajax()) {
            $data = $this->BranchRepository->index(); // Or you can use Branch::select('*');
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
        return view('branches.create');
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
        ];

        $validatedData = Validator::make($request->all(), [
            'name_ar' => 'required',
            'name_en' => 'required',
        ], $messages);

        if ($validatedData->fails()) {

            return redirect()->back()->withErrors($validatedData)->withInput();
        }

        $data = $this->BranchRepository->store($request);

        if ($data) {
            // $user_id = 1;
              $user_id =  Auth::user()->id ?? null;
            $message = "تم اضافة فرع جديد {$data->name_ar}" ;
            $this->log($user_id, $message);
        }
        // return response()->json($data);
        // return $this->respondSuccess($data, 'Store Data successfully.');
        return redirect()->back()->with('success', 'Branch created successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Permission  $permission
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $data = $this->BranchRepository->show($id);
        if ($data) {
            // $user_id = 1;
              $user_id =  Auth::user()->id ?? null;
            $message = "تم عرض فرع  {$data->name_ar}" ;
            $this->log($user_id, $message);
        }
        // return redirect()->back()->with('success', 'Branch created successfully.');
        return response()->json($data);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Permission  $permission
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $data = $this->BranchRepository->edit($id);
        if ($data) {
            // $user_id = 1;
              $user_id =  Auth::user()->id ?? null;
            $message = "تم عرض فرع  {$data->name_ar}" ;
            $this->log($user_id, $message);
        }
        // return redirect()->back()->with('success', 'Branch created successfully.');
        return response()->json($data);
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
        $data = $this->BranchRepository->update($id  ,$request);
        if ($data) {
            // $user_id = 1;
              $user_id =  Auth::user()->id ?? null;
            $message = "تم تعديل فرع  {$data->name_ar}" ;
            $this->log($user_id, $message);
        }
        return redirect()->back()->with('success', 'Branch created successfully.');
        // return response()->json($data);
        // return redirect()->route('branches.index')->with('success', 'Branch updated successfully.');
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
        $data = $this->BranchRepository->destroy($id);
        if ($data) {
            // $user_id = 1;
              $user_id =  Auth::user()->id ?? null;
            $message = "تم مسح فرع  {$data->name_ar}" ;
            $this->log($user_id, $message);
        }
        return redirect()->back()->with('success', 'Branch created successfully.');
        // return response()->json($data);
        // return redirect()->route('branches.index')->with('success', 'Branch deleted successfully.');

    }
}
