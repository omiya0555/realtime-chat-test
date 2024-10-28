<?php

use Illuminate\Support\Facades\Route;
use App\Events\MessageSent;

Route::get('/', function () {
    return view('welcome');
});

Route::post('/send-message', function () {
    $message_id = request()->input('message_id');
    $message    = request()->input('message');
    broadcast(new MessageSent($message_id,$message))->toOthers();
    return response()->json(['status' => 'Message Sent!']);
});