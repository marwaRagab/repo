<?php

namespace App\Interfaces\HumanResources;

use Illuminate\Http\Request;

interface UserRepositoryInterface
{
    public function index();
    public function store($request);
    public function update($request, $id);
}
