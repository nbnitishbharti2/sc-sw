<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Kyslik\ColumnSortable\Sortable;
use Illuminate\Database\Eloquent\SoftDeletes;

use App\Models\Classes;
use App\Models\StudentRegistrationMap;
use App\Models\StudentSessionDetail;

class Section extends Model
{
    use Sortable;

    use SoftDeletes;

    protected $fillable = [ 'classes_id', 'session_id', 'section_name', 'section_short', 'status', 'added_by', 'updated_by' ];

    public $sortable = ['id', 'section_name', 'section_short', 'created_at', 'updated_at'];

    /**
     * Get the class that owns the section.
     */
    public function class()
    {
        return $this->belongsTo('App\Models\Classes', 'classes_id');
    }

    public function student_registration_map()
    {
        return $this->hasMany('App\Models\StudentRegistrationMap', 'section_id');
    }


    public function student_session_detail()
    {
        return $this->hasMany('App\Models\StudentSessionDetail', 'section_id');
    }

    public static function getAllSectionForListing($session_id, $class_id)
    {
        return Section::where(['session_id'=>$session_id, 'classes_id'=>$class_id])->pluck('section_short','id')->toArray();
    }
}
