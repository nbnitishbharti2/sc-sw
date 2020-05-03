<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Kyslik\ColumnSortable\Sortable;
use Illuminate\Database\Eloquent\SoftDeletes;

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
}
