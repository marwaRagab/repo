<?php

namespace App\Http\Controllers\Military_affairs;

use App\Models\ClientImg;
use App\Models\Governorate;
use App\Models\Installment;
use Illuminate\Http\Request;
use App\Models\Military_affairs\Military_affair;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Interfaces\Military_affairs\Open_fileRepositoryInterface;
use App\Interfaces\Military_affairs\CertificateRepositoryInterface;
use App\Models\Client;

// use App\Models\Military_affairs;

class CertificateController extends Controller
{
    //
    protected $CertificateRepository;

    public function __construct(CertificateRepositoryInterface $CertificateRepository)
    {
        $this->CertificateRepository = $CertificateRepository;
    }

    public function index(Request $request)
    {
        // dd("dd");
        return $this->CertificateRepository->index($request);


        // return response()->json($permissions);
    }

    public function data_certificate(Request $request)
    {
        // dd("dd");
        return $this->CertificateRepository->data_certificate($request);

        /*if($data)
        /*{
            $message ="تم دخول صفحة  فتح الملف" ;
            $this->log(Auth::user()->id,$message);

        }*/
        // return response()->json($permissions);
    }

    public function convert_to_export(Request $request)
    {
        return $this->CertificateRepository->convert_to_export($request);
    }

    public function convert_to_money(Request $request)
    {
        return $this->CertificateRepository->convert_to_money($request);
    }

    public function convert_to_stop_salary(Request $request)
    {
        return $this->CertificateRepository->convert_to_stop_salary($request);
    }

    public function convert_book_info($id)
    {
        return $this->CertificateRepository->convert_book_info($id);
    }

    public function print_case_proof($item)
    {
        $item = Military_affair::find($item);

        // return $this->CertificateRepository->print_case_proof();
        return view('military_affairs.Execute_alert.print.case_proof', compact('item'));
    }

    public function print_sticker($item)
    {
        $item = Military_affair::find($item);
        return view('military_affairs.Execute_alert.print.sticker', compact('item'));
    }

    public function print_issue($item, $data_id)
    {
        $item = Military_affair::find($item);
        // DB::table('military_affairs')->where('id', $item)->first();
        // dd($item);
        return view('military_affairs.Execute_alert.print.issue', compact('data_id', 'item'));
    }


    public function print_civil_id($item)
    {

        $item = Military_affair::find($item);
        $installment = Installment::find($item->installment_id);
        $client_civil_id1 = ClientImg::where('client_id', '=', $installment->client_id)->where('type', '=', 'cid_img1')->first();
        $client_civil_id2 = ClientImg::where('client_id', '=', $installment->client_id)->where('type', '=', 'cid_img_2')->first();

        return view('military_affairs.Execute_alert.print.civil_id', compact('client_civil_id1', 'client_civil_id2'));
    }


}
