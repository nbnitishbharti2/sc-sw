<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Kyslik\ColumnSortable\Sortable;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\StudentRegistration;

class StudentDocument extends Model
{
    use Sortable;

    public $timestamps = false;

    protected $fillable = [ 'student_reg_id', 'file_name', 'file' ];

    public $sortable = ['id', 'student_reg_id', 'file_name', 'file' ];

    /**
     * Get the student registration that owns the student document.
     */
    public function student_registration()
    {
        return $this->belongsTo('App\Models\StudentRegistration', 'student_reg_id');
    }

    

}
