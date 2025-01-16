<?php

namespace App\Interfaces\Payments;

use Illuminate\Http\Request;

interface PaymentsRepositoryInterface
{ 
    public function index (Request $request);
    public function archive_all_in (Request $request);
    public function print_invoice($invoice_id,$installment_id,$id,$serial);
    public function set_archief($id);
    public function print_all($ids,$allserials ,$invoiceids);
    public function archieve_all($ids);
    public function invoices_installment_index(Request $request);
    public function get_invoices_papers(Request $request);
    public function export_all();
    public function print_invoice_export($id1,$id2);
    public function getPaymentsData(Request $request);

    public function collect_affairs (Request $request);
    public function getcollect_affairsData (Request $request);

}
