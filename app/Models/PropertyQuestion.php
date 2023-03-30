<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PropertyQuestion extends Model
{
    use HasFactory;

    public function property(){
        return $this->belongsTo(Property::class,'property_id');
    }

    public function question(){
        return $this->belongsTo(Question::class,'question_id');
    }
}
