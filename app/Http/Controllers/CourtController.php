<?php

namespace App\Http\Controllers;

use App\Models\Court;
use App\Models\Governorate;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\StoreCourtRequest;
use Yajra\DataTables\Facades\DataTables;
use App\Http\Requests\UpdateCourtRequest;
use Illuminate\Support\Facades\Validator;
use App\Interfaces\CourtRepositoryInterface;

class CourtController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

     protected $CourtRepository;

     public function __construct(CourtRepositoryInterface $CourtRepository)
     {
         $this->CourtRepository = $CourtRepository;
     }
    public function index()
    {
        //
        // return response()->json($permissions);
        $title='المحاكم';
        $breadcrumb = array();
        $breadcrumb[0]['title'] = " الرئيسية";
        $breadcrumb[0]['url'] = route("dashboard");
       $breadcrumb[1]['title'] = $title;
        $breadcrumb[1]['url'] = 'javascript:void(0);';
    
        $data['courts']=$this->CourtRepository->index();
        $data['government']=Governorate::all();
    
        if ($data['courts']) {
            // $user_id = 1;
              $user_id =  Auth::user()->id ?? null;
            $message = "تم الدخول لصفحة المحاكم ";
            $this->log($user_id, $message);
        }
    
    
        $data['view'] = 'setting/courts';
        return view('layout', $data, compact('breadcrumb','data'));
        // return view('courts.index', compact('courts'));
        // return $this->respondSuccess($data, 'Get Data successfully.');
    }

    public function getall(Request $request)
    {
        if ($request->ajax()) {
            $data = $this->CourtRepository->index(); // Or you can use Branch::select('*');
            return DataTables::of($data)->make(true);
            // $data = Court::select('*');
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
        return view('courts.create');
    }

    public function store(Request $request)
    {
        $messages = [
            'name_ar.required' => 'الاسم بالعربى  مطلوب.',
            'name_en.required' => 'الاسم بالانجليزية  مطلوب.',
            'governorate_id.required' => 'المحافظة   مطلوب.',
        ];

        $validatedData = Validator::make($request->all(), [
            'name_ar' => 'required',
            'name_en' => 'required',
            'governorate_id' =>'required'
        ], $messages);

        if ($validatedData->fails()) {

            return redirect()->back()->withErrors($validatedData)->withInput();
        }
        $data = $this->CourtRepository->store($request);
        // return response()->json($nationalities);
        return redirect()->route('courts.index')->with('success', 'Court created successfully.');
        // return $this->respondSuccess(result: $data, message: 'Store Data successfully.');
    }

    
   

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Court  $court
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $data = $this->CourtRepository->show($id);

        if ($data) {
            $user_id = 1;
            //   $user_id =  Auth::user()->id,
            $message = "تم عرض محكمة {$data->name_ar} ";
            $this->log($user_id, $message);
        }
        return response()->json($data);
        // return view('courts.show', compact('court'));
        // return $this->respondSuccess($data, 'Get Data successfully.');

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Court  $court
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $data = $this->CourtRepository->show($id);
        if ($data) {
            $user_id = 1;
            //   $user_id =  Auth::user()->id,
            $message = "تم عرض محكمة {$data->name_ar} ";
            $this->log($user_id, $message);
        }
        return response()->json($data);
        // return view('courts.edit', compact('court'));
        // return $this->respondSuccess($data, message: 'Get Data successfully.');

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateCourtRequest  $request
     * @param  \App\Models\Court  $court
     * @return \Illuminate\Http\Response
     */
    public function update($id ,  Request $request)
    {
        //
        $data = $this->CourtRepository->update($id  ,$request);

        if ($data) {
            $user_id = 1;
            //   $user_id =  Auth::user()->id,
            $message = "تم تعديل محكمة {$data->name_ar} ";
            $this->log($user_id, $message);
        }
        // return response()->json($data);
        return redirect()->back()->with('success', 'Court updated successfully.');
        // return $this->respondSuccess($data, 'Update Data successfully.');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Court  $court
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
        $data = $this->CourtRepository->destroy($id);

        if ($data) {
            $user_id = 1;
            //   $user_id =  Auth::user()->id,
            $message = "تم مسح محكمة {$data->name_ar} ";
            $this->log($user_id, $message);
        }
        // return response()->json($data);
        return redirect()->back()->with('success', 'Court updated successfully.');
        // return response()->json($data);
        // return $this->respondSuccess($data, message: 'Delete Data successfully.');
        // return redirect()->route('courts.index')->with('success', 'Court deleted successfully.');
    }
}
