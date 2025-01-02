<?php

namespace App\Repositories\Military_affairs;
use App\Http\Controllers\Controller;
use App\Interfaces\Military_affairs\SearchRepositoryInterface;
use App\Models\Military_affairs\Military_affair;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Validator;
use Inertia\Inertia;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\Auth;
use App\Models\Log;
use Illuminate\Support\Facades\DB;
use App\Models\Governorate;
use App\Models\Court;
use App\Models\Military_affairs\Prev_cols_military_affairs;


class SearchRepository implements SearchRepositoryInterface
{
    protected $data;

    public function __construct()
    {
        $this->data['governorates'] = Governorate::with('clients')->get();
        $this->data['courts'] = Court::with('government')->get();
    }

    public function index(Request $request)
    {

        $this->data['title'] = 'البحث ';

        // dd($request->all());
        // $item_military = Prev_cols_military_affairs::with('military_old')->findorfail($id);

        $this->data['results'] = DB::table('military_affairs')
        ->join('installment', 'installment.id', '=', 'military_affairs.installment_id')
        ->join('clients', 'clients.id', '=', 'installment.client_id')
        ->join('prev_cols_military_affairs', 'military_affairs.id', '=', 'prev_cols_military_affairs.military_affairs_id')
        ->where('military_affairs.status','military')
        ->select('clients.name_ar', 'clients.civil_number', 'clients.phone_ids','installment.id as installment_id',
                 'military_affairs.status','issue_id','madionia_amount','reminder_amount','stop_travel','stop_salary',
                 'stop_car','ministry_ids','military_affairs.id as mil_id','prev_cols_military_affairs.command_img',
                 'prev_cols_military_affairs.stop_travel_finished_img','prev_cols_military_affairs.stop_salary_doing_img',
                 'prev_cols_military_affairs.stop_salary_request_img','prev_cols_military_affairs.stop_salary_money_img','prev_cols_military_affairs.stop_car_img_catch',
                 'prev_cols_military_affairs.stop_car_img_request','prev_cols_military_affairs.stop_car_img_print','prev_cols_military_affairs.stop_car_request_img')
        ->get();

        foreach($this->data['results'] as $one )
        {
            // dd($one);
            $one->test = Prev_cols_military_affairs::with('military_old')->findorfail($one->mil_id);

        }
        //  dd($this->data);
        // if ($this->data) {
        //       $user_id =  Auth::user()->id ?? null;
        //       $message = "تم دخول صفحة البحث   ";
        //       $this->log($user_id, $message);
        // }

        $title = '  البحث';

        $breadcrumb = array();
        $breadcrumb[0]['title'] = " الرئيسية";
        $breadcrumb[0]['url'] = route("dashboard");
        $breadcrumb[1]['title'] = "الشئون القانونية";
        $breadcrumb[1]['url'] = route("military_affairs");
        $breadcrumb[2]['title'] = $title;
        $breadcrumb[2]['url'] = 'javascript:void(0);';

        $this->data['view'] = 'military_affairs/search/index';
        return view('layout', $this->data, compact('breadcrumb'));
    }
    public function get_searched(Request $request)
    {

        $results = DB::table('military_affairs')
        ->join('installment', 'installment.id', '=', 'military_affairs.installment_id')
        ->join('clients', 'clients.id', '=', 'installment.client_id')
        ->where('military_affairs.status','military')
        ->select('clients.name_ar', 'clients.civil_number', 'clients.phone_ids','installment.id as installment_id',
                 'military_affairs.status','issue_id','madionia_amount','reminder_amount','stop_travel','stop_salary',
                 'stop_car','ministry_ids');


        if ($request->filled('name')) {
            $results->where('clients.name_ar', 'like', '%' . $request->name . '%');
        }
        if ($request->filled('civil_id')) {
            $results->where('civil_number', $request->civil_id);
        }
        if ($request->filled('phone')) {
            $results->where('phone', $request->phone);
        }
        if ($request->filled('phone')) {
            $results->where('phone', $request->phone);
        }

        $this->data['results'] = $results->get();

        $title = '  البحث';

        $breadcrumb = array();
        $breadcrumb[0]['title'] = " الرئيسية";
        $breadcrumb[0]['url'] = route("dashboard");
        $breadcrumb[1]['title'] = "الشئون القانونية";
        $breadcrumb[1]['url'] = route("military_affairs");
        $breadcrumb[2]['title'] = $title;
        $breadcrumb[2]['url'] = 'javascript:void(0);';

        $this->data['view'] = 'military_affairs/Search/index';
        return view('layout', $this->data, compact('breadcrumb'));
    }

    public function show_images($id)
    {
        $item_military = Prev_cols_military_affairs::with('military_old')->findorfail($id);
    // dd($item_military);
        return redirect()->route('search.index',  $item_military);


    }

    // public function store(Request $request)
    // {

    //     $request->validate([
    //         'date' => 'required| date',
    //         'img_dir' => 'required|image|mimes:jpg,png,jpeg,gif|max:2048',
    //     ]);


    //     if ($request->hasFile('img_dir')) {
    //         $data_img_dir = $request->file('img_dir')->store('military_affairs', 'public'); // Store in the 'products' directory
    //     }
    //     $item_military_affairs = Military_affair::findorfail($request->military_affairs_id);

    //     $data['actions_up'] = 0;
    //     $data['img_dir'] = $data_img_dir;

    //     if ($request->convert_type) {
    //         $data['archived_img_dir'] = $data_img_dir;

    //         $data['archived'] = 1;

    //     }

    //     $item_military_affairs->update($data);
    //     return redirect()->route('checking');


    // }



}