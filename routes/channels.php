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

Broadcast::channel('message-event.{userId}', function ($user) {

  return $user->id === Message::where('receiver_id', '=', $user->id)->first()->receiver_id;
});

Broadcast::channel('voice-message-event.{userId}', function ($user) {

  return $user->id === MessageVoice::where('receiver_id', '=', $user->id)->first()->receiver_id;
});
