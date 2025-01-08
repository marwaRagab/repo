<?php

namespace App\Interfaces\TechnicalSupport;

use Illuminate\Http\Request;

interface ProblemRepositoryInterface
{
    public function index(Request $request);
    public function show($id);
    public function store(Request $request);
    public function updateStatus($id, Request $request);
    public function addReply(Request $request);

    public function updatedeveloper($id, Request $request);
}
