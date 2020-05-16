<?php 

namespace App\Repositories;

use App\Models\VehicleRootMap;
use App\Models\Root;
use App\Models\Vehicle;
use App\Models\VehicleType;
use Log;
use Session;

class VehicleRootMapRepository {

    /**
    * Method to fetch all resource data
    *
    * @return Collection $query
    */
    public function getAllVehicleRootMap()
    {
       
        try {
              return  $query = VehicleRootMap::withTrashed()->with(['roots','vehicle_types','vehicles'])->get();  
        } catch(\Exception $err){
            Log::error('message error in getAllVehicleRootMap on VehicleRootMapRepository :'. $err->getMessage());
            return back()->with('error', $err->getMessage());
        }
    }

    /**
    * Method to fetch create resource data
    *
    * @return array $data
    */
    public function create()
    {
        try {
            $data = [
                'action'          => route('store.vehicle_root_map'),
                'page_title'      => trans('label.vehicle_root_map'),
                'title'           => trans('title.add_vehicle_root_map'),
                'vehicle_root_map_id' => 0,
                'root_list'    => Root::getAllRootForListing(),
                'root_id'       => 0,
                'vehicle_type_list'    => VehicleType::getAllVehicleTypeForListing(),
                'vehicle_type_id'       => 0,
                'vehicle_id'       => 0,

            ];
            return $data;
        } catch(\Exception $err){
            Log::error('message error in create on VehicleRootMapRepository :'. $err->getMessage());
            return back()->with('error', $err->getMessage());
        }
    }

    public function getVehicleNo($vehicle_type_id)
    { 
        try { 
            $vehicle_ids=Vehicle::select(\DB::raw("CONCAT(vehicle_no, ' (', driver_name, ')') AS VEHICLEDETAILS"),'id')->where('vehicle_type_id',$vehicle_type_id)->pluck("VEHICLEDETAILS","id"); 
            return $vehicle_ids;
        } catch(\Exception $err){
            Log::error('message error in getVehicleNo on VehicleRootMapRepository :'. $err->getMessage());
            return back()->with('error', $err->getMessage());
        }
    }

    /**
    * Method to create resource
    * @param $request
    * @return boolean
    */
    public function store($request)
    {
        try {
            $data = [
                'root_id'          => $request->root_id,
                'vehicle_type_id'  => $request->vehicle_type_id,
                'vehicle_id'       => $request->vehicle_id,
            ];
            
            $vehicle_root_map = VehicleRootMap::create($data);
            if ($vehicle_root_map->exists) {
               return true;
            } else {
               return false;
            }
        } catch(\Exception $err){
            Log::error('message error in store on VehicleRootMapRepository :'. $err->getMessage());
            return back()->with('error', $err->getMessage());
        }
    }

    /**
    * Method to fetch edit resource data
    * @param int $vehicle_root_map_id
    * @return array $data
    */
    public function edit($vehicle_root_map_id)
    {
        try {
            $vehicle_root_map = VehicleRootMap::withTrashed()->with(['roots','vehicle_types','vehicles'])
                ->where('id',$vehicle_root_map_id)->first(); //Fetch vehicle root map data
            // Create data for edit form
            $data = [
                'action'              => route('update.vehicle_root_map'),
                'page_title'          => trans('label.vehicle_root_map'),
                'title'               => trans('title.edit_vehicle_root_map'),
                'vehicle_root_map_id' => $vehicle_root_map->id,
                'root_list'           => Root::getAllRootForListing(),
                'root_id'             => $vehicle_root_map->roots->id,
                'vehicle_type_list'   => VehicleType::getAllVehicleTypeForListing(),
                'vehicle_type_id'     => $vehicle_root_map->vehicle_types->id,
                'vehicle_id'          => $vehicle_root_map->vehicles->id,
            ];
            return $data;
        } catch(\Exception $err){ 
            Log::error('message error in edit on VehicleRootMapRepository :'. $err->getMessage());
            return back()->with('error', $err->getMessage());
        }
    }

    /**
    * Method to update resource
    * @param Illuminate\Http\Request
    * @return boolean
    */
    public function update($request)
    {
        try {
            $vehicle_root_map  = VehicleRootMap::findOrFail($request->vehicle_root_map_id); //Fetch vehicle data
            $vehicle_root_map->root_id          =  $request->root_id;
            $vehicle_root_map->vehicle_type_id  =  $request->vehicle_type_id;
            $vehicle_root_map->vehicle_id       =  $request->vehicle_id;
            $vehicle_root_map->save(); // Update data
            if ($vehicle_root_map->wasChanged()) { //Check if data was updated
               return true;
            } else {
               return false;
            }
        } catch(\Exception $err){
            Log::error('message error in update on VehicleRootMapRepository :'. $err->getMessage());
            return back()->with('error', $err->getMessage());
        }
    }

    /**
    * Method to delete resource
    * @param Illuminate\Http\Request
    * @return boolean
    */
    public function delete($vehicle_root_map_id)
    {
        try {
            $vehicle_root_map = VehicleRootMap::destroy($vehicle_root_map_id);
            if ($vehicle_root_map) { //Check if data was updated
               return true;
            } else {
               return false;
            }
        } catch(\Exception $err){
            Log::error('message error in delete on VehicleRootMapRepository :'. $err->getMessage());
            return back()->with('error', $err->getMessage());
        }
    }

    /**
    * Method to delete resource
    * @param Illuminate\Http\Request
    * @return boolean
    */
    public function restore($vehicle_root_map_id)
    {
        try {
            $vehicle_root_map = VehicleRootMap::withTrashed()->find($vehicle_root_map_id)->restore();
            if ($vehicle_root_map) { //Check if data was updated
               return true;
            } else {
               return false;
            }
        } catch(\Exception $err){
            Log::error('message error in restore on VehicleRootMapRepository :'. $err->getMessage());
            return back()->with('error', $err->getMessage());
        }
    }

    
}