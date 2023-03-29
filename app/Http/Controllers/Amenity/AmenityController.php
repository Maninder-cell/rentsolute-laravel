<?php

namespace App\Http\Controllers\Amenity;

use App\Http\Controllers\Controller;
use App\Http\Controllers\files\SaveFileController;
use App\Http\Requests\AmenityRequest;
use App\Models\Amenity;
use Illuminate\Http\Request;

class AmenityController extends Controller
{
    public function saveAmenity(AmenityRequest $request)
    {
        $amenity = new Amenity;
        $amenity->name = $request->name;

        list($filePath, $validator) = SaveFileController::saveFile($request->icon);

        if ($filePath == false) {
            return response()->json(['errors' => $validator]);
        }

        $amenity->icon = $filePath;
        $amenity->save();

        return response()->json([
            'msg' => 'Amenity created successfully',
            'data' => $amenity
        ]);
    }

    public function getAmenities(Request $request)
    {
        $amenities = Amenity::all();

        return response()->json(['msg' => 'Amenities founds successfully', 'data' => $amenities]);
    }
}
