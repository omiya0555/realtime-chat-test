<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class MessageController extends Controller
{
    $message = new Message;
    $message->message_id = $request->message_id;
    $message->message    = $request->message;

    broadcast(new MessageSent($message_id,$message))->toOthers();
}
