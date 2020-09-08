<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\StudentRegistration;
use App\Models\StudentDetail;

class Gender extends Model
{
    public static function getAllGenderListing()
    { 
        return Gender::select('genders.id', 'genders.name')->get();
    }

    public function student_registration()
    {
        return $this->hasMany('App\Models\StudentRegistration', 'gender_id');
    }

    public function student_detail()
    {
        return $this->hasMany('App\Models\StudentDetail', 'gender_id');
    }
}
