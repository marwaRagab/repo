<?php

namespace App\Interfaces\ImportingCompanies;

use Illuminate\Http\Request;

interface MarkRepositoryInterface
{
    public function index();
    public function store(Request $request);
    public function update($id, Request $request);
}
