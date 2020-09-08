<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Kyslik\ColumnSortable\Sortable;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\StudentRegistration;
use App\Models\StudentDetail;

class Category extends Model
{
    use Sortable;

    use SoftDeletes;

    protected $fillable = [ 'name'];

    public $sortable = ['id', 'name', 'created_at', 'updated_at'];

    public static function getAllCategoryListing()
    { 
        return Category::select('categories.id', 'categories.name')->get();
    }

    public function student_registration()
    {
        return $this->hasMany('App\Models\StudentRegistration', 'category_id');
    }

    public function student_detail()
    {
        return $this->hasMany('App\Models\StudentDetail', 'category_id');
    }
}
