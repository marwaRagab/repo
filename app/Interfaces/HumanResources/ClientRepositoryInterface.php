<?php

namespace App\Interfaces\HumanResources;

use Illuminate\Http\Request;

interface ClientRepositoryInterface
{
    public function index();
    public function store($request);
    public function update($request, $id);
    public function destroy($id);
    public function show_client($id);
}
