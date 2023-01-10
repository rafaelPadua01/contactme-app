<?php
namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Galery;
use App\Models\ImageGalery;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\File;

class ImageGaleryController extends Controller {
    private $image_galery;
    public function __construct(ImageGalery $image_galery){
        $this->image_galery = $image_galery;
         
    }

    public static function uploadImages($files, $galery_name){
       $images = $files;
       
       $galery = Galery::select('id')->where('name_galery', '=', $galery_name)->first();
   
       foreach($images as $img){
        $insert_images = ImageGalery::create([
                    'user_id' => \Auth::id(),
                    'galery_id' => $galery->id,
                    'name_image' => $img->getClientOriginalName(),
                    'size'  => $img->getSize(),
                    'extension' => $img->extension(),            
                ]);
                if($insert_images){
                    $path = Storage::putFileAs('public/galery/'.$galery_name, $img, $img->getClientOriginalName());
                    
                }
                else{
                    echo "impossivel criar album";
                }
          
           
            
       }
       $response = 'Galeria criada com sucesso';
                    return \Response::json($response);
    }
    public function selected($id){
        try{
            $images = ImageGalery::where('image_galeries.user_id', '=', $id)
            ->join('galeries', 'galeries.id', '=', 'image_galeries.galery_id')
            ->limit(4)
            ->get([
                'image_galeries.*',
                'galeries.name_galery'
            ]);
            return \Response::json($images);
        }
        catch(Exception $e){
            return \Response::json($e);
        }
    }
    public function selectedAll($id){
        $select_images = ImageGalery::where('image_galeries.galery_id', '=', $id)
            ->join('galeries', 'galeries.id', '=', 'image_galeries.galery_id')
            ->get([
                'galeries.name_galery',
                'galeries.description',
                'image_galeries.*',
            ]);
           
        
        return \Response::json($select_images);
    }
    public function all($id){
        $per_galery = ImageGAlery::where('image_galeries.user_id', '=', $id)
        ->join('galeries', 'galeries.id', '=', 'image_galeries.galery_id')
        ->get([
                'image_galeries.*',
                'galeries.name_galery'
            ]);
        return \Response::json($per_galery);
    }
    public static function delete($id){
        $name_galery = ImageGalery::select('name_image')->where('id', '=', $id)->get();
     
        try{
            $remove_file = Storage::delete('public/galery/'.$name_galery);
            $remove_image = ImageGalery::where('id', '=', $id)->delete();
    
            return \Response::json($name_galery);
        }
        catch(Exception $e){
            return \Response::json($e);
        }
       
    }
}