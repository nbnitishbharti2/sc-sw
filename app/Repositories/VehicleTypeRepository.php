<?php 

namespace App\Repositories;

use App\Models\VehicleType;
use Log;
use Lang;
use Session;
class VehicleTypeRepository {

    /**
    * Method to fetch all resource data
    *
    * @return Collection $query
    */
    public function getAllVehicleType()
    {
       
    	try {
    		  return  $query = VehicleType::withTrashed()->get();  
    	} catch(\Exception $err){
    		Log::error('message error in getAllVehicleType on VehicleTypeRepository :'. $err->getMessage());
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
                'action'          => route('store.vehicle_type'),
                'page_title'      => Lang::get('label.vehicle_type'),
                'title'           => Lang::get('title.add_vehicle_type'),
                'vehicle_type_id' => 0,
                'name'            => (old('name')) ? old('name') : '',
            ];
            return $data;
        } catch(\Exception $err){
            Log::error('message error in create on VehicleTypeRepository :'. $err->getMessage());
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
                'name'    => $request->name
            ];
            
            $vehicle_type = VehicleType::create($data);
            if ($vehicle_type->exists) {
               return true;
            } else {
               return false;
            }
        } catch(\Exception $err){
            Log::error('message error in store on VehicleTypeRepository :'. $err->getMessage());
            return back()->with('error', $err->getMessage());
        }
    }

    /**
    * Method to fetch edit resource data
    * @param int $vehicle_type_id
    * @return array $data
    */
    public function edit($vehicle_type_id)
    {
        try {
            $vehicle_type = VehicleType::findOrFail($vehicle_type_id); //Fetch vehicle type data 
            $data = [
                'action'          => route('update.vehicle_type'),
                'page_title'      => Lang::get('label.vehicle_type'),
                'title'           => Lang::get('title.edit_vehicle_type'),
                'vehicle_type_id' => $vehicle_type->id,
                'name'      => ($vehicle_type->name) ? $vehicle_type->name : old('name')
            ];
            return $data;
        } catch(\Exception $err){ 
            Log::error('message error in edit on VehicleTypeRepository :'. $err->getMessage());
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
            $vehicle_type  = VehicleType::findOrFail($request->vehicle_type_id); //Fetch vehicle type data
            $vehicle_type->name  = $request->name;
            $vehicle_type->save(); // Update data
            if ($vehicle_type->wasChanged()) { //Check if data was updated
               return true;
            } else {
               return false;
            }
        } catch(\Exception $err){
            Log::error('message error in update on VehicleTypeRepository :'. $err->getMessage());
            return back()->with('error', $err->getMessage());
        }
    }

    /**
    * Method to delete resource
    * @param Illuminate\Http\Request
    * @return boolean
    */
    public function delete($vehicle_type_id)
    {
        try {
            $vehicle_type = VehicleType::destroy($vehicle_type_id);
            if ($vehicle_type) { //Check if data was deleted
               return true;
            } else {
               return false;
            }
        } catch(\Exception $err){
            Log::error('message error in delete on VehicleTypeRepository :'. $err->getMessage());
            return back()->with('error', $err->getMessage());
        }
    }

    /**
    * Method to delete resource
    * @param Illuminate\Http\Request
    * @return boolean
    */
    public function restore($vehicle_type_id)
    {
        try {
            $vehicle_type = VehicleType::withTrashed()->find($vehicle_type_id)->restore();
            if ($vehicle_type) { //Check if data was restored
               return true;
            } else {
               return false;
            }
        } catch(\Exception $err){
            Log::error('message error in restore on VehicleTypeRepository :'. $err->getMessage());
            return back()->with('error', $err->getMessage());
        }
    }

    
}