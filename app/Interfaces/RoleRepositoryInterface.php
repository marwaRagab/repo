<?php

namespace App\Interfaces;

use Illuminate\Http\Request;

interface RoleRepositoryInterface
{
    // public function index(Request $request);
    public function index(Request $request);
    public function  create();
    public function show($id);
    public function store(Request $request);
    public function edit($id);
    public function update($id, Request $request);
    public function destroy($id);
}