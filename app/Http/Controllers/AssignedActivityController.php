<?php

namespace App\Http\Controllers;

use App\Models\Assigned_activity;
use App\Models\Quality_indicator;
use App\Models\User;
use Illuminate\Http\Request;

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
            'date' => $request->get('date'),
            'status' => 0
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
                'status' => 0
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

    public function revision()
    {
        $assigned_activity = Assigned_activity::where('status', 4)->with(['user'])->orderBy('updated_at', 'desc')->get();

        return response()->json($assigned_activity);
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
            'status' => 1
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
            'status' => 5
        ]);
        return response()->json([
            'msg' => 'success'
        ]);
    }
}
