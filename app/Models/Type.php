<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Kyslik\ColumnSortable\Sortable;
use Illuminate\Database\Eloquent\SoftDeletes;

class Type extends Model
{   
	use Sortable;

    use SoftDeletes;

    protected $fillable = [ 'name' ];

    public $sortable = ['id', 'name', 'created_at', 'updated_at'];
    
    /**
     * Get the type list for listing.
     */
    public static function getAllTypeForListing()
    {
    	return Type::select('types.id', 'types.name')->get();
    }
}
