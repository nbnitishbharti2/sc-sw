<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Kyslik\ColumnSortable\Sortable;
use Illuminate\Database\Eloquent\SoftDeletes;

class Category extends Model
{
    use Sortable;

    use SoftDeletes;

    protected $fillable = [ 'name'];

    public $sortable = ['id', 'name', 'created_at', 'updated_at'];

}
