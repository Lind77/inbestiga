<?php

namespace App\Http\Controllers;

use App\Mail\WelcomeMail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class EmailController extends Controller
{
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
