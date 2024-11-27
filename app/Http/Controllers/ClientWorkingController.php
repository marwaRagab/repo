<?php

namespace App\Http\Controllers;

use App\Models\ClientWorking;
use App\Http\Requests\StoreClientWorkingRequest;
use App\Http\Requests\UpdateClientWorkingRequest;

class ClientWorkingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreClientWorkingRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreClientWorkingRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\ClientWorking  $clientWorking
     * @return \Illuminate\Http\Response
     */
    public function show(ClientWorking $clientWorking)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\ClientWorking  $clientWorking
     * @return \Illuminate\Http\Response
     */
    public function edit(ClientWorking $clientWorking)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateClientWorkingRequest  $request
     * @param  \App\Models\ClientWorking  $clientWorking
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateClientWorkingRequest $request, ClientWorking $clientWorking)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\ClientWorking  $clientWorking
     * @return \Illuminate\Http\Response
     */
    public function destroy(ClientWorking $clientWorking)
    {
        //
    }
}
