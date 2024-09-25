<?php

namespace App\Http\Controllers;

use App\Models\Task;
use App\Http\Requests\StoreTaskRequest;
use App\Http\Requests\UpdateTaskRequest;
use Illuminate\Http\Request;
use App\Events\NewDoing;
use App\Models\Academic_product;
use App\Models\Assigned_activity;

class TaskController extends Controller
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
     * @param  \App\Http\Requests\StoreTaskRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreTaskRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Task  $task
     * @return \Illuminate\Http\Response
     */
    public function show(Task $task)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Task  $task
     * @return \Illuminate\Http\Response
     */
    public function edit(Task $task)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateTaskRequest  $request
     * @param  \App\Models\Task  $task
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateTaskRequest $request, Task $task)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Task  $task
     * @return \Illuminate\Http\Response
     */
    public function destroy(Task $task)
    {
        //
    }

    public function insertTimeTask(Request $request)
    {
        //update status task
        $task = Task::find($request->get('id_task'));

        $activity = $task->activity;

        $task->update([
            'status' => 1
        ]);

        $task->progress->update([
            'owner' => $request->get('owner'),
            'start_time' => date("Y-m-d H:i:s")
        ]);

        return response()->json([
            'msg' => 'success',
            'task' => $task,
            'activity' => $activity
        ]);
    }
    /**
     * Inserta el tiempo de finalización de una tarea.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response Mensaje de éxito y datos de la tarea.
     */
    public function insertEndTimeTask(Request $request)
    {

        $task = Task::find($request->get('id_task'));

        $task->update([
            'status' => 2
        ]);

        $task->progress->update([
            'end_time' => date("Y-m-d H:i:s"),
            'percentage' => 100
        ]);

        $activity = $task->activity;

        return response()->json([
            'msg' => 'success',
            'task' => $task
        ]);
    }
     /**
     * Inserta el tiempo de inicio de una tarea específica.
     *
     * @param  int  $id ID de la tarea.
     * @return \Illuminate\Http\Response Mensaje de éxito.
     */
    public function insertStartTimeTask($id)
    {
        $task = Task::find($id);
        $task->update([
            'start_time' => time()
        ]);

        return response()->json([
            'msg' => 'success'
        ]);
    }
    /**
     * Cambia el estado de una actividad asignada.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response Mensaje de éxito.
     */
    public function changeStatus(Request $request)
    {

        $assigned_activity = Assigned_activity::find($request->get('taskId'));

        $assigned_activity->update([
            'status' => $request->get('newStatus'),
            'user_id' => $request->get('user_id')
        ]);

        /* $task->update([
            'status' => $newStatus
        ]);

        if($newStatus == 1){ 
            $task->update([
                'start_time' => date('Y-m-d H:i:s')
            ]);
        }

        if($newStatus == 2){ 
            $task->update([
                'end_time' => date('Y-m-d H:i:s')
            ]);
        }

        $task->progress->update([
            'owner' => $request->get('owner')
        ]);

        broadcast(new NewDoing($task)); */

        return response()->json([
            'msg' => 'success'
        ]);
    }

    /**
     * Busca tareas por nombre.
     *
     * @param  string  $name Nombre de la tarea a buscar.
     * @return \Illuminate\Http\Response Lista de productos académicos que coinciden.
     */
    public function searchTask($name)
    {
        $academic_products = Academic_product::with(['acceptance_indicators', 'academic_processes'])->where('name', 'like', '%' . $name . '%')->get();
        return response()->json($academic_products);
    }
}
