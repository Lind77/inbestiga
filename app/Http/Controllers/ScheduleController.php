<?php

namespace App\Http\Controllers;

use App\Models\Schedule;
use App\Models\User;
use Illuminate\Http\Request;
use stdClass;

class ScheduleController extends Controller
{
    public function index() {}
    /**
     * Muestra los horarios de un usuario específico.
     *
     * @param  int  $id El ID del usuario cuyas citas se van a mostrar.
     * @return \Illuminate\Http\Response Información del usuario y sus horarios.
     */
    public function show($id)
    {
        $user = User::with(['attendances', 'schedules'])->find($id);

        $schedules = $user->schedules;

        $newSchedule = new stdClass();

        $newSchedules = collect();

        for ($i = 1; $i < 7; $i++) {
            $scheduleByDay = $schedules->where('day', $i)->where('type', 1);
            $min = $scheduleByDay->where('admission_time', $scheduleByDay->min('admission_time'))->first();
            $max = $scheduleByDay->where('departure_time', $scheduleByDay->max('departure_time'))->first();

            /* $newSchedule->max_schedule = $max->departure_time;
            $newSchedule->min_schedule = $min->admission_time;
            $newSchedule->weeekDay = $i; */
            $newSchedules = $newSchedules->push($min);
            $newSchedules = $newSchedules->push($max);
            /* if ($min != null || $max != null) {
                
            } */
        }

        return response()->json([
            'user' => $user,
            'newSchedules' => $newSchedules
        ]);
    }
    /**
     * Almacena nuevos horarios en la base de datos.
     *
     * @param  \Illuminate\Http\Request  $request La solicitud que contiene los datos de los horarios.
     * @return \Illuminate\Http\Response Mensaje de éxito.
     */
    public function store(Request $request)
    {
        $weekdays = json_decode($request->get('weekdays'), true);
        $admission_time = $request->get('admission_time');
        $departure_time = $request->get('departure_time');
        $type = $request->get('type');
        $user_id = $request->get('user_id');

        $chunksTimes = [];
        $current_time = $admission_time;

        // Generar los rangos de tiempo en un solo ciclo
        while ($current_time < $departure_time) {
            $new_departure_time = date("H:i", strtotime('+60 minutes', strtotime($current_time)));
            $chunksTimes[] = [
                'admission_time' => $current_time,
                'departure_time' => $new_departure_time
            ];
            $current_time = $new_departure_time;
        }

        // Construir las filas a insertar
        $schedules = [];
        foreach ($weekdays as $weekday) {
            foreach ($chunksTimes as $chunk) {
                $schedules[] = [
                    'admission_time' => $chunk['admission_time'],
                    'departure_time' => $chunk['departure_time'],
                    'type' => $type,
                    'day' => $weekday,
                    'week' => 1,
                    'user_id' => $user_id,
                    'created_at' => now(),
                    'updated_at' => now()
                ];
            }
        }

        // Inserción masiva
        Schedule::insert($schedules);

        /*  do {
            $new_departure_time = date("H:i", strtotime('+60 minutes', strtotime($admission_time)));
            foreach ($weekdays as $weekday) {
                $schedule = Schedule::create([
                    'admission_time' => $admission_time,
                    'departure_time' => $new_departure_time,
                    'type' => $request->get('type'),
                    'day' => $weekday,
                    'week' => 1,
                    'user_id' => $request->get('user_id')
                ]);
                $admission_time = $new_departure_time;
            }
        } while ($admission_time != $departure_time); */

        return response()->json([
            'msg' => 'success'
        ]);
    }

    /**
     * Actualiza un horario específico en la base de datos.
     *
     * @param  \Illuminate\Http\Request  $request La solicitud con los datos a actualizar.
     * @param  int  $id El ID del horario a actualizar.
     * @return \Illuminate\Http\Response Mensaje de éxito.
     */
    public function update(Request $request, $id)
    {
        $firstSchedule = Schedule::find($id);

        $weekDays = json_decode($request->get('weekDays'), true);

        if (count($weekDays) > 0) {
            $schedules = Schedule::where('admission_time', $firstSchedule->admission_time)->where('departure_time', $firstSchedule->departure_time)->where('user_id', $request->get('user_id'))->get();

            foreach ($schedules as $schedule) {
                $schedule->update([
                    'admission_time' => $request->get('admission_time'),
                    'departure_time' => $request->get('departure_time'),
                ]);
            }
        } else {
            $firstSchedule->update([
                'admission_time' => $request->get('admission_time'),
                'departure_time' => $request->get('departure_time'),
            ]);
        }


        return response()->json([
            'msg' => 'success'
        ]);
    }
    /**
     * Elimina un horario específico de la base de datos.
     *
     * @param  int  $id El ID del horario a eliminar.
     * @return \Illuminate\Http\Response Mensaje de éxito.
     */
    public function destroy($id)
    {
        $user = Schedule::find($id);
        $user->delete();
        return response()->json([
            'msg' => 'success'
        ]);
    }
    /**
     * Actualiza el tipo de un horario específico.
     *
     * @param  \Illuminate\Http\Request  $request La solicitud con el nuevo tipo.
     * @param  int  $id El ID del horario a actualizar.
     * @return \Illuminate\Http\Response Mensaje de éxito.
     */
    public function updateType(Request $request, $id)
    {
        $schedule = Schedule::find($id);
        $schedule->update([
            'type' => $request->get('type')
        ]);
        return response()->json([
            'msg' => 'success'
        ]);
    }
    /**
     * Obtiene los horarios de un usuario específico por día.
     *
     * @param  \Illuminate\Http\Request  $request La solicitud con el día y el ID del usuario.
     * @return \Illuminate\Http\Response Lista de horarios.
     */
    public function schedulesByDay(Request $request)
    {

        $schedules = Schedule::where('day', $request->get('day'))->where('user_id', $request->get('user_id'))->get();
        return response()->json($schedules);
    }
    /**
     * Elimina todos los horarios de un usuario específico.
     *
     * @param  int  $id El ID del usuario cuyas citas se van a eliminar.
     * @return \Illuminate\Http\Response Mensaje de éxito.
     */
    public function destroyAll($id)
    {
        $schedules = Schedule::where('user_id', $id)->get();
        $schedules->each->delete();
        return response()->json([
            'msg' => 'success'
        ]);
    }
    /**
     * Actualiza la hora de admisión de un horario específico.
     *
     * @param  int  $id El ID del horario a actualizar.
     * @param  \Illuminate\Http\Request  $request La solicitud con la nueva hora de admisión.
     * @return \Illuminate\Http\Response Mensaje de éxito.
     */
    public function updateHour($id, Request $request)
    {
        $schedule = Schedule::find($id);
        $schedule->update([
            'admission_time' => $request->get('admission_time')
        ]);
        return response()->json([
            'msg' => 'success'
        ]);
    }
    /**
     * Actualiza los horarios anteriores y sus tiempos de salida.
     *
     * @param  \Illuminate\Http\Request  $request La solicitud con los horarios y tiempos a actualizar.
     * @return \Illuminate\Http\Response Mensaje de éxito.
     */
    public function updateTimes(Request $request)
    {
        $past_times = json_decode($request->get('pastHours'), true);

        if ($past_times) {
            foreach ($past_times['schedules'] as $schedule) {
                $scheduleToUpdate = Schedule::find($schedule['id']);
                $scheduleToUpdate->update([
                    'departure_time' => $past_times['end']
                ]);
            }
        }


        $times = json_decode($request->get('hours'), true);

        foreach ($times['schedules'] as $schedule) {
            $scheduleToUpdate = Schedule::find($schedule['id']);
            $scheduleToUpdate->update([
                'admission_time' => $times['start'],
                'departure_time' => $times['end']
            ]);
        }

        return response()->json([
            'msg' => 'success'
        ]);
    }
    /**
     * Actualiza los próximos horarios y sus tiempos de admisión.
     *
     * @param  \Illuminate\Http\Request  $request La solicitud con los próximos horarios y tiempos a actualizar.
     * @return \Illuminate\Http\Response Mensaje de éxito.
     */
    public function updateNextTimes(Request $request)
    {
        $next_times  = json_decode($request->get('nextHours'), true);

        if ($next_times) {
            foreach ($next_times['schedules'] as $schedule) {
                $scheduleToUpdate = Schedule::find($schedule['id']);
                $scheduleToUpdate->update([
                    'admission_time' => $next_times['start']
                ]);
            }
        }


        $times = json_decode($request->get('hours'), true);

        foreach ($times['schedules'] as $schedule) {
            $scheduleToUpdate = Schedule::find($schedule['id']);
            $scheduleToUpdate->update([
                'admission_time' => $times['start'],
                'departure_time' => $times['end']
            ]);
        }

        return response()->json([
            'msg' => 'success'
        ]);
    }
}
