<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Kyslik\ColumnSortable\Sortable;
use Illuminate\Database\Eloquent\SoftDeletes;

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
}
