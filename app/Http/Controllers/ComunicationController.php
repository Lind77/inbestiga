<?php

namespace App\Http\Controllers;

use App\Models\Comunication;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreComunicationRequest;
use App\Http\Requests\UpdateComunicationRequest;
use Illuminate\Http\Request;

class ComunicationController extends Controller
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
     * @param  \App\Http\Requests\StoreComunicationRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreComunicationRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Comunication  $comunication
     * @return \Illuminate\Http\Response
     */
    public function show(Comunication $comunication)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Comunication  $comunication
     * @return \Illuminate\Http\Response
     */
    public function edit(Comunication $comunication)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateComunicationRequest  $request
     * @param  \App\Models\Comunication  $comunication
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $comunication = Comunication::find($request->get('comunication_id'));

        $comunication->update([
            'last_management' => $request->get('last_management'),
            'next_management' => $request->get('next_management'),
            'comment' => $request->get('comment'),
            'product_tentative' => $request->get('product_tentative'),
            'type' => $request->get('type')
        ]);

        return response()->json([
            'msg' => 'success'
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Comunication  $comunication
     * @return \Illuminate\Http\Response
     */
    public function destroy(Comunication $comunication)
    {
        //
    }
}
