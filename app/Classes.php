<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Kyslik\ColumnSortable\Sortable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Session;
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
        return $this->hasMany('App\Section', 'classes_id', 'id');
    }

    /**
     * Get the class list for listing.
     */
    public static function getAllClassForListing()
    {
        return Classes::select('classes.id', 'classes.class_short')->leftjoin('sessions', 'sessions.id', 'classes.session_id')->where('sessions.id', Session::get('session'))->get();
    }
}
