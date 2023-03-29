<?php

namespace App\Http\Controllers;

use App\Http\Controllers\files\SaveFileController;
use Illuminate\Http\Request;
use App\Http\Requests\ImageRequest;
use App\Models\Image;
use Illuminate\Support\Facades\Auth;

class ImageController extends Controller
{
    public function saveImage(ImageRequest $request){
        $image = new Image;
        $image->caption = $request->caption;
        $image->user_id = 18;

        list($filePath,$validator) = SaveFileController::saveFile($request->image);

        if($filePath == false){
            return response()->json(['errors' => $validator]);
        }

        $image->image = $filePath;
        $image->save();

        return response()->json([
            'msg' => 'Image added successfully',
            'data' => $image
        ]);
    }
}
