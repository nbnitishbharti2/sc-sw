<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\StudentRegistration;
use App\Models\Session;
use App\Models\Classes;
use App\Models\Section;

class StudentRegistrationMap extends Model
{
    protected $fillable=['session_id','class_id','section_id','student_registration_id','register_by'];

    public function student_registration()
    {
    	return $this->belongsTo('App\Models\StudentRegistration','student_registration_id');  //,'id'
    }

    public function session()
    {
    	return $this->belongsTo('App\Models\Session','session_id');  
    }

    public function class()
    {
    	return $this->belongsTo('App\Models\Classes','class_id');  
    }

    public function section()
    {
    	return $this->belongsTo('App\Models\Section','section_id');  
    }
}
