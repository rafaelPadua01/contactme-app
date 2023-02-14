<?php

use Illuminate\Support\Facades\Broadcast;
use App\Models\Message;
use App\Models\MessageVoice;
use App\Models\User;

/*
|--------------------------------------------------------------------------
| Broadcast Channels
|--------------------------------------------------------------------------
|
| Here you may register all of the event broadcasting channels that your
| application supports. The given channel authorization callbacks are
| used to check if an authenticated user can listen to the channel.
|
*/

Broadcast::channel('App.Models.User.{id}', function ($user, $id) {
    return (int) $user->id === (int) $id;
});

Broadcast::channel('message-event.{user_id}', function($user, $id){
   $message = Message::where('receiver_id', '=', (int) $id)->first();
   //dd($user, $id);
    return $user->id === (int) $id;
 });

 Broadcast::channel('voice-message-event.{user_id}', function($user, $id){
   
       $voice_message = MessageVoice::where('sender_id', '=', (int) $id)->first();
    return $user->id === (int) $id;
 });
