<?php

namespace App\Interfaces\HumanResources;

use Illuminate\Http\Request;

interface MemberRepositoryInterface
{
    public function index();
    public function store(Request $request);
    public function update($id, Request $request);
    public function destroy($id);
}
