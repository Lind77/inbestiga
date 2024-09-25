<?php

namespace App\Http\Controllers;

use App\Models\FixedActivity;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreFixedActivityRequest;
use App\Http\Requests\UpdateFixedActivityRequest;
use Illuminate\Http\Request;
/**
 * Class FixedActivityController
 *
 * Controlador para gestionar actividades fijas. Proporciona métodos para listar, crear, mostrar, actualizar y eliminar actividades fijas asociadas a productos.
 *
 * @package App\Http\Controllers
 */
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
     * Almacena una nueva actividad fija en la base de datos.
     *
     * @param  \Illuminate\Http\Request  $request  La solicitud que contiene los datos de la actividad fija a crear.
     * @return \Illuminate\Http\Response  La respuesta HTTP con el resultado del almacenamiento.
     */
    public function store(Request $request)
    {
        $fixed_activity = FixedActivity::create([
            'product_id' => $request->get('product_id'),
            'title' => $request->get('title'),
            'type' => $request->get('type')
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
