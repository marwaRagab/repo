<?php

namespace App\Interfaces\Military_affairs;

use Illuminate\Http\Request;

interface CertificateRepositoryInterface
{
    public function index(Request $request);
    public function convert_book_info($id);

   public function convert_to_export(Request $request);
   public function convert_to_stop_salary(Request $request);
   public function convert_to_money(Request $request);
   public function data_certificate(Request $request);

}
