<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AichatController extends Controller
{

    //VERIFICACION DE FACEBOOK
    public function webhook(){
        // Toquen
        $token = 'HolaMundo';
        // reto que recibiremos de facebbok
        $hub_challenge = isset($_GET['hub_challenge']) ? $_GET['hub_challenge'] : '';
        // tiquen de verificacion que recibiremos de facebook
        $hub_verfy_token = isset($_GET['hub_verify_token']) ? $_GET['hub_verify_token'] : '';
        //si el toquen que generamos es el mismo que nos envia facebook retornamos el reto para validar que somos nosotros
        if($token === $hub_verfy_token){
            echo $hub_challenge;
            exit;
        }
    }

    //RECEPCIÓN DE MENSAJES
    public function recibe(){
        //Leemos los datos enviados por whatssap
        $respuesta = file_get_contents("php://input");
       //CONVERTIMOS EL JSON EN ARRAY DE PHP
        $respuesta = json_decode($respuesta, true);
        //EXTRAEMOS EL MENSAJE DEL ARRAY
        $mensaje=$respuesta['entry'][0]['changes'][0]['value']['messages'][0]['text']['body'];
        //EXTRAEMOS EL TELEFONO DEL ARRAY
        $telefonoCliente=$respuesta['entry'][0]['changes'][0]['value']['messages'][0]['from'];
        //EXTRAEMOS EL ID DE WHATSAPP DEL ARRAY
        $id=$respuesta['entry'][0]['changes'][0]['value']['messages'][0]['id'];
        //EXTRAEMOS EL TIEMPO DE WHATSAPP DEL ARRAY
        $timestamp=$respuesta['entry'][0]['changes'][0]['value']['messages'][0]['timestamp'];
    }





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
        //
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
}
