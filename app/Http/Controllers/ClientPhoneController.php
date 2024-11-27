<?php

namespace App\Http\Controllers;

use App\Models\ClientPhone;
use App\Http\Requests\StoreClientPhoneRequest;
use App\Http\Requests\UpdateClientPhoneRequest;

class ClientPhoneController extends Controller
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
     * @param  \App\Http\Requests\StoreClientPhoneRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreClientPhoneRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\ClientPhone  $clientPhone
     * @return \Illuminate\Http\Response
     */
    public function show(ClientPhone $clientPhone)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\ClientPhone  $clientPhone
     * @return \Illuminate\Http\Response
     */
    public function edit(ClientPhone $clientPhone)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateClientPhoneRequest  $request
     * @param  \App\Models\ClientPhone  $clientPhone
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateClientPhoneRequest $request, ClientPhone $clientPhone)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\ClientPhone  $clientPhone
     * @return \Illuminate\Http\Response
     */
    public function destroy(ClientPhone $clientPhone)
    {
        //
    }
}
