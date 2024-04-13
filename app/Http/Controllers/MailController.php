<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Mail\MailSender;
use Illuminate\Support\Facades\Mail;

class MailController extends Controller
{
    public function send_mail(Request $request)
    {
        try {
            $request->validate([
                'adress' => 'required|email',
            ]);
            $mail_adress = $request->input('adress');
            \dispatch(new \App\Jobs\TestQueue($mail_adress));
            return response()->json([
                'message' => 'Mail sent successfully.',
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Mail could not be sent.',
                'error' => $e->getMessage(),
            ], 500);
        }
    }
}