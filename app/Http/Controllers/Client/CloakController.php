<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\File;
use App\Models\Cloack;
use App\Models\ProfileUser;

class CloakController extends Controller
{
    private $cloak;

    public function __construct(Cloack $cloak)
    {
        $this->cloak = $cloak;
    }
    public function index()
    {
        $cloak = Cloack::where('user_id', '=', \Auth::id())->where('selected', '=', 'true')->limit(4)->get();
        return \Response::json($cloak);
    }

    public function upload(Request $request, $id)
    {
        foreach ($request->file('file') as $file_image) {
            $file_name = $file_image->getClientOriginalName();
            $file_size = $file_image->getSize();
            $file_ext = $file_image->extension();
            $profile_user = ProfileUser::findOrFail($id);
            try {
                $insert_db = Cloack::create([
                    'image_name' => $file_name,
                    'size' => $file_size,
                    'extension' => $file_ext,
                    'user_id' => $profile_user->user_id,
                    'profile_id' => $profile_user->id,
                    'selected' => false,
                ]);
                $path = Storage::putFileAs('public/cloak', $file_image, $file_name);
                return \Response::json($insert_db);
            } catch (Exception $e) {
                return \Response::json($e);
            }
        }
    }
    public function allCloaks($id)
    {
        try {
            $cloaks = Cloack::where('user_id', '=', $id)->get();
            
            return \Response::json($cloaks);
        } catch (Exception $e) {
            return \Response::json($e);
        }
    }
    public function selected(Request $request, $id)
    {
        $selected = $request->selected;
        try {
            $cloaks = Cloack::where('id', '=', $id)->update(['selected' => $selected]);
            if ($cloaks) {
                $update_others = Cloack::where('id', '!=', $id)
                    ->where('user_id', '=', \Auth::id())
                    ->get();

                foreach ($update_others as $others) {
                    $others->update(['selected' => false]);
                }
            }

            $response = 'Atualizado com sucesso...';
            return \Response::json($response);
        } catch (Exception $e) {
            return \Response::json($e);
        }
    }
    public function delete($id)
    {
        $file = Cloack::where('id', '=', $id)->first();

        try {
            $remove_image = \File::delete($file->image_name);
            $remove_db = $file->delete();
            $response = 'Removido com sucesso';
            return \Response::json($response);
        } catch (Exception $e) {
            return \Response::json($e);
        }
    }
}
