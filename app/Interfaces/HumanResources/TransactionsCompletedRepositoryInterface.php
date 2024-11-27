<?php

namespace App\Interfaces\HumanResources;

use Illuminate\Http\Request;

interface TransactionsCompletedRepositoryInterface
{
    // public function index(Request $request);
    public function index();
    public function store(Request $request);
    public function update($id, Request $request);
    public function destroy($id);
}
