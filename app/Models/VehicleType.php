<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Kyslik\ColumnSortable\Sortable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Session;
use App\Models\Vehicle;
use App\Models\VehicleRootMap;

class VehicleType extends Model
{
    use Sortable;

    use SoftDeletes;

    protected $fillable = [ 'name' ];

    public $sortable = ['id', 'name', 'created_at', 'updated_at'];

	/**
     * Get the vehicles for the vehicle type.
     */
    public function vehicles()
    {
        return $this->hasMany('App\Models\Vehicle', 'vehicle_type_id', 'id');
    }

    /**
     * Get the vehicle root map that owns the vehicle type.
     */
    public function vehicle_root_map()
    {
        return $this->belongsTo('App\Models\VehicleRootMap', 'vehicle_type_id')->withTrashed();
    }

    /**
     * Get the vehicle type list for listing.
     */
    public static function getAllVehicleTypeForListing()
    {
    	return VehicleType::select('vehicle_types.id', 'vehicle_types.name')->get();
    }
    


    
}
