<?php

namespace App\Http\Controllers;

use App\Models\Meeting;
use Illuminate\Http\Request;

class MeetingController extends Controller
{
       /**
     * Muestra una lista de todas las reuniones.
     *
     * Recorre todas las reuniones, y si la reunión tiene un valor para 'time', 
     * concatena 'date' y 'time' en un único valor y asigna ese valor a 'start' y 'end'.
     * Devuelve un JSON con las reuniones.
     *
     * @return \Illuminate\Http\JsonResponse
     */
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
    /**
     * Almacena una nueva reunión en la base de datos.
     *
     * Crea una reunión con los datos proporcionados en la solicitud y la asocia a los usuarios.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
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
    /**
     * Elimina una reunión especificada por su ID.
     *
     * Busca la reunión por su ID y la elimina de la base de datos.
     *
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($id)
    {
        $meeting = Meeting::find($id);

        $meeting->delete();

        return response()->json([
            'msg' => 'success'
        ]);
    }
    /**
     * Actualiza la fecha de una reunión existente.
     *
     * Busca la reunión por su ID y actualiza la fecha con el nuevo valor proporcionado.
     *
     * @param  int  $id
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
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
    /**
     * Marca una reunión como completada.
     *
     * Cambia el estado de la reunión especificada a 1 (completada).
     *
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
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
