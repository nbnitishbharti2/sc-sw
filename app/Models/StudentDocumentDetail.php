<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Kyslik\ColumnSortable\Sortable;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\StudentDetail;

class StudentDocumentDetail extends Model
{
    use Sortable;

    public $timestamps = false;

    protected $fillable = [ 'student_detail_id', 'file_name', 'file' ];

    public $sortable = ['id', 'student_detail_id', 'file_name', 'file' ];

    /**
     * Get the student detail that owns the student document.
     */
    public function student_detail()
    {
        return $this->belongsTo('App\Models\StudentDetail', 'student_detail_id');
    }

    

}
