<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\File;
use App\Models\User;
use App\Models\ProfileUser;
use App\Http\Controllers\Client\ImageProfileController;

class ProfileController extends Controller 
{
    //private $profile;
//
    //public function __construct(){
    //    $this->profile = $profile;
    //}
    public function index(){
       
      $profile_user = ProfileUser::where('user_id', '=', \Auth::id())->first();
      return \Response::json($profile_user);
    }
    public function save(Request $request){
        $data = $request->all();
        $auth_user = $request->id;
        $name = $request->name;
        $email = $request->email; 
        $lastname = $request->lastname;
        $cidade = $request->cidade;
        $bairro = $request->bairro; 
        $endereco = $request->endereco;
        $t_residencial = $request->t_residencial;
        $t_celular = $request->t_celular;
        $uf = $request->uf;
        $sexo = $request->sexo;
        //$image_profile = $request->file('image_profile');
        if($data){
            try{
                $select_user = User::where('id', '=', $auth_user)->update([
                    'name' => $name,
                    'email' => $email,
                ]);
                if($select_user){
                    try{
                        $select_profile = ProfileUser::where('user_id', '=', $auth_user)->first();
                        if($select_profile){
                            $update_profile = $select_profile->update($data);
                            $response = ProfileUser::where('user_id', '=' , $auth_user)->first();
                            return \Response::json($response);
                        }
                        else{
                            
                            $insert_profile = ProfileUser::create($data);
                            return \Response::json($data);
                        }
                    }
                    catch(Exception $e){
                        $response = $e;
                        return \Response::json($response);
                    }
                }
            }
            catch(Exception $e){
                $response = $e;
                return \Response::json($response);
            }
            
        }
        
    } 

}