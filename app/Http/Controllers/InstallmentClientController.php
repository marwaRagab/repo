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
        $title = 'المعاملات';

        $breadcrumb = array();
        $breadcrumb[0]['title'] = " الرئيسية";
        $breadcrumb[0]['url'] = route("dashboard");
        $breadcrumb[1]['title'] = "المعاملات";
        $breadcrumb[1]['url'] = route("myinstall.index", ['status' => 'advanced']);
        $breadcrumb[2]['title'] = $title;
        $breadcrumb[2]['url'] = 'javascript:void(0);';


        $data = $this->InstallmentClientsRepository->index($status);
        //  dd($data);

        if ($data) {
            //  $user_id = 1 ;
            $user_id =  Auth::user()->id ?? null;
            $message = "تم دخول صفحة المتقدمين";
            $this->log($user_id, $message);
        }

        if ($status == "transaction_submited") {
            $data['view'] = 'installmentClient/submitCopy';
        } elseif ($status == "submit_archive") {
            $data['view'] = 'installmentClient/submitCopy';
            // return view('installmentClient.transaction_accepted',compact('data'));
        } elseif ($status == "transaction_accepted") {
            $data['view'] = 'installmentClient/transaction_acceptedCopy';
            // return view('installmentClient.transaction_accepted',compact('data'));
        } elseif ($status == "accepted_archive") {
            $data['view'] = 'installmentClient/transaction_acceptedCopy';
            // return view('installmentClient.transaction_accepted',compact('data'));
        } elseif ($status == "refused") {
            // transaction_refusedCopy
            $data['view'] = 'installmentClient/transaction_refusedCopy';
            // return view('installmentClient.transaction_refused',compact('data'));
        } elseif (($status == "submit_archive") || ($status == "accepted_archive")) {
            // transaction_refusedCopy
            $data['view'] = 'installmentClient/archive';
            // return view('installmentClient.transaction_refused',compact('data'));
        } else {
            $data['view'] = 'installmentClient/index';
            // dd($data);
           
        }
        return view('layout', $data, compact('breadcrumb', 'data'));
    }

    public function install($id)
    {
        // dd($status);
        //


        $user_id =  Auth::user()->id ?? null;
        $message = "تم دخول صفحة المتقدمين";
        $this->log($user_id, $message);

        $bank = Bank::all();
        $government = Governorate::all();
        $region = Region::all();
        $ministry = Ministry::where('type', 'working')->get();
        $boker = Boker::all();
        $data = Boker::where('id', $id)->first();
        return view('installmentClient.installByBroker', compact('data', 'bank', 'government', 'region', 'ministry', 'boker'));
    }
    public function myinstall($status)
    {
        //    dd($status);
        //
        $title = 'المعاملات';

        $breadcrumb = array();
        $breadcrumb[0]['title'] = " الرئيسية";
        $breadcrumb[0]['url'] = route("dashboard");
        $breadcrumb[1]['title'] = "المعاملات";
        $breadcrumb[1]['url'] = route("myinstall.index", ['status' => 'advanced']);
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

        if ($status == 0) {
            $data['Installment'] = Installment_Client::with([
                'bank',
                'installmentBroker',
            ])->withCount(['installment_car', 'installment_issue'])->get();
        } elseif ($status == "refused") {
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

            $data['view'] = 'installmentClient/submitCopy';
        } elseif ($status == "submit_archive") {
            $data['view'] = 'installmentClient/submitCopy';
            // return view('installmentClient.transaction_accepted',compact('data'));
        } elseif ($status == "transaction_accepted") {
            $data['view'] = 'installmentClient/transaction_acceptedCopy';
            // return view('installmentClient.transaction_accepted',compact('data'));
        } elseif ($status == "accepted_archive") {
            $data['view'] = 'installmentClient/transaction_acceptedCopy';
            // return view('installmentClient.transaction_accepted',compact('data'));
        } elseif ($status == "refused") {
            // transaction_refusedCopy
            $data['view'] = 'installmentClient/transaction_refusedCopy';
            // return view('installmentClient.transaction_refused',compact('data'));
        } elseif (($status == "submit_archive") || ($status == "accepted_archive")) {
            // transaction_refusedCopy
            $data['view'] = 'installmentClient/archive';
            // return view('installmentClient.transaction_refused',compact('data'));
        } else {
            $data['view'] = 'installmentClient/indexCopy';


            // return view('installmentClient.index',compact('data','bank','government','region','ministry','boker'));
        }
        return view('layout', $data, compact('breadcrumb', 'data'));
    }

    public function search(Request $request)
    {
        $title = 'البحث';

        $breadcrumb = array();
        $breadcrumb[0]['title'] = " الرئيسية";
        $breadcrumb[0]['url'] = route("dashboard");
        $breadcrumb[1]['title'] = "المعاملات";
        $breadcrumb[1]['url'] = route("myinstall.index", ['status' => 'advanced']);
        $breadcrumb[2]['title'] = $title;
        $breadcrumb[2]['url'] = 'javascript:void(0);';

        $data['bank'] = Bank::all();
        $data['government'] = Governorate::all();
        $data['region'] = Region::all();
        $data['ministry'] = Ministry::where('type', 'working')->get();
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
        $data['view'] = 'installmentClient/search';
        return view('layout', $data, compact('breadcrumb', 'data', 'searchPerformed'));
    }



    public function getAll($status)
    {
        $data = $this->InstallmentClientsRepository->index($status);
        $dataTable = DataTables::of($data['Installment']);

        // Add 'client' column
        $dataTable->addColumn('client', function ($row) {
            return $row->name_ar . '<br>' . $row->civil_number;
        });


        // Add 'ministry' column
        $dataTable->addColumn('ministry', function ($row) {
            switch ($row->ministry_id) {
                case 'ministry_employe':
                    return 'موظف وزارة';
                case 'help_socity':
                    return 'مساعدة اجتماعية';
                case 'work_finish':
                    return 'متقاعد';
                case 'military':
                    return 'عسكري';
                case 'arm_student_help':
                    return 'إعانة طالب عسكري';
                case 'student_help':
                    return 'إعانة طالب دراسة';
                case 'worker_help':
                    return 'دعم عمالة';
                case 'special_needs_help':
                    return 'ذوي الإحتياجات الخاصة';
                case 'dead_help':
                    return 'راتب مرحوم';
                case 'special_needs_care_help':
                    return 'رعاية ذوي الإحتياجات الخاصة';
                default:
                    $ministry = Ministry::find($row->ministry_id);
                    return $ministry ? $ministry->name_ar : 'لايوجد';
            }
        });

        // Add 'car' column conditionally
        if ($status == "car_inquiry") {
            $dataTable->addColumn('car', function ($row) {
                $route = route('advanced.car', $row->id);
                $count = $row->installment_car_count;
                $carButton = '<a class="btn me-1 mb-1 bg-primary-subtle text-primary px-4 fs-4" href="' . $route . '">
                            استعلام سيارات (' . $count . ')
                        </a>';

                // Check if there are cars related to the row
                if ($row->installment_car->isNotEmpty() || $row->installment_car->count() > 0) {
                    // Check if the first car record has an image
                    if ($row->installment_car->first()->image != null) {
                        $carImageButton = '<a class="btn me-1 mb-1 bg-primary-subtle text-primary px-4 fs-4" 
                                       href="' . asset($row->installment_car->first()->image) . '" 
                                       download="car.jpg">
                                       صوره الاستعلام
                                       </a>';
                    } else {
                        $carImageButton = 'لا يوجد صورة';
                    }
                } else {
                    $carImageButton = 'لا يوجد صورة';
                }

                // Return both buttons (car inquiry button and image download button)
                return $carButton . ' </br>' . $carImageButton;
            });
        }

        if ($status == "auditing" || $status == "under_inquiry") {
            $dataTable->addColumn('issue', function ($row) {
                $route = route('advanced.issue', $row->id);
                $count = $row->installment_issue_count;
                $carButton = '<a class="btn me-1 mb-1 bg-primary-subtle text-primary px-4 fs-4" href="' . $route . '">
                            استعلام قضائى (' . $count . ')
                        </a>';

                // Check if there are cars related to the row
                if ($row->installment_issue->isNotEmpty() || $row->installment_issue->count() > 0) {
                    // Check if the first car record has an image
                    if ($row->installment_issue->first()->image != null) {
                        $carImageButton = '<a class="btn me-1 mb-1 bg-primary-subtle text-primary px-4 fs-4 "
                                                    href="' . asset($row->issue_pdf) . '" download="issue.pdf">
                                                    صوره الاستعلام </a>';
                    } else {
                        $carImageButton = 'لا يوجد صورة';
                    }
                } else {
                    $carImageButton = 'لا يوجد صورة';
                }

                // Return both buttons (car inquiry button and image download button)
                return $carButton . ' </br>' . $carImageButton;
            });
        }

        // Add 'inquery_result' column
        $dataTable->addColumn('inquery', function ($row) {
            $updateRoute = route('myinstall.update', $row->id);
            $acceptCondationRoute = route('advanced.acceptCondation', $row->id);
            $acceptRoute = route('advanced.accept', $row->id);
            $rejectRoute = route('advanced.reject', $row->id);

            return '
        <div class="btn-group mb-6 me-6 d-block">
            <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-expanded="false">
                نتيجة الاستعلام 
            </button>
            <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                <li>
                    <form action="' . $updateRoute . '" method="post" style="display:inline;">
                        ' . csrf_field() . '
                        <input type="hidden" name="status" value="advanced">
                        <button class="btn btn-success rounded-0 w-100 mt-2" type="submit">المتقدمين</button>
                    </form>
                </li>
                <li>
                    <form action="' . $updateRoute . '" method="post" style="display:inline;">
                        ' . csrf_field() . '
                        <input type="hidden" name="status" value="under_inquiry">
                        <button class="btn btn-success rounded-0 w-100 mt-2" type="submit">قيد الاستعلام</button>
                    </form>
                </li>
                <li>
                    <form action="' . $updateRoute . '" method="post" style="display:inline;">
                        ' . csrf_field() . '
                        <input type="hidden" name="status" value="auditing">
                        <button class="btn btn-success rounded-0 w-100 mt-2" type="submit">التدقيق القضائي</button>
                    </form>
                </li>
                <li>
                    <form action="' . $updateRoute . '" method="post" style="display:inline;">
                        ' . csrf_field() . '
                        <input type="hidden" name="status" value="car_inquiry">
                        <button class="btn btn-success rounded-0 w-100 mt-2" type="submit">استعلام سيارات</button>
                    </form>
                </li>
                <li>
                    <form action="' . $updateRoute . '" method="post" style="display:inline;">
                        ' . csrf_field() . '
                        <input type="hidden" name="status" value="inquiry_done">
                        <button class="btn btn-success rounded-0 w-100 mt-2" type="submit">تم الاستعلام</button>
                    </form>
                </li>
                <li>
                    <a class="btn btn-info rounded-0 w-100 mt-2" href="' . $acceptCondationRoute . '">مقبول بشرط</a>
                </li>
                <li>
                    <a class="btn btn-info rounded-0 w-100 mt-2" href="' . $acceptRoute . '">مقبول</a>
                </li>
                <li>
                    <a class="btn btn-warning rounded-0 w-100 mt-2" href="' . $rejectRoute . '">مرفوض</a>
                </li>
            </ul>
        </div>
        <div>
            ' . ($row->status == 'archive' ? '
                <form action="' . $updateRoute . '" method="post" style="display:inline;">
                    ' . csrf_field() . '
                    <input type="hidden" name="status" value="advanced">
                    <button class="btn btn-danger">الغاء الارشفة</button>
                </form>
            ' : '
                <form action="' . $updateRoute . '" method="post" style="display:inline;">
                    ' . csrf_field() . '
                    <input type="hidden" name="status" value="archive">
                    <button class="btn btn-success rounded-0 w-100 mt-2" type="submit">تحويل للارشيف</button>
                </form>
            ') . '
        </div>
        ';
        });



        // Add 'boker' column
        $dataTable->addColumn('boker', function ($row) {
            return $row->installmentBroker ? $row->installmentBroker->name : 'لا يوجد';
        });

        $dataTable->addColumn('bank', function ($row) {
            return $row->bank ? $row->bank->name_ar : 'لا يوجد';
        });



        $dataTable->addColumn('created_at', function ($row) {
            $formattedDate = \Carbon\Carbon::parse($row->created_at)->format('d/m/Y');
            $notesRoute = route('advanced.notes', $row->id);

            return '
        <div class="block">
            <h5>' . $formattedDate . '</h5>
            <a class="btn btn-secondary w-100 mt-2" href="' . $notesRoute . '">الملاحظات</a>
        </div>';
        });

        if ($status == "accepted") {
            $dataTable->addColumn('accept', function ($row) {
                $acceptCost = $row->accept_cost;
                $submissionRoute = route('installmentsubmission.index', $row->id);

                return '
            <div class="block">
                <h5>' . $acceptCost . '</h5>
                <a class="btn btn-secondary w-100 mt-2" href="' . e($submissionRoute) . '">تقديم الاقساط</a>
            </div>';
            });
        }
        if ($status == "rejected") {
            $dataTable->addColumn('rejected', function ($row) {
                return $row->reason;
            });
        }



        return $dataTable->rawColumns(['car', 'issue', 'inquery', 'created_at', 'client', 'accept'])->make(true);
    }


    public function getNotes($id)

    {
        $notes = InstallmentClientNote::where('installment_clients_id', $id)->with('user')->get();

        if ($notes) {

            $user_id =  Auth::user()->id ?? null;
            $message = "تم عرض   ملاحظات المعاملات";
            $this->log($user_id, $message);
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
        return response()->json([
            'notesissue' => $formattedNotes,
            // 'pdf' => $pdf,
            'openissuecount' => $openissuecount,
            'closeissuecount' => $closeissuecount,
            'totalissue' => $totalissue
        ]);
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
        $data['bank'] = Bank::all();
        $data['government'] = Governorate::all();
        $data['ministry'] = Ministry::where('type', 'working')->get();
        $data['boker'] = InstallmentBroker::all();
        $data['region'] = Region::all();

        if ($data) {

            $user_id =  Auth::user()->id ?? null;
            $message = "  تم دخول صفحة انشاء  معاملة جديدة";
            $this->log($user_id, $message);
        }
        return $this->respondSuccess($data, 'Get Data successfully.');
    }

    public function convert_approved($id)
    {
        $Installment_Client = Installment_Client::where('id', $id)->first();
        $Installment = Installment::where('installment_clients', $id)->first();
        $Installment_Client_cinet = Installment_Client_Cinet::where('installment_clients_id', $id)->get();
        $Installment_Client_car = InstallmentCar::where('installment_clients_id', $id)->get();
        $Installment_Client_issue = InstallmentIssue::where('installment_clients_id', $id)->get();
        $Installment_Client_note = InstallmentClientNote::where('installment_clients_id', $id)->get();



        $user_id =  Auth::user()->id ?? null;
        $message = "  تم دخول صفحة تقديم فى صفحة  المعاملات المقدمة";
        $this->log($user_id, $message);


        return view('installment.Aksat_approved', compact('Installment_Client', 'Installment', 'Installment_Client_note', 'Installment_Client_issue', 'Installment_Client_car', 'Installment_Client_cinet'));
    }

    public function convert_approvedCopy($id)
    {


        $title = 'نظام الاقساط';

        $breadcrumb = array();
        $breadcrumb[0]['title'] = " الرئيسية";
        $breadcrumb[0]['url'] = route("dashboard");
        $breadcrumb[1]['title'] = "المعاملات المقدمة";
        $breadcrumb[1]['url'] = route("myinstall.index", ['status' => 'transaction_submited']);
        $breadcrumb[2]['title'] = $title;
        $breadcrumb[2]['url'] = 'javascript:void(0);';


        $Installment_Client = Installment_Client::where('id', $id)->first();
        $Installment = Installment::where('installment_clients', $id)->first();
        $ministry = Ministry::where('id', $Installment_Client->ministry_id)->first();
        $Installment_Client_cinet = Installment_Client_Cinet::where('installment_clients_id', $id)->get();
        $Installment_Client_car = InstallmentCar::where('installment_clients_id', $id)->get();
        $Installment_Client_issue = InstallmentIssue::where('installment_clients_id', $id)->get();
        $Installment_Client_note = InstallmentClientNote::where('installment_clients_id', $id)->get();


        $user_id =  Auth::user()->id ?? null;
        $message = " فى المعاملات المقدمة تم دخول صفحة فورم نظام الاقساط";
        $this->log($user_id, $message);

        $data = [
            'Installment' => '',
            'view' => 'installment/Aksat_approvedCopy'
        ];


        // $data['view'] = 'installment/convert_approvedCopy';
        return view('layout', $data, compact('breadcrumb', 'ministry', 'data', 'Installment_Client', 'Installment', 'Installment_Client_note', 'Installment_Client_issue', 'Installment_Client_car', 'Installment_Client_cinet'));
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
        $message = "تم تحويل المعاملة رقم {$installment->name_ar} الى المعاملات المقبولة";
        $this->log($user_id, $message);

        $this->installment_notes($installment->id, $message);
        // Redirect or return a response
        return redirect()->route('myinstall.index', ['status' => "transaction_accepted"])->with('success', 'Installment details have been saved successfully.');
    }

    public function carInquiry($id)
    {
        $Installment_Client = Installment_Client::where('id', $id)->get();

        $user_id =  Auth::user()->id ?? null;
        $message = "تم عرض استعلام السيارات";
        $this->log($user_id, $message);

        return view('installmentClient.car', compact('Installment_Client'));
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
            'governorate_id' => 'required',
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
            'installment_total' => 'required'

        ], $messages);


        if ($validatedData->fails()) {
            return redirect()->back()->withErrors($validatedData)->withInput();
        }
        $data = $this->InstallmentClientsRepository->store($request);
        if ($data) {
            $user_id =  Auth::user()->id ?? null;
            $message = "تم اضافة عميل جديد  فى صفحة عملاء الاقساط";
            $this->log($user_id, $message);

            $this->installment_notes($data->id, $message);
        }
        // return response()->json($nationalities);
        //  return $this->respondSuccess(result: $data, message: 'Store Data successfully.');
        // return redirect()->back()->with('message', 'تم التقديم بنجاح');
        // return redirect()->route('installmentClient.index', ['advanced']);
        return redirect()->route('installmentClient.index', ['status' => 'advanced']);
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


        if ($data) {
            $user_id =  Auth::user()->id ?? null;
            $message = "تم عرض  عميل  {$data->name_ar} من صفحة عملاء الاقساط";
            $this->log($user_id, $message);
            $this->installment_notes($data->id, $message);
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


        if ($data) {
            $user_id =  Auth::user()->id ?? null;
            $message = "تم الدخول  لتعديل  عملاء الاقساط  {$data->name_ar}";
            $this->log($user_id, $message);
            $this->installment_notes($data->id, $message);
        }
        // return response()->json($data);
        return $this->respondSuccess($data, message: 'Get Data successfully.');
    }


    public function update($id, Request $request)
    {
        // dd($request);
        $messages = [
            'status.required' => 'نتيجة الاستعلام   مطلوب.',
        ];
        $validatedData = Validator::make($request->all(), [
            'status' => 'required'
        ], $messages);

        if ($validatedData->fails()) {

            return redirect()->back()->withErrors($validatedData)->withInput();
        }

        $data = $this->InstallmentClientsRepository->update($id, $request);
        if ($data) {
            $user_id =  Auth::user()->id ?? null;
            $status = $this->status_installment_clients($request->status);
            $message = "تم  تحويل العميل  {$data->name_ar} الى {$status['status_ar']}";
            $this->log($user_id, $message);
            $this->installment_notes($data->id, $message);
        }
        // return response()->json($data);
        //  return $this->respondSuccess($data, 'Update Data successfully.');
        // return redirect()->back();

        //  return $this->respondSuccess($data, 'Get Data successfully.');
        return redirect()->route('installmentClient.index', ['status' => $data->status]);
    }

    public function update_myinstall($id, Request $request)
    {
        // dd($request);
        $messages = [
            'status.required' => 'نتيجة الاستعلام   مطلوب.',
        ];
        $validatedData = Validator::make($request->all(), [
            'status' => 'required'
        ], $messages);

        if ($validatedData->fails()) {

            return redirect()->back()->withErrors($validatedData)->withInput();
        }

        $data = $this->InstallmentClientsRepository->update($id, $request);

        if ($data) {
            $user_id =  Auth::user()->id ?? null;
            $status = $this->status_installment_clients($request->status);
            $message = "تم  تحويل العميل  {$data->name_ar} الى {$status['status_ar']}";
            $this->log($user_id, $message);
            $this->installment_notes($data->id, $message);
        }


        // return redirect()->route('myinstall.index', ['status' => $data->status]);
        return redirect()->route('installmentClient.index', ['status' => $data->status]);
    }

    public function destroy($id)
    {
        //
        $data = $this->InstallmentClientsRepository->destroy($id);

        if ($data) {
            $user_id =  Auth::user()->id ?? null;
            $message = "تم   مسح  عميل  {$data->name_ar}";
            $this->log($user_id, $message);
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

        $data = Client::where('civil_number', $request->civil_number)->first();

        if ($data) {
            return $this->respondSuccess(result: $data, message: 'fetch Data successfully.');
        }

        return $this->respondError('Error.', 'failed to fetch Data', 400);
    }
    public function get_status(Request $request)
    {
        $messages = [
            'status.required' => 'نتيجة الاستعلام   مطلوب.',
        ];
        $validatedData = Validator::make($request->all(), [
            'status' => 'required'
        ], $messages);

        if ($validatedData->fails()) {

            return redirect()->back()->withErrors($validatedData)->withInput();
        }

        $data['data'] = Installment_Client::where('status', $request->status)->with('user', 'region', 'ministry_working', 'bank', 'installmentBroker', 'governorate', 'installment_issue', 'installment_car')->withCount('installment_car')->withCount('installment_issue')->get();
        $data['count'] = $data['data']->count();
        if ($data) {
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