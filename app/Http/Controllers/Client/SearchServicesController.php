<?php
namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\SearchService;


class SearchServicesController extends Controller
{
    private $search_service;

    public function __construct(SearchService $search_service){
        $this->search_service = $search_service;
    }

    public function search(Request $request, $id){
        $data = $request->all();
        foreach($data as $d){
            if(empty($request->search)){
                $response = false;
                return $response;
            }
       
                try{
                 
                    $user = User::join('profile_users', 'user_id', '=', 'users.id')
                    ->join('profile_images', 'profile_images.user_id', '=', 'profile_users.user_id')
                    ->join('profile_profs', 'profile_profs.user_id', '=', 'profile_images.user_id')
                    ->join('cloacks', function($join){
                        $join->on('cloacks.user_id', '=', 'profile_profs.user_id')
                            ->where('cloacks.selected', '=', true);
                    })
                    ->where('profissao', 'LIKE', '%'. $d .'%')
                    ->orWhere('cidade', 'LIKE','%'. $d .'%')
                    ->orWhere('name', 'LIKE', '%'.$d.'%')
                    ->orWhere('lastname', 'LIKE', '%'.$d.'%')
                    ->orWhere('bairro', 'LIKE', '%'.$d.'%')
                    ->get([ 'users.id',
                            'users.name',
                            'users.email',
                            'profile_users.lastname',
                            'profile_users.cidade',
                            'profile_users.bairro',
                            'profile_images.image_name',
                            'profile_profs.profissao',
                            'profile_profs.tempo_experiencia',
                            'profile_profs.especialidades',
                            'cloacks.image_name as cloak_image',
                            'cloacks.selected as cloak_status'
                    ]);
                   
                    $response = $user;
                  
                    if(!$response){
                        $response = false;
                        //return $response;
                         return \Response::json($response);
                    }
                    SearchService::create([
                        'user_id' => $id,
                        'search' => $d,
                    ]);
                    return \Response::json($response);
                }
                catch(Exception $e)
                {
                   
                    return \Response::json($e);
                }
               
         
        }
    }
    public function userProfile($id){
        try{
            $profile_user = User::where('users.id', '=', $id)
            ->join('profile_users', 'profile_users.user_id', '=', 'users.id')
            ->join('profile_images', 'profile_images.user_id', '=', 'profile_users.user_id')
            ->join('profile_profs', 'profile_profs.user_id', '=', 'profile_images.user_id')
            ->join('cloacks', 'cloacks.user_id', '=', 'profile_profs.user_id')
           //->where('profile_users.user_id', '=', $id)
          ////  ->where('profissao', '=', $d)
           ->get([ 'users.id',
                           'users.name',
                           'users.email',
                           'profile_users.lastname',
                           'profile_users.sexo',
                           'profile_users.cidade',
                           'profile_users.bairro',
                           'profile_images.image_name',
                           'profile_profs.profissao',
                           'profile_profs.tempo_experiencia',
                           'profile_profs.especialidades',
                           'profile_profs.lastjob',
                           'profile_profs.descricao',
                           'cloacks.image_name as c_image',
                           'cloacks.selected as c_image_status'
            ]);

         return \Response::json($profile_user);
        }
        catch(Exception $e){
            return \Response::json($e);
        }
        
    }
   
}