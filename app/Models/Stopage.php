<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Kyslik\ColumnSortable\Sortable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Session;
use App\Models\Root;
use App\Models\VehicleType;
use App\Models\Vehicle;

class Stopage extends Model
{
    use Sortable;

    use SoftDeletes;

    protected $fillable = [ 'session_id', 'stopage_name', 'root_id', 'vehicle_type_id', 'vehicle_id', 'charge' ];

    public $sortable = ['id', 'session_id', 'stopage_name', 'root_id', 'vehicle_type_id', 'vehicle_id', 'charge', 'created_at', 'updated_at'];

    /**
     * Get the root for the stopage.
     */
    public function roots()
    {
        return $this->belongsTo('App\Models\Root', 'root_id', 'id');
    }

    /**
     * Get the vehicle Type for the stopage.
     */
    public function vehicle_types()
    {
        return $this->belongsTo('App\Models\VehicleType', 'vehicle_type_id', 'id');
    }

    /**
     * Get the vehicles for the stopage.
     */
    public function vehicles()
    {
        return $this->belongsTo('App\Models\Vehicle', 'vehicle_id', 'id');
    }

    public static function getStopageForListing($root_id, $vehicle_type_id, $vehicle_id)
    {
        return $stopages = Stopage::where(['root_id'=>$root_id, 'vehicle_type_id'=>$vehicle_type_id, 'vehicle_id'=>$vehicle_id])->pluck('stopage_name', 'id')->toArray();
    }

    

    
}
