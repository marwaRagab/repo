<?php

namespace App\Http\Controllers;

use App\Models\Bank;
use App\Models\Military_affairs\Military_affair;
use App\Models\Military_affairs\Military_affairs_certificate_type;
use App\Models\Military_affairs\Military_affairs_status;
use App\Models\Military_affairs\Military_affairs_stop_bank_type;
use App\Models\Military_affairs\Military_affairs_stop_car_type;
use App\Models\Military_affairs\Stop_travel_types;
use App\Models\Ministry;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreBankRequest;
use App\Http\Requests\UpdateBankRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Validator;
use App\Interfaces\BankRepositoryInterface;

class old_dbController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */


    public function index($type)
    {

        $array =[];


            $items = DB::table('military_affairs_old')
                ->where('military_affairs_old.status', 'execute')
                ->where('archived', 0)
                ->join('installment', 'installment.id', '=', 'military_affairs_old.installment_id')
                ->join('clients_old', 'installment.client_id', '=', 'clients_old.id');
                if ($type == "stop_bank") {
                    $items->join('ministries', 'clients_old.ministries_income_id', '=', 'ministries.id');
                }

                $items = $items->where('installment.finished', '=', 0)->get();

        $stop_car_request = [];
        $stop_car_info = [];
        $stop_car_police =[];
        $stop_car_catch =[];
        $stop_car_police_station =[];
        $stop_car_doing=[];
        $stop_car_finished=[];
        $stop_car_cancel_request=[];
        $stop_car_cancel=[];

        if ($type == "stop_car") {
            $stop_car_types = Military_affairs_stop_car_type::all();

            foreach ($stop_car_types as $stop_car_type_send) {
                if ($stop_car_type_send->slug == 'stop_car_request') {
                    // Apply the conditions related to 'stop_car_request'
                    $stop_car_request = $items->filter(function ($item) {
                        return $item->stop_car_info == 0 &&
                            $item->stop_car == 1 &&
                            $item->stop_car_archive == 0 &&
                            $item->stop_car_archive_type == 'not_archived' &&
                            $item->stop_car_catch == 0 &&
                            $item->stop_car_police == 0 &&
                            $item->stop_car_doing == 0 &&
                            $item->stop_car_police_station == 0 &&
                            $item->stop_car_finished == 0;
                    })->values();
                } elseif ($stop_car_type_send->slug == 'stop_car_info') {
                    // Apply the conditions related to 'stop_car_info'
                    $stop_car_info = $items->filter(function ($item) {
                        return $item->stop_car_info == 1 &&
                            $item->stop_car_request == 1 &&
                            $item->stop_car == 1 &&
                            $item->stop_car_archive == 0 &&
                            $item->stop_car_archive_type == 'not_archived' &&
                            $item->stop_car_catch == 0 &&
                            $item->stop_car_police == 0 &&
                            $item->stop_car_doing == 0 &&
                            $item->stop_car_police_station == 0 &&
                            $item->stop_car_finished == 0;
                    })->values();
                }
                elseif ($stop_car_type_send->slug == 'stop_car_police') {
                    // Apply the conditions related to 'stop_car_info'
                    $stop_car_police = $items->filter(function ($item) {
                        return $item->stop_car_info == 1 &&
                            $item->stop_car_request == 1 &&
                            $item->stop_car == 1 &&
                            $item->stop_car_archive == 0 &&
                            $item->stop_car_archive_type == 'not_archived' &&
                            $item->stop_car_catch == 0 &&
                            $item->stop_car_police == 1 &&
                            $item->stop_car_doing == 0 &&
                            $item->stop_car_police_station == 0 &&
                            $item->stop_car_finished == 0;
                    })->values();
                }
                elseif ($stop_car_type_send->slug == 'stop_car_catch') {
                    // Apply the conditions related to 'stop_car_info'
                    $stop_car_catch = $items->filter(function ($item) {
                        return $item->stop_car_info == 1 &&
                            $item->stop_car_request == 1 &&
                            $item->stop_car == 1 &&
                            $item->stop_car_archive == 0 &&
                            $item->stop_car_archive_type == 'not_archived' &&
                            $item->stop_car_catch == 1 &&
                            $item->stop_car_police == 1 &&
                            $item->stop_car_doing == 0 &&
                            $item->stop_car_police_station == 0 &&
                            $item->stop_car_finished == 0;
                    })->values();
                }

                elseif ($stop_car_type_send->slug == 'stop_car_police_station') {
                    // Apply the conditions related to 'stop_car_info'
                    $stop_car_police_station = $items->filter(function ($item) {
                        return $item->stop_car_info == 1 &&
                            $item->stop_car_request == 1 &&
                            $item->stop_car == 1 &&
                            $item->stop_car_archive == 0 &&
                            $item->stop_car_archive_type == 'not_archived' &&
                            $item->stop_car_catch == 1 &&
                            $item->stop_car_police == 1 &&
                            $item->stop_car_doing == 0 &&
                            $item->stop_car_police_station == 1 &&
                            $item->stop_car_finished == 0;
                    })->values();
                }

                elseif ($stop_car_type_send->slug == 'stop_car_doing') {
                    // Apply the conditions related to 'stop_car_info'
                    $stop_car_doing = $items->filter(function ($item) {
                        return $item->stop_car_info == 1 &&
                            $item->stop_car_request == 1 &&
                            $item->stop_car == 1 &&
                            $item->stop_car_archive == 0 &&
                            $item->stop_car_archive_type == 'not_archived' &&
                            $item->stop_car_catch == 1 &&
                            $item->stop_car_police == 1 &&
                            $item->stop_car_doing == 1 &&
                            $item->stop_car_police_station == 1 &&
                            $item->stop_car_finished == 0;
                    })->values();
                }

                elseif ($stop_car_type_send->slug == 'stop_car_finished') {
                    // Apply the conditions related to 'stop_car_info'
                    $stop_car_finished = $items->filter(function ($item) {
                        return $item->stop_car_info == 1 &&
                            $item->stop_car_request == 1 &&
                            $item->stop_car == 1 &&
                            $item->stop_car_archive == 0 &&
                            $item->stop_car_archive_type == 'not_archived' &&
                            $item->stop_car_catch == 1 &&
                            $item->stop_car_police == 1 &&
                            $item->stop_car_doing == 1 &&
                            $item->stop_car_police_station == 1 &&
                            $item->stop_car_finished == 1;
                    })->values();
                }
                elseif ($stop_car_type_send->slug == 'stop_car_cancel_request') {
                    // Apply the conditions related to 'stop_car_info'
                    $stop_car_cancel_request = $items->filter(function ($item) {
                        return $item->cancel_stop_car == 1
                            && $item->stop_car_archive_type == 'not_archived' &&
                            $item->stop_car_archive == 0;
                    })->values();
                }

                elseif ($stop_car_type_send->slug == 'stop_car_cancel') {
                    // Apply the conditions related to 'stop_car_info'
                    $stop_car_cancel = $items->filter(function ($item) {
                        return $item->cancel_stop_car == 'done'
                            && $item->stop_car_archive_type == 'not_archived' &&
                            $item->stop_car_archive == 0;
                    })->values();
                }



            }

            // Return or dump the results
            $array = [
                'stop_car_request' => $stop_car_request,
                'stop_car_info' => $stop_car_info,
                'stop_car_police' => $stop_car_police,
                'stop_car_catch' =>$stop_car_catch,
                'stop_car_police_station'=>$stop_car_police_station,
                'stop_car_doing'=>$stop_car_doing,
                'stop_car_finished'=>$stop_car_finished,
                'stop_car_cancel_request'=>$stop_car_cancel_request,
                'stop_car_cancel'=>$stop_car_cancel,
            ];

            foreach ($array as $key => $value)
            {

//            dd($value);
                foreach ($value as $item)
                {
//                dd($item->id);
                    $obj = new Military_affairs_status;
                    $obj->type = $type;
                    $obj->type_id = $key;
                    $obj->military_affairs_id  = $item->id;
                    $obj->created_by  = Auth::user()->id ?? null;
                    $obj->updated_by  = Auth::user()->id ?? null;
                    if($key == "stop_car_request")
                    {
//                    $obj = new Military_affairs_status;
//                    $obj->type = $type;
//                    $obj->type_id = $key;
//                    $obj->military_affairs_id  = $item->id;
//                    $obj->created_by  = Auth::user()->id ?? null;
//                    $obj->updated_by  = Auth::user()->id ?? null;
                        $obj->img_dir = null;
                        $obj->date = null;
                        $obj->note = null;
//                    $obj->save();
                    }
                    elseif ($key == "stop_car_info" )
                    {

                        $obj->img_dir = $item->stop_car_request_img;
                        $obj->date =  date("Y-m-d H:i:s", $item->stop_car_request_date);
                        $obj->note = null;
//                    $obj->save();
                    }
                    elseif ($key == "stop_car_police")
                    {
                        $obj->img_dir = null;
                        $obj->date = null;
                        $obj->note = null;
                    }
                    elseif ($key == "stop_car_catch")
                    {
                        $obj->img_dir = $item->stop_car_police_station_img;
                        $obj->date = date("Y-m-d H:i:s", $item->stop_car_recieve_date);
                        $obj->note = null;
                    }
                    elseif ($key == "stop_car_police_station")
                    {
                        $obj->img_dir = $item->img_dir;
                        $obj->date =  date("Y-m-d H:i:s",$item->stop_car_catch_date);
                        $obj->note = null;
                    }
                    elseif ($key == "stop_car_doing")
                    {
                        $obj->img_dir = $item->stop_car_police_station_img;
                        $obj->date =  date("Y-m-d H:i:s",$item->stop_car_police_station_date);
                        $obj->note = null;
                    }

                    elseif ($key == "stop_car_finished")
                    {
                        $obj->img_dir = null;
                        $obj->date = null;
                        $obj->note = null;
                    }
                    elseif ($key == "stop_car_cancel_request")
                    {
                        $obj->img_dir = $item->stop_car_police_station_img;
                        $obj->date =  date("Y-m-d H:i:s",$item->stop_car_police_station_date);
                        $obj->note = null;
                    }
                    elseif ($key == "stop_car_cancel")
                    {
                        $obj->img_dir = null;
                        $obj->date = null;
                        $obj->note = null;
                    }
                    $obj->save();
                }


//




            }
        }

//        stop travel
        if ($type == "stop_travel") {
            $stop_travel_types = Stop_travel_types::all();

            foreach ($stop_travel_types as $stop_travel_type_send) {

                if ($stop_travel_type_send->slug == 'request') {
                    // Apply the conditions related to 'stop_car_request'
                    $stop_car_request = $items->filter(function ($item) {
                        return $item->command == 0 &&
                            $item->stop_travel == 1 &&
                            $item->stop_travel_finished == 0;
                    })->values();
                } elseif ($stop_travel_type_send->slug == 'command') {
                    // Apply the conditions related to 'stop_car_info'
                    $stop_car_info = $items->filter(function ($item) {
                        return $item->command == 1 &&
                            $item->stop_travel == 1 &&
                            $item->stop_travel_finished == 0;
                    })->values();
                }
                elseif ($stop_travel_type_send->slug == 'stop_travel_finished') {
                    // Apply the conditions related to 'stop_car_info'
                    $stop_car_police = $items->filter(function ($item) {
                        return $item->command == 1 &&
                            $item->stop_travel == 1 &&
                            $item->stop_travel_finished == 1;
                    })->values();
                }
                elseif ($stop_travel_type_send->slug == 'stop_travel_cancel_request') {
                    // Apply the conditions related to 'stop_car_info'
                    $stop_car_catch = $items->filter(function ($item) {
                        return $item->cancel_stop_travel == 1 ;


                    })->values();
                }

                elseif ($stop_travel_type_send->slug == 'stop_travel_cancel') {
                    // Apply the conditions related to 'stop_car_info'
                    $stop_car_police_station = $items->filter(function ($item) {
                        return $item->cancel_stop_travel == 'done' ;

                    })->values();
                }




            }

            // Return or dump the results
            $array = [
                'request' => $stop_car_request,
                'command' => $stop_car_info,
                'stop_travel_finished' => $stop_car_police,
                'stop_travel_cancel_request' =>$stop_car_catch,
                'stop_travel_cancel'=>$stop_car_police_station,
//                'stop_car_doing'=>$stop_car_doing,
//                'stop_car_finished'=>$stop_car_finished,
//                'stop_car_cancel_request'=>$stop_car_cancel_request,
//                'stop_car_cancel'=>$stop_car_cancel,
            ];

//            dd($array);

            foreach ($array as $key => $value)
            {

//            dd($value);
                foreach ($value as $item)
                {
//                dd($item->id);
                    $obj = new Military_affairs_status;
                    $obj->type = $type;
                    $obj->type_id = $key;
                    $obj->military_affairs_id  = $item->id;
                    $obj->created_by  = Auth::user()->id ?? null;
                    $obj->updated_by  = Auth::user()->id ?? null;
                    if($key == "request")
                    {
//
                        $obj->img_dir = null;
                        $obj->date = null;
                        $obj->note = null;
                    }
                    elseif ($key == "command" )
                    {

                        $obj->img_dir = $item->command_img;
                        $obj->date =  date("Y-m-d H:i:s", $item->command_date);
                        $obj->note = null;
//                    $obj->save();
                    }
                    elseif ($key == "stop_travel_finished")
                    {
                        $obj->img_dir = $item->stop_travel_finished_img;
                        $obj->date = date("Y-m-d H:i:s", $item->stop_travel_finished_date);
                        $obj->note = null;
                    }
                    elseif ($key == "stop_travel_cancel_request")
                    {
                        $obj->img_dir = null;
                        $obj->date = null;
                        $obj->note = null;
                    }
                    elseif ($key == "stop_travel_cancel")
                    {
                        $obj->img_dir = null;
                        $obj->date = null;
                        $obj->note = null;
                    }


                    $obj->save();
                }


//




            }
        }


        if ($type == "Military_certificate") {
            $stop_certificate_types = Military_affairs_certificate_type::all();

            foreach ($stop_certificate_types as $stop_certificate_type_send) {

                if ($stop_certificate_type_send->slug == 'info_request') {
                    // Apply the conditions related to 'stop_car_request'
                    $stop_car_request = $items->filter(function ($item) {
                        return $item->certificate_export == 0 &&
                            $item->cancel_certificate == 1 &&
                            $item->certificate_info_book == 0
                            && $item->stop_salary == 0
                            && $item->certificate_money == 0;
                    })->values();
                } elseif ($stop_certificate_type_send->slug == 'info_book') {
                    // Apply the conditions related to 'stop_car_info'
                    $stop_car_info = $items->filter(function ($item) {
                        return $item->certificate_export == 0 &&
                            $item->cancel_certificate == 1 &&
                            $item->certificate_info_book == 1
                            && $item->certificate_money == 0
                             && $item->stop_salary == 0
                            && $item->certificate_info_request == 1;
                    })->values();
                }
                elseif ($stop_certificate_type_send->slug == 'export') {
                    // Apply the conditions related to 'stop_car_info'
                    $stop_car_police = $items->filter(function ($item) {
                        return $item->certificate_export == 1 &&
                            $item->cancel_certificate == 1 &&
                            $item->certificate_info_book == 1
                            && $item->certificate_money == 0
                            && $item->stop_salary == 0
                            && $item->certificate_info_request == 1;
                    })->values();
                }
                elseif ($stop_certificate_type_send->slug == 'money') {
                    // Apply the conditions related to 'stop_car_info'
                    $stop_car_catch = $items->filter(function ($item) {
                        return $item->certificate_export == 1 &&
                            $item->cancel_certificate == 1 &&
                            $item->certificate_info_book == 1
                            && $item->certificate_money == 1
                            && $item->stop_salary == 0
                            && $item->certificate_info_request == 1;
                    })->values();
                }






            }

            // Return or dump the results
            $array = [
                'info_request' => $stop_car_request,
                'info_book' => $stop_car_info,
                'export' => $stop_car_police,
                'money' =>$stop_car_catch,


            ];

//            dd($array);

            foreach ($array as $key => $value)
            {

//            dd($value);
                foreach ($value as $item)
                {
//                dd($item->id);
                    $obj = new Military_affairs_status;
                    $obj->type = $type;
                    $obj->type_id = $key;
                    $obj->military_affairs_id  = $item->id;
                    $obj->created_by  = Auth::user()->id ?? null;
                    $obj->updated_by  = Auth::user()->id ?? null;
                    if($key == "info_request")
                    {
//
                        $obj->img_dir = null;
                        $obj->date = null;
                        $obj->note = null;
                    }
                    elseif ($key == "info_book" )
                    {

                        $obj->img_dir = null;
                        $obj->date =  null;
                        $obj->note = null;
//                    $obj->save();
                    }
                    elseif ($key == "export")
                    {
                        $obj->img_dir = $item->certificate_info_book_img;
                        $obj->date = date("Y-m-d H:i:s", $item->certificate_info_book_date);
                        $obj->note = null;
                    }
                    elseif ($key == "money")
                    {
                        $obj->img_dir = $item->certificate_export_img;
                        $obj->date = $item->certificate_export_date;
                        $obj->note = $item->certificate_export_note;
                    }



                    $obj->save();
                }


//




            }
        }


        if ($type == "stop_bank") {
            $stop_bank_types = Military_affairs_stop_bank_type::all();
            $ministries = Ministry::pluck('id')->toArray();


            foreach ($stop_bank_types as $stop_bank_type_send) {

                if ($stop_bank_type_send->slug == 'stop_bank_request') {

                    $stop_car_request = $items->filter(function ($item) use ($ministries) {
                        return
                            in_array($item->ministries_income_id, $ministries) &&
                            $item->stop_bank_doing == 0 &&
                            $item->stop_bank == 1 &&
                            $item->stop_bank_command == 0 &&
                            $item->stop_bank_researcher == 0 &&
                            $item->bank_archive == 0 &&
                            $item->stop_bank_banks == 0;
                    })->values(); // Re-index the collection after filtering
//
                } elseif ($stop_bank_type_send->slug == 'stop_bank_command') {
                    // Apply the conditions related to 'stop_car_info'
                    $stop_car_info = $items->filter(function ($item) use ($ministries) {
                        return
                            in_array($item->ministries_income_id, $ministries) &&
                            $item->stop_bank_doing == 0 &&
                            $item->stop_bank == 1 &&
                            $item->stop_bank_command == 1
                            && $item->stop_bank_researcher == 0
                            && $item->bank_archive == 0
                            && $item->stop_bank_request == 1
                            && $item->stop_bank_banks == 0;
                    })->values();
                }
                elseif ($stop_bank_type_send->slug == 'stop_bank_researcher') {
                    // Apply the conditions related to 'stop_car_info'
                    $stop_car_police = $items->filter(function ($item) use ($ministries){
                        return in_array($item->ministries_income_id, $ministries) &&
                            $item->stop_bank_doing == 0 &&
                            $item->stop_bank == 1 &&
                            $item->stop_bank_command == 1
                            && $item->stop_bank_researcher == 1
                            && $item->bank_archive == 0
                            && $item->stop_bank_request == 1
                            && $item->stop_bank_banks == 0;
                    })->values();
                }
                elseif ($stop_bank_type_send->slug == 'banks') {
                    // Apply the conditions related to 'stop_car_info'
                    $stop_car_catch = $items->filter(function ($item) use ($ministries) {
                        return in_array($item->ministries_income_id, $ministries) &&
                            $item->stop_bank_doing == 0 &&
                            $item->stop_bank == 1 &&
                            $item->stop_bank_command == 1
                            && $item->stop_bank_researcher == 1
                            && $item->bank_archive == 0
                            && $item->stop_bank_request == 1
                            && $item->stop_bank_banks == 1;
                    })->values();
                }

                elseif ($stop_bank_type_send->slug == 'stop_bank_doing') {
                    // Apply the conditions related to 'stop_car_info'
                    $stop_car_police_station = $items->filter(function ($item) use ($ministries){
                        return in_array($item->ministries_income_id, $ministries) &&
                            $item->stop_bank_doing == 1 &&
                            $item->stop_bank == 1 &&
                            $item->stop_bank_command == 1
                            && $item->stop_bank_researcher == 1
                            && $item->bank_archive == 0
                            && $item->stop_bank_request == 1
                            && $item->stop_bank_banks == 1;
                    })->values();
                }

                elseif ($stop_bank_type_send->slug == 'stop_bank_cancel_request') {
                    // Apply the conditions related to 'stop_car_info'
                    $stop_car_doing = $items->filter(function ($item) use ($ministries) {
                        return in_array($item->ministries_income_id, $ministries) &&
                            $item->stop_bank == 1 &&
                            $item->cancel_stop_bank == 1
                            && $item->bank_archive == 0;
                    })->values();
                }
                elseif ($stop_bank_type_send->slug == 'stop_bank_cancel') {
                    // Apply the conditions related to 'stop_car_info'
                    $stop_car_finished = $items->filter(function ($item) use ($ministries) {
                        return in_array($item->ministries_income_id, $ministries) &&
                            $item->stop_bank == 'done' &&
                            $item->cancel_stop_bank == 1
                            && $item->bank_archive == 0;
                    })->values();
                }





            }

            // Return or dump the results
            $array = [
                'stop_bank_request' => $stop_car_request,
                'stop_bank_command' => $stop_car_info,
                'stop_bank_researcher' => $stop_car_police,
                'banks' =>$stop_car_catch,
                'stop_bank_doing' =>$stop_car_police_station,
                'stop_bank_cancel_request' =>$stop_car_doing,
                'stop_bank_cancel' =>$stop_car_finished,


            ];

            dd($array);

//            foreach ($array as $key => $value)
//            {
//
////            dd($value);
//                foreach ($value as $item)
//                {
////                dd($item->id);
//                    $obj = new Military_affairs_status;
//                    $obj->type = $type;
//                    $obj->type_id = $key;
//                    $obj->military_affairs_id  = $item->id;
//                    $obj->created_by  = Auth::user()->id ?? null;
//                    $obj->updated_by  = Auth::user()->id ?? null;
//                    if($key == "info_request")
//                    {
////
//                        $obj->img_dir = null;
//                        $obj->date = null;
//                        $obj->note = null;
//                    }
//                    elseif ($key == "info_book" )
//                    {
//
//                        $obj->img_dir = null;
//                        $obj->date =  null;
//                        $obj->note = null;
////                    $obj->save();
//                    }
//                    elseif ($key == "export")
//                    {
//                        $obj->img_dir = $item->certificate_info_book_img;
//                        $obj->date = date("Y-m-d H:i:s", $item->certificate_info_book_date);
//                        $obj->note = null;
//                    }
//                    elseif ($key == "money")
//                    {
//                        $obj->img_dir = $item->certificate_export_img;
//                        $obj->date = $item->certificate_export_date;
//                        $obj->note = $item->certificate_export_note;
//                    }
//
//
//
//                    $obj->save();
//                }
//
//
////
//
//
//
//
//            }
        }

    }



}
