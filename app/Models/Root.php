<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Kyslik\ColumnSortable\Sortable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Session;

use App\Models\Vehicle;
use App\Models\VehicleRootMap;

class Root extends Model
{
    use Sortable;

    use SoftDeletes;

    protected $fillable = [ 'name' ];

    public $sortable = ['id', 'name', 'created_at', 'updated_at'];

    /**
     * Get the vehicles for the root.
     */
    public function vehicles()
    {
        return $this->hasMany('App\Models\Vehicle', 'root_id', 'id');
    }

    /**
     * Get the vehicle root map that owns the root.
     */
    public function vehicle_root_map()
    {
        return $this->hasMany('App\Models\VehicleRootMap')->withTrashed();
    }

    /**
     * Get the root list for listing.
     */
    public static function getAllRootForListing()
    {
    	return Root::select('roots.id', 'roots.name')->get();
    }


    
}
