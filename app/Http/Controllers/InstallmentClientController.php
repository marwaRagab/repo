<?php

namespace App\Http\Controllers;
ini_set('memory_limit', '600M');


use App\Models\Log;
use App\Models\Bank;
use App\Models\User;

use App\Models\Boker;
use App\Models\Client;
use App\Models\Region;
use App\Models\Ministry;
use App\Models\Governorate;
use App\Models\Installment;
use Illuminate\Http\Request;
use App\Models\InstallmentCar;
use App\Models\InstallmentIssue;
use App\Models\InstallmentBroker;
use App\Models\Installment_Client;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\InstallmentClientNote;
use App\Models\Installment_Client_Cinet;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Validator;
use App\Http\Requests\StoreInstallment_ClientRequest;
use App\Interfaces\InstallmentClientsRepositoryInterface;

class InstallmentClientController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

     protected $InstallmentClientsRepository;

     public function __construct(InstallmentClientsRepositoryInterface $InstallmentClientsRepository)
     {
         $this->InstallmentClientsRepository = $InstallmentClientsRepository;
     }


     public function index($status)
     {
        // dd($status);
         //


         $data = $this->InstallmentClientsRepository->index($status);

        if($data)
        {
            //  $user_id = 1 ;
              $user_id =  Auth::user()->id ?? null;
                $message ="تم دخول صفحة المتقدمين" ;
                $this->log($user_id ,$message);
        }
        $bank = Bank::all();
        $government = Governorate::all();
        $region = Region::all();
        $ministry= Ministry::where('type','working')->get();
        $boker = Boker::all();

        if ($status == "transaction_submited") {
            return view('installmentClient.submitCopy',compact('data'));
        }elseif($status =="transaction_accepted")
        {
            return view('installmentClient.transaction_acceptedCopy',compact('data'));
        }
        elseif( $status == "refused")
        {
            return view('installmentClient.transaction_refusedCopy',compact('data'));
        }
        else {
            return view('installmentClient.indexCopy',compact('data','bank','government','region','ministry','boker'));
        }

     }

     public function install($id)
     {
        // dd($status);
         //


               $user_id =  Auth::user()->id ?? null;
                $message ="تم دخول صفحة المتقدمين" ;
                $this->log($user_id ,$message);

        $bank = Bank::all();
        $government = Governorate::all();
        $region = Region::all();
        $ministry= Ministry::where('type','working')->get();
        $boker = Boker::all();
        $data=Boker::where('id',$id)->first();
        return view('installmentClient.installByBroker',compact('data','bank','government','region','ministry','boker'));


     }
     public function myinstall($status)
    {
        //    dd($status);
        //
        $title='المعاملات';

        $breadcrumb = array();
        $breadcrumb[0]['title'] = " الرئيسية";
        $breadcrumb[0]['url'] = route("dashboard");
        $breadcrumb[1]['title'] = "المعاملات";
        $breadcrumb[1]['url'] = route("myinstall.index" , ['status' => 'advanced']);
        $breadcrumb[2]['title'] = $title;
        $breadcrumb[2]['url'] = 'javascript:void(0);';

        $data['bank'] = Bank::all();
        $data['government'] = Governorate::all();
        $data['region'] = Region::all();

        $data['ministry'] = Ministry::where('type', 'working')->get();

        $data['boker'] = InstallmentBroker::all();

        $data['counts'] = [
            'advancedCount' => Installment_Client::where('status', 'advanced')->count(),
            'under_inquiryCount' => Installment_Client::where('status', 'under_inquiry')->count(),
            'auditingCount' => Installment_Client::where('status', 'auditing')->count(),
            'car_inquiryCount' => Installment_Client::where('status', 'car_inquiry')->count(),
            'acceptedCount' => Installment_Client::where('status', 'accepted')->count(),
            'accepted_conditionCount' => Installment_Client::where('status', 'accepted_condition')->count(),
            'rejectedCount' => Installment_Client::where('status', 'rejected')->count(),
            'inquiry_doneCount' => Installment_Client::where('status', 'inquiry_done')->count(),
            'total' => Installment_Client::count(),
            'transaction_submitedCount' => Installment_Client::where('status', 'transaction_submited')->count(),
            'transaction_acceptedCount' => Installment_Client::where('status', 'transaction_accepted')->count(),
            'submit_archiveCount' => Installment_Client::where('status', 'submit_archive')->count(),
            // 'transaction_refusedCount' => Installment_Client::where('status', 'transaction_refused')->count(),
            'accepted_archiveCount' => Installment_Client::where('status', 'accepted_archive')->count(),
        ];

        if($status == 0)
        {
            $data['Installment'] = Installment_Client::with([
                'bank',
                'installmentBroker',

            ])->withCount(['installment_car', 'installment_issue'])->get();
        }
        elseif($status == "refused")
        {
            $data['Installment'] = Installment_Client::with([
                'bank',
                'installmentBroker',
            ])->withCount(['installment_car', 'installment_issue'])->where('status', "rejected")->get();
        } else {

            // dd($status);
            $data['Installment'] = Installment_Client::with([
                'bank',
                'installmentBroker',
            ])->withCount(['installment_car', 'installment_issue'])->where('status', $status)->get();
        }
        if ($data) {

            $user_id = Auth::user()->id ?? null;
            $message = "تم دخول صفحة عملاء الاقساط";
            $this->log($user_id, $message);

        }

       if ($status == "transaction_submited") {

           $data['view']='installmentClient/submitCopy';
        }
        elseif($status =="submit_archive")
        {
            $data['view']='installmentClient/submitCopy';
            // return view('installmentClient.transaction_accepted',compact('data'));
        }
        elseif($status =="transaction_accepted")
        {
            $data['view']='installmentClient/transaction_acceptedCopy';
            // return view('installmentClient.transaction_accepted',compact('data'));
        }
        elseif($status =="accepted_archive")
        {
            $data['view']='installmentClient/transaction_acceptedCopy';
            // return view('installmentClient.transaction_accepted',compact('data'));
        }
        elseif( $status == "refused")
        {
            // transaction_refusedCopy
            $data['view']='installmentClient/transaction_refusedCopy';
            // return view('installmentClient.transaction_refused',compact('data'));
        }
        elseif( ($status == "submit_archive") || ($status == "accepted_archive"))
        {
            // transaction_refusedCopy
            $data['view']='installmentClient/archive';
            // return view('installmentClient.transaction_refused',compact('data'));
        }
        else {
            $data['view']='installmentClient/indexCopy';


            // return view('installmentClient.index',compact('data','bank','government','region','ministry','boker'));
        }
        return view('layout',$data,compact('breadcrumb','data'));


    }

    public function search(Request $request)
    {
        $title='البحث';

        $breadcrumb = array();
        $breadcrumb[0]['title'] = " الرئيسية";
        $breadcrumb[0]['url'] = route("dashboard");
        $breadcrumb[1]['title'] = "المعاملات";
        $breadcrumb[1]['url'] = route("myinstall.index" , ['status' => 'advanced']);
        $breadcrumb[2]['title'] = $title;
        $breadcrumb[2]['url'] = 'javascript:void(0);';

        $data['bank'] = Bank::all();
        $data['government'] = Governorate::all();
        $data['region'] = Region::all();
        $data['ministry']= Ministry::where('type','working')->get();
        $data['boker'] = InstallmentBroker::all();

        $installmentsQuery = Installment_Client::with([
            'user',
            'region',
            'ministry_working',
            'bank',
            'installmentBroker',
            'governorate',
            'installment_issue',
            'installment_car',
            'installment_note'
        ]);

        $searchPerformed = false;

        if ($request->filled('transaction_number')) {
            $installmentsQuery->where('id', $request->transaction_number);
            $searchPerformed = true;
        }
        if ($request->filled('client_name')) {
            $installmentsQuery->where('name_ar', 'like', '%' . $request->client_name . '%');
            $searchPerformed = true;
        }
        if ($request->filled('civil_id')) {
            $installmentsQuery->where('civil_number', $request->civil_id);
            $searchPerformed = true;
        }
        if ($request->filled('phone_number')) {
            $installmentsQuery->where('phone', $request->phone_number);
            $searchPerformed = true;
        }

        $data['results'] = $installmentsQuery->get() ?? collect();
        $data['view']='installmentClient/search';
        return view('layout',$data,compact('breadcrumb','data','searchPerformed'));
    }

     public function getAll($status)
    {
        $data = $this->InstallmentClientsRepository->index($status);

        return DataTables::of($data['data'])
            ->addColumn('created_by', function($row) {
                return $row->user ? $row->user->name_ar : 'لا يوجد';
            })
            ->addColumn('region_name', function($row) {
                // Access the related 'region' data
                return $row->region ? $row->region->name_ar : 'لا يوجد';
            })
            ->addColumn('ministry', function($row) {
                // Access the related 'ministry_working' data
                return $row->ministry_working ? $row->ministry_working->name_ar : 'لا يوجد';
            })
            ->addColumn('bank', function($row) {
                // Access the related 'bank' data
                return $row->bank ? $row->bank->name_ar : 'لا يوجد';
            })
            ->addColumn('boker', function($row) {
                // Access the related 'Boker' data
                return $row->Boker ? $row->Boker->name_ar : 'لا يوجد';
            })
            ->addColumn('governorate', function($row) {
                // Access the related 'governorate' data
                return $row->governorate ? $row->governorate->name_ar : 'لا يوجد';
            })
            ->addColumn('installment_car_count', function($row) {
                // Use withCount for installment_car
                return $row->installment_car_count;
            })
            ->addColumn('installment_issue_count', function($row) {
                $count = $row->installment_issue_count; // Assuming this is retrieved via a `withCount` relationship
                $url = route('installmentIssue.index', $row->id);

                return '<a href="' . $url . '"
                            class="btn border border-secondary font-medium text-secondary hover:bg-secondary hover:text-white focus:bg-secondary focus:text-white active:bg-secondary/90
                            dark:text-secondary-light dark:hover:bg-secondary dark:hover:text-white dark:focus:bg-secondary dark:focus:text-white dark:active:bg-secondary/90 ml-3 mt-3">
                            استعلام قضائى (' . $count . ')
                        </a>';
            })

            // ->addColumn('note', function($row) {
            //     // Ensure you return valid HTML for the button
            //     return '<button class="btn btn-sm btn-primary">الملاحظات</button>';
            // })
            ->addColumn('action', function($row) {
                $editUrl = route('broker.edit', $row->id);
                $deleteUrl = route('broker.delete', $row->id);

                return '<a href="' . $editUrl . '" class=""><i class="fa-solid fa-pen-to-square"></i></a>
                <a href="' . $deleteUrl . '" class="" onclick="return confirm(\'Are you sure you want to delete this broker?\');"><i class="fa-solid fa-trash text-danger"></i></a>
                        ';
             })
            ->addColumn('inquery', function ($row) {

                $carInquiryLink = '';

                    // Conditionally show the "استعلام سيارات" link when the status is 'car_inquiry'
                    if ($row->status == 'car_inquiry') {
                        $carInquiryLink = '
                            <a href="' . route('carInquiry', $row->id) . '" style="background-color: black;color: white;text-decoration: auto;padding: 10px;" >
                                استعلام سيارات
                            </a>
                        ';
                    }
                return '

                        <div class="dropdown">
                            <button class="btn btn-warning dropdown-toggle" type="button" id="dropdownMenuButton' . $row->id . '" data-bs-toggle="dropdown" aria-expanded="false">
                                نتيجة الاستعلام
                            </button>
                            <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton' . $row->id . '">
                                <li>
                                        <button data-id="' . $row->id . '" onclick="openModal1(' . $row->id . ')" class="dropdown-item btn bg-slate-150 font-medium text-slate-800 hover:bg-slate-200 focus:bg-slate-200 active:bg-slate-200/80 dark:bg-navy-500 dark:text-navy-50 dark:hover:bg-navy-450 dark:focus:bg-navy-450 dark:active:bg-navy-450/90" type="submit">
                                        مرفوض
                                        </button>

                                </li>
                                <li>
                                        <button data-id="' . $row->id . '" onclick="openModal(' . $row->id . ')" class="dropdown-item btn bg-slate-150 font-medium text-slate-800 hover:bg-slate-200 focus:bg-slate-200 active:bg-slate-200/80 dark:bg-navy-500 dark:text-navy-50 dark:hover:bg-navy-450 dark:focus:bg-navy-450 dark:active:bg-navy-450/90" type="submit">
                                            مقبول
                                        </button>

                                </li>

                                <li>
                                 <form action="' . route('installmentClient.update', $row->id) . '" method="post" style="display:inline;">
                                        ' . csrf_field() . '
                                        <input type="hidden" name="status" value="accepted_condition">
                                        <button class="dropdown-item" type="submit">
                                        مقبول بشرط
                                        </button>
                                    </form>

                                </li>
                                <li>
                                 <form action="' . route('installmentClient.update', $row->id) . '" method="post" style="display:inline;">
                                        ' . csrf_field() . '
                                        <input type="hidden" name="status" value="inquiry_done">
                                        <button class="dropdown-item" type="submit">
                                            تم الاستعلام
                                        </button>
                                    </form>

                                </li>
                                <li>
                                 <form action="' . route('installmentClient.update', $row->id) . '" method="post" style="display:inline;">
                                        ' . csrf_field() . '
                                        <input type="hidden" name="status" value="car_inquiry">
                                        <button class="dropdown-item" type="submit">
                                        استعلام السيارات
                                        </button>
                                    </form>

                                </li>
                                <li>
                                 <form action="' . route('installmentClient.update', $row->id) . '" method="post" style="display:inline;">
                                        ' . csrf_field() . '
                                        <input type="hidden" name="status" value="auditing">
                                        <button class="dropdown-item" type="submit">
                                        التدقيق القضائى
                                        </button>
                                    </form>

                                </li>
                                 <li>
                                 <form action="' . route('installmentClient.update', $row->id) . '" method="post" style="display:inline;">
                                        ' . csrf_field() . '
                                        <input type="hidden" name="status" value="advanced">
                                        <button class="dropdown-item" type="submit">
                                        متقدمين
                                        </button>
                                    </form>
                                </li>
                                <li>
                                 <form action="' . route('installmentClient.update', $row->id) . '" method="post" style="display:inline;">
                                        ' . csrf_field() . '
                                        <input type="hidden" name="status" value="under_inquiry">
                                        <button class="dropdown-item" type="submit">
                                        قيد الاستعلام
                                        </button>
                                    </form>
                                </li>
                            </ul>
                        </div>
                        </br>
                        ' . $carInquiryLink . '
                    ';
            })

            ->addColumn('archive', function ($row) {
                $route = route('installmentClient.update', $row->id);

                // Check the status to determine which button to show
                if ($row->status == 'archive') {
                    // If the status is 'archive', display a disabled button
                    return '
                        <button class="btn btn-danger" disabled>
                            تمت الارشفة
                        </button>
                    ';
                } else {
                    // If the status is not 'archive', show the form to archive
                    return '
                        <form action="' . $route . '" method="post" style="display:inline;">
                            ' . csrf_field() . '
                            <input type="hidden" name="status" value="archive">
                            <button class="btn btn-danger" type="submit">
                                تحويل للارشيف
                            </button>
                        </form>
                    ';
                }
            })
            ->addColumn('acceptcost', function ($row) {
                // Initialize the variable to hold the output
                $output = '';

                // Conditionally show the "استعلام سيارات" link when the status is 'accepted'
                if ($row->status === 'accepted') {
                    // Prepare the output HTML
                    $output .= '<h6>' . htmlspecialchars($row->accept_cost) . '</h6>';
                    $output .= '<a href="' . route('installmentsubmission.index', $row->id) . '"  class="btn btn-danger" disabled aria-disabled="true">
                                    تقديم الاقساط
                                </a>';
                }

                return $output; // Return the constructed output
            })

            ->addColumn('transaction_submited', function ($row) {
                $route = route('installmentClient.update', $row->id);
                return '
                <div class="btn-group dropup  d-block">
                 <a class="btn btn-secondary " href="' . route('installment.convert_approvedCopy', $row->id) . '"  >
                    تقديم
                </a>
                </div>

                <form action="' . $route . '" method="post" style="display:inline;">
                            ' . csrf_field() . '
                    <input type="hidden" name="status" value="submit_archive">
                        <button class="btn btn-danger w-100 mt-2" " type="submit">
                        تحويل للارشيف
                    </button>
                </form>
                    ';
            })

            ->addColumn('transaction_accepted', function ($row) {
                $route = route('installmentClient.update', $row->id);
                return '
                <div class="btn-group dropup mb-6 me-6 d-block">
                 <a class="btn btn-secondary " href="' . route('installmentApprove.indexCopy', $row->id) . '"  >
                                اعتماد المعاملة
                            </a>
                </div>

                <form action="' . $route . '" method="post" style="display:inline;">
                                    ' . csrf_field() . '
                            <input type="hidden" name="status" value="accepted_archive">
                            <button class="btn btn-danger w-100 mt-2" type="submit">
                                تحويل للارشيف
                            </button>
                        </form>
                    ';
            })


            ->rawColumns(['acceptcost','inquery' ,'archive' ,'installment_issue_count','transaction_submited','transaction_accepted'])
            ->make(true);
    }

    public function getNotes($id)

{
    $notes = InstallmentClientNote::where('installment_clients_id', $id)->with('user')->get();

    if($notes)
    {

            $user_id =  Auth::user()->id ?? null;
            $message ="تم عرض   ملاحظات المعاملات" ;
            $this->log($user_id ,$message);
    }
    return response()->json(['notes' => $notes]);
}


// public function getNotesIssue($id)
// {
//     $notesissue = InstallmentIssue::where('installment_clients_id', $id)->with('user')->get();
//     // $issue_pdf = Installment_Client::find($id);
//      // Fetch related user data for each issue
//      $formattedNotes = $notesissue->map(function ($note) {
//         $createdByUser = User::find($note->created_by); // Fetch user by ID
//         return [
//             'id' => $note->id,
//             'created_by_name' => $createdByUser->name_ar ?? 'لا يوجد',
//             'number_issue' => $note->number_issue,
//             'status' => $note->status,
//             'working_company' => $note->working_company,
//             'opening_amount' => $note->opening_amount,
//             'closing_amount' => $note->closing_amount,
//             'date' => $note->date,
//             'image' => $note->image,
//         ];
//     });
//     // dd($issue_pdf);
//     // Calculate opening and closing amounts
//     $openissuecount = $notesissue->sum('opening_amount');
//     $closeissuecount = $notesissue->sum('closing_amount');
//     $totalissue = $openissuecount + $closeissuecount;
//     // $pdf = $issue_pdf->issue_pdf;

//         if ($notes) {

//             $user_id = Auth::user()->id ?? null;
//             $message = "تم عرض   ملاحظات المعاملات";
//             $this->log($user_id, $message);
//         }
//         return response()->json(['notes' => $notes]);
//     }



   public function getNotesIssue($id)
    {
        $notesissue = InstallmentIssue::where('installment_clients_id', $id)->with('user')->get();
        $issue_pdf = Installment_Client::find($id);
        // Fetch related user data for each issue
        $formattedNotes = $notesissue->map(function ($note) {
            $createdByUser = User::find($note->created_by); // Fetch user by ID
            return [
                'id' => $note->id,
                'created_by_name' => $createdByUser->name_ar ?? 'لا يوجد',
                'number_issue' => $note->number_issue,
                'status' => $note->status,
                'working_company' => $note->working_company,
                'opening_amount' => $note->opening_amount,
                'closing_amount' => $note->closing_amount,
                'date' => $note->date,
                'image' => $note->image,
            ];
        });
        // dd($issue_pdf);
        // Calculate opening and closing amounts
        $openissuecount = $notesissue->sum('opening_amount');
        $closeissuecount = $notesissue->sum('closing_amount');
        $totalissue = $openissuecount + $closeissuecount;
        $pdf = $issue_pdf->issue_pdf;

        if ($notesissue->isNotEmpty()) {
            $user_id = Auth::user()->id ?? null;
            $message = "تم عرض ملاحظات قضايا المعاملة";
            $this->log($user_id, $message);

        }
        return response()->json(['notesissue' => $formattedNotes,
            // 'pdf' => $pdf,
            'openissuecount' => $openissuecount,
            'closeissuecount' => $closeissuecount,
            'totalissue' => $totalissue]);
    }


    public function getNotesCar($id)
    {
        $notescar = InstallmentCar::where('installment_clients_id', $id)->with('user')->get();

        if ($notescar) {

            $user_id = Auth::user()->id ?? null;
            $message = "تم عرض   ملاحظات قضايا المعاملة";
            $this->log($user_id, $message);
        }
        return response()->json(['notescar' => $notescar]);
    }


    public function create()
     {
        $data['bank']= Bank::all();
        $data['government']= Governorate::all();
        $data['ministry'] = Ministry::where('type','working')->get();
        $data['boker']= InstallmentBroker::all();
        $data['region'] = Region::all();

        if($data)
        {

                $user_id =  Auth::user()->id ?? null;
                $message ="  تم دخول صفحة انشاء  معاملة جديدة"   ;
                $this->log($user_id ,$message);
        }
        return $this->respondSuccess($data, 'Get Data successfully.');

     }

     public function convert_approved($id)
     {
        $Installment_Client = Installment_Client::where('id',$id)->first();
        $Installment = Installment::where('installment_clients',$id)->first();
        $Installment_Client_cinet = Installment_Client_Cinet::where('installment_clients_id',$id)->get();
        $Installment_Client_car = InstallmentCar::where('installment_clients_id',$id)->get();
        $Installment_Client_issue = InstallmentIssue::where('installment_clients_id',$id)->get();
        $Installment_Client_note = InstallmentClientNote::where('installment_clients_id',$id)->get();



                $user_id =  Auth::user()->id ?? null;
                $message ="  تم دخول صفحة تقديم فى صفحة  المعاملات المقدمة"   ;
                $this->log($user_id ,$message);


        return view('installment.Aksat_approved',compact('Installment_Client','Installment','Installment_Client_note','Installment_Client_issue','Installment_Client_car','Installment_Client_cinet'));
     }

     public function convert_approvedCopy($id)
     {


        $title = 'نظام الاقساط';

        $breadcrumb = array();
        $breadcrumb[0]['title'] = " الرئيسية";
        $breadcrumb[0]['url'] = route("dashboard");
        $breadcrumb[1]['title'] = "المعاملات المقدمة";
        $breadcrumb[1]['url'] = route("myinstall.index" , ['status' => 'transaction_submited']);
        $breadcrumb[2]['title'] = $title;
        $breadcrumb[2]['url'] = 'javascript:void(0);';


        $Installment_Client = Installment_Client::where('id',$id)->first();
        $Installment = Installment::where('installment_clients',$id)->first();
        $ministry = Ministry::where('id', $Installment_Client->ministry_id)->first();
        $Installment_Client_cinet = Installment_Client_Cinet::where('installment_clients_id',$id)->get();
        $Installment_Client_car = InstallmentCar::where('installment_clients_id',$id)->get();
        $Installment_Client_issue = InstallmentIssue::where('installment_clients_id',$id)->get();
        $Installment_Client_note = InstallmentClientNote::where('installment_clients_id',$id)->get();


             $user_id =  Auth::user()->id ?? null;
            $message = " فى المعاملات المقدمة تم دخول صفحة فورم نظام الاقساط";
            $this->log($user_id, $message);

        $data = [
            'Installment' => '',
            'view' => 'installment/Aksat_approvedCopy'
        ];


        // $data['view'] = 'installment/convert_approvedCopy';
        return view('layout', $data, compact('breadcrumb','ministry','data','Installment_Client','Installment','Installment_Client_note','Installment_Client_issue','Installment_Client_car','Installment_Client_cinet'));
     }

     public function convert_approved_store(Request $request)
{
    // dd($request);
    // Validate the incoming request data
    // $request->validate([
    //     'installment_clients' => 'required|exists:installment_clients,id',
    //     'cost_install' => 'required|numeric',
    //     'part' => 'required|numeric',
    //     'final_installment_amount' => 'required|numeric',
    //     'count_months' => 'required',
    //     'count_months_without' => 'nullable',
    //     'total' => 'required|numeric',
    //     'monthly_amount' => 'required|numeric',
    //     'cinet_installment' => 'required|numeric',
    //     'intrenal_installment' => 'required|numeric',
    //     'start_date' => 'required',
    //     'eqrar_dain' => 'nullable|boolean',
    //     'cinet_enter' => 'nullable|boolean',
    //     'amana_paper' => 'nullable|boolean',
    // ]);
    // Convert checkbox values to boolean (0 or 1)
    $eqrar_dain = $request->has('eqrar_dain') ? 1 : 0;
    $cinet_enter = $request->has('cinet_enter') ? 1 : 0;
    $amana_paper = $request->has('amana_paper') ? 1 : 0;
    // Find the installment by the client ID
    $installment = Installment_Client::where('id', $request->installment_clients)->first();

    // If installment exists, update it; otherwise, create a new one
    if ($installment) {
        // Update the existing record
        $installment->update([
            'cost_install' => $request->cost_install,
            'part' => $request->part,
            'final_installment_amount' => $request->final_installment_amount,
            'count_months' => $request->count_months,
            'count_months_without' => $request->count_months_without,
            'status' => 'transaction_accepted',
            'total' => $request->total,
            'monthly_amount' => $request->monthly_amount,
            'cinet_installment' => $request->cinet_installment,
            'intrenal_installment' => $request->intrenal_installment,
            'start_date' => $request->start_date,
            'eqrar_dain' => $eqrar_dain,
            'cinet_enter' => $cinet_enter,
            'amana_paper' => $amana_paper,
        ]);
    } else {
        // Create a new record if no existing installment is found
        Installment_Client::create([
            'installment_clients' => $request->installment_clients,
            'cost_install' => $request->cost_install,
            'part' => $request->part,
            'final_installment_amount' => $request->final_installment_amount,
            'count_months' => $request->count_months,
            'count_months_without' => $request->count_months_without,
            'status' => 'transaction_accepted',
            'total' => $request->total,
            'monthly_amount' => $request->monthly_amount,
            'cinet_installment' => $request->cinet_installment,
            'intrenal_installment' => $request->intrenal_installment,
            'start_date' => $request->start_date,
            'eqrar_dain' => $eqrar_dain,
            'cinet_enter' => $cinet_enter,
            'amana_paper' => $amana_paper,
        ]);
    }
    // $user_id = 1 ;
      $user_id =  Auth::user()->id ?? null;
        $message = "تم تحويل المعاملة رقم {$installment->name_ar} الى المعاملات المقبولة" ;
        $this->log($user_id,$message);

        $this->installment_notes($installment->id ,$message);
    // Redirect or return a response
    return redirect()->route('myinstall.index', ['status' => "transaction_accepted"])->with('success', 'Installment details have been saved successfully.');
    }

     public function carInquiry($id)
     {
        $Installment_Client = Installment_Client::where('id',$id)->get();

                $user_id =  Auth::user()->id ?? null;
                $message ="تم عرض استعلام السيارات" ;
                $this->log($user_id,$message);

        return view('installmentClient.car',compact('Installment_Client'));

     }

     public function store(Request $request)
     {
        // dd($request);
         $messages = [
             'name_ar.required' => 'الاسم بالعربى  مطلوب.',
            //  'name_en.required' => 'الاسم بالانجليزية  مطلوب.',
             'governorate_id.required' => 'المحافظة   مطلوب.',
             'phone.required' => 'رقم الهاتف   مطلوب.',
             'civil_number.required' => 'رقم المدنى   مطلوب.',
             'civil_number.unique' => 'رقم المدنى   مسجل من قبل.',
             'civil_number.regex' => 'رقم المدنى مكون من 12 رقم.',
             'salary.required' => 'المرتب   مطلوب.',
             'bank_id.required' => 'البنك   مطلوب.',
             'area_id.required' => 'المنطقة   مطلوب.',
             'ministry_id.required' => 'جهه العمل   مطلوب.',
             'boker_id.required' => ' الوسيط  مطلوب.',
             'installment_total.required' => 'مجموع الاقساط  مطلوب.',
         ];

         $validatedData = Validator::make($request->all(), [
             'name_ar' => 'required',
            //  'name_en' => 'required',
             'governorate_id' =>'required',
             'phone' => 'required',
            //  'civil_number' => 'required',
             'civil_number' => [
                    'required',
                    'string',
                    'unique:installment_clients,civil_number',
                    'regex:/^\d{12}$/'
                ],
             'salary' => 'required',
             'bank_id' => 'required',
             'area_id' => 'required',
             'ministry_id' => 'required',
             'boker_id' => 'required',
             'installment_total' =>'required'

         ], $messages);


         if ($validatedData->fails()) {
            return redirect()->back()->withErrors($validatedData)->withInput();
         }
         $data = $this->InstallmentClientsRepository->store($request);
         if($data)
            {
                $user_id =  Auth::user()->id ?? null;
                $message ="تم اضافة عميل جديد  فى صفحة عملاء الاقساط" ;
                $this->log($user_id,$message);

                $this->installment_notes($data->id ,$message);
           }
         // return response()->json($nationalities);
        //  return $this->respondSuccess(result: $data, message: 'Store Data successfully.');
        return redirect()->back()->with('message', 'تم التقديم بنجاح');
     }




     /**
      * Display the specified resource.
      *
      * @param  \App\Models\InstallmentClients  $InstallmentClients
      * @return \Illuminate\Http\Response
      */
     public function show($id)
     {
         $data = $this->InstallmentClientsRepository->show($id);


         if($data)
         {
                 $user_id =  Auth::user()->id ?? null;
                 $message ="تم عرض  عميل  {$data->name_ar} من صفحة عملاء الاقساط" ;
                 $this->log($user_id,$message);
                 $this->installment_notes($data->id ,$message);


         }
         // return response()->json($data);
         return $this->respondSuccess($data, 'Get Data successfully.');

     }

     /**
      * Show the form for editing the specified resource.
      *
      * @param  \App\Models\InstallmentClients  $InstallmentClients
      * @return \Illuminate\Http\Response
      */
     public function edit($id)
     {


         $data = $this->InstallmentClientsRepository->show($id);


         if($data)
         {
                 $user_id =  Auth::user()->id ?? null;
                 $message ="تم الدخول  لتعديل  عملاء الاقساط  {$data->name_ar}";
                 $this->log($user_id,$message);
                 $this->installment_notes($data->id ,$message);
         }
         // return response()->json($data);
         return $this->respondSuccess($data, message: 'Get Data successfully.');

     }


     public function update($id , Request $request)
     {
        // dd($request);
         $messages = [
             'status.required' => 'نتيجة الاستعلام   مطلوب.',
         ];
         $validatedData = Validator::make($request->all(), [
             'status' =>'required'
         ], $messages);

         if ($validatedData->fails()) {

            return redirect()->back()->withErrors($validatedData)->withInput();
         }

         $data = $this->InstallmentClientsRepository->update($id ,$request);
         if($data)
         {
                $user_id =  Auth::user()->id ?? null;
                $status = $this->status_installment_clients($request->status);
                 $message ="تم  تحويل العميل  {$data->name_ar} الى {$status['status_ar']}";
                 $this->log( $user_id,$message);
                 $this->installment_notes($data->id ,$message);
         }
         // return response()->json($data);
        //  return $this->respondSuccess($data, 'Update Data successfully.');
        // return redirect()->back();

        //  return $this->respondSuccess($data, 'Get Data successfully.');
        return redirect()->route('installmentClient.index', ['status' => $data->status]);


     }

     public function update_myinstall($id , Request $request)
     {
        // dd($request);
         $messages = [
             'status.required' => 'نتيجة الاستعلام   مطلوب.',
         ];
         $validatedData = Validator::make($request->all(), [
             'status' =>'required'
         ], $messages);

         if ($validatedData->fails()) {

            return redirect()->back()->withErrors($validatedData)->withInput();
         }

         $data = $this->InstallmentClientsRepository->update($id ,$request);

         if($data)
         {
                $user_id =  Auth::user()->id ?? null;
                $status = $this->status_installment_clients($request->status);
                 $message ="تم  تحويل العميل  {$data->name_ar} الى {$status['status_ar']}";
                 $this->log( $user_id,$message);
                 $this->installment_notes($data->id ,$message);
         }


        return redirect()->route('myinstall.index', ['status' => $data->status]);

     }

     public function destroy($id)
     {
         //
         $data = $this->InstallmentClientsRepository->destroy($id);

        if($data)
         {
                 $user_id =  Auth::user()->id ?? null;
                 $message ="تم   مسح  عميل  {$data->name_ar}" ;
                 $this->log($user_id,$message);
         }
         // return response()->json($data);
         return $this->respondSuccess($data, message: 'Delete Data successfully.');
     }

    public function check_client(Request $request)
    {
        $messages = [
            'civil_number.required' => 'رقم المدنى   مطلوب.',
            'civil_number.regex' => 'رقم المدنى مكون من 12 رقم.',
        ];

        $validatedData = Validator::make($request->all(), [
        'civil_number' => [
                    'required',
                    'regex:/^\d{12}$/'
                ],
        ], $messages);

        if ($validatedData->fails()) {

            return redirect()->back()->withErrors($validatedData)->withInput();
        }

        $data = Client::where('civil_number',$request->civil_number)->first();

        if($data)
        {
            return $this->respondSuccess(result: $data, message: 'fetch Data successfully.');
        }

        return $this->respondError('Error.', 'failed to fetch Data', 400);
    }
    public function get_status (Request $request)
    {
        $messages = [
            'status.required' => 'نتيجة الاستعلام   مطلوب.',
        ];
        $validatedData = Validator::make($request->all(), [
            'status' =>'required'
        ], $messages);

        if ($validatedData->fails()) {

            return redirect()->back()->withErrors($validatedData)->withInput();
        }

        $data['data'] = Installment_Client::where('status',$request->status)->with('user','region','ministry_working','bank','installmentBroker','governorate','installment_issue','installment_car')->withCount('installment_car')->withCount('installment_issue')->get();
        $data['count'] = $data['data']->count();
        if($data)
        {
            return $this->respondSuccess(result: $data, message: 'fetch Data successfully.');
        }

        return $this->respondError('Error.', 'failed to fetch Data', 400);

    }

    public function checkCivilNumber(Request $request)
    {
        $exists = Installment_Client::where('civil_number', $request->civil_number)->exists();

        return response()->json(['exists' => $exists]);
    }

    public function checkCivilNumber_accept(Request $request)
    {
        $installmentClientId = $request->input('installment_clients');
        $civilNumber = $request->input('civil_number');

        // Check if a record exists with the given id and civil_number
        $exists = Installment_Client::where('id', $installmentClientId)
            ->where('civil_number', $civilNumber)
            ->exists();

        return response()->json(['exists' => $exists]);
    }

}
