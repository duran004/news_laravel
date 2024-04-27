<?php

namespace App\Http\Controllers;

use App\Jobs\MailQueue;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Bus;
use PHPUnit\Framework\Assert as PHPUnit;


class MailController extends Controller
{
    public function send_mail(Request $request)
    {
        Bus::chain([
            new MailQueue($request->email, $request->name),
            new MailQueue($request->email, $request->name),
            new MailQueue($request->email, $request->name),
        ])->dispatch();

        return response()->json(['message' => 'Mail sent successfully'], 200);
    }
}
