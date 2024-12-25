<?php

namespace App\Repositories\Military_affairs;

use App\Interfaces\Military_affairs\Stop_carRepositoryInterface;
use App\Models\Court;
use App\Models\Governorate;
use App\Models\Military_affairs\Military_affair;
use App\Models\Military_affairs\Military_affairs_stop_car_type;
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

        $stop_car_type = $request->stop_car_type ?? 'stop_car_request';
        $governate_id = $request->governate_id ?? 0;

        $this->data['govern_count_total'] = $this->countStopCarGovernate('execute', 'stop_car', '');
        foreach ($this->data['governorates'] as $one) {
            $count['govern_counter_' . $one->id] = $this->countStopCarGovernate('execute', 'stop_car', $one->id);
        }
        $this->data['item_type_time1'] = Military_affairs_times_type::where(['type' => 'stop_cars', 'slug' => $stop_car_type])->first();

        $this->data['item_type_time_new'] = Military_affairs_times_type::where(['type' => 'stop_cars', 'slug' => $stop_car_type])->first();

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

        $this->data['item_type_time1'] = Military_affairs_stop_car_type::where(['type' => 'stop_cars', 'slug' => $current_request->slug])->first();
        $this->data['item_type_time_new'] = Military_affairs_stop_car_type::where(['type' => 'stop_cars', 'slug' => $next_request->slug])->first();
        $this->data['governate_id'] = $governate_id;
        $this->data['stop_car_type'] = $stop_car_type;

        $this->data['types'] = Military_affairs_stop_car_type::get();
        $this->data['classes'] = ['bg-warning-subtle text-warning', 'bg-success-subtle text-success', 'bg-danger-subtle text-danger', 'px-4 bg-primary-subtle text-primary', 'bg-danger-subtle text-danger', '  bg-warning-subtle text-warning', 'bg-danger-subtle text-danger', 'px-4 bg-primary-subtle text-primary'];

        $counts = [];
        foreach ($this->data['types'] as $type) {
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
            })->get();

        foreach ($transactions as $value) {

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

        return view('layout', compact(['title', 'view', 'transactions', 'breadcrumb', 'count']), $this->data);

    }

    public function count_stop_car($governate_id, $stop_car_type)
    {
        $status = 'execute';

        $govern = !empty($governate_id) ? ['governorate_id' => $governate_id] : [];

        $query = Military_affair::query()
            ->where([
                'stop_car_archive_type' => 'not_archived',
                'tahseel' => null,
                'archived' => 0,
                'stop_car_archive' => 0,
                'status' => $status,
                'stop_car' => 1,
            ]);

        $query->whereHas('installment', function ($q) {
            $q->where('finished', 0);
        });

        if (!empty($govern)) {
            $query->whereHas('installment.client', function ($q) use ($govern) {
                $q->where($govern);
            });
        }
        $subQuery = DB::table('military_affairs_status')
            ->select('id', 'military_affairs_id')
            ->where('flag', 0)
            ->where('type', 'stop_car')
            ->where('type_id', $stop_car_type);

        $query->whereIn('id', $subQuery->pluck('military_affairs_id'));
        $result = $query->get();
        return count($result);

    }

    public function countStopCarGovernate($status, $type, $governateId)
    {

        $query = Military_affair::query()
            ->where([
                'stop_car_archive_type' => 'not_archived',
                'tahseel' => 0,
                'archived' => 0,
                'stop_car_archive' => 0,
                'status' => $status,
            ])
            ->whereHas('installment', function ($q) {
                $q->where('finished', 0);
            });

        if (!empty($type)) {
            $query->where($type, 1);
        }

        if (!empty($governateId) && $governateId != '') {
            $query->whereHas('installment.client', function ($q) use ($governateId) {
                $q->where('governorate_id', $governateId);
            });
        }
        return $query->count();
    }

}
