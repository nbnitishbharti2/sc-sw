<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Kyslik\ColumnSortable\Sortable;
use App\Models\Hostel;

class Facilities extends Model
{
    use Sortable;

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
