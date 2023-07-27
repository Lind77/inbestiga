<?php

namespace App\Http\Controllers;

use App\Models\Meeting;
use Illuminate\Http\Request;

class MeetingController extends Controller
{
    public function index()
    {
        $meetings = Meeting::all();
        return response()->json($meetings);
    }

    public function store(Request $request)
    {
        $meeting = Meeting::create([
            'title' => $request->get('title'),
            'date' => $request->get('date'),
            'link' => $request->get('link'),
            'comment' => $request->get('comment')
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
}
