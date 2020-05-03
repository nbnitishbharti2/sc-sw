<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Kyslik\ColumnSortable\Sortable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Session;
use App\Models\VehicleType;
use App\Models\Root;
use App\Models\VehicleRootMap;

class Vehicle extends Model
{
    use Sortable;

    use SoftDeletes;
   
    protected $fillable = [ 'driver_name', 'driver_contact_no', 'helper_name', 'helper_contact_no', 'vehicle_type_id', 'vehicle_no' ];

    public $sortable = ['id', 'driver_name', 'driver_contact_no', 'helper_name', 'helper_contact_no', 'vehicle_type_id', 'vehicle_no', 'created_at', 'updated_at'];

    /**
     * Get the vehicle type that owns the vehicle.
     */
    public function vehicle_type()
    {
        //Deleted record is required here
        return $this->belongsTo('App\Models\VehicleType', 'vehicle_type_id')->withTrashed();
    }

    /**
     * Get the root that owns the vehicle.
     */
    public function root()
    {
        return $this->belongsTo('App\Models\Root')->withTrashed();
    }

    /**
     * Get the vehicle root map that owns the vehicle.
     */
    public function vehicle_root_map()
    {
        //Deleted record is required here
        return $this->belongsTo('App\Models\VehicleRootMap', 'vehicle_id')->withTrashed();
    }

    /**
     * Get the vehicle list for listing.
     */
    public static function getAllVehicleForListing()
    {
        //Deleted record is not required here
        return Vehicle::select('vehicles.id', 'vehicles.vehicle_no', 'vehicles.driver_name')->get();
    }

}
