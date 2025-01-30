<?php

namespace App\Interfaces;

use Illuminate\Http\Request;

interface InvoicesCashierRepositoryInterface
{
    public function index(Request $request);
    public function processExport(Request $request);
    public function showExportForm();

}