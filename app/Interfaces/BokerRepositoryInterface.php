<?php

namespace App\Interfaces;

use Illuminate\Http\Request;

interface BokerRepositoryInterface
{
    // public function index(Request $request);
    public function index();
    // public function  create();
    // public function show($id);
    public function store(Request $request);
    // public function edit($id);
    public function update($id, $request);
    public function destroy($id);
}
