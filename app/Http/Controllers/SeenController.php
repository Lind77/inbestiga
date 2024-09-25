<?php

namespace App\Http\Controllers;

use App\Models\Seen;
use App\Http\Requests\StoreSeenRequest;
use App\Http\Requests\UpdateSeenRequest;
use Illuminate\Http\Request;

class SeenController extends Controller
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
     * @param  \App\Http\Requests\StoreSeenRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreSeenRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Seen  $seen
     * @return \Illuminate\Http\Response
     */
    public function show(Seen $seen)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Seen  $seen
     * @return \Illuminate\Http\Response
     */
    public function edit(Seen $seen)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateSeenRequest  $request
     * @param  \App\Models\Seen  $seen
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateSeenRequest $request, Seen $seen)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Seen  $seen
     * @return \Illuminate\Http\Response
     */
    public function destroy(Seen $seen)
    {
        //
    }
    /**
     * Registra que un recurso ha sido visto.
     *
     * @param  int  $id El ID del recurso a marcar como visto.
     * @return \Illuminate\Http\Response Mensaje de éxito.
     */
    public function registerSeen($id){
        $seen = Seen::find($id);

        $seen->update([
            'seen' => 1
        ]);

        return response()->json([
            'msg' => 'success'
        ]);
    }
}
