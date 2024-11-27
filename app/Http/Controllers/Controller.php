<?php

namespace App\Http\Controllers;

use App\Models\Log;
use App\Models\InstallmentNote;
use Illuminate\Support\Facades\Auth;
use App\Models\InstallmentClientNote;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function respondSuccess($result, $message, $code = 200)
    {
        $response = [
            'code' => $code,
            'status' => true,
            'message' => $message,
            'data' => $result,
            'errorData' => null,
        ];


        return response()->json($response, $code);
    }
 
    public function respondSuccessPaginate($result, $message, $code = 200)
    { 
        unset($result->meta->links);
      
        $response = [
            'code' => $code,
            'status' => true,
            'message' => $message,
            'data' =>$result->data ,
            'pagination'=>$result->meta,
            'errorData' => null,
        ];


        return response()->json($response, $code);
    }

    /**
     * @param $message
     * @return \Illuminate\Http\JsonResponse
     */
    public function respondError($error, $errorMessages = [], $code)
    {
        if ($code == 404) {
            $code1 = 404;
        } elseif ($code == 500) {
            $code1 = 500;
        } else {
            $code1 = 200;
        }
        $response = [
            'code' => $code,
            'status' => false,
            'message' => $error,
            'data' =>null,
        ];


        if (!empty($errorMessages)) {
            $response['errorData'] = $errorMessages;
        }


        return response()->json($response, $code1);
    }
    public function respondErrorArray($error, $errorMessages = [], $code)
    {
        if ($code == 404) {
            $code1 = 404;
        } elseif ($code == 500) {
            $code1 = 500;
        } else {
            $code1 = 200;
        }
     
        $response = [
            'code' => $code,
            'status' => false,
            'message' => $error,
            'data' =>[],
        ];


        if (!empty($errorMessages)) {
            $response['errorData'] = $errorMessages;
        }


        return response()->json($response, $code1);
    }

    public function respondwarning($result, $message, $errorMessages, $code = 200)
    {
        $response = [
            'code' => $code,
            'status' => false,
            'message' => $message,
            'data' => $result,
        ];


        if (!empty($errorMessages)) {
            $response['errorData'] = $errorMessages;
        }


        return response()->json($response, 200);
    }

    function log($user_id,$message)
    {
        // dd($user_id);
        $log = new Log;
        $log->user_id = $user_id;
        $log->date = now()->format('Y-m-d');
        $log->time = now()->format('h:i:s');
        $log->description =$message;
        $log->save();
    }

    function status_installment_clients($status)
    {
        if($status == "advanced")
        {
            $data=[
                    "status_ar" => "متقدمين",
                    "status_en" => "advanced"
                ];
        }
        elseif($status == "under_inquiry")
        {
            $data=[
                "status_ar" => "قيد الاستعلام",
                "status_en" => "under_inquiry"
            ];
        }
        elseif($status == "auditing")
        {
            $data=[
                "status_ar" => "التدقيق القضائى",
                "status_en" => "auditing"
            ];
        }
        elseif($status == "car_inquiry")
        {
            $data=[
                "status_ar" => "استعلام سيارات",
                "status_en" => "car_inquiry"
            ];
        }
        elseif($status == "issue_inquiry")
        {
            $data=[
                "status_ar" => "استعلام قضائى",
                "status_en" => "issue_inquiry"
            ];
        }
        elseif($status == "archive")
        {
            $data=[
                "status_ar" => "ارشفة",
                "status_en" => "archive"
            ];
        }
        elseif($status == "accepted")
        {
            $data=[
                "status_ar" => "مقبول",
                "status_en" => "accepted"
            ];
        }
        elseif($status == "accepted_condition")
        {
            $data=[
                "status_ar" => "مقبول بشرط",
                "status_en" => "accepted_condition"
            ];
        }
        elseif($status == "rejected")
        {
            $data=[
                "status_ar" => "مرفوض",
                "status_en" => "rejected"
            ];
        }
        elseif($status == "inquiry_done")
        {
            $data=[
                "status_ar" => "تم الاستعلام",
                "status_en" => "inquiry_done"
            ];
        }
        elseif($status == "transaction_submited")
        {
            $data=[
                "status_ar" => "المعاملات المقدمة",
                "status_en" => "transaction_submited"
            ];
        }
        elseif($status == "transaction_accepted")
        {
            $data=[
                "status_ar" => "المعاملات المقبولة",
                "status_en" => "transaction_accepted"
            ];
        }
        elseif($status == "transaction_refused")
        {
            $data=[
                "status_ar" => "المعاملات المرفوضة",
                "status_en" => "transaction_refused"
            ];
        }
        elseif($status == "submit_archive")
        {
            $data=[
                "status_ar" => "ارشيف المعاملات المقدمة",
                "status_en" => "submit_archive"
            ];
        }
        elseif($status == "accepted_archive")
        {
            $data=[
                "status_ar" => "ارشيف المعاملات المقبولة",
                "status_en" => "accepted_archive"
            ];
        }
       
        return $data;
    }

    function installment_notes($installment_clients_id ,$message)
    {
        $data = new InstallmentClientNote;
        $data->reply = "note_under_info";
        $data->date = now()->format('Y-m-d');
        $data->time = now()->format('h:i:s');
        $data->installment_clients_id  = $installment_clients_id ;
        $data->note = $message;
        $data->created_by = Auth::user()->id ?? null;
        $data->updated_by = Auth::user()->id ?? null;
        $data->save();
    }
}
