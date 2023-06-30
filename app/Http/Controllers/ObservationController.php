<?php

namespace App\Http\Controllers;

use App\Models\Observation;
use App\Http\Requests\StoreObservationRequest;
use App\Http\Requests\UpdateObservationRequest;
use App\Models\Delivery;
use Illuminate\Http\Request;

class ObservationController extends Controller
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
     * @param  \App\Http\Requests\StoreObservationRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $delivery = Delivery::find($request->get('delivery_id'));

        $delivery->update([
            'date' => $request->get('date')
        ]);

        $observation = Observation::create([
            'observable_id' => $delivery->id,
            'observable_type' => 'App\Models\Delivery',
            'content' => $request->get('content'),
            'status' => 0
        ]);

        return response()->json([
            'msg' => 'success'
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Observation  $observation
     * @return \Illuminate\Http\Response
     */
    public function show(Observation $observation)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Observation  $observation
     * @return \Illuminate\Http\Response
     */
    public function edit(Observation $observation)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateObservationRequest  $request
     * @param  \App\Models\Observation  $observation
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateObservationRequest $request, Observation $observation)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Observation  $observation
     * @return \Illuminate\Http\Response
     */
    public function destroy(Observation $observation)
    {
        //
    }
}
