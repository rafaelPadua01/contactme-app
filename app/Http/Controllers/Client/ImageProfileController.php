<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\ProfileImages;
use App\Models\ProfileUser;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;
use Illuminate\Http\File;


class ImageProfileController extends Controller
{
    private $profile_image;

    public function __construct(ProfileImages $profile_image)
    {
        $this->$profile_image = $profile_image;
    }
    public function index()
    {
        $profile_image = ProfileImages::where('user_id', '=', \Auth::id())->first();
        return \Response::json($profile_image);
    }

    public function upload(Request $request, $id)
    {
        foreach ($request->file('image_profile') as $img) {
            $name = $img->getClientOriginalName();
            $size = $img->getSize();
            $ext = $img->extension();
            $profile_user = ProfileUser::select('id')->where('user_id', '=', $id)->first();
            $profile_img = ProfileImages::where('user_id', '=', $id)->first();
            $profile_id = $profile_user->id;

            if (!$profile_img) {
                $insert_image = ProfileImages::create([
                    'image_name' => $name,
                    'image_size' => $size,
                    'image_extension' => $ext,
                    'user_id' => $id,
                    'profile_id' => $profile_id,
                ]);

                $path = Storage::putFileAs('public/avatars', $img, $name);
                return \Response::json($insert_image);
            } else {
                $remove_old = Storage::delete('public/avatars/' . $profile_img->image_name);
                if ($remove_old)
                    $update_img = ProfileImages::where('profile_id', '=', $profile_id)
                        ->update([
                            'image_name' => $name,
                            'image_size' => $size,
                            'image_extension' => $ext,
                        ]);
                if ($update_img) {
                    $path = Storage::putFileAs('public/avatars', $img, $name);
                    $response = ProfileImages::where('user_id', '=', \Auth::id())->first();;

                    return \Response::json($response);
                }
            }
        }
    }

    public function update(Request $request, $id)
    {
        $profile_image = $request->file('profile_image');

        foreach ($profile_image as $img) {
            $name = $img->getClientOriginalName();
            $size = $img->getSize();
            $ext = $img->extension();
            $name_profile_img = ProfileImages::where('profile_id', '=', $id)->first();

            try {
                $remove_odd = Storage::delete('public/avatars/' . $name_profile_img->image_name);

                if ($remove_odd) {
                    $update_img = ProfileImages::where('profile_id', '=', $id)
                        ->update([
                            'image_name' => $name,
                            'image_size' => $size,
                            'image_extension' => $ext,
                        ]);
                    if ($update_img) {
                        $path = Storage::putFileAs('public/avatars', $img, $name);
                        $response = $path;
                        return \Response::json($profile_image);
                    }
                }
            } catch (Exception $e) {
                return \Response::json($e);
            }
        }
    }
    public function delete($id)
    {
        $img_delete = ProfileImages::findOrFail($id);
        try {
            $remove_on_directory = Storage::delete('public/avatars/' . $img_delete->image_name);
            if ($remove_on_directory) {
                $img_delete->delete();
            }

            return \Response::json($img_delete);
        } catch (Exception $e) {
            return \Response::json($e);
        }
    }
}
