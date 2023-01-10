<?php 

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Follower;
use Illuminate\Http\Request;
use App\Models\User;


class FollowerController extends Controller {
    private $follower;

    public function __construct(Follower $follower){
        $this->follower = $follower;
    }
    public function index(){
        $followers = Follower::all();
        return \Response::json($followers);
    }
    public function follow($id){
        $follower_user = User::where('users.id', '=', $id)
            ->join('profile_users', 'profile_users.user_id', '=', 'users.id')
            ->first([
                'users.*',
                'profile_users.lastname',
            ]);
          
        try{
            $user = \Auth::id();
            $insert_follower = Follower::create([
                'user_id' => $user,
                'follower_name' => $follower_user->name,
                'follower_lastname' => $follower_user->lastname,
                'follower_id' => $id,
                'status' => true
            ]);
            
            if($insert_follower){
                return \Response::json($insert_follower);
            }
            else{
                return \Response::json('Erro ao seguir');
            }
        }
        catch(Exception $e){
            return \Response::json($e);
        }
    }
    public function followConfirm($id){
        try{
            $follower = Follower::where('id', '=', $id)->update(['status' => true]);
            return \Response::json($follower);
        }
        catch(Exception $e){
            return \Response::json($e);
        }
        
    }
    public function unconfirm($id){
        try{
            $follower = Follower::where('id', '=', $id)->update(['status' => false]);
            $response = false;
            return \Response::json($response);
        }
        catch(Exception $e){
            return \Response::json($e);
        }
    }
    public function remove($id){
        $follower = Follower::where('user_id', '=', $id)->first();
        try{
            $follower->delete();
            $response = 'Você deixou de seguir essa pessoa';
            return \Response::json($response);
        }
        catch(Exception $e){
            return \Response::json($e);
        }
    }
    public function unfollow($id){
        $follower = Follower::where('user_id', '=', $id)->first();
        try{
            $follower->delete();
            $response = 'Você deixou de seguir essa pessoa';
            return \Response::json($response);
        }
        catch(Exception $e){
            return \Response::json($e);
        }
    }
    public function followers($id){
        try{
            //$followers = Follower::where('followers.user_id', '=', $id)->get();

            $followers = Follower::where('followers.user_id', '=', $id)
            ->join('profile_users', 'profile_users.user_id', '=', 'followers.user_id')
            ->join('profile_profs', 'profile_profs.user_id', '=', 'profile_users.user_id')
            ->join('profile_images', 'profile_images.profile_id', '=', 'profile_users.id')
            ->get([
                
                'profile_users.lastname as lastname',
                'profile_profs.profissao as profissao',
                'profile_profs.especialidades as especialidades',
                'profile_images.image_name as image_name',
                'followers.*'
                
            ]);
           
            return \Response::json($followers);
        }catch(Exception $e){
            return \Response::json($e);
        }
        
        dd($followers);
    }

}