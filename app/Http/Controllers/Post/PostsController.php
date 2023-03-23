<?php

namespace App\Http\Controllers\Post;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Posts;
use App\Models\User;

class PostsController extends Controller{
    private $posts;

    public function __construct(Posts $post){
        $this->posts = $post;
    }

    public function index(){
        $posts = Posts::where('user_id', '=', \Auth::id())->get();
        return \Response::json($posts); 
    }

    public function save(Request $request, $id){
        $data = $request;
        $user = User::findOrFail($id);
        try{
            $insert_post = Posts::create([
                'post' => $data->post,
                'user_id' => $user->id,
            ]);
            return \Response::json($insert_post);
        }
        catch(Exception $e){
            return \Response::json($e);
        }
        dd($data, $user);        
    }
    
}