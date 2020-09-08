<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Kyslik\ColumnSortable\Sortable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Session;
use App\Models\StudentRegistrationMap;
use App\Models\StudentSessionDetail;

class Classes extends Model
{
    use Sortable;

    use SoftDeletes;

    protected $fillable = [ 'session_id', 'class_name', 'class_short', 'added_by', 'updated_by' ];

    public $sortable = ['id', 'class_name', 'class_short', 'created_at', 'updated_at'];

    /**
     * Get the sections for the class.
     */
    public function sections()
    {
        return $this->hasMany('App\Models\Section', 'classes_id', 'id');
    }


    public function student_registration_map()
    {
        return $this->hasMany('App\Models\StudentRegistrationMap', 'class_id');
    }

    public function student_session_detail()
    {
        return $this->hasMany('App\Models\StudentSessionDetail', 'class_id');
    }

    /**
     * Get the class list for listing.
     */
    public static function getAllClassForListing($session=null)
    {
        $session_id=($session)?$session:Session::get('session');
        return Classes::select('classes.id', 'classes.class_short')->leftjoin('sessions', 'sessions.id', 'classes.session_id')->where('sessions.id', $session_id)->get();
    }

    /**
     * Get the single class list for listing. // edit of fee for class
     */
    public static function getSingleClassForListing($class_id)
    {
        return Classes::select('classes.id', 'classes.class_short')->where('classes.id',$class_id)->leftjoin('sessions', 'sessions.id', 'classes.session_id')->where('sessions.id', Session::get('session'))->get();
    }
}
