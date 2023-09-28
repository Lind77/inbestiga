<?php

namespace App\Http\Controllers;

use App\Models\Notification;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreNotificationRequest;
use App\Http\Requests\UpdateNotificationRequest;
use App\Models\Project;
use App\Models\Seen;
use App\Models\User;
use Illuminate\Http\Request;

class NotificationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $notifications = Notification::with('user')->orderBy('id', 'desc')->take(5)->get();

        return response()->json($notifications);
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
     * @param  \App\Http\Requests\StoreNotificationRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreNotificationRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Notification  $notification
     * @return \Illuminate\Http\Response
     */
    public function show(Notification $notification)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Notification  $notification
     * @return \Illuminate\Http\Response
     */
    public function edit(Notification $notification)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateNotificationRequest  $request
     * @param  \App\Models\Notification  $notification
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateNotificationRequest $request, Notification $notification)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Notification  $notification
     * @return \Illuminate\Http\Response
     */
    public function destroy(Notification $notification)
    {
        //
    }

    public function getNoSeenNotifications($id)
    {
        $seens = Seen::where('user_id', $id)->where('seen', 0)->orderBy('id', 'desc')->take(5)->get();

        $notSeenNotifications = [];

        foreach ($seens as $seen) {
            $notification = Notification::with(['users', 'emisor'])->find($seen->notification_id);
            array_push($notSeenNotifications, $notification);
        }

        return response()->json($notSeenNotifications);
    }

    public function getAllNotifications($id)
    {
        $seens = Seen::where('user_id', $id)->where('seen', 0)->orderBy('id', 'desc')->get();

        $notifications = [];

        foreach ($seens as $seen) {
            $notification = Notification::with(['users', 'emisor'])->find($seen->notification_id);
            array_push($notifications, $notification);
        }

        return response()->json($notifications);
    }

    public function insertReject(Request $request)
    {
        $project = Project::find($request->get('project_id'));

        $notification = Notification::create([
            'emisor_id' => $request->get('emisor_id'),
            'content' => 'ha rechazado el ' . $project->title . ' en la fase de ' . $request->get('title'),
            'type' => 2,
            'extra' =>  $request->get('extra')
        ]);

        $usersToNotify = User::role('AdminAcad')->get();

        foreach ($usersToNotify as $user) {
            Seen::create([
                'user_id' => $user->id,
                'notification_id' => $notification->id,
                'seen' => 0
            ]);
        }

        return response()->json([
            'msg' => 'success'
        ]);
    }

    public function addNotificationComunication(Request $request)
    {
        $notification = Notification::create([
            'emisor_id' => $request->get('owner'),
            'content' => 'Tienes una comunicación pendiente con ' . $request->get('customerName') . ' a las ' . $request->get('time'),
            'type' => 2,
            'extra' =>  '-'
        ]);

        Seen::create([
            'user_id' => $request->get('owner'),
            'notification_id' => $notification->id,
            'seen' => 0
        ]);

        return response()->json([
            'msg' => 'success'
        ]);
    }
}
