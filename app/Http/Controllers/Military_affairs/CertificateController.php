<?php

namespace App\Http\Controllers\Military_affairs;

use App\Http\Controllers\Controller;
use App\Interfaces\Military_affairs\CertificateRepositoryInterface;
use App\Interfaces\Military_affairs\Open_fileRepositoryInterface;
use App\Models\Governorate;
use App\Models\Military_affairs;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\DataTables;

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


}
