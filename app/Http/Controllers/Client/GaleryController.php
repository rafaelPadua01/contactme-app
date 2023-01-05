<?php
namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Client\ImageGaleryController;
use App\Models\Galery;
use App\Models\ImageGalery;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\File;

class GaleryController extends Controller {
    private $galery;

    public function __construct(Galery $galeries){
        $this->galery= $galeries;
    }
    public function index($id){
        $albuns = Galery::where('user_id', '=', $id)->get();
        return \Response::json($albuns);
    }
    public function create(Request $request, $id){
        $auth_user = User::findOrFail($id);
        $files = $request->file('files');
        try{
            
            $create_galery = Galery::create([
                'name_galery' => $request->galery_name,
                'user_id' => $auth_user->id,
            ]);
            $galery_name = $request->galery_name;
            ImageGaleryController::uploadImages($files, $galery_name);
           // $response = 'Galeria criada com sucesso...';
           return \Response::json($create_galery);
           
        }
        catch(Excpetion $e)
        {
            return \Response::json($e);
        }
        
    }
    public function update(Request $request, $id){
        $galery = Galery::findOrFail($id);
        
        try{
          
            $rename_directory = \File::copyDirectory(
                public_path('storage/galery/'.$galery->name_galery),
                public_path('storage/galery/'.$request->rename)
            );
            $directorie_delete = \File::deleteDirectory(public_path('storage/galery/'.$galery->name_galery)); 
            $galery->update([
                'name_galery' => $request->rename,
            ]);
            return \Response::json($galery);
        }
        catch(Exception $e){
            return \Response::json($e);
        }
    }
    public function delete($id){
        $galery = Galery::FindOrFail($id); 
        $galery_images = ImageGalery::where('galery_id', '=', $id)->get();
     //  dd($galery_images);
        $galery_delete = Galery::findOrFail($id)
        ->join('image_galeries', 'image_galeries.galery_id', '=', 'galeries.id')
        ->get([
            'galeries.id',
            'galeries.name_galery',
            'image_galeries.*'
        ]);

        if(!$galery_images){
            $response = "Galeria possui imagens, você deve remove-las";
            return \Response::json($response);
        }
      
            try{
                $directorie_delete = \File::deleteDirectory(public_path('storage/galery/'.$galery->name_galery)); 
                $galery->delete();
                $response = 'Galeria Removida com sucesso';
                foreach($galery_images as $galery_image){
                    $delete_image = \File::delete(public_path('storage/galery/'.$galery->name_galery.'/'.$galery_image->name_image));
                    $delete_image_db = ImageGaleryController::delete($galery_image->id);
                    return \Response::json($galery_images);
                }
                
               // return \Response::json($galery_delete);
    
            }
            catch(Exception $e){
                return \Response::json($e);
            }
     
       
       
    }

    
}