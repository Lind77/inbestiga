<?php

namespace App\Http\Controllers;

use App\Models\NewPrice;
use App\Http\Requests\StoreNewPriceRequest;
use App\Http\Requests\UpdateNewPriceRequest;

class NewPriceController extends Controller
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
     * @param  \App\Http\Requests\StoreNewPriceRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreNewPriceRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\NewPrice  $newPrice
     * @return \Illuminate\Http\Response
     */
    public function show(NewPrice $newPrice)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\NewPrice  $newPrice
     * @return \Illuminate\Http\Response
     */
    public function edit(NewPrice $newPrice)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateNewPriceRequest  $request
     * @param  \App\Models\NewPrice  $newPrice
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateNewPriceRequest $request, NewPrice $newPrice)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\NewPrice  $newPrice
     * @return \Illuminate\Http\Response
     */
    public function destroy(NewPrice $newPrice)
    {
        //
    }
}
