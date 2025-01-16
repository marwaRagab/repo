<?php

namespace App\Http\Controllers\Installment;

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
    public function getAllData(Request $request, $slug = null)
    {
        $slug = $request->get('slug', $slug) ?? 'index';

        $query = Eqrars_details::with(['installment.client'])
            ->when($slug === 'not_finished', function ($q) {
                $q->where('paper_received_checked', 0);
            })
            ->when($slug === 'received', function ($q) {
                $q->where('paper_received_checked', 1);
            })
            ->when($slug === 'tadqeeq', function ($q) {
                $q->whereHas('installment', function ($subQuery) {
                    $subQuery->where('slug', 'tadqeeq')->where('tadqeeq', 1);
                });
            })
            ->when($slug === 'manage_review', function ($q) {
                $q->whereHas('installment', function ($subQuery) {
                    $subQuery->where('slug', 'manage_review')->where('manage_review', 1);
                });
            })
            ->when($slug === 'archive', function ($q) {
                $q->whereHas('installment', function ($subQuery) {
                    $subQuery->where('slug', 'archive');
                });
            })
            ->when($slug === 'archive_finished', function ($q) {
                $q->whereHas('installment', function ($subQuery) {
                    $subQuery->where('slug', 'archive_finished');
                });
            })
            ->orderBy('eqrars_details.id', 'desc'); // Correct the column name

        return DataTables::of($query)
            ->addIndexColumn()
            ->addColumn('transaction_number', function ($detail) {
                return '<a href="' . url('installment/show-installment/' . $detail->installment->id) . '">' . $detail->installment->id . '</a>';
            })
            ->addColumn('client_name', function ($detail) {
                $client = $detail->installment->client;
                return $client ? $client->name_ar . '<br/>' . $client->civil_number : '-';
            })
            ->addColumn('received_date', function ($detail) {
                return $detail->installment->date ?? '-';
            })
            ->addColumn('created_by', function ($detail) {
                return $detail->installment->user->name_ar ?? '-';
            })
            ->addColumn('actions', function ($detail) use ($slug) {
                if ($slug === 'index') {
                    return '<a href="' . route('installment.papers.addToInstallmentPapers', ['slug' => 'not_finished', 'id' => $detail->id]) . '" class="btn btn-primary">تسليم المعاملة</a>';
                } elseif ($slug === 'archive') {
                    return '<a href="#" class="btn btn-warning">أرشفة</a>';
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





}
