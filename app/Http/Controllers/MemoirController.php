<?php

namespace App\Http\Controllers;

use App\Models\Memoir;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreMemoirRequest;
use App\Http\Requests\UpdateMemoirRequest;

class MemoirController extends Controller
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
     * @param  \App\Http\Requests\StoreMemoirRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreMemoirRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Memoir  $memoir
     * @return \Illuminate\Http\Response
     */
    public function show(Memoir $memoir)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Memoir  $memoir
     * @return \Illuminate\Http\Response
     */
    public function edit(Memoir $memoir)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateMemoirRequest  $request
     * @param  \App\Models\Memoir  $memoir
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateMemoirRequest $request, Memoir $memoir)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Memoir  $memoir
     * @return \Illuminate\Http\Response
     */
    public function destroy(Memoir $memoir)
    {
        //
    }
}
