<?php

namespace App\Http\Controllers;

use App\Models\FixedTask;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreFixedTaskRequest;
use App\Http\Requests\UpdateFixedTaskRequest;
use Illuminate\Http\Request;

class FixedTaskController extends Controller
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
     * @param  \App\Http\Requests\StoreFixedTaskRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $fixed_task = FixedTask::create([
            'fixed_activity_id' => $request->get('fixed_activity_id'),
            'title' => $request->get('title')
        ]);
        return response()->json([
            'msg' => 'success'
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\FixedTask  $fixedTask
     * @return \Illuminate\Http\Response
     */
    public function show(FixedTask $fixedTask)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\FixedTask  $fixedTask
     * @return \Illuminate\Http\Response
     */
    public function edit(FixedTask $fixedTask)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateFixedTaskRequest  $request
     * @param  \App\Models\FixedTask  $fixedTask
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateFixedTaskRequest $request, FixedTask $fixedTask)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\FixedTask  $fixedTask
     * @return \Illuminate\Http\Response
     */
    public function destroy(FixedTask $fixedTask)
    {
        //
    }
}
