<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Education extends Model
{
    public static function getAllEducationForListing()
    { 
    	 return Education::select('education.id', 'education.name')->get();
    }
}
