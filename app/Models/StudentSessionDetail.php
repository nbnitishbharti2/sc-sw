<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\StudentSessionDetail;
use App\Models\Session;
use App\Models\Classes;
use App\Models\Section;

class StudentSessionDetail extends Model
{
    protected $fillable=['session_id','class_id','section_id','student_detail_id','admission_by','admission_no', 'roll_no', 'date_of_admission', 'siblings', 'type', 'transport', 'hostel','register_by'];

    public function student_detail()
    {
    	return $this->belongsTo('App\Models\StudentDetail','student_detail_id');  //,'id'
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
