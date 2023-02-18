<?php

namespace App\Http\Controllers\Message;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Message\ChatsController;
use Illuminate\Http\Request;
use App\Models\Message;
use App\Models\User;
use App\Models\Chat;
use App\Models\ProfileUser;
use App\Notifications\MessageNotification;

class MessagesController extends Controller
{
    private $messages;

    public function __construct(Message $messages)
    {
        $this->messages = $messages;
    }
    public function index($id)
    {
        try {
            $messages = Message::where('user_id', '!=', \Auth::id())->orderBy('messages.created_at', 'asc')->first();

            return \Response::json($messages);
        } catch (Exception $e) {
            return \Response::json($e);
        }
    }
    public static function send(Request $request, $id)
    {
        $messages = $request;
        $status  = false;
        $user_id = \Auth::id();
        $chat = Chat::where('id', '=', $id)->first();
        if(!$chat){
            $chat = Chat::where('sender_id', '=', $id)->first();
            return $chat;
        }
        $receiver = User::where('users.id', '=', $chat->receiver_id)
                ->join('profile_users', 'profile_users.user_id', '=', 'users.id')
                ->first([
                    'users.id',
                    'users.name',
                    'profile_users.lastname'
                ]); //remetente

            if ($receiver && $chat->receiver_id !== $user_id) {
                try {
                    $insert_message = Message::create([
                        'message' => $messages->messages,
                        'status' => $status,
                        'user_name' => $receiver->name,
                        'user_lastname' => $receiver->lastname,
                        'user_id' => $user_id,
                        'chat_id' => $chat->id,
                        'receiver_id' => $chat->receiver_id
                    ]);
                    if ($insert_message) {
                        event(new \App\Events\MessageEvent($insert_message));
                        $user_notify = \Auth::user();
                        $user_notify->notify(new MessageNotification($insert_message));
                    }
                    return \Response::json($insert_message);
                } catch (Exception $e) {
                    return \Response::json($e);
                }
                return \Response::json($insert_message);
            } 
                $receiver = User::where('users.id', '=', $chat->sender_id)
                    ->join('profile_users', 'profile_users.user_id', '=', 'users.id')
                    ->first([
                        'users.id',
                        'users.name',
                        'profile_users.lastname'
                    ]); //remetente

                try {
                    $insert_message = Message::create([
                        'message' => $messages->messages,
                        'status' => $status,
                        'user_name' => $receiver->name,
                        'user_lastname' => $receiver->lastname,
                        'user_id' => $user_id,
                        'chat_id' => $chat->id,
                        'receiver_id' => $receiver->id
                    ]);
                    if ($insert_message) {
                        event(new \App\Events\MessageEvent($insert_message));
                        $user_notify = \Auth::user();
                        $user_notify->notify(new MessageNotification($insert_message));
                    }
                   
                    return \Response::json($insert_message);
                } 
                catch (Exception $e) {
                    return \Response::json($e);
                }
    }
    public function show($id)
    {
        try{
            $messages = Message::where('chat_id', '=', (int) $id)
            ->where(function($query) {
                $query->where('messages.receiver_id', '=', \Auth::id())
                    ->orWhere('user_id', '=', \Auth::id());
            })
            ->join('chats', 'chats.id', '=', 'messages.chat_id')
            ->orderBy('created_at', 'asc')
            ->get([
                'chats.id',
                'messages.*'
            ]);
            foreach($messages as $message){
                if($message->status == false){
                    $message->update(['status' => true]);
                }

                return \Response::json($messages);
            }
        }
        catch(Exception $e){
            return \Response::json($e);
        }
    }
    public function remove($id)
    {
        try {
            $remove_message = Message::findOrFail($id)->delete();
            return \Response::json($remove_message);
        } catch (Exception $e) {
            return \Response::json($e);
        }
    }
}
