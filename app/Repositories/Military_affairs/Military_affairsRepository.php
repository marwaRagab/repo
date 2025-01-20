<?php

namespace App\Repositories\Military_affairs;

use App\Interfaces\Military_affairs\Military_affairsRepositoryInterface;
use App\Models\Client;
use App\Models\Installment;
use App\Models\Installment_month;
use App\Models\Military_affairs\Military_affair;
use App\Models\Military_affairs\Military_affairs_times_type;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;

class Military_affairsRepository implements Military_affairsRepositoryInterface
{
    protected $data;

    public function __construct()
    {

        //   $this->data['governorates'] = Governorate::with('clients')->get();

    }
    public function index()
    {

        $message = "تم دخول صفحة  الشئون القانونية";

        $title = 'الشئون القانونية';
        $view = 'military_affairs/index';

        $count['all_military_affairs_count'] = count($this->all_military_affairs_count(''));
        $count['open_file_count'] = count($this->all_military_affairs_count('open_file'));
        $count['images_count'] = count($this->all_military_affairs_count('images'));
        $count['case_proof_count'] = count($this->all_military_affairs_count('case_proof'));
        $count['execute_alert_count'] = count($this->all_military_affairs_count('execute_alert'));
        $count['stop_travel_count'] = count($this->all_military_affairs_count('stop_travel'));
        $count['stop_car_count'] = count($this->all_military_affairs_count('stop_car'));
        $count['Military_certificate_count'] = count($this->all_military_affairs_count('Military_certificate'));
        $count['stop_salary_count'] = count($this->all_military_affairs_count('stop_salary'));
        $count['stop_bank_count'] = count($this->all_military_affairs_count('stop_bank'));
        $count['eqrar_dain_count'] = count($this->all_military_affairs_count('eqrar_dain'));
        $count['eqrar_dain_received_count'] = count($this->all_military_affairs_count('eqrar_dain_received'));
        $count['excute_actions_count'] = count($this->all_military_affairs_count('excute_actions'));
        $count['settlement_count'] = $this->get_settlment('request') + $this->get_settlment('done') + $this->get_settlment('canceled');

        $transactions = $this->all_military_affairs_count('');

        $breadcrumb = array();
        $breadcrumb[0]['title'] = " الرئيسية";
        $breadcrumb[0]['url'] = route("dashboard");

        $breadcrumb[1]['title'] = $title;
        $breadcrumb[1]['url'] = 'javascript:void(0);';

        return view('layout', compact(['title', 'view', 'transactions', 'breadcrumb', 'count']));

    }
    public function get_settlment($type = null)
    {
        if (!empty($type)) {
            if ($type == 'done') {
                $whr = ['type' => 1];
            } elseif ($type == 'canceled') {
                $whr = ['type' => '!=""', 'type' => 0];
            } elseif ($type == 'request') {
                $whr = ['type' => ''];
            } else {
                $whr = ['type' => ''];
            }

        } else {
            $whr = "";
        }
        $items = DB::table('military_affairs_settlement')->where($whr)->get()->count();
        return $items;
    }

    public function all_military_affairs_count($type = '')
    {
        $count = Military_Affair::with('installment')
                                ->with('status_all')
                                ->whereHas('installment', function ($query) {
                                    $query->where('finished',0)->where('laws',1)->orderBy('id', 'asc');
                                })
                                ->with('installment.client')
                                ->with('installment.installment_eqrardain')
                                ->when($type === 'open_file', function ($q) use ($type) {
                                    $q->where('status', 'military');
                                })
                                ->when($type === 'images', function ($q) use ($type) {
                                    $q->where('status', 'images')->where('jalasat_alert_status','accepted');
                                })
                                ->when($type === 'execute_alert', function ($q) use ($type) {
                                    $q->where('status', 'execute_alert')->where('jalasat_alert_status','!=','accepted');
                                })
                                ->when($type === 'case_proof', function ($q) use ($type) {
                                    $q->where('status', 'case_proof')->where('jalasat_alert_status','accepted');
                                })
                                ->when($type === 'Military_certificate', function ($q) use ($type) {
                                    $q
                                    ->whereHas('installment.client', function ($query) {
                                        $query->where('job_type','military');
                                    })
                                    ->where('stop_salary', 0)->where('cancel_certificate',1);
                                })
                                ->when($type === 'stop_bank', function ($q) use ($type) {
                                    $q->where('status', 'execute')->where('stop_bank',1)->where('bank_archive',0);
                                })
                                ->when($type === 'stop_car', function ($q) use ($type) {
                                    $q->where('status', 'execute')->where('stop_car',1)->where('stop_car_archive',0);
                                })
                                ->when($type === 'stop_travel', function ($q) use ($type) {
                                    $q->where('status', 'execute')->where('stop_travel',1);
                                })
                                ->when($type === 'eqrar_dain', function ($q) use ($type) {
                                    $q
                                    ->whereHas('installment', function ($query) {
                                        $query->where('status','finished')->where('type','installment');
                                    })
                                    ->whereHas('installment.installment_eqrardain', function ($query) {
                                        $query->where('paper_eqrar_dain_received',0);
                                    })
                                    ->where('status', null);
                                })
                                ->when($type === 'eqrar_dain_received', function ($q) use ($type) {
                                    $q
                                    ->whereHas('installment', function ($query) {
                                        $query->where('status','finished')->where('type','installment');
                                    })
                                    ->whereHas('installment.installment_eqrardain', function ($query) {
                                        $query->where('paper_eqrar_dain_received',1);
                                    })
                                    ->where('status', null);
                                })
                                ->when($type === 'excute_actions', function ($q) use ($type) {
                                    $q->where('status', 'execute');
                                })
                                ->where('archived',0)
                                ->get();
                    //  dd($count);           
        return $count;

    }
    public function convert($id)
    {
        $message = "تم تحويل المعاملة رقم " . $id . ' للشئون القانونية';
        log_move(Auth::user()->id, $message);
        // $data['laws']=1;
        $old_time_type = "";

        $install = Military_Affair::with('installment')->where(['installment_id' => $id])->first();

        if (!empty($install)) {
            //  dd('kkk'.$install);
            return redirect()->route('military_affairs')->with('error', 'عفوا تم تحويل المعاملة للشئون القانونية من قبل!!');
        } else {
            $eqrars_id = DB::table('eqrars_details')->insertGetId([

                'paper_eqrar_dain_received' => 0,
                'paper_eqrar_dain_received_user_id' => null,
                'paper_eqrar_dain_sender_id' => null,
                'paper_eqrar_dain_received_date' => date('Y-m-d H:i:s'),
                'paper_eqrar_dain_received_img' => null,
                'created_by' => Auth::id(),
                'updated_by' => null,
            ]);

            $data = Installment::findOrFail($id);
            $data->laws = 1;
            $data->eqrars_id = $eqrars_id;

            $data->updated_by = (isset(Auth::user()->id) ? Auth::user()->id : '');
            $data->save();

            $install = Installment::findOrFail($id);
            $client = Client::findOrFail($install->client_id);
            $data = [
                'laws' => $install->laws,
                'updated_by' => (isset(Auth::user()->id) ? Auth::user()->id : ''),
            ];
            $client->update($data);

            if ($install->installment_clients > 0) {
                $madionia_amount = $install->amount;
                $eqrar_dain_amount = $install->eqrardain_amount;
            } else {
                $madionia_amount = $install->amount - $install->first_amount;
                $eqrar_dain_amount = $madionia_amount + (($madionia_amount) * 25 / 100);
            }
            $payment_done = $this->total_install_paid_msql($id);
            $law_percent = ($madionia_amount * 25 / 100);
            $add_data = new Military_affair;
            $add_data->installment_id = $id;
            $add_data->date = date('Y-m-d H:i:s');
            $add_data->amount = $install->amount;
            $add_data->madionia_amount = ($madionia_amount ? $madionia_amount : '');
            $add_data->eqrar_dain_amount = $eqrar_dain_amount;
            $add_data->payment_done = $payment_done;
            $add_data->law_percent = $law_percent;
            $add_data->archived = 0;
            $add_data->created_by = (isset(Auth::user()->id) ? Auth::user()->id : '');
            $add_data->updated_by = (isset(Auth::user()->id) ? Auth::user()->id : '');
            $get_data = $add_data->save();
            $military_affairs_id = $add_data->id;

            $old_one = Military_affairs_times_type::where('slug', 'lated_installment')->first();
            $new_one = Military_affairs_times_type::where('slug', 'eqrar_dain_not_received')->first();
            if ($old_one) {
                $old_time_type = Military_affairs_times_type::findOrFail($old_one->id);
            }

            $new_time_type = Military_affairs_times_type::findOrFail($new_one->id);
            if ($old_one) {
                Add_note($old_time_type, $new_time_type, $military_affairs_id); //eqrart not recieved
            }

            Add_note_time($new_time_type, $military_affairs_id);

            //   Add_note($old_time_type,3,$military_affairs_id);    // open file

            $add_data = new Installment_month;
            $add_data->installment_id = $id;
            $add_data->date = date('Y-m-d H:i:s');
            $add_data->amount = $law_percent;
            $add_data->installment_type = 'law_percent';
            $add_data->created_by = (isset(Auth::user()->id) ? Auth::user()->id : '');
            $add_data->updated_by = (isset(Auth::user()->id) ? Auth::user()->id : '');
            $add_data->save();

            return redirect()->route('papers.eqrar_dain')->with('message', 'تم الحفظ بنجاح');

        }
    }

    public function total_install_paid_msql($id)
    {
        $result = DB::table('installment_months')
            ->join('installment', 'installment_months.installment_id', '=', 'installment.id')
            ->where('installment_months.status', 'done')
            ->where('installment.type', 'installment')
            ->where('installment.status', 'finished')
            ->where('installment_months.date', '!=', 131313)
            ->where('installment_months.installment_type', 'installment')
            ->where('installment.id', $id)
            ->selectRaw('SUM(installment_months.amount) AS total_install_paid_msql')
            ->groupBy('installment_months.installment_id')
            ->first(); // Use `first()` to get the result (single record).

        // Ensure that if no result is returned, you set default value of 0
        $totalInstallPaidMsql = $result ? $result->total_install_paid_msql : 0;

        return $totalInstallPaidMsql;
    }
}