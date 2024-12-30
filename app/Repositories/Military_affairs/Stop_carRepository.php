<?php

namespace App\Repositories\Military_affairs;

use App\Interfaces\Military_affairs\Stop_carRepositoryInterface;
use App\Models\Client;
use App\Models\Court;
use App\Models\Governorate;
use App\Models\Installment;
use App\Models\Military_affairs\Military_affair;
use App\Models\Military_affairs\Military_affairs_status;
use App\Models\Military_affairs\Military_affairs_stop_car_type;
use App\Models\Military_affairs\Military_affairs_times;
use App\Models\Military_affairs\Military_affairs_times_type;
use App\Models\Military_affairs\Prev_cols_military_affairs;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\DB;

class Stop_carRepository implements Stop_carRepositoryInterface
{
    protected $data;
    protected $title;

    public function __construct()
    {
        $this->data['title'] = 'حجز السيارات';
        $this->data['governorates'] = Governorate::with('clients')->get();
        $this->data['courts'] = Court::with('government')->get();
        $this->data['stop_car_types'] = military_affairs_stop_car_type::all();
        foreach ($this->data['courts'] as $court) {
            $court->counter = count_court($court->id, 'stop_car', '', '');
        }
        $color_array = ['bg-warning-subtle text-warning', 'bg-success-subtle text-success', 'bg-danger-subtle text-danger',
            'px-4 bg-primary-subtle text-primary', 'bg-danger-subtle text-danger', 'me-1 mb-1  bg-warning-subtle text-warning',
            'bg-warning-subtle text-warning', 'px-4 bg-primary-subtle text-primary', 'bg-success-subtle text-success', 'bg-danger-subtle text-danger'];

        for ($i = 0; $i < count($this->data['courts']); $i++) {
            $this->data['courts'][$i]['style'] = $color_array[$i];
        }
        for ($i = 0; $i < count($this->data['stop_car_types']); $i++) {
            $this->data['stop_car_types'][$i]['style'] = $color_array[$i];
        }

    }
    public function index(Request $request)
    {
        // dd($request->stop_car_type);
        $message = "تم دخول صفحة  حجز السيارات";

        $stop_car_type = $request->stop_car_type;
        $governate_id = $request->governate_id ?? 0;

        $this->data['govern_count_total'] = '';
        foreach ($this->data['governorates'] as $one) {
            $count['govern_counter_' . $one->id] = $this->countStopCarGovernate('execute', 'stop_car', $one->id);
        }

        $this->data['item_type_time1'] = Military_affairs_times_type::where(['type' => 'stop_car', 'slug' => $stop_car_type])->first();

        $this->data['item_type_time_new'] = Military_affairs_times_type::where(['type' => 'stop_car', 'slug' => $stop_car_type])->first();

        $stop_type = $stop_car_type;
        if (!$stop_type) {
            $stop_type = 'stop_car_request';
            $new_type = 'stop_car_info';
        }
        $current_request = Military_affairs_stop_car_type::
            where('slug', $stop_type)
            ->orderBy('id', 'asc')
            ->first();
        $next_request = Military_affairs_stop_car_type::
            where('id', '>', $current_request->id)
            ->orderBy('id', 'asc')
            ->first();

        $this->data['item_type_time1'] = Military_affairs_stop_car_type::where(['type' => 'stop_car', 'slug' => $current_request->slug])->first();
        $this->data['item_type_time_new'] = Military_affairs_stop_car_type::where(['type' => 'stop_car', 'slug' => $next_request->slug ?? ''])->first();
        $this->data['governate_id'] = $governate_id;
        $this->data['stop_car_type'] = $stop_car_type;
        $this->data['col_name'] = $current_request->col_name ?? '';
        $this->data['types'] = Military_affairs_stop_car_type::get();
        $this->data['classes'] = ['bg-warning-subtle text-warning', 'bg-success-subtle text-success', 'bg-danger-subtle text-danger', 'px-4 bg-primary-subtle text-primary', 'bg-danger-subtle text-danger', '  bg-warning-subtle text-warning', 'bg-danger-subtle text-danger', 'px-4 bg-primary-subtle text-primary'];

        $counts = [];

        foreach ($this->data['types'] as $one) {
            $counts['stop_car_count_' . $one->id] = $this->count_stop_car($governate_id, $one->slug);
        }
        $transactions = Military_affair::where('archived', '=', 0)
            ->where(['military_affairs.status' => 'execute', 'military_affairs.stop_car' => 1])
            ->with('installment')
            ->with('status_all')
            ->when(request()->has('governate_id'), function ($query) {
                return $query
                    ->whereHas('installment.client.court', function ($q) {
                        $q->where('governorate_id', request()->get('governate_id'));
                    });
            })
            ->with('installment.client.area.police_station')
            ->when(request()->has('stop_car_type'), function ($query) {
                $query
                    ->whereHas('status_all', function ($q) {
                        return $q->where('type', 'stop_car')->where('type_id', request()->get('stop_car_type'))->where('flag', 0);
                    });
            })->get();
/*
$sql = $query->toSql();
$bindings = $query->getBindings();
foreach ($bindings as $binding) {
$value = is_numeric($binding) ? $binding : "'$binding'";
$sql = preg_replace('/\\?/', $value, $sql, 1);
}

dd($sql);
 */
//dd($transactions);
      /*  foreach ($transactions as $value) {

            $value->item_old_data = Prev_cols_military_affairs::where('military_affairs_id', $value->id)->first();

            $value->different_date = get_different_dates($value->date, date('Y-m-d'));
            $value->adress = ($value->installment->client->client_address ? $value->installment->client->client_address->last() : '');
            $value->phone = ($value->installment->client->client_phone ? $value->installment->client->client_phone->last() : '');
            if ($value->eqrardain_date != null) {
                $value->type_papar = 'وصل امانة';
            } elseif ($value->qard_paper != null) {
                $value->type_papar = 'اقرار دين';
            } else {
                $value->type_papar = 'لايوجد';
            }

        }
*/
        $breadcrumb = array();
        $breadcrumb[0]['title'] = " الرئيسية";
        $breadcrumb[0]['url'] = route("dashboard");
        $breadcrumb[1]['title'] = " الشئون القانونية";
        $breadcrumb[1]['url'] = route("military_affairs");
        $breadcrumb[2]['title'] = $this->data['title'];
        $breadcrumb[2]['url'] = 'javascript:void(0);';
        $view = 'military_affairs/stop_car/index';
        $title = $this->title;
        $this->data['get_responsible'] = get_responsible();

        return view('layout', compact(['title', 'view', 'transactions', 'breadcrumb', 'count','counts']), $this->data);

    }

    public function info_update(Request $request)
    {
        $haveCars = $request->input('have_cars');

        $addData = [];
        if ($haveCars == 0) {
            $addData['stop_car_archive_date'] = time();
            $addData['stop_car_archive'] = 1;
        } else {
            $request->validate([
                'stop_car_car_num' => 'required|numeric',
                'img_dir_2' => 'required|image',
            ], [
                'stop_car_car_num.required' => 'هذا الحقل مطلوب.',
                'stop_car_car_num.numeric' => 'يجب أن يكون عدد السيارات رقماً.',
                'img_dir_2.required' => 'يرجى تحميل صورة البرنت.',
                'img_dir_2.image' => 'يجب أن يكون الملف صورة.',
            ]);

            $addData['stop_car_car_num'] = $request->input('stop_car_car_num');

            if ($request->hasFile('img_dir_1')) {
                $file = $request->file("img_dir_1");
                $filename = time() . '-' . uniqid() . '.' . $file->getClientOriginalExtension();
                $file->move(public_path('military_affairs'), $filename);
                $addData['stop_car_img_print'] = 'military_affairs/' . $filename;

            } else {
                return redirect()->back()
                    ->withErrors(['img_dir_1' => 'عفوا يوجد خطأ فى رفع الصورة.'])
                    ->withInput();
            }

            if ($request->hasFile('img_dir_2')) {
                $file = $request->file("img_dir_2");
                $filename = time() . '-' . uniqid() . '.' . $file->getClientOriginalExtension();
                $file->move(public_path('military_affairs'), $filename);
                $addData['stop_car_img_request'] = 'military_affairs/' . $filename;

            } else {
                return redirect()->back()
                    ->withErrors(['img_dir_2' => 'عفوا يوجد خطأ فى رفع الصورة.'])
                    ->withInput();
            }
        }
        Military_affair::findOrFail($request->military_affairs_id)->update($addData);

        $old = Military_affairs_stop_car_type::where('slug', $request->item_type_old)->first();

        if ($old) {
            $new = Military_affairs_stop_car_type::where('id', '>', $old->id)
                ->orderBy('id', 'asc')
                ->first();

        }

        $request->type_id = $new->slug;

        $item_time = Military_affairs_times::where(['times_type_id' => $old->id, 'military_affairs_id' => $request->military_affairs_id])->first();
        $item_status = Military_affairs_status::where(['type_id' => $old->slug, 'military_affairs_id' => $request->military_affairs_id])->first();
        if ($item_status) {
            $data_status['flag'] = 1;
            $item_status->update($data_status);
        }
        if ($item_time) {
            $data['date_end'] = date('Y-m-d H:i:s');
            $item_time->update($data);
        }
        Add_note($old, $new, $request->military_affairs_id);
        Add_note_time($new, $request->military_affairs_id);
        change_status($request, $request->military_affairs_id);

        if (!empty($addData['stop_car_car_num']) && $addData['stop_car_car_num'] > 0) {
            return redirect()->route('show_update_info_cars_numbers', ['id' => $request->military_affairs_id])->with('success', 'تم حفظ البيانات بنجاح');
        } else {
            return redirect()->route('stop_car', ['governate_id' => 0, 'type' => 'stop_car_police'])->with('success', 'تم حفظ البيانات بنجاح');
        }

    }

    public function stop_car_convert(Request $request)
    {
        $request->validate([
            'date' => 'required| date',
            'img_dir' => 'required|image|mimes:jpg,png,jpeg,gif|max:2048',
        ],
            [
                'date.required' => 'التاريخ مطلوب',
                'img_dir.required' => 'الصورة مطلوبة',
            ]);

        $old = Military_affairs_stop_car_type::where('slug', $request->item_type_old)->first();

        if ($old) {
            $new = Military_affairs_stop_car_type::where('id', '>', $old->id)
                ->orderBy('id', 'asc')
                ->first();

        }
        if ($old->slug == 'stop_car_cancel_request') {
            $item = Military_affair::where(['id' => $request->military_affairs_id])->first();
            if ($item) {
                $data_1['stop_travel_cancel_reason'] = $request->stop_travel_cancel_reason;
                $item->update($data_1);
            }
        }

        $request->type_id = $new->slug;

        $item_time = Military_affairs_times::where(['times_type_id' => $old->id, 'military_affairs_id' => $request->military_affairs_id])->first();

        $item_status = Military_affairs_status::where(['type_id' => $old->slug, 'military_affairs_id' => $request->military_affairs_id])->first();



        if ($item_status) {
            $data_status['flag'] = 1;
            $item_status->update($data_status);
          //   dd($item_status);
        }
        /* $isUpdated = $item_status->update($data_status);

if ($isUpdated) {
    dd('Update successful', $item_status);
} else {
    dd('Update failed');
}
     */
        if ($item_time) {
            $data['date_end'] = date('Y-m-d H:i:s');
            $item_time->update($data);
        }
        Add_note($old, $new, $request->military_affairs_id);
        Add_note_time($new, $request->military_affairs_id);
        change_status($request, $request->military_affairs_id);

        return redirect()->back()->with('success', 'تم حفظ البيانات بنجاح');

    }
    public function count_stop_car($governate_id, $stop_car_type)
    {

      $result = Military_affair::where('archived', '=', 0)
        ->where(['military_affairs.status' => 'execute', 'military_affairs.stop_car' => 1])
        ->with('installment')
        ->with('status_all')
        ->when($governate_id != 0, function ($query) use ($governate_id) {
            return $query->whereHas('installment.client.court', function ($q) use ($governate_id) {
                $q->where('governorate_id', $governate_id);
            });
        })->when($stop_car_type != 0, function ($query) use ($stop_car_type) {
            $query->whereHas('status_all', function ($q) use ($stop_car_type) {
                return $q->where('type', 'stop_car')->where('type_id', $stop_car_type)->where('flag', 0);
            })
        ->with('installment.client.area.police_station');
        })->count();

    return $result;

    }

    public function countStopCarGovernate($status, $type, $governate_id)
    {
  // dd($governate_id);
       $stop_car_type=1;
      $result = Military_affair::where('archived', '=', 0)
        ->where(['military_affairs.status' => 'execute', 'military_affairs.stop_car' => 1])
        ->with('installment')
        ->with('status_all')
        ->when($governate_id != 0, function ($query) use ($governate_id) {
            return $query->whereHas('installment.client.court', function ($q) use ($governate_id) {
                $q->where('governorate_id', $governate_id);
            });
        }) ->when($stop_car_type != 0, function ($query) use ($stop_car_type) {
            $query->whereHas('status_all', function ($q) use ($stop_car_type) {
                return $q->where('type', 'stop_car')->where('flag', 0);
            })
        ->with('installment.client.area.police_station');
        })->count();
   /*     $query=$result;
       $sql = $query->toSql();
$bindings = $query->getBindings();
foreach ($bindings as $binding) {
$value = is_numeric($binding) ? $binding : "'$binding'";
$sql = preg_replace('/\\?/', $value, $sql, 1);
}

dd($sql);
*/
    return $result;


    }

    public function updateRegionsPoliceStations()
    {
        try {
            $regions = DB::table('regions')->get();

            foreach ($regions as $region) {
                $policeStation = DB::table('prev_table_military_affairs_areas_police_st')
                    ->where('area_id', $region->id)
                    ->first();

                if ($policeStation) {
                    DB::table('regions')
                        ->where('id', $region->id)
                        ->update(['police_station_id' => $policeStation->police_station_id]);
                }
            }
            return "Regions updated successfully.";
        } catch (\Exception $e) {
            return "Error: " . $e->getMessage();
        }
    }

    public function getprevCols()
    {
        $prevCols = DB::table('military_affairs_old')->get();

        foreach ($prevCols as $prevCol) {
            $militaryAffair = Military_affair::find($prevCol->military_affairs_id);

            if ($militaryAffair) {
                $militaryAffair->update([
                    'stop_car_car_num' => $prevCol->stop_car_car_num,
                    'stop_car_img_print' => $prevCol->stop_car_img_print,
                    'stop_car_img_request' => $prevCol->stop_car_img_request,
                    'stop_car_finished' => $prevCol->stop_car_finished,
                ]);
            }
        }

        return response()->json(['message' => 'Data transfer completed successfully.']);
    }

    public function update_info_cars_numbers($id, Request $request)
    {
        $item = Military_affair::findOrFail($id);
        $client = Installment::first('id', $item->installment_id)->with('client');
//dd($client);

        if ($request->isMethod('post')) {
            $carNumber = $item->stop_car_car_num;


            if (!empty($carNumber) && $carNumber > 0) {
                $validatedData = $request->validate([
                    'car_number.*' => 'required|string',
                    'car_type.*' => 'required|string',
                    'car_price.*' => 'required|numeric',
                    'car_modal.*' => 'nullable|string',
                    'car_color.*' => 'nullable|string',
                ], [
                    'car_number.*.required' => 'رقم اللوحة مطلوب لكل سيارة.',
                    'car_type.*.required' => 'نوع السيارة مطلوب لكل سيارة.',
                    'car_price.*.required' => 'قيمة السيارة مطلوبة.',
                ]);

                $carsData = [];
                foreach ($request->car_number as $index => $carNumber) {
                    $carsData[] = [
                        'military_affairs_id' => $id,
                        'car_number' => $carNumber,
                        'car_type' => $request->car_type[$index],
                        'car_price' => $request->car_price[$index],
                        'car_modal' => $request->car_modal[$index] ?? null,
                        'car_color' => $request->car_color[$index] ?? null,
                    ];
                }

                DB::table('military_affairs_cars')->insert($carsData);


                return redirect()->route('stop_car', ['governate_id' => 0, 'stop_car_type' => 'stop_car_police'])
                    ->with('success', 'تمت العملية بنجاح.');
            }

            return redirect()->route('stop_car', ['governate_id' => 0, 'stop_car_type' => 'stop_car_police']);
        }

        $breadcrumb = array();
        $breadcrumb[0]['title'] = " الرئيسية";
        $breadcrumb[0]['url'] = route("dashboard");
        $breadcrumb[1]['title'] = " الشئون القانونية";
        $breadcrumb[1]['url'] = route("military_affairs");
        $breadcrumb[2]['title'] = "حجز السيارات";
        $breadcrumb[2]['url'] = route("stop_car");
        $breadcrumb[3]['title'] = 'ادخال بيانات الاستعلام ';
        $breadcrumb[3]['url'] = 'javascript:void(0);';
        $view = 'military_affairs.stop_car.add_info_car_numbers';
        $title = $this->title;

        return view('layout', compact('item', 'client', 'breadcrumb', 'view', 'title'), $this->data);

    }

    public function catchCarDone($id, Request $request)
    {

        $item = Military_affair::findOrFail($id);
        $client = Installment::first('id', $item->installment_id)->with('client');
        $cars = DB::table('military_affairs_cars')->where('military_affairs_id', $id)->get();

        $this->data['item_type_time1'] = Military_affairs_stop_car_type::where(['type' => 'stop_car', 'slug' => 'stop_car_doing'])->first();
        $this->data['item_type_time_new'] = Military_affairs_stop_car_type::where(['type' => 'stop_car', 'slug' => 'stop_car_finished'])->first();
        if ($request->isMethod('post')) {
//dd($request->item_type_old);

            $carCatchIds = $request->input('car_catch', []);

            DB::table('military_affairs_cars')->whereIn('id', $carCatchIds)->update(['car_catch' => 1]);

            $remainingCars = DB::table('military_affairs_cars')->where('military_affairs_id', $id)
                ->where('car_catch', 0)
                ->count();

            if ($remainingCars === 0) {
                $old = Military_affairs_stop_car_type::where('slug', $request->item_type_old)->first();

                if ($old) {
                    $new = Military_affairs_stop_car_type::where('id', '>', $old->id)
                        ->orderBy('id', 'asc')
                        ->first();

                }

                $request->type_id = $new->slug;

                $item_time = Military_affairs_times::where(['times_type_id' => $old->id, 'military_affairs_id' => $request->military_affairs_id])->first();
                // dd($item_time);
                $item_status = Military_affairs_status::where(['type_id' => $old->slug, 'military_affairs_id' => $request->military_affairs_id])->first();
                if ($item_status) {
                    $data_status['flag'] = 1;
                    $item_status->update($data_status);
                }
                if ($item_time) {
                    $data['date_end'] = date('Y-m-d H:i:s');
                    $item_time->update($data);
                }
                Add_note($old, $new, $request->military_affairs_id);
                Add_note_time($new, $request->military_affairs_id);
                change_status($request, $request->military_affairs_id);
                return redirect()
                    ->route('stop_car', ['governate_id' => 0, 'stop_car_type' => 'stop_car_finished'])
                    ->with('success', 'تمت العملية بنجاح.');
            }

            return redirect()
                ->route('stop_car', ['governate_id' => 0, 'stop_car_type' => 'stop_car_finished'])
                ->with('success', 'تمت العملية بنجاح.');
        }

        $breadcrumb = array();
        $breadcrumb[0]['title'] = " الرئيسية";
        $breadcrumb[0]['url'] = route("dashboard");
        $breadcrumb[1]['title'] = " الشئون القانونية";
        $breadcrumb[1]['url'] = route("military_affairs");
        $breadcrumb[2]['title'] = "حجز السيارات";
        $breadcrumb[2]['url'] = route("stop_car");
        $breadcrumb[3]['title'] = 'ادخال سيارات الحجز ';
        $breadcrumb[3]['url'] = 'javascript:void(0);';
        $view = 'military_affairs.stop_car.catch_car_done';
        $title = $this->title;

        return view('layout', compact('item', 'client', 'breadcrumb', 'view', 'title', 'cars'), $this->data);

    }

    public function send_sms($id)
    {
        $slug = 'stop_car';
        $item = Military_affair::where('id', $id)->with('installment.client.client_phone')->first();

        $phone_2 = $item->installment->client->client_phone[0]->phone ?? '';

        if (strlen($item->installment->client->client_phone[0]->phone_work ?? '') == 8) {
            $phone_2 = $phone_2 . ',' . $item->installment->client->client_phone[0]->phone_work;
        }

        if (strlen($item->installment->client->client_phone[0]->nearist_phone ?? '') == 8) {
            $phone_2 = $phone_2 . ',' . $item->installment->client->client_phone[0]->nearist_phone;
        }

        if ($item['code'] == 0) {
            $item['code'] = $this->checkCode();

            $add_data['code'] = $item['code'];
            $item_military = Military_affair::findOrFail($id);
            $item_military->update($add_data);
        }

        $message = buildMessage($slug, $item);

        if (!$message) {
            return redirect()->back()->with('error', 'Invalid case selected.');
        }

        $message .= "\nللتواصل\n60901515";

        sendSmsHelper($message, $phone_2);

        return redirect()->back()->with('success', 'تم إرسال الرسالة بنجاح.');
    }
    public function checkCode()
    {
        $code = rand(10, 999);

        $exists = DB::table('military_affairs')->where('code', $code)->exists();

        if ($exists) {
            return $this->checkCode();
        }

        return $code;
    }
}