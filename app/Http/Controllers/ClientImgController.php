<?php

namespace App\Http\Controllers;

use App\Models\ClientImg;
use App\Http\Requests\StoreClientImgRequest;
use App\Http\Requests\UpdateClientImgRequest;

class ClientImgController extends Controller
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
     * @param  \App\Http\Requests\StoreClientImgRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreClientImgRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\ClientImg  $clientImg
     * @return \Illuminate\Http\Response
     */
    public function show(ClientImg $clientImg)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\ClientImg  $clientImg
     * @return \Illuminate\Http\Response
     */
    public function edit(ClientImg $clientImg)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateClientImgRequest  $request
     * @param  \App\Models\ClientImg  $clientImg
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateClientImgRequest $request, ClientImg $clientImg)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\ClientImg  $clientImg
     * @return \Illuminate\Http\Response
     */
    public function destroy(ClientImg $clientImg)
    {
        //
    }
}
