<?php
namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ProfileProfs;
//use App\Models\ProfileUser;

class ProfileProfController extends Controller{
    private $profile_profs;

    public function __construct(ProfileProfs $profile_profs){
        $this->profile_profs = $profile_profs;
    }
    public function index(){
        $profile_profs = ProfileProfs::where('user_id', '=', \Auth::id())->first();
        return \Response::json($profile_profs);
    }
    public function save(Request $request, $id){
        $data = $request->all();
        $profile_prof_user = ProfileProfs::find($id);
        $prof = $request->profissao;
        $t_experiencia = $request->tempo_experiencia;
        $lastjob = $request->lastjob;
        $especialidades = $request->especialidades;
        $descricao = $request->descricao;
      
        if(!$profile_prof_user){
            try{
                $insert_profile_prof = ProfileProfs::create([
                    'profissao' => $prof,
                    'tempo_experiencia' => $t_experiencia,
                    'lastjob' => $lastjob,
                    'especialidades' => $especialidades,
                    'descricao' => $descricao,
                    'user_id' => $id,
                ]);
                if($insert_profile_prof){
                    return \Response::json($data);
                }
            }
            catch(Exception $e){
                return \Response::json($e);
            }
          
        }
        else{
            try{
                $update_profile_prof = ProfileProfs::where('user_id', '=', $id)->update($data);
                if($update_profile_prof){
                   return \Response::json([$data]); 
                }
            }       
            catch(Exception $e){
                return \Response::json([$data]);
            }     
        }
        
    }
}