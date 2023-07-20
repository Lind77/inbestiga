<?php

namespace App\Http\Controllers;

use App\Models\Schedule;
use Illuminate\Http\Request;

class ScheduleController extends Controller
{
    public function index()
    {
        $schedules=Schedule::all();
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
        $schedule = Schedule::create([
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

    public function update(Request $request, $id){
        $schedule = Schedule::find($id);
        $schedule->update([
            'admission_time' => $request->get('admission_time'),
            'departure_time' => $request->get('departure_time'),
            'type' => $request->get('type'),
            'day' => $request->get('day'),
            'week' => $request->get('week'),
            'user_id'=>$request->get('user_id')
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
