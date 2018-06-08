<?php

namespace C2Y\Http\Controllers;

use Carbon\Carbon;
use Image;
use Illuminate\Http\Request;

class ImageController extends Controller
{
    public static function upload ($image) {
        // $validator = Validator::make($info, [
        //     'image' => 'image64:jpeg,jpg,png'
        // ]);
        // if ($validator->fails())
        //     return APIController::error($validator->errors());
        if (!$image)
            return null;

        if (!file_exists(public_path('upload/')))
            mkdir(public_path('upload/'), 0777, true);

        $data = $image;
        $name = Carbon::now()->timestamp . '_' . uniqid() . '.' . explode('/', explode(':', substr($data, 0, strpos($data, ';')))[1])[1];
        $prev = $name;
        $name = public_path('upload/').$name;
        Image::make($image)->save($name);
        return $prev;
    }

    public static function delete ($path) {
        // unlink(public_path('upload/').$path);
        return public_path('upload/').$path;
    }
}
