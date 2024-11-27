<?php

namespace App\Interfaces\ImportingCompanies;

use Illuminate\Http\Request;

interface CompanyRepositoryInterface
{
    public function index();
    public function store(Request $request);
    public function update($id, Request $request);
    public function create();
    public function edit($id);
}
