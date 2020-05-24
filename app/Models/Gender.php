<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Gender extends Model
{
    public static function getAllGenderListing()
    { 
        return Gender::select('genders.id', 'genders.name')->get();
    }
}
