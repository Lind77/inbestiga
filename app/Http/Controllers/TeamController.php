<?php

namespace App\Http\Controllers;

use App\Models\Team;
use App\Http\Requests\StoreTeamRequest;
use App\Http\Requests\UpdateTeamRequest;
use App\Models\Activity;
use App\Models\Project;
use App\Models\User;
use Illuminate\Http\Request;

class TeamController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $teams = Team::with('users')->get();

        return response()->json($teams);
    }

     /**
     * Muestra el formulario para crear un nuevo recurso.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $team = Team::create([
            'name' => $request->get('name')
        ]);

        return response()->json([
            'msg' => 'success'
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreTeamRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreTeamRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Team  $team
     * @return \Illuminate\Http\Response
     */
    public function show(Team $team)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Team  $team
     * @return \Illuminate\Http\Response
     */
    public function edit(Team $team)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateTeamRequest  $request
     * @param  \App\Models\Team  $team
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateTeamRequest $request, Team $team)
    {
        //
    }

    /**
     * Elimina un recurso específico de la base de datos.
     *
     * @param  int  $id ID del equipo a eliminar.
     * @return \Illuminate\Http\Response Mensaje de éxito.
     */
    public function destroy($id)
    {
        $team = Team::find($id);
        $team->delete();
        return response()->json([
            'msg' => 'success'
        ]);
    }
    /**
     * Asigna un equipo a un proyecto específico.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response Mensaje de éxito y datos del proyecto actualizado.
     */
    public function assignTeam(Request $request)
    {
        $project =  Project::find($request->get('contract_id'));

        $project->update([
            'team_id' => $request->get('team_selected')
        ]);

        return response()->json([
            'msg' => 'success',
            'project' => $project
        ]);
    }
    /**
     * Actualiza el equipo de un usuario específico.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response Mensaje de éxito.
     */
    public function updateUserTeam(Request $request)
    {
        $user = User::find($request->get('userId'));
        $user->update([
            'team_id' => $request->get('teamId')
        ]);
        return response()->json([
            'msg' => 'success'
        ]);
    }
}
