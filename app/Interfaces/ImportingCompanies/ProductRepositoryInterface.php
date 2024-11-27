<?php

namespace App\Interfaces\ImportingCompanies;

use Illuminate\Http\Request;
// use App\Http\Requests\ProductsRequest;

interface ProductRepositoryInterface
{
    public function index();
    public function store(Request $request);
    public function update($id,Request $request);
    public function destroy($id);
    public function print_all();
}