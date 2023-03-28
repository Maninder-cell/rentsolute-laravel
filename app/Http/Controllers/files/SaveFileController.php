<?php

namespace App\Http\Controllers\files;

use App\Http\Controllers\Controller;
use App\Models\Image;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class SaveFileController extends Controller
{
    public static function disk(){
        return Storage::disk(Image::DISK);
    }

    public static function saveFile($file){
        $imageFile = Array('imageFile' => $file);

        $validator = Validator::make($imageFile, [
            'imageFile' => sprintf('required|mimes:jpeg,png,jpg'),
        ]);

        if ($validator->fails()) {
            return Array(false,$validator->messages());
        }

        $fileName = Str::uuid()->toString() . '_' . $file->getClientOriginalName();
        self::disk()->put($fileName, file_get_contents($file));
        $filePath = self::disk()->url($fileName);

        return Array($filePath,$validator);
    }
}
