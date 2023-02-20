<?php

namespace App\Http\Controllers\Message;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\FileMessage;
use App\Models\Chat;

class FileMessagesController extends Controller{
    private $files;

    public function __construct(FileMessage $files){
        $this->files = $files;
    }
    public function send(Request $request, $id){
        $chat = Chat::findOrFail($id);
        $receiver_id = $request->sender_id;
        $file = $request->file('file');
        $file_name = $file->getClientOriginalName();
        try{ 
            $insert_db = FileMessage::create([
                'chat_id' => $id,
                'receiver_id' => $receiver_id,
                'sender_id' => \Auth::id(),
                'file_derectory' => $file_name,
                'extension' => $request->file('file')->extension(),
                'size' => $request->file('file')->getSize(),
            ]);

            if($insert_db){
                $path = \Storage::putFileAs('public/chats/files'.$chat->id, $request->file('file')->getClientOriginalName(), $request->file('file')->getClientOriginalName());
                //Criar trigger de eventos
            }

                return \Response::json($insert_db);
        }
        catch(Exception $e){
            return \Response::json($e);
        }
        dd($request, $request->file('file'), $id);
    }
}