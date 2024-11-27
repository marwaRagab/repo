<?php

namespace App\Interfaces\ImportingCompanies;

use Illuminate\Http\Request;

interface PurchaseOrdersRepositoryInterface
{
    public function index(Request $request);
    public function destroy($id);
    public function showOrderProducts($id);
    public function sending($id, Request $request);
    public function print_invoice($order_id);
}
