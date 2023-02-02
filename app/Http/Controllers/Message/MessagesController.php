<?php

namespace App\Http\Controllers\Message;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Message\ChatsController;
use Illuminate\Http\Request;
use App\Models\Message;
use App\Models\User;
use App\Models\Chat;
use App\Models\ProfileUser;

class MessagesController extends Controller
{
    private $messages;

    public function __construct(Message $messages){
        $this->messages = $messages;
    }
    public function index($id){
        try{
            $messages = Message::where('user_id', '!=', \Auth::id())->orderBy('messages.created_at', 'asc')->first();

            return \Response::json($messages);
        }
        catch(Exception $e){
            return \Response::json($e);
        }
    }
    public static function send(Request $request, $id){
     
       $message = $request->messages;
       $status  = false;
       $receiver = User::where('users.id', '=', $request->id)
       ->join('profile_users', 'profile_users.user_id', '=','users.id')
       ->first([
            'users.name',
            'profile_users.lastname'
       ]); //remetente
      
       $chat = Chat::where('receiver_id', '=', $request->id)->first();
      if(!$chat){
        $chat = Chat::where('sender_id', '=', $request->id)->first();
      }
       $user_id = \Auth::id();
     
       try{
        $insert_message = Message::create([
            'message' => $message,
            'status' => $status,
            'user_name' => $receiver->name,
            'user_lastname' => $receiver->lastname,
            'user_id' => $user_id,
            'chat_id' => $chat->id,
            'receiver_id' => (int) $id
        ]);
        if($insert_message){
            event(new \App\Events\MessageEvent($insert_message));
         }
        return \Response::json($insert_message);
       }
       catch(Exception $e)
       {
        return \Response::json($e);
       }
    }
    public function show($id){
        try{
            $messages = Chat::where('chats.id', '=', $id)
            ->join('messages', 'messages.chat_id', '=', 'chats.id')
            ->get([
                'messages.*',
                'chats.id'
            ]);
            
            return \Response::json($messages);
        }
        catch(Exception $e){
            return \Response::json($e);
        }
    }
    public function remove($id)
    {
        try{
            $remove_message = Message::findOrFail($id)->delete();
            return \Response::json($remove_message);
        }catch(Exception $e){
            return \Response::json($e);
        }
       

    }
}


