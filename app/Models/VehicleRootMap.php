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

    

    
}
