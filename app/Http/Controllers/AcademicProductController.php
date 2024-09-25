<?php

namespace App\Http\Controllers;

use App\Models\Academic_process;
use App\Models\Academic_product;
use App\Models\Acceptance_indicator;
use App\Models\Assigned_activity;
use Illuminate\Http\Request;

/**
 * Controlador para la gestión de productos académicos.
 *
 * Este controlador maneja las operaciones CRUD (Crear, Leer, Actualizar, Eliminar)
 * para los productos académicos y está relacionado con los procesos académicos.
 *
 * @category Controller
 * @package  App\Http\Controllers
 */
class AcademicProductController extends Controller
{
    /**
     * Muestra una lista de productos académicos y procesos académicos.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $academicProducts = Academic_product::all();
        $academicProcesses = Academic_process::all();
        return response()->json([
            'academicProducts' => $academicProducts,
            'academicProcesses' => $academicProcesses
        ]);
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
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
