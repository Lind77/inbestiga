<?php

namespace App\Http\Controllers;

use App\Models\Comission;
use App\Http\Requests\StoreComissionRequest;
use App\Http\Requests\UpdateComissionRequest;

class ComissionController extends Controller
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
     * @param  \App\Http\Requests\StoreComissionRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreComissionRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Comission  $comission
     * @return \Illuminate\Http\Response
     */
    public function show(Comission $comission)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Comission  $comission
     * @return \Illuminate\Http\Response
     */
    public function edit(Comission $comission)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateComissionRequest  $request
     * @param  \App\Models\Comission  $comission
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateComissionRequest $request, Comission $comission)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Comission  $comission
     * @return \Illuminate\Http\Response
     */
    public function destroy(Comission $comission)
    {
        //
    }

    public function getAllComissions(){
        $comissions = Comission::all();

        return response()->json($comissions);
    }
}
