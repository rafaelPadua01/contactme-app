<?php
namespace App\Http\Controllers\Message;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Message\MessagesController;
use Illuminate\Http\Request;
use App\Models\Chat;
use App\Models\User;
use App\Models\ProfileUser;

use function PHPUnit\Framework\isNull;

class ChatsController extends Controller {
    private $chats;

public function __construct(Chat $chats)
    {
        $this->chats  = $chats;
    } 
    public function index($id){
        try{
            $talk = Chat::where('receiver_id', '=', $id)
            ->join('users', 'users.id', '=', 'chats.sender_id')
            ->join('profile_users', 'profile_users.user_id', '=', 'users.id')
            ->join('profile_images', 'profile_images.user_id', '=', 'profile_users.user_id')
            ->get([
                'chats.*',
                'users.name',
                'profile_users.lastname',
                'profile_images.image_name',
            ]);
           // dd(sizeof($talk));
            if(sizeof($talk) == 0){
                $talk = Chat::where('sender_id', '=', $id)
                ->join('users', 'users.id', '=', 'chats.receiver_id')
                ->join('profile_users', 'profile_users.user_id', '=', 'users.id')
                ->join('profile_images', 'profile_images.user_id', '=', 'profile_users.user_id')
                ->get([
                    'chats.*',
                    'users.name',
                    'profile_users.lastname',
                    'profile_images.image_name',
                ]);
                return $talk;
            }
            
           
            return \Response::json($talk);
        }
        catch(Exception $e){
            return \Response::json($e);
        }
    }
    public function create(Request $request, $id){
        $profile_user = ProfileUser::where('user_id', '=', (int) $id)->first();
        $chat = Chat::where('receiver_id', '=', $profile_user->user_id)->first();
        $user = \Auth::user();
        if(!$chat){
            try{
                $insert_chat = Chat::create([
                    'receiver_id' => (int) $id,
                    'sender_id' => $user->id,
                ]);
                
            }
            catch(Exception $e){
                return $e;
            }
            return MessagesController::send($request, $insert_chat->id);
        }
        else{
            //dd($profile_user, $chat, $user, $user->id, $id, $request->receiver_id);
           return MessagesController::send($request, (int) $id);
        }
       
    }

    public function selectChat($id){
        try{
            $chat = Chat::where('chats.id', '=', $id)->get();
            foreach($chat as $user_chat){
                if($user_chat->sender_id != \Auth::id()){
                    $chat = $user_chat
                    ->join('users', 'users.id', '=', 'chats.sender_id')
                    ->join('profile_users', 'profile_users.user_id', '=', 'users.id')
                    ->join('profile_images', 'profile_images.user_id', '=', 'profile_users.user_id')
                    ->get([
                        'chats.*',
                        'users.name',
                        'profile_users.lastname',
                        'profile_images.image_name'
                    ]);

                    return $chat;
                }
                else if($user_chat->sender_id == \Auth::id()){
                    $chat = $user_chat
                        ->join('users', 'users.id', '=', 'chats.receiver_id')
                        ->join('profile_users', 'profile_users.user_id', '=', 'users.id')
                        ->join('profile_images', 'profile_images.user_id', '=', 'profile_users.user_id')
                        ->get([
                                'chats.*',
                                'users.name',
                                'profile_users.lastname',
                                'profile_images.image_name',
                            ]);
                   
                   return $chat;
                }
                return $chat;
            }
            
            return \Response::json($chat);
        }
        catch(Exception $e){
            return \Response::json($e);
        }
    }
    public function changeColor(Request $request, $id){
        try{
            
            $chat = Chat::where('id', '=', $id)->update(['color' => $request->colorPicker]);
            return \Response::json($request->colorPicker);
        }
        catch(Exception $e){
            return \Response::json($e);
        }
        
    }
    
}