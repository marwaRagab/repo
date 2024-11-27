<?php

namespace App\Http\Controllers;

use App\Models\ClientAddress;
use App\Http\Requests\StoreClientAddressRequest;
use App\Http\Requests\UpdateClientAddressRequest;

class ClientAddressController extends Controller
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
     * @param  \App\Http\Requests\StoreClientAddressRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreClientAddressRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\ClientAddress  $clientAddress
     * @return \Illuminate\Http\Response
     */
    public function show(ClientAddress $clientAddress)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\ClientAddress  $clientAddress
     * @return \Illuminate\Http\Response
     */
    public function edit(ClientAddress $clientAddress)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateClientAddressRequest  $request
     * @param  \App\Models\ClientAddress  $clientAddress
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateClientAddressRequest $request, ClientAddress $clientAddress)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\ClientAddress  $clientAddress
     * @return \Illuminate\Http\Response
     */
    public function destroy(ClientAddress $clientAddress)
    {
        //
    }
}
