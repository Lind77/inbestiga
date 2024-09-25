<?php

namespace App\Http\Controllers;

use App\Models\Comunication;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreComunicationRequest;
use App\Http\Requests\UpdateComunicationRequest;
use App\Models\User;
use Illuminate\Http\Request;

class ComunicationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * This method retrieves and displays a list of all communications.
     * Currently, the implementation is not provided.
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
     * @param  \App\Http\Requests\StoreComunicationRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreComunicationRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Comunication  $comunication
     * @return \Illuminate\Http\Response
     */
    public function show(Comunication $comunication)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Comunication  $comunication
     * @return \Illuminate\Http\Response
     */
    public function edit(Comunication $comunication)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * This method updates the specified communication based on the provided request.
     *
     * @param  \Illuminate\Http\Request  $request  The request containing updated communication data.
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $comunication = Comunication::find($request->get('comunication_id'));

        $comunication->update([
            'last_management' => $request->get('last_management'),
            'next_management' => $request->get('next_management'),
            'comment' => $request->get('comment'),
            'product_tentative' => $request->get('product_tentative'),
            'type' => $request->get('type')
        ]);

        return response()->json([
            'msg' => 'success'
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Comunication  $comunication
     * @return \Illuminate\Http\Response
     */
    public function destroy(Comunication $comunication)
    {
        //
    }
    /**
     * Insert a new communication record in storage.
     *
     * This method creates a new communication entry with the provided request data.
     *
     * @param  \Illuminate\Http\Request  $request  The request containing communication data to be inserted.
     * @return \Illuminate\Http\Response
     */
    public function insertComunication(Request $request)
    {

        $dateTime = date_create($request->get('next_management'));

        $comunication = Comunication::create([
            'customer_id' => $request->get('customer_id'),
            'first_management' => $request->get('first_management'),
            'last_management' => $request->get('last_management'),
            'next_management' => date_format($dateTime, 'Y-m-d'),
            'comment' => $request->get('comment'),
            'product_tentative' => $request->get('product_tentative'),
            'type' => $request->get('type'),
            'time' => date_format($dateTime, 'H:i:s')
        ]);

        return response()->json([
            'msg' => 'success',
            'comunication' => $comunication
        ]);
    }
    /**
     * Retrieve communications scheduled for today based on user ID.
     *
     * This method retrieves communications for the specified user,
     * filtering by today's date. It handles specific conditions based on user ID.
     *
     * @param  int  $id_user  The ID of the user for whom to retrieve communications.
     * @return \Illuminate\Http\Response
     */
    public function getComunicationsByToday($id_user)
    {
        if ($id_user == 22) {
            $comunications = Comunication::with(['customer', 'customer.user'])
                ->where('next_management', date('Y-m-d'))
                ->('customer', function ($query) {
                    $query->where('user_id', null);
                })
                ->orderBy('time')
                ->get();
        } else {
            $comunications = Comunication::with(['customer', 'customer.user'])
                ->where('next_management', date('Y-m-d'))
                ->whereHas('customer.user', function ($query) use ($id_user) {
                    $query->where('id', $id_user);
                })
                ->orderBy('time')
                ->get();
        }


        return response()->json($comunications);
    }
     /**
     * Update the attended status of a communication.
     *
     * This method marks the specified communication as attended.
     *
     * @param  int  $comunicationId  The ID of the communication to be updated.
     * @return \Illuminate\Http\Response
     */
    public function updateComunication($comunicationId)
    {
        $comunication = Comunication::find($comunicationId);

        $comunication->update([
            'atended' => 2
        ]);

        return response()->json([
            'msg' => 'Comunicación actualizada'
        ]);
    }
    /**
     * Retrieve communications related to clients.
     *
     * This method retrieves communications for clients that have a specific status.
     *
     * @return \Illuminate\Http\Response
     */
    public function comunicationsClient()
    {
        $comunications = Comunication::with(['customer', 'customer.comunications' => function ($secondQuery) {
            $secondQuery->orderBy('id', 'desc');
        }])->whereHas('customer', function ($query) {
            $query->where('status', 11);
        })->get();


        return response()->json($comunications);
    }
}
