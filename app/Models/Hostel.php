<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Kyslik\ColumnSortable\Sortable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Session;
use App\Models\Facilities;


class Hostel extends Model
{
    use Sortable;

    use SoftDeletes;
   
    protected $fillable = [ 'name', 'address', 'facilities_ids', 'no_of_rooms', 'warden_name' ];

    public $sortable = ['id', 'name', 'address', 'facilities_ids', 'no_of_rooms', 'warden_name', 'created_at', 'updated_at'];

    /**
     * Get the hostel list for listing.
     */
    public static function getAllHostelForListing()
    {
    	return Hostel::select('hostels.id', 'hostels.name')->get();
    }

    
}
