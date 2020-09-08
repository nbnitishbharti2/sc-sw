<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Kyslik\ColumnSortable\Sortable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Session;
//use App\Models\StudentDocument;
use App\Models\StudentSessionDetail;
use App\Models\Gender;
use App\Models\BloodGroup;
use App\Models\Category;
use App\Models\Education;
use App\Models\Occupation;
use App\Models\StudentDocumentDetail;

class StudentDetail extends Model
{
    use Sortable;

	use SoftDeletes;


	protected $fillable=[ 'session_id', 'student_registration_id', 'admission_no', 'roll_no',   'gender_id', 'blood_group_id', 'category_id', 'name', 'dob', 'aadhar_no', 'cast',       'mobile_no', 'primary_mobile_no', 'email', 'date_of_admission', 'date_of_registration', 'address', 'city', 'district', 'state', 'country', 'zip_code', 'father_name','father_mobile_no', 'father_occupation_id', 'father_education_id', 'mother_name','mother_mobile_no', 'mother_occupation_id', 'mother_education_id', 'image' ];


    public static function getLastAdmissionedStudent($session_id)
    { 
        return StudentDetail::where('session_id',$session_id)->orderBy('id','desc')->first();
    }

    // public static function getLastRollNoOfStudent($session_id)
    // { 
    //     return StudentDetail::where('session_id',$session_id)->orderBy('id','desc')->first();
    // }


    public static function isRegisteredAdmitted($session_id, $reg_id)
    {
        return StudentDetail::where(['session_id'=>$session_id,'student_registration_id'=>$reg_id])->count();
    }

    public function student_session_detail()
    {
        //must be hasMany
        return $this->hasOne('App\Models\StudentSessionDetail', 'student_detail_id');
    }

    public function student_document_detail()
    {
        return $this->hasMany('App\Models\StudentDocumentDetail', 'student_detail_id', 'id');
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
