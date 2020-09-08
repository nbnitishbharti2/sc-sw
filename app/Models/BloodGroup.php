<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Kyslik\ColumnSortable\Sortable;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\StudentRegistration;
use App\Models\StudentDetail;

class BloodGroup extends Model
{
    use Sortable;

    use SoftDeletes;

    protected $fillable = [ 'name'];

    public $sortable = ['id', 'name', 'created_at', 'updated_at'];

	public static function getAllBloodGroupListing()
    {  
        return BloodGroup::select('blood_groups.id', 'blood_groups.name')->get();
    }

    public function student_registration()
    {
        return $this->hasMany('App\Models\StudentRegistration', 'blood_group_id');
    }

    public function student_detail()
    {
        return $this->hasMany('App\Models\StudentDetail', 'blood_group_id');
    }
}
