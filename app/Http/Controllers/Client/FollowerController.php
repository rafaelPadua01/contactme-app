<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Follower;
use Illuminate\Http\Request;
use App\Models\User;


class FollowerController extends Controller
{
    private $follower;

    public function __construct(Follower $follower)
    {
        $this->follower = $follower;
    }
    public function index()
    {
        $followers = Follower::all();
        return \Response::json($followers);
    }
    public function follow($id)
    {
        $follow_user = User::where('users.id', '=', $id)
            ->join('profile_users', 'profile_users.user_id', '=', 'users.id')
            ->first([
                'users.*',
                'profile_users.lastname as lastname'
            ]);


        try {
            $user = \Auth::user();

            $insert_follower = Follower::create([
                'user_id' => $user->id,
                'follower_name' => $follow_user->name,
                'follower_lastname' => $follow_user->lastname,
                'follower_id' => $follow_user->id,
                'status' => false
            ]);

            if ($insert_follower) {
                return \Response::json($insert_follower);
            } else {
                return \Response::json('Erro ao seguir');
            }
        } catch (Exception $e) {
            return \Response::json($e);
        }
    }
    public function followConfirm($id)
    {
        try {
            $create_new_follower = Follower::where('followers.id', '=', $id)
                ->join('users', 'users.id', '=', 'followers.user_id')
                ->join('profile_users', 'profile_users.user_id', '=', 'users.id')
                ->first([
                    'users.name',
                    'profile_users.lastname as lastname',
                    'followers.*'
                ]);

            $insert_follower = Follower::create([
                'user_id' => \Auth::id(),
                'follower_name' => $create_new_follower->name,
                'follower_lastname' => $create_new_follower->lastname,
                'follower_id' => $create_new_follower->user_id,
                'status' => false
            ]);

            //dd($create_new_follower);
            return \Response::json($insert_follower);
        } catch (Exception $e) {
            return \Response::json($e);
        }
    }
    public function alterStatus($id)
    {
        $follower = Follower::where('user_id', '=', (int) $id)->first();
        // ->join('users', 'users.id', '=', 'followers.user_id')
        // ->join('profile_users', 'profile_users.user_id', '=', 'users.id')
        // ->first([
        //     'users.*',
        //     'profile_users.*',
        //     'followers.*'
        // ]);

        try {

            $follower->update(['status' => true]);
            // if(!$follower){
            //     $new_follower = Follower::create([
            //         'user_id' => $follower->follower_id,
            //         'follower_name' => $follower->name,
            //         'follower_lastname' => $follower->lastname,
            //         'follower_id' => $follower->user_id,
            //         'status' => false
            //     ]);
            //
            //     return \Response::json($new_form);
            // }
            // $new_follower = Follower::create([
            //     'user_id' => $follower->follower_id,
            //     'follower_name' => $follower->name,
            //     'follower_lastname' => $follower->lastname,
            //     'follower_id' => $follower->user_id,
            //     'status' => false
            // ]);

            return \Response::json($follower);
        } catch (Exception $e) {
            return \Response::json($e);
        }
    }
    public function unconfirm($id)
    {
        try {
            $follower = Follower::where('user_id', '=', $id)->update(['status' => false]);
            // $response = false;
            return \Response::json($follower);
        } catch (Exception $e) {
            return \Response::json($e);
        }
    }
    public function unfollow($id)
    {
        try {
            $follower = Follower::where('follower_id', '=', $id);
            $follower->delete();
            $response = 'Você deixou de seguir essa pessoa';
            return \Response::json($response);
        } catch (Exception $e) {
            return \Response::json($e);
        }
    }
    public function followers($id)
    {
        try {
            $followers = Follower::where('followers.follower_id', '=', (int) $id)
                ->join('users', 'users.id', '=', 'followers.user_id')
                ->join('profile_users', 'profile_users.user_id', '=', 'users.id')
                ->join('profile_images', 'profile_images.user_id', '=', 'profile_users.user_id')
                ->join('profile_profs', 'profile_profs.user_id', '=', 'profile_images.user_id')
                ->orderBy('created_at', 'desc')
                ->get([
                    'users.name',
                    'profile_users.lastname as lastname',
                    'profile_profs.profissao as profissao',
                    'profile_profs.especialidades as especialidades',
                    'profile_images.image_name as image_name',
                    'followers.*'
                ]);

            return \Response::json($followers);
        } catch (Exception $e) {
            return \Response::json($e);
        }
    }
    public function following($id)
    {

        try {
            $following = Follower::where('followers.follower_id', '=', (int) $id)
                ->join('users', 'users.id', '=', 'followers.user_id')
                ->join('profile_users', 'profile_users.user_id', '=', 'users.id')
                ->join('profile_images', 'profile_images.profile_id', '=', 'profile_users.id')
                ->get([
                    'users.name',
                    'profile_users.lastname as lastname',
                    'profile_images.image_name as image_name',
                    'followers.*',
                ]);
            if (empty($following)) {
                $following = Follower::where('followers.status', '=',  true)->get();
                dd($following);
            }
            return \Response::json($following);
        } catch (Exception $e) {
            return \Response::json($e);
        }
    }
}
