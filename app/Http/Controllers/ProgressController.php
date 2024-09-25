<?php

namespace App\Http\Controllers;

use App\Events\NewUpdate;
use App\Models\Progress;
use App\Http\Requests\StoreProgressRequest;
use App\Http\Requests\UpdateProgressRequest;
use App\Models\Activity;
use App\Models\Notification;
use App\Models\Project;
use App\Models\Seen;
use App\Models\User;
use Illuminate\Http\Request;

class ProgressController extends Controller
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
     * @param  \App\Http\Requests\StoreProgressRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreProgressRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Progress  $progress
     * @return \Illuminate\Http\Response
     */
    public function show(Progress $progress)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Progress  $progress
     * @return \Illuminate\Http\Response
     */
    public function edit(Progress $progress)
    {
        //
    }

    /**
     * Actualizar el recurso especificado en almacenamiento.
     *
     * @param  \Illuminate\Http\Request  $request  La solicitud que contiene los datos actualizados del progreso.
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $activity = Activity::find($request->get('id'));

        $progress = Progress::where('progressable_type', 'App\Models\Activity')->where('progressable_id', $request->get('id'))->get();

        $project = Project::find($request->get('project_id'));

        if($request->get('comment')){
            $project->update([
                'aditional' =>  $request->get('comment')
            ]);
        }

        $progress[0]->update([
            'comment' => $request->get('comment'),
            'percentage' => 100
        ]);

        $notification = Notification::create([
            'emisor_id' => $request->get('emisor_id'),
            'content' => 'completó '.$activity->title.' del '.$project->title,
            'type' => 1
        ]);

        $userEmisor = User::with('roles')->find($request->get('emisor_id'));

        $roleName = $userEmisor->roles->first()->name;

        if($roleName == 'AdminAcad'){
            $usersToNotify = User::role('Experience')->get();
        }else{
            $usersToNotify = User::role('AdminAcad')->get();
        }
       
        foreach($usersToNotify as $user){
            Seen::create([
                'user_id' => $user->id,
                'notification_id' => $notification->id,
                'seen' => 0
            ]);
        }

        broadcast(new NewUpdate($activity));

        return response()->json([
            'msg' => 'success'
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Progress  $progress
     * @return \Illuminate\Http\Response
     */
    public function destroy(Progress $progress)
    {
        //
    }
     /**
     * Insertar detalles de la primera reunión.
     *
     * @param  \Illuminate\Http\Request  $request  La solicitud que contiene los datos de la reunión.
     * @return \Illuminate\Http\Response
     */
    public function insertDetailsFirstMeeting(Request $request){
        $progress = Progress::where('progressable_id', $request->get('activityId'))->where('progressable_type','App\Models\Activity')->get();

        $progress[0]->update([
            'comment' => $request->get('detail'),
            'percentage' => 100
        ]);

        return response()->json([
            'msg' => 'progress updated successfully'
        ]);
    }
    /**
     * Actualizar el progreso de la actividad.
     *
     * @param  int  $id  El ID de la actividad a actualizar.
     * @return \Illuminate\Http\Response
     */
    public function updateActivityProgress($id){
        $activity = Activity::find($id);
        $progress = $activity->progresses[0];
        $progress->update([
            'percentage' => 100
        ]);

        return response()->json([
            'msg' => 'progress updated successfully'
        ]);
    }
    /**
     * Remover el progreso de la actividad.
     *
     * @param  int  $id  El ID de la actividad a remover.
     * @return \Illuminate\Http\Response
     */
    public function removeActivityProgress($id){
        $activity = Activity::find($id);
        $progress = $activity->progresses[0];
        $progress->update([
            'percentage' => 0
        ]);

        return response()->json([
            'msg' => 'progress updated successfully'
        ]);
    }   
    /**
     * Eliminar el progreso de la actividad.
     *
     * @param  \Illuminate\Http\Request  $request  La solicitud que contiene los datos de la actividad.
     * @return \Illuminate\Http\Response
     */
    public function deleteActivityProgress(Request $request){

        $activity = Activity::find($request->get('id'));

        $progress = Progress::where('progressable_type', 'App\Models\Activity')->where('progressable_id', $request->get('id'))->get();

        $project = Project::find($request->get('project_id'));

        if($request->get('comment')){
            $project->update([
                'aditional' =>  $request->get('comment')
            ]);
        }

        $progress[0]->update([
            'comment' => $request->get('comment'),
            'percentage' => 0
        ]);

       /*  $notification = Notification::create([
            'emisor_id' => $request->get('emisor_id'),
            'content' => 'Completó '.$activity->title.'del '.$project->title,
            'type' => 1
        ]);

        $usersToNotify = User::role('AdminAcad')->get();

        foreach($usersToNotify as $user){
            Seen::create([
                'user_id' => $user->id,
                'notification_id' => $notification->id,
                'seen' => 0
            ]);
        } */

        //broadcast(new NewUpdate($activity));

        return response()->json([
            'msg' => 'success'
        ]);
    }
    /**
     * Actualizar la calidad de la actividad.
     *
     * @param  int  $id  El ID de la actividad a actualizar.
     * @return \Illuminate\Http\Response
     */
    public function updateQualityActivity($id){
        $activity = Activity::find($id);

        $activity->update([
            'progress' => 100
        ]);

        return response()->json([
            'msg' => 'success'
        ]);
    }
    /**
     * Remover la calidad de la actividad.
     *
     * @param  int  $id  El ID de la actividad a remover.
     * @return \Illuminate\Http\Response
     */
    public function removeQualityActivity($id){
        $activity = Activity::find($id);

        $activity->update([
            'progress' => 0
        ]);

        return response()->json([
            'msg' => 'success'
        ]);
    }
}
