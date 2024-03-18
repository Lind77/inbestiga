<?php

namespace App\Http\Controllers;

use App\Mail\WelcomeMail;
use Illuminate\Http\Request;
use Mail;

class EmailController extends Controller
{
    public function sendWelcomeEmail()
    {
        $body = 'Welcome to the inbestiga.com example email';
        $subject = 'Thank you for participating!';

        Mail::to('juliofn.system@inbestiga.com')->send(new WelcomeMail($subject, $body));

        return response()->json([
            'msg' => 'Email sent successfully'
        ]);
    }
}
