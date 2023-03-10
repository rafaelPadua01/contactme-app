<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Auth;
use App\Providers\RouteServiceProvider;

class RegisterUser extends Controller
{
    private $user;

    public function __construct(User $user)
    {
        $this->user = $user;
    }
    public function index()
    {
    }
    public function insert(Request $request)
    {
        $data_user = $request->all();
        $name = $request->name;
        $email      = $request->email;
        $password   = Hash::make($request->password);

        $user = User::create([
            'name' => $name,
            'email' => $email,
            'password' => $password,
            'type' => 'default',
        ]);
        $response = 'Cadastrado com sucesso';
        event(new Registered($user));

        Auth::login($user);

        return \Response::json($response);
    }
    public function getNotifications()
    {
        $user_notifications = Auth::user();
        echo $user_notifications->unreadNotifications;
    }
    public function markasread($id){
        try{
            $user_notifications = Auth::user();
            if($user_notifications){
                echo $user_notifications->notifications->where('id','=', $id)->first()->markAsRead();
            }
            return;
        }
        catch(Exception $e){
            return \Response::json($e);
        }
       
    }
    public function markAll(){
        $user_notifications = Auth::user();
        foreach($user_notifications->notifications as $notification){
            echo $notification->markAsRead();
        }
    }
    public function removeNotification($id){
        $user_notifications = Auth::user();
        if($user_notifications){
            echo $user_notifications->notifications->where('id', '=', $id)->first()->delete();
        }
    }
}
