<?php

namespace App\Http\Controllers;

use App\Models\Assigned_activity;
use App\Models\Quality_indicator;
use App\Models\User;
use Illuminate\Http\Request;
use stdClass;
/**
 * Controlador para la gestión de actividades asignadas.
 *
 * Este controlador maneja las operaciones CRUD (Crear, Leer, Actualizar, Eliminar)
 * para las actividades asignadas en el sistema, así como acciones adicionales
 * como la actualización de estado y la gestión de indicadores de calidad.
 *
 * @category Controller
 * @package  App\Http\Controllers
 */
class AssignedActivityController extends Controller
{
    /**
     * Mostrar una lista de todas las actividades asignadas.
     *
     * Este método recupera todas las actividades asignadas y las devuelve
     * en formato JSON.
     *
     * @return \Illuminate\Http\Response Respuesta con la lista de actividades asignadas.
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
     * Almacenar una nueva actividad asignada en la base de datos.
     *
     * Este método valida y crea una nueva actividad asignada a partir de los datos recibidos
     * en la solicitud, y también crea los indicadores de calidad asociados.
     *
     * @param  \Illuminate\Http\Request  $request La solicitud HTTP con los datos de la nueva actividad asignada.
     * @return \Illuminate\Http\Response Respuesta JSON indicando el éxito de la operación.
     */
    public function store(Request $request)
    {

        $assigned_activity = Assigned_activity::create([
            'assigned_activitiable_type' => 'App\Models\Delivery',
            'assigned_activitiable_id' => $request->get('deliveryId'),
            'name' => $request->get('name'),
            'end_date' => $request->get('end_date'),
            'status' => null,
            'type' => 0,
            'academic_process_id' => $request->get('academic_process_id') ? $request->get('academic_process_id') : null
        ]);

        $indicators = json_decode($request->get('indicators'), true);

        foreach ($indicators as $indicator) {
            $newIndicator = Quality_indicator::create([
                'quality_indicable_id' => $assigned_activity->id,
                'quality_indicable_type' => 'App\Models\Assigned_activity',
                'name' => $indicator['value'],
                'status' => 0
            ]);
        }

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
     * Actualizar una actividad asignada existente en la base de datos.
     *
     * Este método valida y actualiza los datos de una actividad asignada específica
     * según los datos proporcionados en la solicitud.
     *
     * @param  \Illuminate\Http\Request  $request La solicitud HTTP con los nuevos datos de la actividad asignada.
     * @param  int  $id El ID de la actividad asignada a actualizar.
     * @return \Illuminate\Http\Response Respuesta JSON indicando el éxito de la operación.
     */
    public function update(Request $request, $id)
    {
        $assigned_activity = Assigned_activity::find($id);

        $quality_indicators = Quality_indicator::where('quality_indicable_id', $id)->where('quality_indicable_type', 'App\Models\Assigned_activity')->get();

        $quality_indicators->each->delete();

        $indicators = json_decode($request->get('indicators'), true);

        foreach ($indicators as $indicator) {
            $newIndicator = Quality_indicator::create([
                'quality_indicable_id' => $assigned_activity->id,
                'quality_indicable_type' => 'App\Models\Assigned_activity',
                'name' => $indicator['name'],
                'status' => 0,
                'type' => 0
            ]);
        }

        return response()->json([
            'msg' => 'success'
        ]);
    }

    /**
     * Eliminar una actividad asignada de la base de datos.
     *
     * Este método elimina una actividad asignada específica según el ID proporcionado,
     * así como sus indicadores de calidad asociados.
     *
     * @param  int  $id El ID de la actividad asignada a eliminar.
     * @return \Illuminate\Http\Response Respuesta JSON indicando el éxito de la operación.
     */
    public function destroy($id)
    {
        $assigned_activity = Assigned_activity::find($id);

        $quality_indicators = Quality_indicator::where('quality_indicable_id', $id)->where('quality_indicable_type', 'App\Models\Assigned_activity')->get();

        $quality_indicators->each->delete();

        $assigned_activity->delete();

        return response()->json([
            'msg' => 'success'
        ]);
    }
    /**
     * Obtener las actividades asignadas para un equipo específico.
     *
     * Este método recupera las actividades asignadas que pertenecen a los usuarios
     * de un equipo determinado y que tienen un estado específico.
     *
     * @param  int  $team_id El ID del equipo cuyos miembros se están consultando.
     * @return \Illuminate\Http\Response Respuesta con las actividades asignadas del equipo.
     */
    public function revision($team_id)
    {
        $users = User::where('team_id', $team_id)->pluck('id');

        $assignedActivities = Assigned_activity::whereIn('user_id', $users)->where('status', 4)
            ->with(['user', 'quality_indicators', 'assigned_activitiable', 'assigned_activitiable.project'])->orderBy('updated_at', 'desc')->get();

        return response()->json($assignedActivities);
    }
    /**
     * Actualizar los puntos de una actividad asignada.
     *
     * Este método actualiza la cantidad de puntos de una actividad asignada específica.
     *
     * @param  int  $id El ID de la actividad asignada a actualizar.
     * @param  int  $points La nueva cantidad de puntos.
     * @return \Illuminate\Http\Response Respuesta JSON indicando el éxito de la operación.
     */
    public function points($id, $points)
    {
        $assigned_activity = Assigned_activity::find($id);
        $assigned_activity->update([
            'points' => $points
        ]);

        return response()->json([
            'msg' => 'success'
        ]);
    }
    /**
     * Actualizar la prioridad de una actividad asignada.
     *
     * Este método actualiza el nivel de prioridad de una actividad asignada específica.
     *
     * @param  int  $id El ID de la actividad asignada a actualizar.
     * @param  int  $priority El nuevo nivel de prioridad.
     * @return \Illuminate\Http\Response Respuesta JSON indicando el éxito de la operación.
     */
    public function priority($id, $priority)
    {
        $assigned_activity = Assigned_activity::find($id);
        $assigned_activity->update([
            'priority' => $priority
        ]);

        return response()->json([
            'msg' => 'success'
        ]);
    }
    /**
     * Actualizar el estado de una actividad asignada a "en proceso".
     *
     * Este método cambia el estado de una actividad asignada a 1 y establece la fecha de inicio.
     *
     * @param  int  $id El ID de la actividad asignada a actualizar.
     * @return \Illuminate\Http\Response Respuesta JSON indicando el éxito de la operación.
     */
    public function kanban($id)
    {
        $assigned_activity = Assigned_activity::find($id);
        $assigned_activity->update([
            'status' => 1,
            'start_date' => now()
        ]);

        return response()->json([
            'msg' => 'success'
        ]);
    }
    /**
     * Actualizar el nombre de una actividad asignada.
     *
     * Este método permite cambiar el nombre de una actividad asignada específica.
     *
     * @param  int  $id El ID de la actividad asignada a actualizar.
     * @param  string  $name El nuevo nombre para la actividad asignada.
     * @return \Illuminate\Http\Response Respuesta JSON indicando el éxito de la operación.
     */
    public function updateName($id, $name)
    {
        $assigned_activity = Assigned_activity::find($id);
        $assigned_activity->update([
            'name' => $name
        ]);

        return response()->json([
            'msg' => 'success'
        ]);
    }
    /**
     * Actualizar el usuario asignado a una actividad.
     *
     * Este método cambia el usuario asignado a una actividad asignada específica.
     *
     * @param  int  $id El ID de la actividad asignada a actualizar.
     * @param  int  $uid El ID del nuevo usuario a asignar.
     * @return \Illuminate\Http\Response Respuesta JSON indicando el éxito de la operación y el nombre del usuario asignado.
     */
    public function updateUser($id, $uid)
    {
        $assigned_activity = Assigned_activity::find($id);
        $assigned_activity->update([
            'user_id' => $uid
        ]);

        $user = User::find($uid);

        return response()->json([
            'msg' => 'success',
            'name' => $user->name
        ]);
    }
    /**
     * Aprobar una actividad asignada.
     *
     * Este método cambia el estado de una actividad asignada a "aprobada" y registra la fecha de verificación.
     *
     * @param  int  $id El ID de la actividad asignada a aprobar.
     * @return \Illuminate\Http\Response Respuesta JSON indicando el éxito de la operación.
     */
    public function approve($id)
    {
        $assigned_activity = Assigned_activity::find($id);
        $assigned_activity->update([
            'status' => 5,
            'verified_date' => now()
        ]);
        return response()->json([
            'msg' => 'success'
        ]);
    }
    /**
     * Obtener los puntos totales aprobados para un usuario en el día actual.
     *
     * Este método suma todos los puntos de las actividades aprobadas de un usuario
     * que fueron verificadas en la fecha actual.
     *
     * @param  int  $user_id El ID del usuario cuyas actividades se están consultando.
     * @return \Illuminate\Http\Response Respuesta JSON con el total de puntos.
     */
    public function approved($user_id)
    {
        $assignedActivities = Assigned_activity::where('user_id', $user_id)->where('verified_date', 'like', date("Y-m-d") . "%")->get();

        $totalPoints = 0;

        foreach ($assignedActivities as $activity) {
            $totalPoints += $activity->points;
        }

        return response()->json([
            'points' => $totalPoints
        ]);
    }
    /**
     * Obtener los puntos por equipo en una semana específica.
     *
     * Este método recupera los puntos acumulados por cada usuario de un equipo
     * en un rango de fechas de la semana actual.
     *
     * @param  int  $team_id El ID del equipo cuyas actividades se están consultando.
     * @return \Illuminate\Http\Response Respuesta JSON con los puntos acumulados por usuario.
     */
    public function pointsByTeam($team_id)
    {

        $sunday = date('Y-m-d', strtotime('last Sunday'));
        $saturday = date('Y-m-d', strtotime('saturday this week'));

        $users = User::where('team_id', $team_id)->with(['assigned_activities' => function ($query) use ($sunday, $saturday) {
            $query->whereBetween('verified_date', [$sunday, $saturday])->orderBy('verified_date', 'asc')->get();
        }])->get();

        $dates = array();

        for ($i = 0; $i < 7; $i++) {
            $timestamp = strtotime($sunday . ' +' . $i . ' day');
            $formatTime = date('Y-m-d', $timestamp);

            $dayAndPoints = new stdClass();
            $dayAndPoints->date = $formatTime;
            $dayAndPoints->points = 0;
            $dayAndPoints->foundedActivities = array();

            array_push($dates, $dayAndPoints);
        }

        foreach ($users as $user) {
            // Clona el array $dates para el usuario actual
            $userDates = array_map(function ($date) {
                return (object) ['date' => $date->date, 'points' => $date->points];
            }, $dates);

            foreach ($user->assigned_activities as $assigned_activity) {
                $formattedDate = date('Y-m-d', strtotime($assigned_activity->verified_date));
                $dateFounded = array_search($formattedDate, array_column($userDates, 'date'));
                if ($dateFounded !== false) {
                    $userDates[$dateFounded]->points += $assigned_activity->points;
                }
            }

            // Asigna la copia del array $dates al usuario
            $user->datesAndpoints = $userDates;
        }

        return response()->json([
            'usersAndPoints' => $users
        ]);
    }
    /**
     * Rechazar una actividad asignada.
     *
     * Este método actualiza el estado de una actividad asignada a "rechazada" y
     * también actualiza los indicadores de calidad asociados con observaciones.
     *
     * @param  \Illuminate\Http\Request  $request La solicitud HTTP con los datos de rechazo.
     * @return \Illuminate\Http\Response Respuesta JSON indicando el éxito de la operación.
     */
    public function reject(Request $request)
    {
        $assigned_activity = Assigned_activity::find($request->get('assignedActivityId'));

        $assigned_activity->update([
            'status' => 2,
            'type' => 1
        ]);

        $indicators = json_decode($request->get('indicators'), true);

        foreach ($indicators as $indicator) {

            $newIndicator = Quality_indicator::find($indicator['id']);
            $newIndicator->update([
                'observation' => $indicator['observation'],
                'status' => $indicator['status']
            ]);
        }

        return response()->json([
            'msg' => 'success'
        ]);
    }
    /**
     * Actualizar la fecha de finalización de una actividad asignada.
     *
     * Este método permite establecer una nueva fecha de finalización para
     * una actividad asignada específica.
     *
     * @param  \Illuminate\Http\Request  $request La solicitud HTTP con la nueva fecha de finalización.
     * @return \Illuminate\Http\Response Respuesta JSON indicando el éxito de la operación.
     */
    public function updEndDate(Request $request)
    {
        $assigned_activity = Assigned_activity::find($request->get('assignedActivtyId'));

        $assigned_activity->update([
            'end_date' => $request->get('end_date')
        ]);

        return response()->json([
            'msg' => 'success'
        ]);
    }
}
