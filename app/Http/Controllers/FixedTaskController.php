<?php

namespace App\Http\Controllers;

use App\Models\FixedTask;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreFixedTaskRequest;
use App\Http\Requests\UpdateFixedTaskRequest;
use Illuminate\Http\Request;
/**
 * Class FixedTaskController
 *
 * Controlador para gestionar tareas fijas. Proporciona métodos para listar, crear, mostrar, actualizar y eliminar tareas fijas asociadas a actividades fijas.
 *
 * @package App\Http\Controllers
 */
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
     * Almacena una nueva tarea fija en la base de datos.
     *
     * @param  \Illuminate\Http\Request  $request  La solicitud que contiene los datos de la tarea fija a crear.
     * @return \Illuminate\Http\Response  La respuesta HTTP con el resultado del almacenamiento.
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
