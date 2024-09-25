<?php

namespace App\Http\Controllers;

use App\Mail\WelcomeMail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
/**
 * Class EmailController
 *
 * Controlador para gestionar el envío de correos electrónicos.
 * Incluye métodos para enviar correos de bienvenida.
 *
 * @package App\Http\Controllers
 */
class EmailController extends Controller
{
    /**
     * Envía un correo electrónico de bienvenida al usuario.
     *
     * @param  \Illuminate\Http\Request  $request  La solicitud HTTP que contiene los datos del correo.
     * @return \Illuminate\Http\JsonResponse  La respuesta JSON indicando el estado del envío.
     */
    public function sendWelcomeEmail(Request $request)
    {
        $body = $request->get('content');
        $subject = 'Desde el Sistema de INBESTIGA!';

        Mail::to($request->get('email'))->send(new WelcomeMail($subject, $body));

        return response()->json([
            'msg' => 'Email sent successfully'
        ]);
    }
}
