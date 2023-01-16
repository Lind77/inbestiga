<?php

namespace App\Http\Controllers;

use App\Models\Task;
use App\Http\Requests\StoreTaskRequest;
use App\Http\Requests\UpdateTaskRequest;
use Illuminate\Http\Request;

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

    public function insertTimeTask(Request $request){
        //update status task
        $task = Task::find($request->get('id_task'));
        
        $activity = $task->activity;

        $task->update([
            'status' => 1
        ]);

        $task->progress[0]->update([
            'owner' => $request->get('owner'),
            'start_time' => date("Y-m-d H:i:s") 
        ]);

        return response()->json([
            'msg' => 'success',
            'task' => $task,
            'activity' => $activity
        ]);
    }

    public function insertEndTimeTask(Request $request){
        $task = Task::find($request->get('id_task'));

        $activity = $task->activity;

        $task->update([
            'status' => 2
        ]);

        $task->progress[0]->update([
            'end_time' => date("Y-m-d H:i:s"),
            'percentage' => 100
        ]);

        return response()->json([
            'msg' => 'success',
            'task' => $task,
            'activity' => $activity
        ]);
    }
}
