<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PropertyAmenity extends Model
{
    use HasFactory;

    public function user(){
        return $this->belongsTo(User::class,'user_id');
    }

    public function amenity(){
        return $this->belongsTo(Amenity::class,'amenity_id');
    }
}
