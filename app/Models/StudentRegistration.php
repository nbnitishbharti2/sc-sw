<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StudentRegistration extends Model
{
	protected $fillable=['session_id','gender_id','category_id','blood_group_id','registration_no','name','dob','mobile_no','email','aadhar_no','primary_mobile_no','status','address'];
    public static function getLastRegisterdStudent()
    { 
        return StudentRegistration::orderBy('id','desc')->first();
    }
}
