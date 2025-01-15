<?php

namespace App\Repositories\Military_affairs;

use App\Interfaces\Military_affairs\EqrardainRepositoryInterface;
use App\Models\Client;
use App\Models\Installment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class EqrardainRepository implements EqrardainRepositoryInterface
{
    protected $data;

    public function __construct()
    {
        //

    }

    public function index(Request $request)
    {

        $eqrardain_type = $request->eqrardain_type;
        $message = "تم دخول صفحة فتح اقرارات الدين ";

        $user_id =  Auth::user()->id;
        log_move($user_id ,$message);

        $this->data['title'] = 'اقرارات الدين  ';
        if ($eqrardain_type == 'requre_cancel') {

            $this->data['items'] = Installment::where(['status' => 'finished', 'finished' => 1])
                ->with('client')->with('installment_eqrardain', function ($query) {
                $query->where('cancel_eqrar_dain', '=', 0);
                $query->where('please_cancel_eqrar_dain', '=', 1);
                return $query;
            })->get();

        } elseif ($eqrardain_type == 'canceled') {
            $this->data['items'] = Installment::where('installment.qard_paper', 'like', '%uploads/new_photos%')
                ->with('client')->with('installment_eqrardain', function ($query) {
                $query->where('please_cancel_eqrar_dain', '=', 1);
                return $query;
            })->get();
        } else {
            $this->data['items'] = Installment::where('installment.qard_paper', 'like', '%uploads/new_photos%')
                ->with('client')->with('installment_eqrardain', function ($query) {
                $query->where('cancel_eqrar_dain', '=', 0);
                $query->where('please_cancel_eqrar_dain', '=', 0);
                return $query;
            })->get();

        }

        $this->data['eqrar_count'] = Installment::where('installment.qard_paper', 'like', '%uploads/new_photos%')->where('finished', '=', 0)
            ->with('client')->with('installment_eqrardain', function ($query) {
            $query->where('cancel_eqrar_dain', '=', 0);
            $query->where('please_cancel_eqrar_dain', '=', 0);
            return $query;
        })->sum('installment.eqrardain_amount');

        $sumAmount = Installment::with('client')->with('installment_eqrardain', function ($query) {
            $query->where('cancel_eqrar_dain', 0);
            return $query->where('please_cancel_eqrar_dain', 0);

        })
            ->where('installment.qard_paper', 'like', '%uploads%')
            ->where('installment.laws', 0)
            ->where('installment.finished', 0)
            ->sum('eqrardain_amount');

        $this->data['items_not_laws'] = $sumAmount ? $sumAmount : 0;

        $this->data['eqrar_2023'] = all_eqrardeain_sql_for_year('2023', 'laws');
        $this->data['eqrar_all'] = all_eqrardeain_sql_for_year('', '');
        $this->data['not_laws_2023'] = all_eqrardeain_sql_for_year('2023', 'not_laws');

        $this->data['amount_military_affairs'] = getTotalAmount('');
        $this->data['installment_military_affairs_2023'] = getTotalAmount(2023);

        $sumAmount = Installment::with('client')
            ->join('installment_months', 'installment_months.installment_id', '=', 'installment.id')
            ->where('installment.finished', 0)
            ->where('installment.type', 'installment')
            ->where('installment.status', 'finished')
            ->where('installment_months.status', 'not_done')
            ->where('installment_months.installment_type', '!=', 'law_percent')
            ->select(DB::raw('SUM(installment_months.amount) as sum_amount'))
            ->first()->sum_amount;
        $this->data['reminder'] = $sumAmount ?: 0;

        $title = 'اقرارات الدين ';
        $breadcrumb = array();
        $breadcrumb[0]['title'] = " الرئيسية";
        $breadcrumb[0]['url'] = route("dashboard");
        $breadcrumb[1]['title'] = "الشئون القانونية";
        $breadcrumb[1]['url'] = route("military_affairs");
        $breadcrumb[2]['title'] = $title;
        $breadcrumb[2]['url'] = 'javascript:void(0);';
        $this->data['view'] = 'military_affairs/Eqrardain/index';
        return view('layout', $this->data, compact('breadcrumb'));

    }

    public function please_cancel_eqrar($id)
    {

        $item_installment = Installment::findorfail($id);
        $data['please_cancel_eqrar_dain'] = 1;
        $item_installment->update($data);
        return redirect()->route('eqrardain');

    }

    public function update_actions_reminder(Request $request)
    {

        $request->validate([
            'client_id' => 'required',
            'qard_img' => 'required|image|mimes:jpg,png,jpeg,gif|max:2048',
            'qard_amount' => 'required',
            'qard_place' => 'required',
            'qard_number' => 'required',
        ]);

        if ($request->hasFile('qard_img')) {
            $data_qard_img = $request->file('qard_img')->store('military_affairs', 'public'); // Store in the 'products' directory
        }
        $clients = Client::all();
        $add_data['client_id'] = $request->client_id;
        $add_data['qard_amount'] = $request->qard_amount;
        $add_data['eqrardain_amount'] = $this->request->qard_amount;
        $add_data['qard_place'] = $request->qard_place;
        $add_data['qard_number'] = $request->qard_number;
        $add_data['date'] = date('Y-m-d');
        $add_data['qard_paper_img'] = $data_qard_img;

        return redirect()->route('eqrardain');

    }

}
