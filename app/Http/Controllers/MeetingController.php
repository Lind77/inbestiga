<?php

namespace App\Http\Controllers;

use App\Models\Meeting;
use Illuminate\Http\Request;

class MeetingController extends Controller
{
    public function index()
    {
        $meetings = Meeting::all();
        foreach ($meetings as $meeting) {
            if ($meeting->time) {
                $meeting->date = $meeting->date . ' ' . $meeting->time;
                $meeting->start = $meeting->date;
                $meeting->end = $meeting->date;
            }
        }
        return response()->json($meetings);
    }

    public function store(Request $request)
    {
        $meeting = Meeting::create([
            'title' => $request->get('title'),
            'date' => $request->get('date'),
            'time' => $request->get('time'),
            'link' => $request->get('link'),
            'comment' => $request->get('comment'),
            'status' => 0
        ]);

        $meeting->users()->attach($meeting->id);

        return response()->json([
            'msg' => 'success'
        ]);
    }

    public function destroy($id)
    {
        $meeting = Meeting::find($id);

        $meeting->delete();

        return response()->json([
            'msg' => 'success'
        ]);
    }

    public function update($id, Request $request)
    {
        $meeting = Meeting::find($id);
        $meeting->update([
            'date' => $request->get('date')
        ]);
        return response()->json([
            'msg' => 'success'
        ]);
    }

    public function complete($id)
    {
        $meeting = Meeting::find($id);
        $meeting->update([
            'status' => 1
        ]);
        return response()->json([
            'msg' => 'success'
        ]);
    }
}
