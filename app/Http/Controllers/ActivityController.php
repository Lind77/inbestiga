<?php

namespace App\Http\Controllers;

use App\Models\Activity;
use App\Http\Requests\StoreActivityRequest;
use App\Http\Requests\UpdateActivityRequest;
use App\Models\Project;
use Illuminate\Http\Request;
/**
 * Controlador para la gestión de actividades.
 *
 * Este controlador maneja las operaciones CRUD (Crear, Leer, Actualizar, Eliminar)
 * para las actividades dentro de un proyecto.
 *
 * @category Controller
 * @package  App\Http\Controllers
 */
class ActivityController extends Controller
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
     * Almacena una nueva actividad en la base de datos.
     *
     * @param  \Illuminate\Http\Request  $request  Datos enviados para la creación de la actividad.
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $activity = Activity::create([
            'product_id' => $request->get('product_id'),
            'title' => $request->get('title')
        ]);
        return response()->json([
            'msg' => 'success'
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Activity  $activity
     * @return \Illuminate\Http\Response
     */
    public function show(Activity $activity)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Activity  $activity
     * @return \Illuminate\Http\Response
     */
    public function edit(Activity $activity)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateActivityRequest  $request
     * @param  \App\Models\Activity  $activity
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateActivityRequest $request, Activity $activity)
    {
        //
    }

    /**
     * Elimina una actividad específica de la base de datos.
     *
     * @param  int  $id  El identificador de la actividad a eliminar.
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $activity = Activity::find($id);
        $activity->delete();
        return response()->json([
            'msg' => 'success'
        ]);
    }
    /**
     * Cambia el estado de un proyecto a '1'.
     *
     * @param  int  $id  El identificador del proyecto.
     * @return \Illuminate\Http\JsonResponse
     */
    public function changeStatus($id){
        $project = Project::find($id);
        
        $project->update([
            'status' => 1
        ]);
        return $project;
        return response()->json([
            'msg' => 'success'
        ]);
    }   
    /**
     * Obtiene las actividades de un proyecto específico.
     *
     * @param  int  $id  El identificador del proyecto.
     * @return \Illuminate\Http\JsonResponse
     */
    public function getActivitiesPerId($id){
        $activities = Activity::where('project_id', $id)
                                ->where('type', '==', 0)
                                ->with('progresses')
                                ->get();
        return response()->json($activities);
    }
}
