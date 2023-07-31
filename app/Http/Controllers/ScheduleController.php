<?php

namespace App\Http\Controllers;

use App\Models\Schedule;
use Illuminate\Http\Request;

class ScheduleController extends Controller
{
    public function index()
    {
        $schedules = Schedule::all();
        return response()->json($schedules);
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

        do {
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
        } while ($admission_time != $departure_time);

        return response()->json([
            'msg' => 'success'
        ]);
    }

    public function update(Request $request, $id)
    {
        $schedule = Schedule::find($id);
        $schedule->update([
            'admission_time' => $request->get('admission_time'),
            'departure_time' => $request->get('departure_time'),
            'type' => $request->get('type'),
            'day' => $request->get('day'),
            'week' => $request->get('week'),
            'user_id' => $request->get('user_id')
        ]);
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
}
