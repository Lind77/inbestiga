<?php

namespace App\Http\Controllers;

use App\Models\Assigned_activity;
use App\Models\Quality_indicator;
use App\Models\User;
use Illuminate\Http\Request;
use stdClass;

class AssignedActivityController extends Controller
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
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
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
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
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
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
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

    public function revision($team_id)
    {
        $users = User::where('team_id', $team_id)->pluck('id');

        $assignedActivities = Assigned_activity::whereIn('user_id', $users)->where('status', 4)
            ->with(['user', 'quality_indicators', 'assigned_activitiable', 'assigned_activitiable.project'])->orderBy('updated_at', 'desc')->get();

        return response()->json($assignedActivities);
    }

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
