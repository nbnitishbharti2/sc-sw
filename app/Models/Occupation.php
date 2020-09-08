<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\StudentRegistration;
use App\Models\StudentDetail;

class Occupation extends Model
{
    public static function getAllOccupationForListing()
    {  
        return Occupation::select('occupations.id', 'occupations.name')->get();
    }


    public function student_registration_father()
    {
        return $this->hasMany('App\Models\StudentRegistration', 'father_occupation_id');
    }
    public function student_registration_mother()
    {
        return $this->hasMany('App\Models\StudentRegistration', 'mother_occupation_id');
    }


    public function student_detail_father()
    {
        return $this->hasMany('App\Models\StudentDetail', 'father_occupation_id');
    }
    public function student_detail_mother()
    {
        return $this->hasMany('App\Models\StudentDetail', 'mother_occupation_id');
    }
}
