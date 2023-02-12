<?php

namespace App\HTTP\Controllers\Message;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\MessageVoice;
use App\Models\Chat;
use Illuminate\Support\Facades\Storage;

class VoiceMessageController extends Controller {
    private $message;

    public function __construct(MessageVoice $messages){
        $this->message = $messages;
    }
    public function send(Request $request, $id){
       // dd($request->receiver_id, $request->file('audio'), $id);
        $chat = Chat::findOrFail($id);
        $sender_message = \Auth::user();
        $receiver_id = (int) $request->receiver_id;
     //   dd($sender_message->id, $receiver_id);
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
                return \Response::json($insert_db);
            }
            
                $insert_db = MessageVoice::create([
                    'chat_id' => $chat->id,
                    'sender_id' => $request->receiver_id,
                    'receiver_id' => (int) $sender_message->id,
                    'audio_name' => $name_file
                ]);
                $directory_to_file = Storage::putFileAs('public/voice/' . $chat->id, $audio_file, $name_file);
                return \Response::json($insert_db);
            //dd($audio_file);
        }
        catch(Exception $e){
            return \Response::json($e);
        }
     
    }
}
