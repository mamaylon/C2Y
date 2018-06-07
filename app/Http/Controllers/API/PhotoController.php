<?php

namespace C2Y\Http\Controllers\API;

use C2Y\LessonImage;
use Illuminate\Http\Request;
use C2Y\Http\Requests\StoreBnccRequest;
use C2Y\Http\Controllers\Controller;
use C2Y\Http\Controllers\API\APIController;

class PhotoController extends Controller
{
    public static function upload ($image) 
    {
        if (!$image)
            return null;
    }
}
