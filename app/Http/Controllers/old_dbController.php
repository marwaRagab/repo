<?php

namespace App\Http\Controllers;

use App\Models\Bank;
use App\Models\Military_affairs\Military_affair;
use App\Models\Military_affairs\Military_affairs_certificate_type;
use App\Models\Military_affairs\Military_affairs_status;
use App\Models\Military_affairs\Military_affairs_stop_bank_type;
use App\Models\Military_affairs\Military_affairs_stop_car_type;
use App\Models\Military_affairs\Military_affairs_stop_salary_type;
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

        $array = [];


        $items = DB::table('military_affairs_old')
            ->select(
                'military_affairs_old.*',
                'military_affairs_settlement.military_affairs_id',
                'military_affairs_settlement.date as my_date',
                'clients_old.ministry',
                'clients_old.ministries_income_id',
                'clients_old.job_type as client_job',
                DB::raw('JSON_UNQUOTE(JSON_EXTRACT(military_affairs_settlement.stop_travel_cancel_request_date, "$.type_date")) as cancel_type'),
                DB::raw('JSON_UNQUOTE(JSON_EXTRACT(military_affairs_settlement.stop_travel_cancel_request_date, "$.date")) as cancel_date'),
                'military_affairs_settlement.stop_travel_cancel_reason'
            )
            ->where('military_affairs_old.status', 'execute')
            ->where('archived', 0)
            ->join('installment', 'installment.id', '=', 'military_affairs_old.installment_id')
            ->join('clients_old', 'installment.client_id', '=', 'clients_old.id')
            ->join('military_affairs_settlement', 'military_affairs_settlement.military_affairs_id', '=', 'military_affairs_old.id', 'left');

        if ($type == "stop_bank") {
            $items->join('ministries', 'clients_old.ministries_income_id', '=', 'ministries.id');
        }
        if ($type == "stop_salary") {
            $items->join('ministries', 'clients_old.ministry', '=', 'ministries.id');
        }

        $items = $items->where('installment.finished', '=', 0)->get();


        $stop_car_request = [];
        $stop_car_info = [];
        $stop_car_police = [];
        $stop_car_catch = [];
        $stop_car_police_station = [];
        $stop_car_doing = [];
        $stop_car_finished = [];
        $stop_car_cancel_request = [];
        $stop_car_cancel = [];
        $stop_salary_sabah_salem = [];
        $stop_salary_force_affairs = [];
        // dd($items);

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
                } elseif ($stop_car_type_send->slug == 'stop_car_police') {
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
                } elseif ($stop_car_type_send->slug == 'stop_car_catch') {
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
                } elseif ($stop_car_type_send->slug == 'stop_car_police_station') {
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
                } elseif ($stop_car_type_send->slug == 'stop_car_doing') {
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
                } elseif ($stop_car_type_send->slug == 'stop_car_finished') {
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
                } elseif ($stop_car_type_send->slug == 'stop_car_cancel_request') {
                    // Apply the conditions related to 'stop_car_info'
                    $stop_car_cancel_request = $items->filter(function ($item) {
                        return $item->cancel_stop_car == 1
                            && $item->stop_car_archive_type == 'not_archived' &&
                            $item->stop_car_archive == 0;
                    })->values();
                } elseif ($stop_car_type_send->slug == 'stop_car_cancel') {
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
                'stop_car_catch' => $stop_car_catch,
                'stop_car_police_station' => $stop_car_police_station,
                'stop_car_doing' => $stop_car_doing,
                'stop_car_finished' => $stop_car_finished,
                'stop_car_cancel_request' => $stop_car_cancel_request,
                'stop_car_cancel' => $stop_car_cancel,
            ];

            foreach ($array as $key => $value) {

//            dd($value);
                foreach ($value as $item) {

                    $obj = new Military_affairs_status;
                    $obj->type = $type;
                    $obj->type_id = $key;
                    $obj->military_affairs_id = $item->id;
                    $obj->created_by = Auth::user()->id ?? null;
                    $obj->updated_by = Auth::user()->id ?? null;
                    if ($key == "stop_car_request") {
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
                    } elseif ($key == "stop_car_info") {

                        $obj->img_dir = $item->stop_car_request_img;
                        $obj->date = $item->stop_car_request_date;
                        $obj->note = null;
//                    $obj->save();
                    } elseif ($key == "stop_car_police") {
                        $obj->img_dir = null;
                        $obj->date = null;
                        $obj->note = null;
                    } elseif ($key == "stop_car_catch") {
                        $obj->img_dir = $item->stop_car_police_station_img;
                        $obj->date = $item->stop_car_recieve_date;
                        $obj->note = null;
                    } elseif ($key == "stop_car_police_station") {
                        $obj->img_dir = $item->img_dir;
                        $obj->date = $item->stop_car_catch_date;
                        $obj->note = null;
                    } elseif ($key == "stop_car_doing") {
                        $obj->img_dir = $item->stop_car_police_station_img;
                        $obj->date = $item->stop_car_police_station_date;
                        $obj->note = null;
                    } elseif ($key == "stop_car_finished") {
                        $obj->img_dir = null;
                        $obj->date = null;
                        $obj->note = null;
                    } elseif ($key == "stop_car_cancel_request") {
                        $obj->img_dir = $item->stop_car_police_station_img;
                        $obj->date = $item->my_date;
                        $obj->note = null;
                    } elseif ($key == "stop_car_cancel") {
                        $obj->img_dir = null;
                        if ($item->cancel_type == 'stop_car') {
                            $obj->date = $item->cancel_date;
                        } else {
                            $obj->date = null;
                        }

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
                } elseif ($stop_travel_type_send->slug == 'stop_travel_finished') {
                    // Apply the conditions related to 'stop_car_info'
                    $stop_car_police = $items->filter(function ($item) {
                        return $item->command == 1 &&
                            $item->stop_travel == 1 &&
                            $item->stop_travel_finished == 1;
                    })->values();
                } elseif ($stop_travel_type_send->slug == 'stop_travel_cancel_request') {
                    // Apply the conditions related to 'stop_car_info'
                    $stop_car_catch = $items->filter(function ($item) {
                        return $item->cancel_stop_travel == 1;


                    })->values();
                } elseif ($stop_travel_type_send->slug == 'stop_travel_cancel') {
                    // Apply the conditions related to 'stop_car_info'
                    $stop_car_police_station = $items->filter(function ($item) {
                        return $item->cancel_stop_travel == 'done';

                    })->values();
                }


            }

            // Return or dump the results
            $array = [
                'request' => $stop_car_request,
                'command' => $stop_car_info,
                'stop_travel_finished' => $stop_car_police,
                'stop_travel_cancel_request' => $stop_car_catch,
                'stop_travel_cancel' => $stop_car_police_station,
//                'stop_car_doing'=>$stop_car_doing,
//                'stop_car_finished'=>$stop_car_finished,
//                'stop_car_cancel_request'=>$stop_car_cancel_request,
//                'stop_car_cancel'=>$stop_car_cancel,
            ];


            foreach ($array as $key => $value) {

//            dd($value);
                foreach ($value as $item) {
//                dd($item->id);
                    $obj = new Military_affairs_status;
                    $obj->type = $type;
                    $obj->type_id = $key;
                    $obj->military_affairs_id = $item->id;
                    $obj->created_by = Auth::user()->id ?? null;
                    $obj->updated_by = Auth::user()->id ?? null;
                    if ($key == "request") {
//
                        $obj->img_dir = null;
                        $obj->date = null;
                        $obj->note = null;
                    } elseif ($key == "command") {
                        $obj->img_dir = $item->command_img;
                        $obj->date = $item->command_date;
                        $obj->note = null;
//                    $obj->save();
                    } elseif ($key == "stop_travel_finished") {
                        $obj1 = new Military_affairs_status;
                        $obj1->type = $type;
                        $obj1->type_id = 'command';
                        $obj1->military_affairs_id = $item->id;
                        $obj1->created_by = Auth::user()->id ?? null;
                        $obj1->updated_by = Auth::user()->id ?? null;
                        $obj1->img_dir = $item->command_img;
                        $obj1->flag = 1;
                        $obj1->date = $item->command_date;
                        $obj1->note = null;
                        $obj1->save();

                        $obj->img_dir = $item->stop_travel_finished_img;
                        $obj->date = $item->stop_travel_finished_date;
                        $obj->note = null;
                    } elseif ($key == "stop_travel_cancel_request") {
                        $obj->img_dir = null;
                        $obj->date = $item->my_date;
                        $obj->note = null;
                    } elseif ($key == "stop_travel_cancel") {
                        $obj2 = new Military_affairs_status;
                        $obj2->type = $type;
                        $obj2->type_id = 'stop_travel_cancel_request';
                        $obj2->military_affairs_id = $item->id;
                        $obj2->created_by = Auth::user()->id ?? null;
                        $obj2->updated_by = Auth::user()->id ?? null;
                        $obj2->img_dir = null;
                        $obj2->flag = 1;
                        $obj2->date = $item->my_date;
                        $obj2->note = null;
                        $obj2->save();
//
                        $obj->img_dir = null;
                        if ($item->cancel_type == 'stop_travel') {
                            $obj->date = $item->cancel_date;
                        } else {
                            $obj->date = null;
                        }
                        $obj->note = null;
                    }


                    $obj->save();

                }
            }


//


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
                } elseif ($stop_certificate_type_send->slug == 'export') {
                    // Apply the conditions related to 'stop_car_info'
                    $stop_car_police = $items->filter(function ($item) {
                        return $item->certificate_export == 1 &&
                            $item->cancel_certificate == 1 &&
                            $item->certificate_info_book == 1
                            && $item->certificate_money == 0
                            && $item->stop_salary == 0
                            && $item->certificate_info_request == 1;
                    })->values();
                } elseif ($stop_certificate_type_send->slug == 'money') {
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
                'money' => $stop_car_catch,


            ];


            foreach ($array as $key => $value) {

//            dd($value);
                foreach ($value as $item) {
//                dd($item->id);
                    $obj = new Military_affairs_status;
                    $obj->type = $type;
                    $obj->type_id = $key;
                    $obj->military_affairs_id = $item->id;
                    $obj->created_by = Auth::user()->id ?? null;
                    $obj->updated_by = Auth::user()->id ?? null;
                    if ($key == "info_request") {
//
                        $obj->img_dir = null;
                        $obj->date = null;
                        $obj->note = null;
                    } elseif ($key == "info_book") {

                        $obj->img_dir = null;
                        $obj->date = null;
                        $obj->note = null;
//                    $obj->save();
                    } elseif ($key == "export") {
                        $obj->img_dir = $item->certificate_info_book_img;
                        $obj->date = $item->certificate_info_book_date;
                        $obj->note = null;
                    } elseif ($key == "money") {
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
                } elseif ($stop_bank_type_send->slug == 'stop_bank_researcher') {
                    // Apply the conditions related to 'stop_car_info'
                    $stop_car_police = $items->filter(function ($item) use ($ministries) {
                        return in_array($item->ministries_income_id, $ministries) &&
                            $item->stop_bank_doing == 0 &&
                            $item->stop_bank == 1 &&
                            $item->stop_bank_command == 1
                            && $item->stop_bank_researcher == 1
                            && $item->bank_archive == 0
                            && $item->stop_bank_request == 1
                            && $item->stop_bank_banks == 0;
                    })->values();
                } elseif ($stop_bank_type_send->slug == 'banks') {
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
                } elseif ($stop_bank_type_send->slug == 'stop_bank_doing') {
                    // Apply the conditions related to 'stop_car_info'
                    $stop_car_police_station = $items->filter(function ($item) use ($ministries) {
                        return in_array($item->ministries_income_id, $ministries) &&
                            $item->stop_bank_doing == 1 &&
                            $item->stop_bank == 1 &&
                            $item->stop_bank_command == 1
                            && $item->stop_bank_researcher == 1
                            && $item->bank_archive == 0
                            && $item->stop_bank_request == 1
                            && $item->stop_bank_banks == 1;
                    })->values();
                } elseif ($stop_bank_type_send->slug == 'stop_bank_cancel_request') {
                    // Apply the conditions related to 'stop_car_info'
                    $stop_car_doing = $items->filter(function ($item) use ($ministries) {
                        return in_array($item->ministries_income_id, $ministries) &&
                            $item->stop_bank == 1 &&
                            $item->cancel_stop_bank == 1
                            && $item->bank_archive == 0;
                    })->values();
                } elseif ($stop_bank_type_send->slug == 'stop_bank_cancel') {
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
                'banks' => $stop_car_catch,
                'stop_bank_doing' => $stop_car_police_station,
                'stop_bank_cancel_request' => $stop_car_doing,
                'stop_bank_cancel' => $stop_car_finished,

            ];

//            dd($array);

            foreach ($array as $key => $value) {

//            dd($value);
                foreach ($value as $item) {
//                dd($item->id);
                    $obj = new Military_affairs_status;
                    $obj->type = $type;
                    $obj->type_id = $key;
                    $obj->military_affairs_id = $item->id;
                    $obj->created_by = Auth::user()->id ?? null;
                    $obj->updated_by = Auth::user()->id ?? null;
                    if ($key == "stop_bank_request") {
//
                        $obj->img_dir = null;
                        $obj->date = null;
                        $obj->note = null;
                    } elseif ($key == "stop_bank_command") {

                        $obj->img_dir = $item->stop_bank_request_img;
                        $obj->date = $item->stop_bank_request_date;
                        $obj->note = null;
//                    $obj->save();
                    } elseif ($key == "stop_bank_researcher") {
                        $obj->img_dir = $item->stop_bank_request_img;
                        $obj->date = $item->stop_bank_request_date;
                        $obj->note = null;
                    } elseif ($key == "banks") {
                        $obj->img_dir = $item->stop_bank_banks_img;
                        $obj->date = $item->stop_bank_banks_date;
                        $obj->note = null;
                    } elseif ($key == "stop_bank_doing") {
                        $obj->img_dir = null;
                        $obj->date = null;
                        $obj->note = $item->reason;
                    } elseif ($key == "stop_bank_cancel_request") {
//                        $obj->cancel_stop_bank = "1";
                        $obj->img_dir = null;
                        $obj->date = $item->my_date;
                        $obj->note = null;

                    } elseif ($key == "stop_bank_cancel") {
                        $obj->img_dir = null;
                        $obj->date = null;
                        $obj->note = null;
                    }


                    $obj->save();
                }


//


            }
        }

        if ($type == "stop_salary") {
            $stop_Salary_types = Military_affairs_stop_salary_type::all();
            $ministries = Ministry::whereIN('id', [5, 14, 27])->pluck('id')->toArray();


            foreach ($stop_Salary_types as $stop_salary_type_send) {


                if ($stop_salary_type_send->slug == 'stop_salary_request') {

                    $stop_car_request = $items->filter(function ($item) use ($ministries) {

                        return
                            in_array($item->ministry, $ministries) &&
                            $item->stop_salary_request == 0 &&
                            $item->client_job == 'military' &&
                            $item->stop_salary == 1;
                    })->values(); // Re-index the collection after filtering

//
                } elseif ($stop_salary_type_send->slug == 'stop_salary_doing') {
                    // Apply the conditions related to 'stop_car_info'
                    $stop_car_info = $items->filter(function ($item) use ($ministries) {
                        return
                            in_array($item->ministry, $ministries) &&
                            $item->stop_salary_request == 1 &&
                            $item->stop_salary_doing == 0 &&
                            $item->client_job == 'military' &&
                            $item->stop_salary == 1;
                    })->values();
                } elseif ($stop_salary_type_send->slug == 'stop_salary_money') {
                    // Apply the conditions related to 'stop_car_info'
                    $stop_car_police = $items->filter(function ($item) use ($ministries) {
                        return in_array($item->ministry, $ministries) &&
                            // Check for ministry 27 and the specific conditions
                            (($item->ministry == 27 && $item->stop_salary_sabah_salem == 1 && $item->stop_salary_force_affairs == 1) ||

                                // Check for ministry 5 and the specific condition
                                ($item->ministry == 5 && $item->stop_salary_military_judgement == 1) || $item->ministry == 14) &&

                            // Additional general conditions
                            $item->stop_salary_request == 1 &&
                            $item->stop_salary_doing == 1 &&
                            $item->stop_salary_money == 0 &&
                            $item->client_job == 'military' &&
                            $item->stop_salary == 1;
                    })->values();
                } elseif ($stop_salary_type_send->slug == 'stop_salary_part') {
                    // Apply the conditions related to 'stop_car_info'
                    $stop_car_catch = $items->filter(function ($item) use ($ministries) {
                        return in_array($item->ministry, $ministries) &&
                            // Check for ministry 27 and the specific conditions
                            (($item->ministry == 27 && $item->stop_salary_sabah_salem == 1 && $item->stop_salary_force_affairs == 1) ||

                                // Check for ministry 5 and the specific condition
                                ($item->ministry == 5 && $item->stop_salary_military_judgement == 1) || $item->ministry == 14) &&

                            // Additional general conditions
                            $item->stop_salary_request == 1 &&
                            $item->stop_salary_doing == 1 &&
                            $item->stop_salary_money == 1 &&
                            $item->stop_salary_part == 0 &&
                            $item->client_job == 'military' &&
                            $item->stop_salary == 1;
                    })->values();
                } elseif ($stop_salary_type_send->slug == 'stop_salary_cancel_request') {
                    // Apply the conditions related to 'stop_car_info'
                    $stop_car_police_station = $items->filter(function ($item) use ($ministries) {
                        return in_array($item->ministry, $ministries) &&
                            $item->cancel_stop_salary == 1;
                    })->values();
                } elseif ($stop_salary_type_send->slug == 'stop_salary_cancel') {
                    // Apply the conditions related to 'stop_car_info'
                    $stop_car_doing = $items->filter(function ($item) use ($ministries) {
                        return in_array($item->ministry, $ministries) &&
                            $item->cancel_stop_salary == 'done';
                    })->values();
                } elseif ($stop_salary_type_send->slug == 'stop_salary_military_judgement') {
                    // Apply the conditions related to 'stop_car_info'
                    $stop_car_finished = $items->filter(function ($item) use ($ministries) {

                        return in_array($item->ministry, $ministries) &&
                            ($item->ministry == 5 &&
                                $item->stop_salary_military_judgement == 0 &&
                                $item->stop_salary_request == 1 &&
                                $item->stop_salary_doing == 1 &&
                                $item->client_job == 'military' &&
                                $item->stop_salary == 1);

                    })->values();
                } elseif ($stop_salary_type_send->slug == 'stop_salary_sabah_salem') {
                    // Apply the conditions related to 'stop_car_info'
                    $stop_salary_sabah_salem = $items->filter(function ($item) use ($ministries) {

                        return in_array($item->ministry, $ministries) &&
                            ($item->ministry == 27 &&
                                $item->stop_salary_sabah_salem == 0 &&
                                $item->stop_salary_request == 1 &&
                                $item->stop_salary_doing == 1 &&
                                $item->client_job == 'military' &&
                                $item->stop_salary == 1);
                    })->values();
                } elseif ($stop_salary_type_send->slug == 'stop_salary_force_affairs') {
                    // Apply the conditions related to 'stop_car_info'
                    $stop_salary_force_affairs = $items->filter(function ($item) use ($ministries) {

                        return in_array($item->ministry, $ministries) &&
                            ($item->ministry == 27 &&
                                $item->stop_salary_sabah_salem == 1 &&
                                $item->stop_salary_force_affairs == 0 &&
                                $item->stop_salary_request == 1 &&
                                $item->stop_salary_doing == 1 &&
                                $item->client_job == 'military' &&
                                $item->stop_salary == 1);
                    })->values();
                }


            }
//            dd($stop_car_request);

            // Return or dump the results
            $array = [
                'stop_salary_request' => $stop_car_request,
                'stop_salary_doing' => $stop_car_info,
                'stop_salary_money' => $stop_car_police,
                'stop_salary_part' => $stop_car_catch,
                'stop_salary_cancel_request' => $stop_car_police_station,
                'stop_salary_cancel' => $stop_car_doing,

                'stop_salary_military_judgement' => $stop_car_finished,
                'stop_salary_sabah_salem' => $stop_salary_sabah_salem,
                'stop_salary_force_affairs' => $stop_salary_force_affairs,

            ];


            foreach ($array as $key => $value) {

//            dd($value);
                foreach ($value as $item) {
//                dd($item->id);
                    $obj = new Military_affairs_status;
                    $obj->type = $type;
                    $obj->type_id = $key;
                    $obj->military_affairs_id = $item->id;
                    $obj->created_by = Auth::user()->id ?? null;
                    $obj->updated_by = Auth::user()->id ?? null;
                    $obj->ministry = $item->ministry;
                    if ($key == "stop_salary_request") {
//
                        $obj->img_dir = null;
                        $obj->date = null;
                        $obj->note = null;
                    }
                    elseif ($key == "stop_salary_doing") {
                        $this->get_old($type, 'stop_bank_request', $item->id, $item->stop_bank_request_date, $item->stop_salary_doing_img);
                        $obj->img_dir = $item->stop_salary_request_img;
                        $obj->date = $item->stop_car_request_date;
                        $obj->note = null;
//                    $obj->save();
                    } elseif ($key == "stop_salary_money") {
                        $this->get_old($type, 'stop_bank_request', $item->id, $item->stop_bank_request_date, $item->stop_salary_doing_img);
                        $this->get_old($type, 'stop_salary_doing', $item->id, $item->stop_salary_doing_date, $item->stop_salary_doing_img);
                        if ($item->ministry == 14) {
                            $obj->img_dir = $item->stop_salary_military_judgement_img;
                            $obj->date = $item->stop_salary_military_judgement_date;
                            $obj->note = null;

                        } elseif ($item->ministry == 5) {
                            $obj->img_dir = $item->stop_salary_doing_img;
                            $obj->date = $item->stop_salary_doing_date;
                            $obj->note = null;
                            $this->get_old($type, 'stop_salary_military_judgement', $item->id, $item->stop_salary_military_judgement_date, $item->stop_salary_military_judgement_img);


                        } elseif
                        ($item->ministry == 27) {
                            $obj->img_dir = $item->stop_salary_force_affairs_img;
                            $obj->date = $item->stop_salary_force_affairs_date;
                            $obj->note = null;
                            $this->get_old($type, 'stop_salary_sabah_salem', $item->id, $item->stop_salary_sabah_salem_date, $item->stop_salary_sabah_salem_img);
                            $this->get_old($type, 'stop_salary_force_affairs', $item->id, $item->stop_salary_force_affairs, $item->stop_salary_force_affairs_img);

                        }

                    } elseif ($key == "stop_salary_part") {
                        $this->get_old($type, 'stop_bank_request', $item->id, $item->stop_bank_request_date, $item->stop_salary_doing_img);
                        $this->get_old($type, 'stop_salary_doing', $item->id, $item->stop_salary_doing_date, $item->stop_salary_doing_img);
                        $obj->img_dir = $item->stop_salary_money_img;
                        $obj->date = $item->stop_salary_money_date;
                        $obj->note = null;
                        if($item->ministry == 27){
                            $this->get_old($type, 'stop_salary_sabah_salem', $item->id, $item->stop_salary_sabah_salem_date, $item->stop_salary_sabah_salem_img);
                            $this->get_old($type, 'stop_salary_force_affairs', $item->id, $item->stop_salary_force_affairs, $item->stop_salary_force_affairs_img);

                        }if($item->ministry == 5){
                            $this->get_old($type, 'stop_salary_military_judgement', $item->id, $item->stop_salary_military_judgement_date, $item->stop_salary_military_judgement_img);

                        }
                        $this->get_old($type, 'stop_salary_money', $item->id, $item->stop_salary_money_date, $item->stop_salary_money_img);



                    } elseif ($key == "stop_salary_cancel_request") {

//                        $obj->cancel_stop_salary = "1";
                        $obj->img_dir = null;
                        $obj->date = $item->my_date;
                        $obj->note = null;
                    } elseif ($key == "stop_salary_cancel") {
//                        $obj->cancel_stop_salary = "done";
                        $obj->img_dir = null;
                        $obj->date = null;
                        $obj->note = null;

                    } elseif ($key == "stop_salary_military_judgement") {
                        $this->get_old($type, 'stop_bank_request', $item->id, $item->stop_bank_request_date, $item->stop_salary_doing_img);
                        $this->get_old($type, 'stop_salary_doing', $item->id, $item->stop_salary_doing_date, $item->stop_salary_doing_img);
                        $obj->img_dir = $item->stop_salary_doing_img;
                        $obj->date = $item->stop_salary_doing_date;
                        $obj->note = null;
                    } elseif ($key == "stop_salary_sabah_salem") {
                        $this->get_old($type, 'stop_bank_request', $item->id, $item->stop_bank_request_date, $item->stop_salary_doing_img);
                        $this->get_old($type, 'stop_salary_doing', $item->id, $item->stop_salary_doing_date, $item->stop_salary_doing_img);
                        $obj->img_dir = $item->stop_salary_doing_img;
                        $obj->date = $item->stop_salary_doing_date;
                        $obj->note = null;
                    } elseif ($key == "stop_salary_force_affairs") {
                        $this->get_old($type, 'stop_bank_request', $item->id, $item->stop_bank_request_date, $item->stop_salary_doing_img);
                        $this->get_old($type, 'stop_salary_doing', $item->id, $item->stop_salary_doing_date, $item->stop_salary_doing_img);
                        $this->get_old($type, 'stop_salary_sabah_salem', $item->id, $item->stop_salary_sabah_salem_date, $item->stop_salary_sabah_salem_img);
                        $obj->img_dir = $item->stop_salary_sabah_salem_img;
                        $obj->date = $item->stop_salary_sabah_salem_date;
                        $obj->note = null;
                    }


                    $obj->save();
                }


//


            }
        }

    }

    public function get_old($type, $type_id, $military_affairs_id, $date, $img)
    {

        $obj1 = new Military_affairs_status;
        $obj1->type = $type;
        $obj1->type_id = $type_id;
        $obj1->military_affairs_id = $military_affairs_id;
        $obj1->created_by = Auth::user()->id ?? null;
        $obj1->updated_by = Auth::user()->id ?? null;
        $obj1->img_dir = $img;
        $obj1->flag = 1;
        $obj1->date = $date;
        $obj1->note = null;
        $obj1->save();

    }
   public function get_reminder(){


       $law_36 = '(SELECT SUM(installment_months.amount)
            FROM installment_months
            WHERE installment_months.installment_type = "law_percent"
            AND installment_months.installment_id  =  installment.id)';

       $total_madoina = '(SELECT SUM(installment_months.amount)
                   FROM installment_months
                   WHERE installment_months.installment_type != "first_amount"
                   AND installment_months.installment_id  =  installment.id
                   AND installment_months.status != "delay")';

       $law_percent = '(SELECT SUM(installment_months.amount)
                 FROM installment_months
                 WHERE installment_months.installment_type in("law_percent","2_._5_percent")
                 AND installment_months.installment_id  =  installment.id
                 AND installment_months.status="done")';

       $check_pay = '(SELECT SUM(military_affairs_check.amount)
               FROM military_affairs_check
               WHERE military_affairs_check.deposit = 1
               AND military_affairs_check.military_affairs_id  =  military_affairs.id)';

       $amount_pay = '(SELECT SUM(military_affairs_amounts.amount)
                FROM military_affairs_amounts
                WHERE military_affairs_amounts.military_affairs_check_id = 0
                AND military_affairs_amounts.military_affairs_id  =  military_affairs.id)';
       $pay_done ='(SELECT SUM(installment_months.amount)
                FROM installment_months
                 WHERE installment_months.installment_type != "first_amount" and  installment_months.status = "done"
                AND installment_months.installment_id  =  installment.id)';
       $settlement_paid= '(SELECT SUM(military_affairs_settlement_months.amout) FROM military_affairs_settlement_months WHERE  military_affairs_settlement_months.status="done" AND military_affairs_settlement_months.installment_id  =  installment.`id` )';


       $items = DB::table('military_affairs')
           ->select(
               'military_affairs.id as my_id',
               'military_affairs.excute_actions_check_amount',
               'military_affairs.reminder_amount',
               'military_affairs.is_reminder_amount',
               'military_affairs.excute_actions_amount',
               'installment_months.amount',
               'installment_months.status',
               'installment_months.installment_type',
               'installment.months',

               DB::raw('(SELECT SUM(installment_months.amount)
                  FROM installment_months
                  WHERE installment_months.installment_type != "first_amount"
                    AND installment_months.installment_id = installment.id
                    AND installment_months.status = "done") AS pay_done'),
               DB::raw('(
            SELECT

               IF(military_affairs.eqrar_dain_amount IS NULL, 0, military_affairs.eqrar_dain_amount)
             - IF(' . $pay_done . ' IS NULL, 0, ' . $pay_done . ')
             - IF(' . $check_pay . ' IS NULL, 0, ' . $check_pay . ')
             - IF(' . $amount_pay . ' IS NULL, 0, ' . $amount_pay . ')
             - IF(' . $settlement_paid . ' IS NULL, 0, ' . $settlement_paid . ')
        ) AS ALL_reminder', false)
           )
           ->join('installment', 'installment.id', '=', 'military_affairs.installment_id')
           ->join('installment_months', 'installment.id', '=', 'installment_months.installment_id')
           ->groupBy('military_affairs.id')
           ->get();


       //  $all_items=Military_affair::all();



       // Assuming you know the model related to the item (e.g. Reminder)
       foreach ($items as $item) {
           if ($item->is_reminder_amount == 0) {

               $model = Military_affair::findorfail($item->my_id); // Find the Eloquent model

               $model->reminder_amount = $item->ALL_reminder;
               $model->save(); // Save it to the database
           }
       }


       dd($items);








   }

}



