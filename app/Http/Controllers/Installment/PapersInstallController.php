<?php

namespace App\Http\Controllers\Installment;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Models\Client;
use App\Models\Eqrars_details;
use App\Models\Installment;
use App\Models\User;
use App\Models\Paperstype;
use App\Repositories\Installment\PapersInstallRepository;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class PapersInstallController extends Controller
{
    protected $repository;

    public function __construct(PapersInstallRepository $repository)
    {
        $this->repository = $repository;
    }

    public function index(Request $request, $status)
    {
        $data = $this->repository->getIndexData($status);
        return view('layout', $data['data'], $data);
    }

    public function getAllData(Request $request)
    {
        $slug = $request->input('slug') ?? 'index';
        $query = $this->buildQuery($slug);

        return DataTables::of($query)
            ->addIndexColumn()
            ->addColumn('transaction_number', function ($detail) use ($slug) {

                    return $detail->id ? '<a href="' . url('installment/show-installment/' . $detail->id) . '">' . $detail->id . '</a>' : '-';


            })
            ->addColumn('client_name', function ($detail) use ($slug) {
                    $client = $detail->client;
                    return $client ? $client->name_ar . '<br/>' . $client->civil_number : '-';

            })
            ->addColumn('received_date', function ($detail) use ($slug) {
                if ($slug === 'received') {
                    return $detail->paper->date ?? '-';
                }else {
                    return $detail->date ?? '-';
                }


            })
            ->addColumn('created_by', function ($detail) use ($slug) {
                    return $detail->user->name_ar ?? '-';


            })
            ->addColumn('actions', function ($detail) use ($slug) {
                if ($slug === 'not_finished') {
                    return '<a href="' . route('installment.papers.addToInstallmentPapers', ['slug' => 'not_finished', 'id' => $detail->id]) . '" class="btn btn-primary">تسليم المعاملة</a>';
                    } else {
                    return '<a href="#" class="btn btn-primary">تعديل</a>';
                }
            })
            ->rawColumns(['transaction_number', 'client_name', 'actions'])
            ->filter(function ($query) use ($request) {
                if ($request->has('search') && $request->search['value']) {
                    $search = $request->search['value'];
                    $query->where(function ($q) use ($search) {
                        $q->whereHas('installment', function ($subQuery) use ($search) {
                            $subQuery->where('id', 'like', "%{$search}%")
                                ->orWhereHas('client', function ($clientQuery) use ($search) {
                                    $clientQuery->where('name_ar', 'like', "%{$search}%")
                                        ->orWhere('civil_number', 'like', "%{$search}%");
                                });
                        });
                    });
                }
            })
            ->toJson();
    }

    private function buildQuery($slug)
    {

        if ($slug == 'archive') {
            return Installment::with(['client', 'paper', 'eqrarsDetail'])
                ->whereHas('paper', function ($query) {
                    $query->where('slug', 'manage_review');
                })
                ->whereHas('eqrarsDetail', function ($query) {
                    $query->where('paper_received_checked', 1);
                    $query->where('paper_received', 1);
                })
                ->where('type', 'installment')
                ->where('tadqeeq', 1)
                ->where('manage_review', 1)
                ->where('tadqeeq_archive', 1)
                ->where('archive_finished', 0)
                ->where('status', 'finished')
                ->orderBy('installment.id', 'desc');
        } else if ($slug == 'eqrar_dain') {
            return Installment::with(['client', 'eqrarsDetail'])
                ->where('type', 'installment')
                ->where('status', 'finished')
                ->where('laws', 1)
                ->whereHas('eqrarsDetail', function ($query) {
                    $query->where('paper_eqrar_dain_received', 0);
                })
                ->orderBy('installment.id', 'desc');
        } else if ($slug == 'eqrar_dain_recieved') {
            return Installment::with(['client', 'eqrarsDetail','paper'])
                ->where('type', 'installment')
                ->where('status', 'finished')
                ->where('laws', 1)
                ->whereHas('eqrarsDetail', function ($query) {
                    $query->where('paper_eqrar_dain_received', 1);
                })
                ->orderBy('installment.id', 'desc');
        } else if ($slug == 'archive_finished') {
            return Installment::with(['client', 'paper', 'eqrarsDetail'])
                ->whereHas('paper', function ($query) {
                    $query->where('slug', 'manage_review');
                })
                ->whereHas('eqrarsDetail', function ($query) {
                    $query->where('paper_received_checked', 1);
                    $query->where('paper_received', 1);
                })
                ->where('type', 'installment')
                ->where('tadqeeq', 1)
                ->where('manage_review', 1)
                ->where('tadqeeq_archive', 1)
                ->where('archive_finished', 1)
                ->where('archive_received', 0)
                ->where('status', 'finished')
                ->orderBy('installment.id', 'desc');
        } else if ($slug == 'manage_review') {
            return Installment::with(['client', 'paper', 'eqrarsDetail'])
                ->whereHas('paper', function ($query) {
                    $query->where('slug', 'tadqeeq');
                })
                ->whereHas('eqrarsDetail', function ($query) {
                    $query->where('paper_received_checked', 1);
                })
                ->where('type', 'installment')
                ->where('tadqeeq', 1)
                ->where('manage_review', 1)
                ->where('tadqeeq_archive', 0)
                ->where('status', 'finished')
                ->orderBy('installment.id', 'desc');
        } else if ($slug == 'archive_received') {
            return Installment::with(['client', 'paper', 'eqrarsDetail'])
                ->whereHas('paper', function ($query) {
                    $query->where('slug', 'manage_review');
                })
                ->whereHas('eqrarsDetail', function ($query) {
                    $query->where('paper_received_checked', 1);
                    $query->where('paper_received', 1);
                    $query->where('paper_eqrar_dain_received', 0);
                })
                ->where('type', 'installment')
                ->where('tadqeeq', 1)
                ->where('manage_review', 1)
                ->where('tadqeeq_archive', 1)
                ->where('archive_finished', 1)
                ->where('archive_received', 1)
                ->where('archive_final', 0)
                ->orderBy('installment.id', 'desc');
        }
        else if ($slug == 'received') {
            return Installment::with(['client', 'paper', 'eqrarsDetail'])
            ->where('type', 'installment')
            ->where('status', 'finished')
                ->whereHas('paper', function ($query) {
                    $query->where('slug', 'not_finished');
                })
                ->whereHas('eqrarsDetail', function ($query) {
                    $query->where('paper_received_checked', 0);
                    $query->where('paper_received', 1);
                })

                ->orderBy('installment.id', 'desc');
        }

        else if ($slug == 'tadqeeq') {
            return Installment::with(['client', 'paper', 'eqrarsDetail'])
                ->whereHas('paper', function ($query) {
                    $query->where('slug', 'my_index');
                })
                ->whereHas('eqrarsDetail', function ($query) {
                    $query->where('paper_received_checked', 1);
                })
                ->where('type', 'installment')
                ->where('tadqeeq', 1)
                ->where('manage_review', 0)
                ->where('status', 'finished')
                ->orderBy('installment.id', 'desc');
        }
        else if ($slug == 'not_finished') {
            return Installment::with(['client', 'eqrarsDetail'])
            ->where('type', 'installment')
            ->where('status', 'finished')

                ->whereHas('eqrarsDetail', function ($query) {
                    $query->where('paper_received', 0);
                })

                ->orderBy('installment.id', 'desc');
        }

    }

    public function addToInstallmentPapers(Request $request, $slug, $id)
    {
        if ($request->isMethod('post')) {
            $data = $request->all();


            if ($request->hasFile('cinet_img')) {
                $fileName = time() . '_' . $request->file('cinet_img')->getClientOriginalName();
                $filePath = 'papers/' . $fileName;
                $request->file('cinet_img')->move(public_path('papers'), $fileName);
                $data['cinet_img']  = $filePath;
            }

            $result = $this->repository->addToInstallmentPapers($slug, $id, $data);
            $papers_type_id = PapersType::where('slug', $slug)->first()->id;
            $nextPapersType = PapersType::where('id', '>', $papers_type_id)->orderBy('id')->first();
            $next_papers_type_slug = $nextPapersType ? $nextPapersType->slug : null;

            if ($result) {
                return redirect()->route("installment.papers.status", $next_papers_type_slug)->with('success', 'تمت العملية بنجاح.');

            }

            return redirect()->back()->with('error', 'حدث خطأ ما، يرجى المحاولة مرة أخرى.');
        }

        $installment = Installment::with('client')->findOrFail($id);
        $admins = User::where(['active' => '1', 'deleted_at' => null, 'type' => 'emp'])->get();



        $title = 'إضافة صورة الاعتماد';

        $breadcrumb = array();
        $breadcrumb[0]['title'] = " الرئيسية";
        $breadcrumb[0]['url'] = route("dashboard");
        $breadcrumb[1]['title'] = " المحفوظات";
        $breadcrumb[1]['url'] = route("installment.papers.status", 'index');
        $breadcrumb[2]['title'] = $title;
        $breadcrumb[2]['url'] = 'javascript:void(0);';
        $view = 'installment.papers.add_to_installment_papers';

        return view(
            'layout', compact('breadcrumb', 'title', 'installment', 'admins', 'slug','view')
        );

    }

    public function recieveInstallPaper($id)
    {
        $installment = Installment::with('client')->findOrFail($id);// dd($installment);
        $client = $installment->client;
        $bank = $client->client_banks->last();
        $ministry = $client->get_ministry;
        $bankName = $bank->name_ar ?? 'لا يوجد';
        $ministryName = $ministry->name_ar ?? 'لا يوجد';

        $title = 'نموذج الاستلام' ;
        $addTitle = 'نموذج الاستلام' ;

        $breadcrumb = array();
        $breadcrumb[0]['title'] = " الرئيسية";
        $breadcrumb[0]['url'] = route("dashboard");
        $breadcrumb[1]['title'] = $title;
        $breadcrumb[1]['url'] = 'javascript:void(0);';
        $view = 'installment.papers.recieve_install_paper';

        return view('installment.papers.recieve_install_paper', compact('breadcrumb', 'title', 'addTitle', 'installment', 'client', 'bankName', 'ministryName', 'view'));
    }

 // Fetch records from installment_papers_old with matching installment_id
    public function updateInstallmentPapersDates()
    {

        $records = DB::table('installment_papers_old')
            ->join('installment_papers', 'installment_papers_old.installment_id', '=', 'installment_papers.installment_id')
            ->select('installment_papers_old.date', 'installment_papers.installment_id')
            ->get();

        // Update each matching record
        foreach ($records as $record) {
            $formattedDate = date('Y-m-d', $record->date);

            DB::table('installment_papers')
                ->where('installment_id', $record->installment_id)
                ->update(['date' => $formattedDate]);
        }

        echo "Installment papers dates updated successfully.";
    }



}