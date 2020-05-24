<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BloodGroup extends Model
{
    public static function getAllBloodGroupListing()
    {  
        return BloodGroup::select('blood_groups.id', 'blood_groups.name')->get();
    }
}
