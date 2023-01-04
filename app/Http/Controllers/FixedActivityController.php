<?php

namespace App\Http\Controllers;

use App\Models\FixedActivity;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreFixedActivityRequest;
use App\Http\Requests\UpdateFixedActivityRequest;
use Illuminate\Http\Request;

class FixedActivityController extends Controller
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
     * @param  \App\Http\Requests\StoreFixedActivityRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $fixed_activity = FixedActivity::create([
            'product_id' => $request->get('product_id'),
            'title' => $request->get('title')
        ]);
        return response()->json([
            'msg' => 'success'
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\FixedActivity  $fixedActivity
     * @return \Illuminate\Http\Response
     */
    public function show(FixedActivity $fixedActivity)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\FixedActivity  $fixedActivity
     * @return \Illuminate\Http\Response
     */
    public function edit(FixedActivity $fixedActivity)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateFixedActivityRequest  $request
     * @param  \App\Models\FixedActivity  $fixedActivity
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateFixedActivityRequest $request, FixedActivity $fixedActivity)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\FixedActivity  $fixedActivity
     * @return \Illuminate\Http\Response
     */
    public function destroy(FixedActivity $fixedActivity)
    {
        //
    }
}
