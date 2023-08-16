<?php

namespace App\Http\Controllers;

use App\Models\Schedule;
use App\Models\User;
use Illuminate\Http\Request;
use stdClass;

class ScheduleController extends Controller
{
    public function index($id)
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

    public function show($id)
    {
        $schedule = Schedule::find($id);

        return response()->json([
            'schedule' => $schedule
        ]);
    }

    public function store(Request $request)
    {

        $weekdays = json_decode($request->get('weekdays'), true);

        $admission_time = $request->get('admission_time');
        $departure_time = $request->get('departure_time');


        $chunksTimes = [];

        do {
            $new_departure_time = date("H:i", strtotime('+60 minutes', strtotime($admission_time)));
            $newSchedule = (object)[];
            $newSchedule->admission_time = $admission_time;
            $newSchedule->departure_time = $new_departure_time;
            array_push($chunksTimes, $newSchedule);
            $admission_time = $new_departure_time;
        } while ($new_departure_time != $departure_time);


        foreach ($weekdays as $weekday) {
            foreach ($chunksTimes as $chunk) {
                $schedule = Schedule::create([
                    'admission_time' => $chunk->admission_time,
                    'departure_time' => $chunk->departure_time,
                    'type' => $request->get('type'),
                    'day' => $weekday,
                    'week' => 1,
                    'user_id' => $request->get('user_id')
                ]);
            }
        }

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
    public function destroy($id)
    {
        $user = Schedule::find($id);
        $user->delete();
        return response()->json([
            'msg' => 'success'
        ]);
    }

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

    public function schedulesByDay(Request $request)
    {

        $schedules = Schedule::where('day', $request->get('day'))->where('user_id', $request->get('user_id'))->get();
        return response()->json($schedules);
    }
}
