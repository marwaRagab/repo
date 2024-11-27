<?php

namespace App\Http\Controllers;

use App\Models\Region;
use App\Models\Governorate;
use Illuminate\Http\Request;
use App\Models\Police_station;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\Facades\DataTables;
use App\Http\Requests\StoreRegionRequest;
use Illuminate\Support\Facades\Validator;
use App\Http\Requests\UpdateRegionRequest;
use App\Interfaces\RegionRepositoryInterface;


class RegionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    protected $RegionRepository;

    public function __construct(RegionRepositoryInterface $RegionRepository)
    {
        $this->RegionRepository = $RegionRepository;
    }
   public function index()
   {
    $title='المناطق';
    $breadcrumb = array();
    $breadcrumb[0]['title'] = " الرئيسية";
    $breadcrumb[0]['url'] = route("dashboard");
  $breadcrumb[1]['title'] = $title;
        $breadcrumb[1]['url'] = 'javascript:void(0);';

    $data['region']=$this->RegionRepository->index();
    $data['Police_station']= Police_station::all();

    if ($data['region']) {
        // $user_id = 1;
          $user_id =  Auth::user()->id ?? null;
        $message = "تم الدخول لصفحة المناطق ";
        $this->log($user_id, $message);
    }

    $data['view'] = 'setting/region';
    return view('layout', $data, compact('breadcrumb','data'));
    //    $data =
    //    // return response()->json($permissions);
    //    return $this->respondSuccess($data, 'Get Data successfully.');
   }

   public function getall(Request $request)
   {
       if ($request->ajax()) {
           $data = Region::select('*');
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

   public function store(Request $request)
   {
       $messages = [
           'name_ar.required' => 'الاسم بالعربى  مطلوب.',
           'name_en.required' => 'الاسم بالانجليزية  مطلوب.',
           'police_station_id.required' => 'المحافظة   مطلوب.',
       ];

       $validatedData = Validator::make($request->all(), [
           'name_ar' => 'required',
           'name_en' => 'required',
           'police_station_id' =>'required'
       ], $messages);

       if ($validatedData->fails()) {

        return redirect()->back()->withErrors($validatedData)->withInput();
       }
       $data = $this->RegionRepository->store($request);
       if ($data) {

        //$user_id = 1;
           $user_id =  Auth::user()->id ?? null;

        $message = "تم اضافة منطقة جديدة";
        $this->log($user_id, $message);
    }

       return redirect()->back()->with('success', 'region created successfully.');
       // return response()->json($nationalities);
    //    return $this->respondSuccess(result: $data, message: 'Store Data successfully.');
   }




   /**
    * Display the specified resource.
    *
    * @param  \App\Models\Region  $Region
    * @return \Illuminate\Http\Response
    */
   public function show($id)
   {
       $data = $this->RegionRepository->show($id);
       // return response()->json($data);
    //    return $this->respondSuccess($data, 'Get Data successfully.');

    if ($data) {
        // $user_id = 1;
          $user_id =  Auth::user()->id ?? null;
        $message = "تم عرض منطقة {$data->name_ar}";
        $this->log($user_id, $message);
    }

    //    return redirect()->back()->with('success', 'Bank created successfully.');
    return response()->json($data);

   }

   /**
    * Show the form for editing the specified resource.
    *
    * @param  \App\Models\Region  $Region
    * @return \Illuminate\Http\Response
    */
   public function edit($id)
   {
       $data = $this->RegionRepository->show($id);
       // return response()->json($data);
       if ($data) {
        // $user_id = 1;
          $user_id =  Auth::user()->id ?? null;
        $message = "تم عرض منطقة {$data->name_ar}";
        $this->log($user_id, $message);
    }

    //    return redirect()->back()->with('success', 'Bank created successfully.');
     return response()->json($data);

   }

   /**
    * Update the specified resource in storage.
    *
    * @param  \App\Http\Requests\UpdateRegionRequest  $request
    * @param  \App\Models\Region  $Region
    * @return \Illuminate\Http\Response
    */
   public function update($id ,  Request $request)
   {
       //
       $data = $this->RegionRepository->update($id  ,$request);
       // return response()->json($data);
    //    return $this->respondSuccess($data, 'Update Data successfully.');
    if ($data) {
        // $user_id = 1;
          $user_id =  Auth::user()->id ?? null;
        $message = "تم تعديل منطقة {$data->name_ar}";
        $this->log($user_id, $message);
    }

       return redirect()->back()->with('success', 'region created successfully.');
    // return response()->json($data);

   }

   /**
    * Remove the specified resource from storage.
    *
    * @param  \App\Models\Region  $Region
    * @return \Illuminate\Http\Response
    */
   public function destroy($id)
   {
       //
       $data = $this->RegionRepository->destroy($id);
       // return response()->json($data);
    //    return $this->respondSuccess($data, message: 'Delete Data successfully.');
            if ($data) {
                // $user_id = 1;
                  $user_id =  Auth::user()->id ?? null;
                $message = "تم مسح منطقة {$data->name_ar}";
                $this->log($user_id, $message);
            }

               return redirect()->back()->with('success', 'region deleted successfully.');
            // return response()->json($data);
   }

   public function filter($id)
   {

     $title='المناطق';
    $breadcrumb = array();
    $breadcrumb[0]['title'] = " الرئيسية";
    $breadcrumb[0]['url'] = route("dashboard");
$breadcrumb[1]['title'] = $title;
        $breadcrumb[1]['url'] = 'javascript:void(0);';

    $data['region']=Region::where('governorate_id','=',$id)->get();
    $data['Police_station']=Police_station::all();

    if ($data['region']) {
        // $user_id = 1;
          $user_id =  Auth::user()->id ?? null;
        $message = "تم الدخول لصفحة المناطق ";
        $this->log($user_id, $message);
    }


    $data['view'] = 'setting/region';
    return view('layout', $data, compact('breadcrumb','data'));
    //  return redirect()->route('region.index',compact('data'));
   }
}
