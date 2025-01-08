<?php

namespace App\Http\Controllers;

use App\Models\Addendum;
use App\Http\Requests\StoreAddendumRequest;
use App\Http\Requests\UpdateAddendumRequest;
use App\Models\Contract;
use Illuminate\Http\Request;

/**
 * Controlador para la gestión de addendums.
 *
 * Este controlador maneja las operaciones CRUD (Crear, Leer, Actualizar, Eliminar)
 * para los addendums dentro de la aplicación.
 *
 * @category Controller
 * @package  App\Http\Controllers
 */
class AddendumController extends Controller
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
     * @param  \App\Http\Requests\StoreAddendumRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $contract = Contract::find($request->contract_id);

        $contract->addendums()->create([
            "date" => date('Y-m-d'),
            "object" => $request->object,
            "clausule" => $request->clausule,
            "status" => 0,
            "amount" => $request->amount,
            "user_id" => $request->user_id
        ]);

        return $contract;
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Addendum  $addendum
     * @return \Illuminate\Http\Response
     */
    public function show(Addendum $addendum)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Addendum  $addendum
     * @return \Illuminate\Http\Response
     */
    public function edit(Addendum $addendum)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateAddendumRequest  $request
     * @param  \App\Models\Addendum  $addendum
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateAddendumRequest $request, Addendum $addendum)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Addendum  $addendum
     * @return \Illuminate\Http\Response
     */
    public function destroy(Addendum $addendum)
    {
        //
    }
}
