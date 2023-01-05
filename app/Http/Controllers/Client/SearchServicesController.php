<?php
namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\SearchService;


class SearchServicesController extends Controller
{
    private $search_service;

    public function __create(SearchService $search_service){
        $this->search_service = $search_service;
    }

    public function search(Request $request, $id){
        $data = $request->all();
        foreach($data as $d){
            if(empty($request->search)){
                $response = false;
                return $response;
            }
            else{
                try{
                    $user = User::join('profile_users', 'user_id', '=', 'users.id')
                    ->join('profile_images', 'profile_images.user_id', '=', 'profile_users.user_id')
                    ->join('profile_profs', 'profile_profs.user_id', '=', 'profile_images.user_id')
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
                            'profile_profs.especialidades'
                            
                        ]);
                        
                    $response = $user;
                    if(sizeOf($response) != true){
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
    }
    public function userProfile(Request $request, $id){
        $profile_user = User::findOrFail($id)
            ->join('profile_users', 'user_id', '=', 'users.id')
            ->join('profile_images', 'profile_images.user_id', '=', 'profile_users.user_id')
            ->join('profile_profs', 'profile_profs.user_id', '=', 'profile_images.user_id')
            ->join('cloacks', 'cloacks.user_id', '=', 'profile_images.user_id')
           // ->where('profissao', '=', $d)
            ->first([ 'users.id',
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
                            'cloacks.image_name as cloaks_image'
                        ]);

        return \Response::json($profile_user);
    }
   
}