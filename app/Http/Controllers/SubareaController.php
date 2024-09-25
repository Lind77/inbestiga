<?php

namespace App\Http\Controllers;

use App\Models\Subarea;
use Illuminate\Http\Request;

class SubareaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $subareas = Subarea::with(['area', 'roles'])->get();
        return response()->json($subareas);
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
     * Almacena un nuevo recurso en la base de datos.
     *
     * @param  \Illuminate\Http\Request  $request La solicitud con los datos del recurso.
     * @return \Illuminate\Http\Response Mensaje de éxito.
     */
    public function store(Request $request)
    {
        $subarea = Subarea::create($request->all());
        return response()->json([
            'msg' => 'success'
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
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
     * Elimina un recurso específico de la base de datos.
     *
     * @param  int  $id El ID del recurso a eliminar.
     * @return \Illuminate\Http\Response Mensaje de éxito.
     */
    public function destroy($id)
    {
        $subarea = Subarea::find($id);
        $subarea->delete();
        return response()->json([
            'msg' => 'success'
        ]);
    }
}
