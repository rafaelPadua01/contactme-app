<?php

namespace App\HTTP\Controllers\Message;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\MessageVoice;
use App\Models\Chat;
use Illuminate\Support\Facades\Storage;
use App\Events\VoiceMessageEvent;
use App\Notifications\VoiceMessageNotification;

class VoiceMessageController extends Controller {
    private $message;

    public function __construct(MessageVoice $messages){
        $this->message = $messages;
    }
    public function send(Request $request, $id){
        $chat = Chat::findOrFail($id);
        $sender_message = \Auth::user();
        $receiver_id = (int) $request->receiver_id;
      
        $audio_file = $request->file('audio');
        $date = date('Y/m/dHim');
        $name_file = str_replace('/',  "", $date) . '.ogg';
        try{
            if($receiver_id !== $sender_message->id){
                $insert_db = MessageVoice::create([
                    'chat_id' => $chat->id,
                    'sender_id' => $sender_message->id,
                    'receiver_id' => $request->receiver_id,
                    'audio_name' => $name_file,
                    'status' => false
                ]);
                $directory_to_file = Storage::putFileAs('public/voice/' . $chat->id, $audio_file, $name_file);
                if($insert_db){ 
                    event(new VoiceMessageEvent($insert_db));
                    $auth_user = \Auth::user();
                    $auth_user->notify(new VoiceMessageNotification($insert_db));
                }
                return \Response::json($insert_db);
            }
               elseif($chat->receiver_id !== $sender_message->id) {
                $insert_db = MessageVoice::create([
                    'chat_id' => $chat->id,
                    'sender_id' => $request->receiver_id,
                    'receiver_id' => $chat->receiver_id,
                    'audio_name' => $name_file,
                    'status' => false
                ]);
                $directory_to_file = Storage::putFileAs('public/voice/' . $chat->id, $audio_file, $name_file);
                if($insert_db){ 
                    event(new VoiceMessageEvent($insert_db));
                    $auth_user = \Auth::user();
                    $auth_user->notify(new VoiceMessageNotification($insert_db));
                    
                }
                return \Response::json($insert_db);
               }
                
          
        }
        catch(Exception $e){
            return \Response::json($e);
        }
     
    }
    public function show($id){
        
        try{
            $messages = MessageVoice::where('chat_id', '=', (int) $id)
            ->where(function($query) {
                $query->where('sender_id', '=', \Auth::id())
                        ->orWhere('receiver_id', '=', \Auth::id())
                        ->orderBy('created_at', 'asc');
            })
            ->get();
           foreach($messages as $message){
            if($message->status == false){
                $message->update(['status' => true]);
            }
           }

            return \Response::json($messages);
          
        }
        catch(Exception $e){
            return \Response::json($e);
        }
      
    }
    public function delete($id){
        try{
            $message_voice = MessageVoice::findOrFail($id)->delete();
            return \Response::json($message_voice);
        }

        catch(Exception $e){
            return \Response::json($e);
        }
       
    }
}
