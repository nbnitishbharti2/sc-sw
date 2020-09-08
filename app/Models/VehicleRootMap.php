<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Kyslik\ColumnSortable\Sortable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Session;
use App\Models\Root;
use App\Models\VehicleType;
use App\Models\Vehicle;

class VehicleRootMap extends Model
{
    use Sortable;

    use SoftDeletes;

    protected $fillable = [ 'root_id', 'vehicle_type_id', 'vehicle_id' ];

    public $sortable = ['id', 'root_id', 'vehicle_type_id', 'vehicle_id', 'created_at', 'updated_at'];

    /**
     * Get the root for the vehicle root map.
     */
    public function roots()
    {
        return $this->belongsTo('App\Models\Root', 'root_id', 'id');
    }

    /**
     * Get the vehicle Type for the vehicle root map.
     */
    public function vehicle_types()
    {
        return $this->belongsTo('App\Models\VehicleType', 'vehicle_type_id', 'id');
    }

    /**
     * Get the vehicles for the vehicle root map.
     */
    public function vehicles()
    {
        return $this->belongsTo('App\Models\Vehicle', 'vehicle_id', 'id');
    }



    public static function getVehicleTypeForListing($root_id)
    {
        return VehicleRootMap::with('vehicle_types')->distinct()->where('root_id',$root_id)->get()->pluck('vehicle_types.name', 'vehicle_types.id')->toArray();
    }


    public static function getVehicleForListing($root_id, $vehicle_type_id)
    {
        return Vehicle::join('vehicle_root_maps','vehicle_root_maps.vehicle_id','=','vehicles.id')->where(['vehicle_root_maps.root_id'=>$root_id,'vehicle_root_maps.vehicle_type_id'=>$vehicle_type_id])->select(\DB::raw("CONCAT(vehicles.vehicle_no, ' (', vehicles.driver_name, ')') AS VEHICLEDETAILS"),'vehicles.id')->get()->pluck('VEHICLEDETAILS', 'id')->toArray();
    }

    

    
}
