<?php

namespace App\Repositories\Military_affairs;

use App\Models\User;
use App\Models\Installment;
use Illuminate\Http\Request;
use App\Models\Installment_Client;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use App\Models\Military_affairs\Military_affair;
use App\Models\Military_affairs\Military_affairs_times_type;
use App\Interfaces\Military_affairs\PapersRepositoryInterface;

class PapersRepository implements PapersRepositoryInterface
{
    protected $data;
    public function __construct()
    {
        $this->data['eqrar_dain_counter'] = $this->get_count_eqrar_dain('eqrar_dain');
        $this->data["eqrar_dain_received_counter"] = $this->get_count_eqrar_dain('eqrar_dain_received');

    }
    public function index()
    {
        // echo 'yes';

    }

    public function nmozag_eqrar($id)
    {
        $user_id = (isset(Auth::user()->id) ? Auth::user()->id : '');
        $title = 'نموذج اقرار دين';
        $message = "طباعة نموذج اقرار دين";

        log_move($user_id, $message);

        $install = Installment_Client::findOrFail($id);

        return view('military_affairs/papers/print_papers', compact('title', 'install'));
    }

    public function eqrar_not_received()
    {
        $user_id = (isset(Auth::user()->id) ? Auth::user()->id : '');
        $title = 'اقرارت غير مستلمة';
        $message = "تم دخول صفحة الاقرارات الغير مستلمة";
        log_move($user_id, $message);
        $transactions = DB::table('installment')->select('military_affairs.id as m_a_id', 'installment.id', 'clients.name_ar', 'installment.finished_user_id'
            , 'installment.created_by', 'clients.civil_number', 'installment.created_at', 'eqrars_details.paper_received_img', 'file_number',
            'eqrars_details.paper_eqrar_dain_received_date', 'eqrars_details.paper_eqrar_dain_sender_id', 'eqrars_details.paper_eqrar_dain_received_user_id')
            ->where(['type' => 'installment', 'installment.status' => 'finished', 'military_affairs.status' => null, 'eqrars_details.paper_eqrar_dain_received' => 0, 'installment.laws' => 1])
            ->leftJoin('eqrars_details', 'installment.eqrars_id', '=', 'eqrars_details.id')
            ->leftJoin('clients', 'installment.client_id', '=', 'clients.id')
            ->leftJoin('military_affairs', 'installment.id', '=', 'military_affairs.installment_id')
            ->orderBy('installment.id', 'desc')->get();

        $count = $this->data['eqrar_dain_counter'];

        $users = User::where(['active' => '1', 'deleted_at' => null, 'type' => 'emp'])->get();

        $view = 'military_affairs/papers/index';

        $breadcrumb = array();
        $breadcrumb[0]['title'] = " الرئيسية";
        $breadcrumb[0]['url'] = route("dashboard");
        $breadcrumb[1]['title'] = "الشئون القانونية";
        $breadcrumb[1]['url'] = route("military_affairs");
        $breadcrumb[2]['title'] = $title;
        $breadcrumb[2]['url'] = 'javascript:void(0);';

        $this->data['item_type_time'] = Military_affairs_times_type::where(['type' => 'lated_installment', 'slug' => 'lated_installment'])->first();
        $this->data['item_type_time_new'] = Military_affairs_times_type::where(['type' => 'eqrar_dain', 'slug' => 'eqrar_dain_not_received'])->first();

        return view('layout', compact('title', 'users', 'view', 'transactions', 'count', 'breadcrumb'), $this->data);

        // return view('military_affairs/papers/index',compact('title','users'));

    }

    public function to_open_file(Request $request)
    {
        //  dd($request->all());
        $messages = [
            'received_user_id.required' => ' اسم الموظف المستلم اجباري .',
            'convert_date.required' => ' تاريخ الاستلام اجباري.',
        ];

        $validator = Validator::make($request->all(), [
            'received_user_id' => 'required',
            'convert_date' => 'required',
        ], $messages);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        } else {

            $lawsinff = Military_affair::where('installment_id', $request->installment_id)->first();

            $military_affairs_id = $lawsinff['id'];

            $data =
                ['status' => 'military',
                'emp_id' => $request->received_user_id,
                'convert_date' => $request->convert_date,
                'note_transfer' => $request->note_transfer,
                'updated_by' => Auth::id(),
            ];

            Military_affair::where('id', $military_affairs_id)
                ->update($data);

            $old_one = Military_affairs_times_type::where('slug', 'eqrar_dain_received')->first();
            $new_one = Military_affairs_times_type::where('slug', 'open_file')->first();
            $old_time_type = Military_affairs_times_type::findOrFail($old_one->id);
            $new_time_type = Military_affairs_times_type::findOrFail($new_one->id);
            Add_note($old_time_type, $new_time_type, $military_affairs_id); //to open file
            Add_note_time($new_time_type, $request->military_affairs_id);

            return redirect()->route('papers.eqrar_dain_received')->with('message', 'تم التحويل بنجاح');

        }

    }
    public function to_eqrar_dain(Request $request)
    {
        $messages = [

            'paper_recieved_note.required' => 'الملاحظة مطلوبة',
            'received_user_id.required' => 'الموظف المستلم مطلوب',

        ];

        $validatedData = Validator::make($request->all(), [
            'paper_recieved_note' => 'required',
            'received_user_id' => 'required',

        ], $messages);
        if ($validatedData->fails()) {
            return redirect()->back()
                ->withErrors($validatedData)
                ->withInput();
        }

        if ($request->hasFile('cinet_img')) {
            $file = $request->file('cinet_img');
            $filePath = $file->store('uploads/new_photos', 'public');
            $eqrars_id = DB::table('eqrars_details')->insertGetId([

                'paper_eqrar_dain_received' => 1,
                'paper_eqrar_dain_received_user_id' => $request->received_user_id,
                'paper_eqrar_dain_sender_id' => auth()->id(),
                'paper_eqrar_dain_received_date' => date('Y-m-d H:i:s'),
                'paper_eqrar_dain_received_img' => '/storage/' . $filePath,
                'created_by' => Auth::id(),
                'updated_by' => null,
            ]);
            // dd($eqrars_id);
            Installment::where('id', $request->installment_id)
                ->update(['eqrars_id' => $eqrars_id]);

            $eqrars_id = DB::table('installment_papers')->insertGetId([

                'installment_id' => $request->installment_id,
                'received_id' => $request->received_user_id,
                'slug' => 'paper_eqrar_dain_received',
                'sender_id' => auth()->id(),
                'date' => date('Y-m-d H:i:s'),
                'img_dir' => '/storage/' . $filePath,
                'note' => ($request->paper_recieved_note ? $request->paper_recieved_note : auth()->id()),
                //    'created_by' => Auth::id(),
                //   'updated_by' => null,
            ]);

            $military_affairs = Military_affair::where('installment_id', $request->installment_id)->first();
            $military_affairs_id = $military_affairs->id;

            $old_one = Military_affairs_times_type::where('slug', 'eqrar_dain_not_received')->first();
            $new_one = Military_affairs_times_type::where('slug', 'eqrar_dain_received')->first();

            $old_time_type = Military_affairs_times_type::findOrFail($old_one->id);

            $new_time_type = Military_affairs_times_type::findOrFail($new_one->id);

            //  dd($new_time_type);

            Add_note($old_time_type, $new_time_type, $military_affairs_id); //eqrart not recieved
            Add_note_time($new_time_type, $request->military_affairs_id);

            return redirect()->route('papers.eqrar_dain')->with('message', 'تم التحويل بنجاح');

        }

    }
    public function eqrar_received()
    {
        $message = "تم دخول صفحة الاقرارات المستلمة";
        $user_id = (isset(Auth::user()->id) ? Auth::user()->id : '');
        $title = 'اقرارت  دين مستلمة';
        $users = User::where(['active' => '1', 'deleted_at' => null, 'type' => 'emp'])->get();

        $extra = ['installment.laws' => '1', 'eqrars_details.paper_eqrar_dain_received' => '1'];

        $items = DB::table('installment')->select('military_affairs.id as m_a_id', 'installment.id', 'clients.name_ar', 'installment.finished_user_id'
            , 'installment.created_by', 'clients.civil_number', 'installment.date', 'eqrars_details.paper_received_img', 'installment.file_number',
            'eqrars_details.paper_eqrar_dain_received_date', 'eqrars_details.paper_eqrar_dain_sender_id', 'eqrars_details.paper_eqrar_dain_received_user_id')
            ->where(['type' => 'installment', 'installment.status' => 'finished', 'military_affairs.status' => null])
            ->where($extra)
            ->leftJoin('eqrars_details', 'installment.eqrars_id', '=', 'eqrars_details.id')
            ->leftJoin('clients', 'installment.client_id', '=', 'clients.id')
            ->leftJoin('military_affairs', 'installment.id', '=', 'military_affairs.installment_id')
            ->orderBy('installment.id', 'desc')->get();

        $all_paper_eqrar_dain_received = $items;

        $count = $this->data['eqrar_dain_received_counter'];
        $view = 'military_affairs/papers/recieved';
        $breadcrumb = array();
        $breadcrumb[0]['title'] = " الرئيسية";
        $breadcrumb[0]['url'] = route("dashboard");
        $breadcrumb[1]['title'] = "الشئون القانونية";
        $breadcrumb[1]['url'] = route("military_affairs");
        $breadcrumb[2]['title'] = $title;
        $breadcrumb[2]['url'] = 'javascript:void(0);';

        $this->data['item_type_time'] = Military_affairs_times_type::where(['type' => 'lated_installment', 'slug' => 'lated_installment'])->first();
        $this->data['item_type_time_new'] = Military_affairs_times_type::where(['type' => 'eqrar_dain', 'slug' => 'eqrar_dain_not_received'])->first();

        return view('layout', compact('title', 'view', 'users', 'all_paper_eqrar_dain_received', 'count', 'breadcrumb'), $this->data);

    }
    public function get_count_eqrar_dain($slug = null)
    {

        if ($slug == 'archive_received') {

            $extra = ['eqrars_details.paper_received' => '1', 'eqrars_details.paper_received_checked' => '1',
                'installment.tadqeeq' => '1', 'installment.manage_review' => '1', 'installment.tadqeeq_archive' => '1',
                'installment.archive_finished' => '1', 'eqrars_details.paper_eqrar_dain_received' => '0',
                'installment.archive_final' => '0'];

        } else if ($slug == 'eqrar_dain') {
            $extra = ['installment.laws' => '1', 'eqrars_details.paper_eqrar_dain_received' => '0'];
        } else if ($slug == 'eqrar_dain_received') {
            $extra = ['installment.laws' => '1', 'eqrars_details.paper_eqrar_dain_received' => '1'];

        } else {
            $extra = ['eqrars_details.paper_received' => '0'];
        }

        $items = DB::table('installment')->select('military_affairs.id as m_a_id', 'installment.id', 'clients.name_ar', 'installment.finished_user_id'
            , 'installment.created_by', 'clients.civil_number', 'installment.date', 'eqrars_details.paper_received_img', 'installment.file_number',
            'eqrars_details.paper_eqrar_dain_received_date', 'eqrars_details.paper_eqrar_dain_sender_id', 'eqrars_details.paper_eqrar_dain_received_user_id')
            ->where(['type' => 'installment', 'installment.status' => 'finished', 'military_affairs.status' => null])
            ->where($extra)
            ->leftJoin('eqrars_details', 'installment.eqrars_id', '=', 'eqrars_details.id')
            ->leftJoin('clients', 'installment.client_id', '=', 'clients.id')
            ->leftJoin('military_affairs', 'installment.id', '=', 'military_affairs.installment_id')
            ->orderBy('installment.id', 'desc')->get();

        return count($items);

    }
    public function getall_eqrar_received()
    {

        /*
    $transactions = DB::table('installment')->select('installment.id','clients.name_ar','installment.finished_user_id'
    ,'installment.created_by', 'clients.civil_number','installment.date','eqrars_details.paper_received_img', 'file_number',
    'eqrars_details.paper_eqrar_dain_received_date','eqrars_details.paper_eqrar_dain_sender_id','eqrars_details.paper_eqrar_dain_received_user_id')
    ->where(['type' => 'installment','installment.status'=>'finished','military_affairs.status' =>'','eqrars_details.paper_eqrar_dain_received'=>1, 'installment.laws'=>1  ])
    ->leftJoin('eqrars_details', 'installment.eqrars_id', '=', 'eqrars_details.id')
    ->leftJoin('clients', 'installment.client_id', '=', 'clients.id')
    ->leftJoin('military_affairs', 'installment.id', '=', 'military_affairs.installment_id')
    ->orderBy('installment.id', 'desc');

    return DataTables::of($transactions)
    ->addColumn('client_name', function($row) {
    return $row->client ? $row->client->name_ar : 'لا يوجد';
    })
    ->addColumn('action', function($row) {
    $toeqrarUrl = route('papers.to_eqrar_dain', $row->id);
    $out='';

    return '<a href="' . $toeqrarUrl . '" class="btn rounded-full bg-warning font-medium text-white hover:bg-warning-focus focus:bg-warning-focus active:bg-warning-focus/90">تسليم اقرار الدين</a>';
    })
    ->rawColumns(['action'])
    ->make(true);
     */

    }
}
