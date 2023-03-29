<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Property extends Model
{
    use HasFactory;

    public function user(){
        return $this->belongsTo(User::class,'user_id');
    }

    public function images(){
        return $this->belongsToMany(Images::class,'property_images');
    }

    public function amenities(){
        return $this->belongsToMany(Amenity::class,'property_amenities');
    }
}
