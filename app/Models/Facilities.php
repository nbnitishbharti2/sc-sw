<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Kyslik\ColumnSortable\Sortable;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Hostel;

class Facilities extends Model
{
    use Sortable;

    use SoftDeletes;

    protected $fillable = [ 'name'];

    public $sortable = ['id', 'name', 'created_at', 'updated_at'];

    
    /**
     * Get the facility list for listing.
     */
    public static function getAllFacilitiesForListing()
    { 
        return Facilities::pluck('name','id');
    }
}
