<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Occupation extends Model
{
    public static function getAllOccupationForListing()
    {  
        return Occupation::select('occupations.id', 'occupations.name')->get();
    }
}
