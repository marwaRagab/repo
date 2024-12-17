<?php

namespace App\Repositories\Military_affairs;

use App\Interfaces\Military_affairs\CertificateRepositoryInterface;
use App\Models\Court;
use App\Models\Governorate;
use App\Models\Installment;
use App\Models\InstallmentNote;
use App\Models\Military_affairs\Military_affair;
use App\Models\Military_affairs\Military_affairs_certificate_type;
use App\Models\Military_affairs\Military_affairs_jalasaat;
use App\Models\Military_affairs\Military_affairs_notes;
use App\Models\Military_affairs\Military_affairs_status;
use App\Models\Military_affairs\Military_affairs_stop_salary_type;
use App\Models\Military_affairs\Military_affairs_times_type;
use App\Models\Ministry;
use App\Models\Prev_cols_clients;
use http\Client;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Validator;
use Inertia\Inertia;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\Auth;
use App\Models\Log;

class CertificateRepository implements CertificateRepositoryInterface
{
    protected $data;


    public function __construct()
    {
        //

        $this->data['governorates'] = Governorate::with('clients')->get();
        $this->data['courts'] = Court::with('government')->get();
        $this->data['ministries'] = Ministry::whereIn('id', [14, 5, 27])->get();
        $this->data['Certificate_types'] = Military_affairs_certificate_type::all();
        $color_array = ['bg-warning-subtle text-warning', 'bg-success-subtle text-success', 'bg-danger-subtle text-danger', 'px-4 bg-primary-subtle text-primary', 'bg-danger-subtle text-danger', 'me-1 mb-1  bg-warning-subtle text-warning'];

        for ($i = 0; $i < count($this->data['courts']); $i++) {
            $this->data['courts'][$i]['style'] = $color_array[$i];
        }

        for ($i = 0; $i < count($this->data['Certificate_types']); $i++) {
            $this->data['Certificate_types'][$i]['style'] = $color_array[$i];
        }
        for ($i = 0; $i < count($this->data['ministries']); $i++) {
            $this->data['ministries'][$i]['style'] = $color_array[$i];
        }


    }

    public function index(Request $request)
    {
        $certificate_type = $request->certificate_type;
        $message = "تم دخول صفحة الشهادة العسكرية";

        $user_id = Auth::user()->id;
        log_move($user_id, $message);
        $user_id = Auth::user()->id;
        $this->data['title'] = '   اصدار الشهادة العسكرية';
        $this->data['items'] = Military_affair::where('archived', '=', 0)->where(['military_affairs.status' => 'execute', 'military_affairs.certificate' => 1, 'stop_salary' => 0])
            ->when('certificate_type', function ($q) use ($certificate_type) {

                if ($certificate_type == 'money') {
                    $q->where('certificate_info_book', 1);
                    $q->where('certificate_info_request', 1);
                    $q->where('certificate_export', 1);
                    return $q->where('certificate_no', '!=', NULL);
                } elseif ($certificate_type == 'info_book') {
                    $q->where('certificate_info_book', 1);
                    $q->where('certificate_info_request', 1);
                    return $q->where('certificate_export', 0);
                } elseif ($certificate_type == 'export') {
                    $q->where('certificate_info_book', 1);
                    $q->where('certificate_info_request', 1);
                    $q->where('certificate_export', 1);
                    return $q->where('certificate_no', '=', NULL);
                } elseif ($certificate_type == 'info_request') {

                    return $q->where('certificate_info_request', 0);

                } else {

                }
            })
            ->with('installment')->with('status_all')->get();
        $title = 'اصدار الشهادة العسكرية ';

        foreach ($this->data['items'] as $value) {
            $value->old_client = Prev_cols_clients::where('client_id', $value->installment->client_id)->first();
        }


        $breadcrumb = array();
        $breadcrumb[0]['title'] = " الرئيسية";
        $breadcrumb[0]['url'] = route("dashboard");
        $breadcrumb[1]['title'] = "الشئون القانونية";
        $breadcrumb[1]['url'] = route("military_affairs");


        $breadcrumb[2]['title'] = $title;
        $breadcrumb[2]['url'] = 'javascript:void(0);';
        $this->data['item_type_time'] = Military_affairs_certificate_type::where(['type' => 'certificate', 'slug' => 'info_request'])->first();
        $this->data['item_type_time_info'] = Military_affairs_certificate_type::where(['type' => 'certificate', 'slug' => 'info_request'])->first();
        $this->data['item_type_time_book'] = Military_affairs_certificate_type::where(['type' => 'certificate', 'slug' => 'info_book'])->first();
        $this->data['item_type_time_export'] = Military_affairs_certificate_type::where(['type' => 'certificate', 'slug' => 'export'])->first();
        $this->data['item_type_time_money'] = Military_affairs_certificate_type::where(['type' => 'certificate', 'slug' => 'money'])->first();

      
        $this->data['get_responsible'] = get_responsible();
        $this->data['view'] = 'military_affairs/Military-certificate/index';

        // dd($this->data['items']);
        return view('layout', $this->data, compact('breadcrumb'));

    }

    public function convert_book_info($id)
    {
        $message = "تم    التحويل الى كتاب الاستعلام";

        $user_id = Auth::user()->id;
        log_move($user_id, $message);

        $item_old_time = Military_affairs_certificate_type::where('slug', 'info_request')->first();
        $item_new_time = Military_affairs_certificate_type::where('slug', 'info_book')->first();
        $case_proof_item = Military_affairs_notes::where(['type' => 'case_proof', 'date_end' => NULL, 'date_start' => !NULL, 'military_affairs_id' => $id])->first();
        $military_item = Military_affair::findorfail($id);
        $data_military['certificate_info_request'] = 1;
        $data_military['certificate_info_book'] = 1;
        $military_item->update($data_military);
        $data_update['date_end'] = date('Y-m-d');
        $data_update['updated_by'] = Auth::user() ? Auth::user()->id : null;
        $data_update['updated_at'] = date('Y-m-d');
        $case_proof_item->update($data_update);
        Add_note($item_old_time, $item_new_time, $id);

        return redirect()->route('Certificate');


    }

    public function convert_to_export(Request $request)
    {

        $message = "تم    التحويل الى  الصادر والوارد";


        $user_id = Auth::user()->id;
        log_move($user_id, $message);

        $id = $request->military_affairs_id;
        $request->validate([
            'date' => 'required| date',
            'img_dir' => 'required|image|mimes:jpg,png,jpeg,gif|max:2048',
        ]);

        $item_old_time = Military_affairs_certificate_type::where('slug', 'info_book')->first();
        $item_new_time = Military_affairs_certificate_type::where('slug', 'export')->first();
        $certificate_type_item = Military_affairs_notes::where(['times_type_id' => $item_old_time->id, 'date_end' => NULL, 'date_start' => !NULL, 'military_affairs_id' => $id])->first();
        $military_item = Military_affair::findorfail($id);

        $data_military['certificate_info_request'] = 1;
        $data_military['certificate_info_book'] = 1;
        $data_military['certificate_export'] = 1;
        $military_item->update($data_military);
        $data_update['date_end'] = date('Y-m-d');
        $data_update['updated_by'] = Auth::user() ? Auth::user()->id : null;
        $data_update['updated_at'] = date('Y-m-d');
        if ($certificate_type_item) {
            $certificate_type_item->update($data_update);

        }

        Add_note($item_old_time, $item_new_time, $id);
        change_status($request, $request->military_affairs_id);
        return redirect()->route('Certificate');


    }

    public function convert_to_money(Request $request)

    {

        $message = "تم    التحويل الى    المالية";

        $user_id = Auth::user()->id;
        log_move($user_id, $message);
        $request->validate([
            'date' => 'required| date',
            'certificate_no' => 'required',
            'note' => 'required|string',
            'img_dir' => 'required|image|mimes:jpg,png,jpeg,gif|max:2048',
        ]);
        $id = $request->military_affairs_id;

        $item_old_time = Military_affairs_certificate_type::where('slug', 'export')->first();
        $item_new_time = Military_affairs_certificate_type::where('slug', 'money')->first();
        $certificate_type_item = Military_affairs_notes::where(['times_type_id' => $item_old_time->id, 'date_end' => NULL, 'date_start' => !NULL, 'military_affairs_id' => $id])->first();
        $military_item = Military_affair::findorfail($id);
        $data_military['certificate_info_request'] = 1;
        $data_military['certificate_info_book'] = 1;
        $data_military['certificate_export'] = 1;
        $data_military['certificate_no'] = $request->certificate_no;
        $military_item->update($data_military);
        $data_update['date_end'] = date('Y-m-d');
        $data_update['updated_by'] = Auth::user() ? Auth::user()->id : null;
        $data_update['updated_at'] = date('Y-m-d');
        if ($certificate_type_item) {
            $certificate_type_item->update($data_update);
        }

        Add_note($item_old_time, $item_new_time, $id);

        change_status($request, $request->military_affairs_id);

        return redirect()->route('Certificate');
    }


    public function convert_to_stop_salary(Request $request)

    {
        $message = "تم    التحويل الى    حجز الراتب";

        $user_id = Auth::user()->id;
        log_move($user_id, $message);
        $request->validate([
            'img_dir' => 'required|image|mimes:jpg,png,jpeg,gif|max:2048',
        ]);
        $id = $request->military_affairs_id;
        $item_old_time = Military_affairs_certificate_type::where('slug', 'money')->first();
        $item_new_time = Military_affairs_stop_salary_type::where('slug', 'stop_salary_request')->first();
        $certificate_type_item = Military_affairs_notes::where(['times_type_id' => $item_old_time->id, 'date_end' => NULL, 'date_start' => !NULL, 'military_affairs_id' => $id])->first();
        $military_item = Military_affair::findorfail($id);
        $data_military["stop_salary"] = 1;
        $military_item->update($data_military);
        $data_update['date_end'] = date('Y-m-d');
        $data_update['updated_by'] = Auth::user() ? Auth::user()->id : null;
        $data_update['updated_at'] = date('Y-m-d');
        if ($certificate_type_item) {
            $certificate_type_item->update($data_update);

        }
        Add_note($item_old_time, $item_new_time, $id);
        change_status($request, $request->military_affairs_id);
        return redirect()->route('Certificate');
    }


    public function data_certificate(Request $request)
    {
        $governorate_id = $request->governorate_id;
        $bank_slug = $request->bank_slug;
        $data = \App\Models\Client::when($governorate_id, function ($q) use ($governorate_id) {
            return $q->where('governorate_id', $governorate_id);
        })->when($bank_slug, function ($q) use ($bank_slug) {
            return $q->where('bank_name', $bank_slug);
        })
            ->with('military_clients', function ($query) {
                $query->where('archived', '=', 0);
                $query->where('stop_bank', '=', 1);
                return $query->where('military_affairs.status', '=', 'execute');
            })->with('installments', function ($query) {
                return $query->where('finished', '=', 0);
            })->with('ministry')
            ->get();

        /*  $data = \App\Models\Client::with('military_clients', function ($query) {
            return  $query->where('archived','=',0);
          })->with('installments', function ($query) {
              $query->where('finished','=',0);
          })->get();*/
        /* })->with('military_clients', function ($query) {
             $query->where('archived','=',0);
             //  $query->where('stop_salary','=',0);
             // $query->where('certificate','=',1);
         })->with('installments', function ($query) {
             $query->where('finished','=',0);
         })*/


        dd($data);


        return DataTables::of($data)->toJson();

    }


}
