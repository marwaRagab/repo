<?php

namespace App\Interfaces;

use Illuminate\Http\Request;

interface InvoicesCashierRepositoryInterface
{
    public function index();
    public function show($id);
    public function store(Request $request);
    public function update($id, Request $request);
    public function destroy($id);
}