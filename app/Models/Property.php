<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Property extends Model
{
    use HasFactory;

    protected $hidden = ['pivot'];
    
    protected $fillable = [
        'name',
        'property_type',
        'description',
        'tenancy_status',
        'street',
        'city',
        'state',
        'postal_code',
        'country',
        'latitude',
        'longitude',
        'area',
        'funishing_status',
        'funishing_details',
        'share_property_url'
    ];

    public function user(){
        return $this->belongsTo(User::class,'user_id');
    }

    public function questions(){
        return $this->belongsToMany(Question::class,'property_questions');
    }

    public function images(){
        return $this->belongsToMany(Image::class,'property_images');
    }

    public function rooms(){
        return $this->hasMany(Room::class,'property_id');
    }

    public function amenities(){
        return $this->belongsToMany(Amenity::class,'property_amenities');
    }
}
