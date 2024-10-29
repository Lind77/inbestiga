<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\File;
use App\Models\Justification;
use Illuminate\Http\Request;

/**
 * Class JustificationController
 *
 * Controlador para gestionar las justificaciones de ausencias de los usuarios. 
 * Permite crear, listar, mostrar, actualizar y eliminar justificaciones.
 *
 * @package App\Http\Controllers
 */
class JustificationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $justifications = Justification::with(['user', 'files'])->where('created_at', 'like', date('Y-m') . '%')->get();

        return response()->json($justifications);
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
     * Almacena una nueva justificación en la base de datos.
     *
     * @param  \Illuminate\Http\Request  $request  La solicitud que contiene los datos de la justificación.
     * @return \Illuminate\Http\Response La respuesta HTTP con el resultado de la operación.
     */
    public function store(Request $request)
    {
        $justification = json_decode($request->get('justification'), true);

        $newJustification = Justification::create([
            'miss_date' => $justification['miss_date'],
            'reason' => $justification['reason'],
            'status' => 0,
            'user_id' => $justification['userId'],
            'miss_time_admission' => $justification['admission_time'],
            'miss_time_departure' => $justification['departure_time']
        ]);

        if ($request->hasFile('file')) {
            $fileName = $request->file->getClientOriginalName();
            $url = $request->file->move(public_path('files'), $fileName);
            $newJustification->files()->create([
                'url' => $fileName,
                'type' => 3,
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    /**
     * Display a listing of the resource per month.
     *
     * 
     * @return \Illuminate\Http\Response
     */
    public function justificationsPerMonth()
    {
        $justifications = Justification::with(['user', 'files'])->orderBy('id', 'desc')->get();

        return response()->json($justifications);
    }
}
