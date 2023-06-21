<?php

namespace App\Http\Controllers;

use App\Models\StartupActivity;
use App\Http\Requests\StoreStartupActivityRequest;
use App\Http\Requests\UpdateStartupActivityRequest;

class StartupActivityController extends Controller
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
     * @param  \App\Http\Requests\StoreStartupActivityRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreStartupActivityRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\StartupActivity  $startupActivity
     * @return \Illuminate\Http\Response
     */
    public function show(StartupActivity $startupActivity)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\StartupActivity  $startupActivity
     * @return \Illuminate\Http\Response
     */
    public function edit(StartupActivity $startupActivity)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateStartupActivityRequest  $request
     * @param  \App\Models\StartupActivity  $startupActivity
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateStartupActivityRequest $request, StartupActivity $startupActivity)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\StartupActivity  $startupActivity
     * @return \Illuminate\Http\Response
     */
    public function destroy(StartupActivity $startupActivity)
    {
        //
    }
}
