<?php

namespace App\Http\Controllers;

use App\Models\Message; 
use Illuminate\Http\Request;
use App\Events\MessageSent;

class SendMessageController extends Controller
{
    public function index()
    {
        return view('sendmsg'); // blade failas sendmsg.blade.php
    }

    public function send(Request $request)
    {
        $request->validate([
            'message' => 'required|string|max:255',
        ]);

        $messageText = $request->message;

         Message::create([
            'content' => $messageText,
            'sent_at' => now(),
        ]);

        // Broadcast event
        broadcast(new MessageSent($request->message))->toOthers();

        return response()->json(['status' => 'ok']);
    }
}
