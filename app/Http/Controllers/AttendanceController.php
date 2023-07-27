<?php

namespace App\Http\Controllers;

use App\Models\Attendance;
use App\Http\Requests\StoreAttendanceRequest;
use App\Http\Requests\UpdateAttendanceRequest;
use Illuminate\Http\Request;

class AttendanceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $attendances  = Attendance::all();
        return response()->json($attendances);
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
     * @param  \App\Http\Requests\StoreAttendanceRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $attendancesJson = json_decode($request->get('attendances'), true);
        $attendances = $attendancesJson['data'];

        foreach ($attendances as $attendance) {

            if ($attendance['weekday'] == 'Lunes') {
                $newWeekDay = 1;
            } else if ($attendance['weekday'] == 'Martes') {
                $newWeekDay = 2;
            } else if ($attendance['weekday'] == 'Miércoles') {
                $newWeekDay = 3;
            } else if ($attendance['weekday'] == 'Jueves') {
                $newWeekDay = 4;
            } else if ($attendance['weekday'] == 'Viernes') {
                $newWeekDay = 5;
            } else if ($attendance['weekday'] == 'Sábado') {
                $newWeekDay = 6;
            }

            $newAttendance = Attendance::create([
                'user_id' => $attendance['emp_code'],
                'date' => $attendance['att_date'],
                'first_punch' => $attendance['first_punch'],
                'last_punch' => $attendance['last_punch'],
                'weekday' => $newWeekDay
            ]);
        }

        return response()->json([
            'msg' => 'success'
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Attendance  $attendance
     * @return \Illuminate\Http\Response
     */
    public function show(Attendance $attendance)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Attendance  $attendance
     * @return \Illuminate\Http\Response
     */
    public function edit(Attendance $attendance)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateAttendanceRequest  $request
     * @param  \App\Models\Attendance  $attendance
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateAttendanceRequest $request, Attendance $attendance)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Attendance  $attendance
     * @return \Illuminate\Http\Response
     */
    public function destroy(Attendance $attendance)
    {
        //
    }
}
