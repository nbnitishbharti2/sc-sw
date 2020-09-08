<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Kyslik\ColumnSortable\Sortable;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\StudentRegistration;
use App\Models\StudentDetail;

class Education extends Model
{
    use Sortable;

    use SoftDeletes;

    protected $fillable = [ 'name'];

    public $sortable = ['id', 'name', 'created_at', 'updated_at'];

    public static function getAllEducationForListing()
    { 
    	 return Education::select('education.id', 'education.name')->get();
    }


    public function student_registration_father()
    {
        return $this->hasMany('App\Models\StudentRegistration', 'father_education_id');
    }

    public function student_registration_mother()
    {
        return $this->hasMany('App\Models\StudentRegistration', 'mother_education_id');
    }


    public function student_detail_father()
    {
        return $this->hasMany('App\Models\StudentDetail', 'father_education_id');
    }

    public function student_detail_mother()
    {
        return $this->hasMany('App\Models\StudentDetail', 'mother_education_id');
    }
}
