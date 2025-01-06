<?php

namespace App\Repositories\Payments;

use DateTime;
use Carbon\Carbon;
use App\Models\Log;
use App\Models\Bank;
use Inertia\Inertia;
use App\Models\Court;
use App\Models\Client;
use App\Models\Ministry;
use App\Models\Governorate;
use App\Models\Installment;
use Illuminate\Http\Request;
use App\Models\InstallmentNote;
use Yajra\DataTables\DataTables;
use App\Models\Installment_month;
use App\Models\Installment_Client;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use App\Models\InstallmentClientNote;
use Illuminate\Support\Facades\Validator;
use App\Models\Military_affairs\Military_affair;
use App\Models\Military_affairs\Stop_travel_types;
use App\Models\Military_affairs\Military_affairs_check;
use App\Models\Military_affairs\Military_affairs_notes;
use App\Interfaces\Payments\PaymentsRepositoryInterface;
use App\Models\InvoicesInstallment\Invoices_installment;
use App\Models\Military_affairs\Military_affairs_amount;
use App\Models\Military_affairs\Military_affairs_status;
use App\Models\Military_affairs\Military_affairs_jalasaat;
use App\Models\Military_affairs\Military_affairs_times_type;
use App\Interfaces\Military_affairs\CheckingRepositoryInterface;
use App\Interfaces\Military_affairs\Open_fileRepositoryInterface;
use App\Models\Military_affairs\Military_affairs_certificate_type;
use App\Interfaces\Military_affairs\Stop_travelRepositoryInterface;

class PaymentsRepository implements PaymentsRepositoryInterface
{
    protected $data;


    public function __construct()
    {
        //


        $this->data['governorates'] = Governorate::with('clients')->get();
        $this->data['courts'] = Court::with('government')->get();
        $this->data['stop_travel_types'] = Stop_travel_types::all();
        $this->data['dates'] = array();

        array_push($this->data['dates'], date('Y-m'));
        for ($i = 1; $i <= 24; $i++) {

            array_push($this->data['dates'], Carbon::now()->subMonth($i)->format('Y-m'));

        }


    }

    public function index(Request $request)
    {

        $title = '  عمليات الدفع ';
        // $pay_date = $request->month;
        // $this->data['items'] = Invoices_installment::where('arch', 0)->when($pay_date, function ($q) use ($pay_date) {
        //     $date = new DateTime($pay_date);
        //     $year = $date->format('Y');
        //     $month = $date->format('m');
        //     return $q->whereyear('date', $year)->wheremonth('date', $month);
        // })->where('branch_id', Auth::user()->branch_id)
        //     ->with('installment', function ($query) {
        //         return $query->where('installment.laws', '=', 0);
        //     })->with('install_month')->get();
        // foreach ($this->data['items'] as $item) {
        //     if ($item->payment_type == 'cash') {
        //         $item->pay_method = 'كاش';
        //     } elseif ($item->payment_type == 'part') {
        //         $item->pay_method = 'روابط';
        //     } elseif ($item->payment_type == 'check') {
        //         $item->pay_method = 'شيك';
        //     } else {
        //         $item->pay_method = 'كى نت';
        //     }
        // }
        $breadcrumb = array();
        $breadcrumb[0]['title'] = " الرئيسية";
        $breadcrumb[0]['url'] = route("dashboard");
        $breadcrumb[1]['title'] = " عمليات الدفع";
        $breadcrumb[1]['url'] = route("payments");


        $this->data['view'] = 'Payments/index';
        return view('layout', $this->data, compact('breadcrumb'));

    }

    public function getPaymentsData(Request $request)
    {
        // Retrieve the selected month from the request
        $pay_date = $request->month;
    
        // Query the database with necessary filters and relationships
        $payments = Invoices_installment::where('arch', 0)
            ->when($pay_date, function ($query) use ($pay_date) {
                $date = new DateTime($pay_date);
                $year = $date->format('Y');
                $month = $date->format('m');
                return $query->whereYear('date', $year)->whereMonth('date', $month);
            })
            ->where('branch_id', Auth::user()->branch_id)
            ->with([
                'installment' => function ($query) {
                    $query->where('laws', 0);
                },
                'install_month',
            ])
            ->select([
                'id', 'payment_type', 'date', 'branch_id', 
                'installment_id', 'install_month_id', 
                'description', 'amount', 'print_status'
            ]);
    
        // Process data for DataTables
        return DataTables::of($payments)
            ->addColumn('pay_method', function ($payment) {
                return match ($payment->payment_type) {
                    'cash' => 'كاش',
                    'part' => 'روابط',
                    'check' => 'شيك',
                    default => 'كى نت',
                };
            })
            ->addColumn('installment_name', function ($payment) {
                return $payment->installment && $payment->installment->client
                    ? $payment->installment->client->name_ar
                    : 'لايوجد';
            })
            ->addColumn('serial_no', function ($payment) {
                $current_month_year = now()->format('Ym');
                $total_items = Invoices_installment::count();
                return $current_month_year . ($total_items - $payment->id); // Example calculation
            })
            ->addColumn('print_status_label', function ($payment) {
                return $payment->print_status == 'done' 
                    ? '<span class="text-success">تم الطباعة</span>' 
                    : '<span class="text-danger">لم يتم الطباعة</span>';
            })
            ->addColumn('final_date_formatted', function ($payment) {
                $finalDate = $payment->date ?? null;
            
                if ($finalDate) {
                    try {
                        return \Carbon\Carbon::parse($finalDate)->format('d-m-Y');
                    } catch (\Exception $e) {
                        return $finalDate; // Handle invalid date gracefully
                    }
                }
            
                return 'N/A'; // Return default if date is null or invalid
            })
            ->addColumn('actions', function ($payment) {
                $printUrl = route('print_invoice', [
                    'id' => $payment->id,
                    'id1' => $payment->installment_id,
                    'id2' => $payment->install_month_id,
                    'id3' => $payment->id,
                ]);
                $archiveUrl = route('set_archief.data', ['id' => $payment->id]);
    
                $printButton = $payment->print_status == 'done' 
                    ? '<a style="text-decoration: line-through; pointer-events: none" class="btn btn-primary btn-sm rounded-pill">طباعة</a>' 
                    : "<a class='btn btn-primary btn-sm rounded-pill' href='$printUrl'>طباعة</a>";
    
                $archiveButton = $payment->print_status == 'done' 
                    ? "<a class='btn btn-danger btn-sm rounded-pill' href='$archiveUrl'>تحويل للأرشيف</a>" 
                    : '<button class="btn btn-secondary btn-sm rounded-pill" disabled>لم يتم الطباعة</button>';
    
                return $printButton . ' ' . $archiveButton;
            })
            ->addColumn('select_checkbox', function ($payment) {
                return '<input type="checkbox" name="checkAll[]" value="' . $payment->id . '" class="form-check-input">'; // Checkbox for bulk actions
            })
            ->rawColumns(['print_status_label', 'actions', 'select_checkbox']) // Allow HTML for specific columns
            ->addIndexColumn() // Add an auto-incrementing index column
            ->make(true); // Generate JSON response for DataTables
    // dd(DataTables::of($payments)->toArray());

}


    public function invoices_installment_index(Request $request)
    {
        $title = '  عمليات الدفع ';

        $pay_date = $request->month;
        $payment_type = $request->payment_type;
        $start_date = $request->start_date;
        $end_date = $request->end_date;
        // $this->data["central_bank"] = $this->db_get->get_where_r('invoices_central_bank', 'slug', 'installment');
        $this->data["central_bank"] = DB::table('invoices_central_bank')->where('slug', 'installment')->first();

        $this->data['items'] = Invoices_installment::where('arch', 0)->when($pay_date, function ($q) use ($pay_date) {
            $date = new DateTime($pay_date);
            $year = $date->format('Y');
            $month = $date->format('m');
            return $q->whereyear('date', $year)->wheremonth('date', $month);
        })->when($payment_type, function ($q) use ($payment_type) {
            return $q->where('payment_type', $payment_type);
        })->when($start_date, function ($q) use ($start_date) {
            return $q->whereDate('date', '>=', $start_date);
        })->when($end_date, function ($q) use ($end_date) {
            return $q->whereDate('date', '<=', $end_date);
        })->where('branch_id', Auth::user()->branch_id)
            ->with('installment')->with('install_month')->get();


        foreach ($this->data['items'] as $item) {
            if ($item->payment_type == 'cash') {
                $item->pay_method = 'كاش';
            } elseif ($item->payment_type == 'part') {
                $item->pay_method = 'روابط';
            } elseif ($item->payment_type == 'check') {
                $item->pay_method = 'شيك';
            } else {
                $item->pay_method = 'كى نت' . $item->knet_code;
            }
        }
        $breadcrumb = array();
        $breadcrumb[0]['title'] = " الرئيسية";
        $breadcrumb[0]['url'] = route("dashboard");
        $breadcrumb[1]['title'] = "عملاء الاقساط  ";
        $breadcrumb[1]['url'] = url("installment/admin");
        $breadcrumb[2]['title'] = " حساب الأقساط";
        $breadcrumb[2]['url'] = route("invoices_installment");

        $this->data['view'] = 'Payments/invoices_installment_index';
        return view('layout', $this->data, compact('breadcrumb'));

    }

    public function set_archief($id)

    {

        $data['arch'] = 1;

        $invoice = Invoices_installment::findorfail($id);
        $invoice->update($data);


        return redirect()->route('payments');


    }

    ///////////////////////////////case_proof function


    public function print_invoice($invoice_id, $installment_id, $id, $serial_no) // id is month_id
    {
        $data['user_name'] = Auth::user()->name_ar;
        $data['title'] = 'نظام الأقساط';

        $data['add_title'] = 'الأقساط';


        $data_update['print_status'] = 'done';

        $invoice = Invoices_installment::findorfail($invoice_id);
        $invoice->update($data_update);


        $data["item"] = $installment_item = Installment::findorfail($installment_id);

        // dd($installment_item->getCountAttribute('not_done'));
        $data["item"]['not_done_count'] = $installment_item->get_total_amount('not_done');

        $data["item"]['not_done_count_lated'] = $installment_item->count_installment_lated();

        $data["installment_month"] = Installment_month::findorfail($id);
        //   dd( $data["item"]['not_done_count_lated']);

        $total = explode(".", $data["item"]['installment']);


        //  $data["item"]['first_ar_amount'] = english_to_arabic($total[0]);

        //  $data["item"]['secound_ar_amount'] = english_to_arabic($total[1]);

        $explode = explode('.', $data["installment_month"]['amount']);

        $data['first_sum'] = numberToArabicWords($explode[0]);

        if (empty($explode[1])) {
            $data['secound_sum'] = "";
        } else {
            $data['secound_sum'] = '';
        }

        $data["client"] = $client = $installment_item->client;

        $data["item_images"] = array();

        if ($data["item"]['laws'] == 1) {

            $conditions_laws_per['installment_type'] = 'law_percent';

            $conditions_laws_per['installment_id'] = $id;
            $conditions_laws_item = Installment_month::where('installment_type', 'law_percent')
            ->where('installment_id', $id)
            ->get();
            // $conditions_laws_item = Installment_month::where(['installment_type' => 'law_percent', ''])->get();
            if (!empty($conditions_laws_item)) {
                $data['laws_item_amount'] = $conditions_laws_item->first()->amount ?? 0;
            } else {
                $data['laws_item_amount'] = 0;
            }

            $data["military_affairs_item"] = Military_affair::where('installment_id', $installment_id)->get();

            if (!$data["military_affairs_item"]->isEmpty()) {
                $item_law = $data["military_affairs_item"]->first();
                $data['military_affairs_amounts'] = Military_affairs_check::where('military_affairs_id', $item_law->id)->orderBy('id', 'asc')->first();

                /*$cond_679['military_affairs_id'] = $data["military_affairs_item"]['id'];
                $cond_del['military_affairs_id'] = $data["military_affairs_item"]['id'];
                $data["item_deligate"]['deligation_notes'] = $this->db_get->get_where_conditions('military_affairs_deligations', $cond_del);*/

                $data['military_affairs_checks'] = Military_affairs_check::where('military_affairs_id', $item_law->id)->get();

                $military_affairs_id = $item_law->id;

                // $data['all_cars_times'] = $this->all_military_affairs_times_sql($military_affairs_id);

                //  $data['all_salary_times'] = $this->all_stop_salary_times_sql($military_affairs_id);

                $cond300['military_affairs_id'] = $military_affairs_id;
                $cond345['military_affairs_id'] = $military_affairs_id;
                // $data['the_military_affairs_type_cars'] = $this->all_stop_cars_times_id('stop_cars');
                //  $data['the_military_affairs_type_salary'] = $this->all_stop_cars_times_id('stop_salary');
                // $data['the_military_affairs_type_travel'] = $this->all_stop_cars_times_id('stop_travel');

                // $data['the_military_affairs_type_images'] = $this->all_stop_cars_times_id('images');
                //  $data['the_military_affairs_type_alert'] = $this->all_stop_cars_times_id('execute_alert');
                //  $data['the_military_affairs_notes'] = Military_affairs_notes::where('military_affairs_id',$item_law->id)->get();
            } else {
                $data["military_affairs_item"] = '';
                $data['military_affairs_amounts'] = '';
                $data['military_affairs_checks'] = '';
            }

        } else {

            $data["military_affairs_item"] = '';
            $data['military_affairs_amounts'] = '';
            $data['military_affairs_checks'] = '';
            $data['laws_item_amount'] = 0;
        }

        $data['installment_bank_2'] = $data["item"]['installment_bank'];

        // $data["client"] =  $client->ministry;

        if ($data["item"]['installment_clients'] > 0) {
            // $data["installment_clients"] = $this->db_get->get_by_id('installment_clients', $data["item"]['installment_clients']);
            $data["installment_clients"] = Invoices_installment::findorfail($data["item"]['installment_clients']);
            // $data["client"] = $this->client_detail__install_clients_sql($data["item"]['client_id']);
        } else {
            $data["installment_clients"] = 0;
        }
        // dd($client);
        // $ministries_income = $this->db_get->get_by_id('ministries_income', $data["client"]['ministries_income_id']);
        
        if ($client->get_ministry) {
            // dd($client->get_ministry);
            $ministries_income = $client->get_ministry;

            if (isset($ministries_income)) {
                $data["client"]['ministry_percent'] = $ministries_income['percent'];
                $data["client"]['ministry_name'] = $ministries_income['name'];
                $data["client"]['ministry_date'] = $ministries_income['date'];
            } else {
                $data["client"]['ministry_percent'] = '';
                $data["client"]['ministry_name'] = '';
                $data["client"]['ministry_date'] = '';
            }
        }


        /*if ($data["client"]['ministry_2'] > 0) {
            $my_cl_ministry_2 = $this->db_get->get_by_id('ministries', $data["client"]['ministry_2']);
            $data["client"]['ministry_2_name'] = $my_cl_ministry_2['name'];

            $bank_2 = $this->db_get->get_by_id('bank', $data["client"]['bank_name_2']);
            $data["client"]['bank_2_name'] = $bank_2['name'];
        }*/

        /*if ($data["client"]['ministry_3'] > 0) {
            $my_cl_ministry_3 = $this->db_get->get_by_id('ministries', $data["client"]['ministry_3']);
            $data["client"]['ministry_3_name'] = $my_cl_ministry_3['name'];
            $bank_3 = $this->db_get->get_by_id('bank', $data["client"]['bank_name_3']);
            $data["client"]['bank_3_name'] = $bank_3['name'];
        }
        $data["kafil"] = $this->client_detail($data["item"]['kafil_id']);
        if ($data["item"]['installment_clients'] > 0) {
            $data["bank"] = $this->db_get->get_by_id('bank', $data["client"]['bank_name']);
        } else {
            $data["bank"] = Bank::where('slug',$client->bank_name)->first();
          //  $data["bank"] = $this->db_get->get_where_r('bank', 'slug', $data["client"]['bank_name']);
        }*/

        if (empty($data["bank"])) {
            $data["bank_name"] = " لا يوجد بنك للعميل";
        } else {
            $data["bank_name"] = $data["bank"]['name'];
        }


        $data['done_amount'] = $installment_item->get_total_amount('done');
        $data['not_done_amount'] = $installment_item->get_total_amount('not_done');

        $data['total_madionia'] = $data['done_amount'] + $data['not_done_amount'];
        $data['installment_id'] = $installment_id;


        $data["items"] = Installment_month::where('installment_id', $installment_id)->orderBy('date', 'asc')->get();
        $data["items_done"] = Installment_month::where('installment_id', $installment_id)->where('status', 'done')->orderBy('date', 'asc')->get();


        $cond_67777['installment_id'] = $installment_id;
        //$cond_67777['knet_code != '] = '';
        //    $cond_67777['install_month_id'] = 0;

        $data["items_invoices_installment"] = Invoices_installment::where('installment_id', $installment_id)->get();
        //  $data["items_invoices_installment"] = $this->db_get->get_where_conditions('invoices_installment', $cond_67777);
        // echo '<pre>';print_r($data['items_done']);exit;
        for ($i = 0; $i < count($data['items_done']); $i++) {
            if (isset($data['items_invoices_installment'][$i])) {
                $knet = Invoices_installment::where('installment_id', $installment_id)
                    ->where($data['items_done'][$i]['id'], '=', $data['items_invoices_installment'][$i]['install_month_id']);
        
                $data['items_done'][$i]['knet'] = $data["items_invoices_installment"][$i]['knet_code'];
            } else {
                // Handle cases where items_invoices_installment[$i] does not exist
                $data['items_done'][$i]['knet'] = null; // or some default value
            }
        }

        //$data['the_notes'] = InstallmentNote::where(['client_id'=> $client->id ,'installment_id'=>$installment_id])->get();
        // $data['the_notes'] = $this->db_get->get_where_conditions('installment_notes', $cond);

        $cond3599['installment_id'] = $data["item"]['installment_clients'];

        // $data['installment_clients_notes'] = $this->db_get->get_where_conditions('installment_clients_notes', $cond3599);
        // $data['installment_clients_notes'] = InstallmentClientNote::where('installment_id',$data["item"]['installment_clients'])->get();

        // $data["items_products"] = $this->order_prods_details_sql($data["item"]['order_id']);
        //  $data["items_products"] = getOrderDetails($data["item"]['order_id']);

        $total_amount_and_lawyer_percent = 0;
        for ($i = 0; $i < count($data["items"]); $i++) {
            if ($data["items"][$i]['status'] == 'not_done') {
                $total_amount_and_lawyer_percent = $total_amount_and_lawyer_percent + $data["items"][$i]['amount'];
            }
        }
        $data['first_amount'] = $installment_item->first_amount;

        $data["total_amount_and_lawyer_percent"] = $total_amount_and_lawyer_percent;

        //$data["sum_paid_unstallment_months"] = $this->money_gets_4_install('done', $id);

        //  $data["sum_un_paid_unstallment_months"] = $this->money_gets_4_install('not_done', $id);

        $nstallment_discount = Invoices_installment::where(['type' => 'expenses_pending', 'installment_id' => $installment_id])->get();

        if (count($nstallment_discount) == 0) {
            $data['nstallment_discount'] = 0;
        } else {
            $data['nstallment_discount'] = $nstallment_discount['amount'];
        }

        $data['serial'] = $serial_no;
        $nstallment_discount_amount = Invoices_installment::where(['type' => 'income', 'installment_id' => $installment_id])->get();
        if (count($nstallment_discount) == 0) {
            $data['nstallment_discount_amount'] = 0;
        } else {
            $data['nstallment_discount_amount'] = $nstallment_discount_amount['amount'];
        }
        $data['title1'] = 'نسخة ملف العميل (1)';
        echo view("Payments/print_invoice", $data);

        $data['title1'] = 'نسخة ملف العميل الاحتياطى (2)';
        echo view("Payments/print_invoice", $data);

        $data['title1'] = 'نسخة احتياطية ارشيف الشركة (3)';
        echo view("Payments/print_invoice", $data);

        $data['title1'] = 'نسخة احتياطية أرشيف البيت (4)';
        echo view("Payments/print_invoice", $data);
    }

    public function print_all($ids, $serial_nos)
{
    // dd($ids, $serial_nos);

    $data['user_name'] = Auth::user()->name_ar;
    $data['title'] = 'نظام الأقساط';
    $data['add_title'] = 'الأقساط';
    
    $data_update['print_status'] = 'done';
    if (is_string($ids)) {
        $ids = explode(',', $ids); // تحويل السلسلة إلى مصفوفة
    }
        foreach ($ids as $index => $id) {
            $invoice = Invoices_installment::findorfail($id);
            $invoice->update($data_update);

            $data["item"] = $installment_item = Installment::findorfail($id);

            // حساب عدد المدفوعات غير المكتملة وغيرها من الحقول لهذا القسط
            $data["item"]['not_done_count'] = $installment_item->get_total_amount('not_done');
            $data["item"]['not_done_count_lated'] = $installment_item->count_installment_lated();

            $data["installment_month"] = Installment_month::findorfail($id);
            $total = explode(".", $data["item"]['installment']);
            
            $explode = explode('.', $data["installment_month"]['amount']);
            $data['first_sum'] = numberToArabicWords($explode[0]);
            $data['secound_sum'] = empty($explode[1]) ? "" : '';

            $data["client"] = $client = $installment_item->client;

            // حسابات إضافية للقوانين والشؤون العسكرية
            if ($data["item"]['laws'] == 1) {
                // منطق مشابه لمعالجة 'laws' والشؤون العسكرية
            } else {
                $data["military_affairs_item"] = '';
                $data['military_affairs_amounts'] = '';
                $data['military_affairs_checks'] = '';
                $data['laws_item_amount'] = 0;
            }

            // إعدادات القسط والبنك
            $data['installment_bank_2'] = $data["item"]['installment_bank'];
            if ($data["item"]['installment_clients'] > 0) {
                $data["installment_clients"] = Invoices_installment::findorfail($data["item"]['installment_clients']);
            } else {
                $data["installment_clients"] = 0;
            }

            // منطق وزارة وغير ذلك من تفاصيل العميل
            if ($client->get_ministry) {
                $ministries_income = $client->get_ministry;
                if (isset($ministries_income)) {
                    $data["client"]['ministry_percent'] = $ministries_income['percent'];
                    $data["client"]['ministry_name'] = $ministries_income['name'];
                    $data["client"]['ministry_date'] = $ministries_income['date'];
                } else {
                    $data["client"]['ministry_percent'] = '';
                    $data["client"]['ministry_name'] = '';
                    $data["client"]['ministry_date'] = '';
                }
            }

            $data['done_amount'] = $installment_item->get_total_amount('done');
            $data['not_done_amount'] = $installment_item->get_total_amount('not_done');
            $data['total_madionia'] = $data['done_amount'] + $data['not_done_amount'];
            $data['installment_id'] = $id;

            // استرجاع شهور الأقساط والفواتير
            $data["items"] = Installment_month::where('installment_id', $id)->orderBy('date', 'asc')->get();
            $data["items_done"] = Installment_month::where('installment_id', $id)->where('status', 'done')->orderBy('date', 'asc')->get();

            $data["items_invoices_installment"] = Invoices_installment::where('installment_id', $id)->get();

            // تطابق العناصر مع الفواتير
            for ($i = 0; $i < count($data['items_done']); $i++) {
                if (isset($data['items_invoices_installment'][$i])) {
                    $data['items_done'][$i]['knet'] = $data["items_invoices_installment"][$i]['knet_code'];
                } else {
                    $data['items_done'][$i]['knet'] = null;
                }
            }

            $total_amount_and_lawyer_percent = 0;
            for ($i = 0; $i < count($data["items"]); $i++) {
                if ($data["items"][$i]['status'] == 'not_done') {
                    $total_amount_and_lawyer_percent += $data["items"][$i]['amount'];
                }
            }
            $data["total_amount_and_lawyer_percent"] = $total_amount_and_lawyer_percent;

            $nstallment_discount = Invoices_installment::where(['type' => 'expenses_pending', 'installment_id' => $id])->get();
            $data['nstallment_discount'] = count($nstallment_discount) == 0 ? 0 : $nstallment_discount['amount'];

            // إعداد الرقم التسلسلي والخصم
            $data['serial'] = $serial_nos[$index];
            $nstallment_discount_amount = Invoices_installment::where(['type' => 'income', 'installment_id' => $id])->get();

            $data['nstallment_discount_amount'] = count($nstallment_discount_amount) == 0 || !isset($nstallment_discount_amount[0]['amount']) 
                ? 0 
                : $nstallment_discount_amount[0]['amount'];

            // عرض النسخ المختلفة
            $data['title1'] = 'نسخة ملف العميل (1)';
            echo view("Payments/print_invoice", $data);

            $data['title1'] = 'نسخة ملف العميل الاحتياطى (2)';
            echo view("Payments/print_invoice", $data);

            $data['title1'] = 'نسخة احتياطية ارشيف الشركة (3)';
            echo view("Payments/print_invoice", $data);

            $data['title1'] = 'نسخة احتياطية أرشيف البيت (4)';
            echo view("Payments/print_invoice", $data);
        }
    
}


    public function archieve_all($ids)
    {
        $add_data['arch'] = 1;
        $invoices = explode(',', $ids);

        foreach ($invoices as $id) {
            $items = Invoices_installment::findorfail($id);
            $items->update(['arch' => 1]);
        }
        $response['redirect'] = url('/payments');
        echo json_encode($response);
    }


    public function get_invoices_papers(Request $request)
    {

        $request->validate([

            'img_dir' => 'nullable|image|mimes:jpg,png,jpeg,gif|max:2048',
        ]);


        $message = "تم دخول صفحة  إلي صفحة تصدير الكل داخل قسم حسابات الاقساط',   ";

        $user_id = 1;
        $user_id = Auth::user() ? Auth::user()->id : null;
        log_move($user_id, $message);

        //  $data['slug_page'] = $this->slug_page;

        $data['title'] = 'حسابات  عملاء  الاقساط';

        $data['add_title'] = 'تصدير';

        //$where_i['type'] = 'export';
        $branch_id = Auth::user()->branch_id;
        // $where_i['branch_id'] = Auth::user()->branch_id;
        //  $exports = $this->db_get->get_where_conditions('invoices_installment', $where_i);
        $exports = Invoices_installment::where('type', 'export')->where('branch_id', $branch_id)->get();

        if ($request->has('_token')) {

            $where['come_from'] = 'installment';
            //  $exports_central = $this->db_get->get_where_conditions('invoices', $where);
            $exports_central = DB::table('invoices')->where('come_from')->get();

            $fieldname = 'payment_file_dir';
            if ($request->hasFile('img_dir')) {
                $add_data['img_dir'] = $request->file('payment_file_dir')->store('installment', 'public'); // Store in the 'products' directory
            }

            // echo '<pre>';print_r($exports_central);exit;

            // $this->db_get->update_tb('invoices_installment', $exports[0]['id'], $add_data);
            Invoices_installment::where('id', $exports[0]['id'])->update(['img_dir' => $add_data['img_dir']]);
            DB:: table('invoices')->where('id', $exports_central[0]['id'])->update(['payment_file_dir' => $add_data['payment_file_dir']]);
            // $this->db_get->update_tb('invoices', $exports_central[0]['id'], $add_data);
            return redirect()->to('invoices_installment');
        }

        if (count($exports) >= 1) {

            //$data['items']=$this->all_invoices( $exports[0]['id']);
            //$where['id > '] = $exports[0]['id'];
            // $data['items'] = $this->db_get->get_where_conditions('invoices_installment', $where);
            $data['items'] = Invoices_installment::where('id', '>', $exports[0]['id'])->get();
        } else {
            //  $where['id > '] = 0;
            // $data['items'] = $this->db_get->get_where_conditions('invoices_installment', $where);
            $data['items'] = Invoices_installment::where('id', '>', 0)->get();

        }

        if (count($data['items']) < 1) {

            return redirect()->back()->with('error', 'عفوا ، لا يوجد حسابات للتصدير');

        } else

            return redirect()->back();


    }


    public function export_all()
    {

        //$exports = $this->db_get->get_where('invoices_installment', 'type', 'export');

        $where_i['type'] = 'export';
        $where_i['branch_id'] = Auth::user()->branch_id;
        $branch_id = Auth::user()->branch_id;
        //  $exports = $this->db_get->get_where_conditions('invoices_installment', $where_i);
        $exports = Invoices_installment::where($where_i)->get();

        //echo '<pre>';print_r($exports); exit;

        //$where['branch_id'] = $this->session->get('branch_id');

        if (!empty($exports)) {
            //$data['items']=$this->all_invoices( $exports[0]['id']);

            $where['id > '] = $exports[0]['id'];

            $exports_id = $exports[0]['id'];

            // $data['items'] = $this->db_get->get_where_conditions('invoices_installment', $where);
            $data['items'] = Invoices_installment::where('id', '>', $exports_id)->where('branch_id', $branch_id)->orderBy('id', 'desc')->get();
        } else {
            $where['id > '] = 0;

            $exports_id = 0;

            // $data['items'] = $this->db_get->get_where_conditions('invoices_installment', $where);

            $data['items'] = Invoices_installment::where('id', '>', 0)->get();

        }
//        echo '<pre>';print_r($data); exit;
        if (count($data['items']) > 0) {

            // $data['cash'] = $this->all_invoices($exports_id, 'income', 'cash');
            $data['cash'] = all_invoices($exports_id, 'income', 'cash');

            $sum_cash = 0.000;

            for ($l = 0; $l < count($data['cash']); $l++) {
                $sum_cash = $sum_cash + $data['cash'][$l]['amount'];
            }

            //echo '<pre>';print_r($sum_cash);exit;

            // $data['knet'] = $this->all_invoices($exports_id, 'income', 'knet');
            $data['knet'] = all_invoices($exports_id, 'income', 'knet');

            $sum_knet = 0.000;

            for ($l = 0; $l < count($data['knet']); $l++) {
                $sum_knet = $sum_knet + $data['knet'][$l]['amount'];
            }

            //$data['part'] = $this->all_invoices($exports_id, 'income', 'part');
            $data['part'] = all_invoices($exports_id, 'income', 'part');

            $sum_bank = 0.000;

            for ($l = 0; $l < count($data['part']); $l++) {
                $sum_bank = $sum_bank + $data['part'][$l]['amount'];
            }
            //   echo '<pre>';print_r($data['part']);
            // echo '<pre>';print_r($sum_bank);exit;

            $branch_name = Bank::findorfail($branch_id)->name_ar;

            $desc_1 = ' حساب الأقساط'
                . ' '
                . 'فرع '
                . ' '
                . $branch_name;

            update_big_invoice_cash('installment', $sum_cash, $desc_1);

            update_big_invoice_knet('installment', $sum_knet, $desc_1);

            update_invoice_central_bank('cash', '-', $sum_cash, 'installment');
            update_invoice_central_bank('knet', '-', $sum_knet, 'installment');

            $add_data_bank_2['date'] = date('Y-m-d H:i:s');
            $add_data_bank_2['balance'] = 0;
            $add_data_bank_2['user_id'] = Auth::user()->id;

            $add_data_bank_2['debtor'] = 1;
            $add_data_bank_2['cat_id'] = 3;
            $add_data_bank_2['type'] = 'income';
            $add_data_bank_2['datebasheer'] = date("Y-m-d H:i:s");

            $add_data_2['date'] = date('Y-m-d H:i:s');

            $add_data_bank_2['amount'] = $add_data_2['amount'] = $sum_knet;

            $add_data_2['description'] = 'تصدير لكل  حسابات الكي نت      ';

            $add_data_2['payment_type'] = 'knet';

            $add_data_2['type'] = 'export';

            $add_data_2['branch_id'] = $branch_id;

            $add_data_2['creditor'] = 1;

            $add_data_2['created_by'] = Auth::user()->id;

            $add_data_bank_2['description'] = 'من حساب الأقساط :'
                . '<br>'
                . $add_data_2['description'];

            if ($add_data_bank_2['amount'] > 0) {
                //$this->db_get->add_tb("fast_banks_invoices", $add_data_bank_2);
                DB::table('fast_banks_invoices')->insert($add_data_bank_2);
            }
            if ($add_data_2['amount'] > 0) {
                //  $this->db_get->add_tb("invoices_installment", $add_data_2);
                Invoices_installment::create($add_data_2);
            }

            $add_data_bank_2['amount'] = $add_data_2['amount'] = $sum_cash;

            $add_data_2['description'] = 'تصدير لكل  حسابات الكاش      ';

            $add_data_2['payment_type'] = 'cash';

            $add_data_2['type'] = 'export';

            $add_data_2['created_by'] = Auth::user()->id;

            $add_data_bank_2['description'] = 'من حساب الأقساط :'
                . '<br>'
                . $add_data_2['description'];

            if ($add_data_bank_2['amount'] > 0) {
                //$this->db_get->add_tb("fast_banks_invoices", $add_data_bank_2);
                DB::table('fast_banks_invoices')->insert($add_data_bank_2);
                DB::table('fast_cash_invoices')->insert($add_data_bank_2);


                // $this->db_get->add_tb("fast_cash_invoices", $add_data_bank_2);

                // $this->db_get->add_tb("invoices_installment", $add_data_2);
                Invoices_installment::create($add_data_2);

            }

            $add_data_2['amount'] = $sum_bank;

            $add_data_2['description'] = 'تصدير لكل  حسابات  الروابط     ';

            $add_data_2['payment_type'] = 'part';

            $add_data_2['type'] = 'export';

            $add_data_2['user_id'] = Auth::user()->id;

            // $this->db_get->add_tb("invoices_installment", $add_data_2);
            Invoices_installment::create($add_data_2);


        } else {


            return redirect()->route('invoices_installment')->with('error', 'عفوا ، لا يوجد حسابات للتصدير');

        }

        return redirect()->url('print_invoice/' . $data['items'][count($data['items']) - 1]['id'] . '/' . $data['items'][0]['id']);

        //   echo view("installment/views_invoices_installment/print_all_invoices_details", $data);
    }

    public function print_invoice_export($start_id, $end_id)
    {

        $data['slug_page'] = '';

        $data['title'] = '';

        $data['add_title'] = '';

        //echo '<pre>';print_r($data);exit;

        $data['knet_payments'] = allInvoicesLimit($start_id, $end_id, 'income', 'knet');

        $sum_knet = 0.000;

        for ($m = 0; $m < count($data['knet_payments']); $m++) {
            $sum_knet = $sum_knet + $data['knet_payments'][$m]['amount'];
        }

        $data['amount_knet'] = $sum_knet;

        $data['bank_payments'] = allInvoicesLimit($start_id, $end_id, 'income', 'part');

        $sum_bank = 0.000;

        for ($m = 0; $m < count($data['bank_payments']); $m++) {
            $sum_bank = $sum_bank + $data['bank_payments'][$m]['amount'];
        }
        //    echo $sum_bank.'<pre>';print_r($data['bank_payments']);exit;
        $data['amount_bank'] = $sum_bank;

        $data['cash_payments'] = allInvoicesLimit($start_id, $end_id, 'income', 'cash');

        // echo '<pre>';print_r($data);exit;
        $sum_cash = 0.000;

        for ($l = 0; $l < count($data['cash_payments']); $l++) {
            $sum_cash = $sum_cash + $data['cash_payments'][$l]['amount'];
        }

        $data['amount_cash'] = $sum_cash;

        $data['items'] = array();
        $m = 0;
        for ($k = 0; $k < count($data['cash_payments']); $k++) {
            // $data['items'][$m]= $data['cash_payments'][$k];
            for ($w = 0; $w < count($data['knet_payments']); $w++) {
                if ($data['cash_payments'][$k]['installment_id'] == $data['knet_payments'][$w]['installment_id']
                    and
                    $data['cash_payments'][$k]['install_month_id'] == $data['knet_payments'][$w]['install_month_id']
                ) {
                    $data['cash_payments'][$k]['cash_amount'] = $data['cash_payments'][$k]['balance'];
                    $data['cash_payments'][$k]['knet_amount'] = $data['knet_payments'][$w]['balance'];
                    $data['items'][$m] = $data['cash_payments'][$k];
                    $m++;
                } else {
                    $data['knet_payments'][$w]['cash_amount'] = 0;
                    $data['knet_payments'][$w]['knet_amount'] = $data['knet_payments'][$w]['balance'];
                    $data['items'][$m] = $data['knet_payments'][$w];
                    $m++;
                }

            }

            $data['cash_payments'][$k]['cash_amount'] = $data['cash_payments'][$k]['balance'];
            $data['cash_payments'][$k]['knet_amount'] = 0;
            $data['items'][$m] = $data['cash_payments'][$k];
            $m++;
        }

        //          echo '<pre>';print_r($data);exit;

        return view("Payments/print_all_invoices_details", $this->data);

    }


}
