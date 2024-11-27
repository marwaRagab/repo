<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\InstallmentCar;
use App\Models\Installment_Client;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Validator;
use App\Http\Requests\StoreInstallmentCarRequest;
use App\Http\Requests\UpdateInstallmentCarRequest;
use App\Interfaces\InstallmentCarRepositoryInterface;

class InstallmentCarController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    protected $InstallmentCarRepository;

    public function __construct(InstallmentCarRepositoryInterface $InstallmentCarRepository)
    {
        $this->InstallmentCarRepository = $InstallmentCarRepository;
    }
   public function index()
   {
       //
       $data = $this->InstallmentCarRepository->index();
       if($data)
         {
                 $user_id =  Auth::user()->id ?? null;
                 $message ="تم الدخول الى صفحة استعلام السيارات";
                 $this->log($user_id,$message);
         }
       // return response()->json($permissions);
       return $this->respondSuccess($data, 'Get Data successfully.');
   }

   public function getall(Request $request)
   {
       if ($request->ajax()) {
           $data = InstallmentCar::select('*');
           return DataTables::of($data)->toJson();
       }
   }

   /**
    * Show the form for creating a new resource.
    *
    * @return \Illuminate\Http\Response
    */
   
    public function create($id)
   {
    $Installment_Client = Installment_Client::where('id', $id)->first();
    
                 $user_id =  Auth::user()->id ?? null;
                 $message ="تم فتح صفحة لانشاء اتعلام سيارات " ;
                 $this->log($user_id,$message);
       
    return view('installmentClient.car',compact('Installment_Client'));
   }

   public function store(Request $request)
{

    // dd("s");
    
    // $messages = [
    //     'installment_clients_id.required' => 'رقم التعريف مطلوب.',
    //     'installment_car.*.type_car.required' => 'نوع السيارة مطلوب.',
    //     'installment_car.*.model_year.required' => 'سنة الموديل مطلوب.',
    //     'installment_car.*.model_year.integer' => 'سنة الموديل يجب أن تكون رقمًا.',
    //     'installment_car.*.average_price.required' => 'متوسط السعر مطلوب.',
    //     'installment_car.*.average_price.numeric' => 'متوسط السعر يجب أن يكون رقمًا.',
    // ];

    // $validatedData = $request->validate([
    //     'installment_clients_id' => 'required|integer|exists:installment_clients,id',
    //     'installment_car' => 'required|array',
    //     'installment_car.*.type_car' => 'required|string|max:255',
    //     'installment_car.*.model_year' => 'required|integer|min:1900|max:' . date('Y'),
    //     'installment_car.*.average_price' => 'required|numeric|min:0',
    //     'installment_car.*.image' => 'nullable|file|mimes:jpg,jpeg,png|max:2048',
    // ], $messages);

    $data = $this->InstallmentCarRepository->store($request);

    if ($data) {
        if($request->exist == "notexist")
        {
            $message = "تم استعلام السيارات  ولا يوجد سيارات ";
        }
        else
        {
            $message = "تم اضافه استعلام السيارات جديد " . count($data);
        }
        // Log the creation and add any related notes.
        // $message = "تم اضافه استعلام السيارات جديد " . count($data);
        $this->log(Auth::user()->id ?? null, $message);
        $this->installment_notes($request->installment_clients_id, $message);

        // return redirect()->route('myinstall.index', ['status' => 'car_inquiry'])
        // ->with('success', 'تم إضافة استعلام السيارات بنجاح.');
        return redirect()->back();
        }

    return redirect()->back()->withErrors('فشل في إضافة استعلام السيارات.');
}

   /**
    * Display the specified resource.
    *
    * @param  \App\Models\Region  $Region
    * @return \Illuminate\Http\Response
    */
   public function show($id)
   {
       $data = $this->InstallmentCarRepository->show($id);

       if($data)
         {
                 $message ="تم عرض استعلام  السيارات {data->type_car} ";
                 $this->log(Auth::user()->id ?? null,$message);
         }
       // return response()->json($data);
       return $this->respondSuccess($data, 'Get Data successfully.');

   }

   /**
    * Show the form for editing the specified resource.
    *
    * @param  \App\Models\Region  $Region
    * @return \Illuminate\Http\Response
    */
   public function edit($id)
   {
       $data = $this->InstallmentCarRepository->show($id);

       if($data)
       {
               $message ="تم عرض استعلام  السيارات {data->type_car} ";
               $this->log(Auth::user()->id ?? null,$message);
       }
       // return response()->json($data);
       return $this->respondSuccess($data, message: 'Get Data successfully.');

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
       $data = $this->InstallmentCarRepository->update($id  ,$request);
       if($data)
       {
               $message ="تم تعديل على استعلام  السيارات {data->type_car} ";
               $this->log(Auth::user()->id ?? null,$message);
       }
       // return response()->json($data);
       return $this->respondSuccess($data, 'Update Data successfully.');

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
       $data = $this->InstallmentCarRepository->destroy($id);
       if($data)
       {
               $message ="تم مسح استعلام  السيارات {data->type_car} ";
               $this->log(Auth::user()->id ?? null,$message);
       }
       // return response()->json($data);
       return $this->respondSuccess($data, message: 'Delete Data successfully.');
   }
}
