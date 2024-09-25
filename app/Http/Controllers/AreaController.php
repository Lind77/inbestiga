<?php

namespace App\Http\Controllers;

use App\Models\Area;

use Illuminate\Http\Request;
/**
 * Controlador para la gestión de áreas.
 *
 * Este controlador maneja las operaciones CRUD (Crear, Leer, Actualizar, Eliminar)
 * para las áreas en el sistema.
 *
 * @category Controller
 * @package  App\Http\Controllers
 */
class AreaController extends Controller
{
     /**
     * Mostrar una lista de todas las áreas.
     *
     * Este método recupera todas las áreas de la base de datos y las devuelve
     * en formato JSON.
     *
     * @return \Illuminate\Http\Response Respuesta con la lista de áreas.
     */
    public function index()
    {
        $areas = Area::all();
        return response()->json($areas);
    }

    /**
     * Mostrar el formulario para crear una nueva área.
     *
     * Este método se puede utilizar para devolver una vista con un formulario
     * para la creación de una nueva área. Actualmente no implementado.
     *
     * @return \Illuminate\Http\Response La vista con el formulario de creación.
     */
    public function create()
    {
        //
    }

    /**
     * Almacenar una nueva área en la base de datos.
     *
     * Este método valida y crea una nueva área a partir de los datos recibidos
     * en la solicitud.
     *
     * @param  \Illuminate\Http\Request  $request La solicitud HTTP con los datos de la nueva área.
     * @return \Illuminate\Http\Response Respuesta JSON indicando el éxito de la operación.
     */
    public function store(Request $request)
    {
        $area = Area::create([
            'name' => $request->get('name')
        ]);
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
     * Eliminar una área de la base de datos.
     *
     * Este método elimina una área específica según el ID proporcionado.
     *
     * @param  int  $id El ID de la área a eliminar.
     * @return \Illuminate\Http\Response Respuesta JSON indicando el éxito de la operación.
     */
    public function destroy($id)
    {
        $area = Area::find($id);
        $area->delete();

        return response()->json([
            'msg' => 'success'
        ]);
    }
     /**
     * Actualizar la jerarquía de una área.
     *
     * Este método permite actualizar el campo 'hierarchy' de un área
     * específica según el ID y el nuevo valor proporcionado en la solicitud.
     *
     * @param  \Illuminate\Http\Request  $request La solicitud HTTP con el ID del área y la nueva jerarquía.
     * @return \Illuminate\Http\Response Respuesta JSON indicando el éxito de la operación.
     */
    public function hierarchy(Request $request)
    {
        $area = Area::find($request->get('areaId'));

        $area->update([
            'hierarchy' => $request->get('hierarchy')
        ]);

        return response()->json([
            'msg' => 'success'
        ]);
    }
}
