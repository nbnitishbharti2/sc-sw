<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\StudentRegistrationMap;
use App\Models\StudentSessionDetail;

class Session extends Model
{
    const YES = 'Yes';

    public static function getAllSessionList()
    {
    	return Session::pluck('academic_year', 'id');
    }


    public function student_registration_map()
    {
    	return $this->hasMany('App\Models\StudentRegistrationMap', 'session_id');
    }

    public function student_session_detail()
    {
    	return $this->hasMany('App\Models\StudentSessionDetail', 'session_id');
    }


}
