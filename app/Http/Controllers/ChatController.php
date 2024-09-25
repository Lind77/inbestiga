<?php

namespace App\Http\Controllers;

use App\Events\NewMessage;
use App\Models\Chat;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreChatRequest;
use App\Http\Requests\UpdateChatRequest;
use App\Models\Notification;
use App\Models\Seen;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ChatController extends Controller
{
    /**
     * Display a listing of the chat messages.
     *
     * This method retrieves all chat messages from the database
     * and returns them as a JSON response.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $chats  = Chat::all();
        return response()->json($chats);
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
     * Store a newly created chat message in storage.
     *
     * This method validates the request and creates a new chat message
     * between the sender and receiver. It broadcasts the new message
     * event to notify other users.
     *
     * @param  \Illuminate\Http\Request  $request  The incoming request containing message data.
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $chat = Chat::create([
            'emisor_id' => Auth::id(),
            'receptor_id' => $request->get('receptor_id'),
            'message' => $request->get('message'),
            'viewed' => 0
        ]);

        /* $notification = Notification::create([
            'emisor_id' => Auth::id(),
            'content' => ' te ha enviado un mensaje',
            'type' => 1
        ]);
 */
        /*  $seen = Seen::create([
            'user_id' =>  $request->get('receptor_id'),
            'notification_id' => $notification->id,
            'seen' => 0
        ]);
 */
        broadcast(new NewMessage($chat));

        return response()->json($chat);
    }

    /**
     * Display the specified chat messages for a given receiver.
     *
     * This method retrieves messages for a specific receiver
     * and groups them by sender (emisor). It returns the latest message
     * from each sender as a JSON response.
     *
     * @param  int  $id  The ID of the receiver for whom to retrieve messages.
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $messages = Chat::query()->with(['emisor', 'emisor.images'])->where('receptor_id', $id)->latest('id')->get()->groupBy('emisor_id');

        $messagesFiltered = [];

        foreach ($messages as $message) {
            array_push($messagesFiltered, $message[0]);
        }

        return response()->json($messagesFiltered);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Chat  $chat
     * @return \Illuminate\Http\Response
     */
    public function edit(Chat $chat)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateChatRequest  $request
     * @param  \App\Models\Chat  $chat
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateChatRequest $request, Chat $chat)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Chat  $chat
     * @return \Illuminate\Http\Response
     */
    public function destroy(Chat $chat)
    {
        //
    }
    /**
     * Get all messages between the authenticated user and a specified user.
     *
     * This method retrieves all messages exchanged between the
     * authenticated user and the specified user by ID.
     *
     * @param  int  $id  The ID of the user with whom to retrieve messages.
     * @return \Illuminate\Http\Response
     */
    public function getAllMessagesById($id)
    {

        $emisor_id = Auth::id();

        $messages = Chat::where('receptor_id', $id)
            ->where('emisor_id', $emisor_id)
            ->orWhere('receptor_id', $emisor_id)
            ->where('emisor_id', $id)
            ->get();

        return response()->json($messages);
    }
    /**
     * Get the latest message sent to a specified user.
     *
     * This method retrieves the latest message sent to the specified user
     * and returns it as a JSON response.
     *
     * @param  int  $id  The ID of the user to whom the latest message was sent.
     * @return \Illuminate\Http\Response
     */
    public function newMessage($id)
    {
        $message = Chat::where('receptor_id', $id)->with('emisor')->latest('id')->first();
        return response()->json($message);
    }
     /**
     * Retrieve a list of contacts for the authenticated user.
     *
     * This method retrieves all users except the authenticated user
     * and includes their roles and images. It returns the list as a JSON response.
     *
     * @param  int  $id  The ID of the authenticated user.
     * @return \Illuminate\Http\Response
     */
    public function contacts($id)
    {
        $users = User::where('id', '!=', $id)->with(['roles', 'images'])->get();
        return response()->json($users);
    }
}
