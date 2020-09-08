<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Kyslik\ColumnSortable\Sortable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Session;
use App\Models\StudentDocument;
use App\Models\StudentRegistrationMap;
use App\Models\Gender;
use App\Models\BloodGroup;
use App\Models\Category;
use App\Models\Education;
use App\Models\Occupation;

class StudentRegistration extends Model
{
	use Sortable;

	use SoftDeletes;


	protected $fillable=['session_id','gender_id','category_id','blood_group_id','registration_no','name','dob','mobile_no','email','aadhar_no','primary_mobile_no','status','address'];


    public static function getLastRegisterdStudent()
    { 
        return StudentRegistration::orderBy('id','desc')->first();
    }

    public function student_registration_map()
    {
        return $this->hasOne('App\Models\StudentRegistrationMap', 'student_registration_id');
    }

    public function student_document()
    {
        return $this->hasMany('App\Models\StudentDocument', 'student_reg_id', 'id');
    }

    public function gender()
    {
        return $this->belongsTo('App\Models\Gender','gender_id');  
    }

    public function blood_group()
    {
        return $this->belongsTo('App\Models\BloodGroup','blood_group_id');  
    }

    public function category()
    {
        return $this->belongsTo('App\Models\Category','category_id');  
    }

    public function father_education()
    {
        return $this->belongsTo('App\Models\Education','father_education_id');  
    }
    public function father_occupation()
    {
        return $this->belongsTo('App\Models\Occupation','father_occupation_id');  
    }

    public function mother_education()
    {
        return $this->belongsTo('App\Models\Education','mother_education_id');  
    }
    public function mother_occupation()
    {
        return $this->belongsTo('App\Models\Occupation','mother_occupation_id');  
    }


}
