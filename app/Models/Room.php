<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Room extends Model
{
    use HasFactory;

    public function property(){
        return $this->belongsTo(Property::class,'property_id');
    }

    public function image(){
        return $this->belongsTo(Image::class,'image_id');
    }
}

