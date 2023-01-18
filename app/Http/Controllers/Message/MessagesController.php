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

    public static function send(Request $request, $user){
       $message = $request->messages;
       $status  = false;
       $receiver =  ProfileUser::where('user_id', '=', $user)->first(); //remetente
      
       $chat = Chat::where('receiver_id', '=', $receiver->user_id)->first();
       $user = \Auth::id();
     
       try{
        $insert_message = Message::create([
            'message' => $message,
            'status' => $status,
            'user_id' => $user,
            'chat_id' => $chat->id,
        ]);
        
        return \Response::json($insert_message);
       }
       catch(Exception $e)
       {
        return \Response::json($e);
       }
    }
    public function show($id){
        try{
            $messages = Message::where('chat_id', '=', $id)->get();
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


