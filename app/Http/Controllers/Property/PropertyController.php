<?php

namespace App\Http\Controllers\Property;

use App\Http\Controllers\Controller;
use App\Http\Requests\PropertyRequest;
use App\Models\Property;
use App\Models\PropertyAmenity;
use App\Models\PropertyImage;
use App\Models\PropertyQuestion;
use App\Models\Room;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PropertyController extends Controller
{
    public function dbProperty($images, $amenities, $rooms, $questions, $property)
    {
        foreach ($images as $image) {
            $image_obj = new PropertyImage;
            if (!PropertyImage::where([['property_id', $property->id], ['image_id', $image['image']]])->first()) {
                $image_obj->image_id = $image['image'];
                $image_obj->property_id = $property->id;

                $image_obj->save();
            }
        }

        foreach ($amenities as $amenity) {
            if (!PropertyAmenity::where([['property_id', $property->id], ['amenity_id', $amenity]])->first()) {
                $amenity_obj = new PropertyAmenity;
                $amenity_obj->amenity_id = $amenity;
                $amenity_obj->property_id = $property->id;

                $amenity_obj->save();
            }
        }

        foreach ($rooms as $room) {
            if (!Room::where([['property_id', $property->id], ['name', $room['name']]])->first()) {
                $room_obj = new Room;
                $room_obj->property_id = $property->id;
                $room_obj->image_id = $room['image'];
                $room_obj->name = $room['name'];
                $room_obj->room_type = $room['type'];

                $room_obj->save();
            }
        }

        foreach ($questions as $question) {
            if (!PropertyQuestion::where([['property_id', $property->id], ['question_id', $question['question_id']]])->first()) {
                $question_obj = new PropertyQuestion;
                $question_obj->question_id = $question['question_id'];
                $question_obj->property_id = $property->id;

                $question_obj->save();
            }
        }

        $get_property = Property::with('images', 'amenities', 'rooms', 'questions.options')->find($property->id);

        return $get_property;
    }

    public function saveProperty(PropertyRequest $request)
    {
        $property = Auth::user()->properties()->create($request->all());

        $get_property = $this->dbProperty($request->images, $request->amenities, $request->rooms, $request->questions, $property);

        return response()->json(["msg" => "Property created successfully", "data" =>  $get_property]);
    }

    public function updateProperty(PropertyRequest $request, $id)
    {
        $property = Auth::user()->properties()->find($id);

        $get_property = $this->dbProperty($request->images, $request->amenities, $request->rooms, $request->questions, $property);

        return response()->json(["msg" => "Property update successfully", "data" =>  $get_property]);
    }

    public function deleteProperty(Request $request, $id)
    {
        $property = Auth::user()->properties()->find($id);

        if ($property) {
            $property->delete();
            return response()->json(["msg" => "Property deleted successfully"]);
        } else {
            return response()->json(["msg" => "Property not found"]);
        }
    }
}
