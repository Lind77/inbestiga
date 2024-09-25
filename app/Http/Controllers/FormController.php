<?php

namespace App\Http\Controllers;

use App\Models\Form;
use App\Models\Project_situation;
use Illuminate\Http\Request;
/**
 * Class FormController
 *
 * Controlador para gestionar formularios. Proporciona métodos para listar, crear, mostrar, actualizar y eliminar formularios asociados a situaciones de proyecto.
 *
 * @package App\Http\Controllers
 */
class FormController extends Controller
{
      /**
     * Muestra una lista de todos los formularios y situaciones de proyecto.
     *
     * @return \Illuminate\Http\Response  La respuesta HTTP con la lista de formularios y situaciones de proyecto.
     */
    public function index()
    {
        $forms = Form::all();
        $project_situations = Project_situation::all();

        return response()->json([
            'forms' => $forms,
            'project_situations' => $project_situations
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
     * Almacena un nuevo formulario en la base de datos.
     *
     * @param  \Illuminate\Http\Request  $request  La solicitud que contiene los datos del formulario a crear.
     * @return \Illuminate\Http\Response  La respuesta HTTP con el resultado del almacenamiento.
     */
    public function store(Request $request)
    {
        $form = Form::create([
            'name' => $request->get('name'),
            'forms' => $request->get('questions'),
            'project_situation_id' => $request->get('project_situation_id')
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
     * Actualiza un formulario existente en la base de datos.
     *
     * @param  \Illuminate\Http\Request  $request  La solicitud que contiene los datos actualizados del formulario.
     * @param  int  $id  El ID del formulario que se va a actualizar.
     * @return \Illuminate\Http\Response  La respuesta HTTP con el resultado de la actualización.
     */
    public function update(Request $request, $id)
    {
        $form = Form::find($id);

        $form->update([
            'name' => $request->get('name'),
            'forms' => $request->get('questions'),
            'project_situation_id' => $request->get('project_situation_id')
        ]);

        return response()->json([
            'msg' => 'success'
        ]);
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
