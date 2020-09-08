<?php 

namespace App\Repositories;

use App\Models\Vehicle;
use App\Models\VehicleType;
use Log;
use Session;

class VehicleRepository {

    /**
    * Method to fetch all resource data
    *
    * @return Collection $query
    */
    public function getAllVehicle()
    {
       
    	try {
    		return  $query = Vehicle::withTrashed()->with('vehicle_type')->get();  
    	} catch(\Exception $err){
    		Log::error('message error in getAllVehicle on VehicleRepository :'. $err->getMessage());
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
                'action'          => route('store.vehicle'),
                'page_title'      => trans('label.vehicle'),
                'title'           => trans('title.add_vehicle'),
                'vehicle_id'      => 0,
                'driver_name'       => (old('driver_name')) ? old('driver_name') : '',
                'driver_contact_no' => (old('driver_contact_no')) ? old('driver_contact_no') : '',
                'helper_name'       => (old('helper_name')) ? old('helper_name') : '',
                'helper_contact_no' => (old('helper_contact_no')) ? old('helper_contact_no') : '',
                'vehicle_type_list'    => VehicleType::getAllVehicleTypeForListing(),
                'vehicle_type_id'       => 0,
                'vehicle_no' => (old('vehicle_no')) ? old('vehicle_no') : '',
            ];
            return $data;
        } catch(\Exception $err){
            Log::error('message error in create on VehicleRepository :'. $err->getMessage());
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
                'driver_name'        => $request->driver_name,
                'driver_contact_no'  => $request->driver_contact_no,
                'helper_name'        => $request->helper_name,
                'helper_contact_no'  => $request->helper_contact_no,
                'vehicle_type_id'    => $request->vehicle_type_id,
                'vehicle_no'         => $request->vehicle_no
            ];
           
            $vehicle = Vehicle::create($data);
            if ($vehicle->exists) {
               return true;
            } else {
               return false;
            }
        } catch(\Exception $err){
            Log::error('message error in store on VehicleRepository :'. $err->getMessage());
            return back()->with('error', $err->getMessage());
        }
    }

    /**
    * Method to fetch edit resource data
    * @param int $vehicle_id
    * @return array $data
    */
    public function edit($vehicle_id)
    {
        try {
            $vehicle = Vehicle::withTrashed()->with('vehicle_type')
                ->where('id',$vehicle_id)->first(); //Fetch vehicle data

            // Create data for edit form
            $data = [
                'action'          => route('update.vehicle'),
                'page_title'      => trans('label.vehicle'),
                'title'           => trans('title.edit_vehicle'),
                'vehicle_id'      => $vehicle->id,
                'driver_name'       => ($vehicle->driver_name) ? $vehicle->driver_name : old('driver_name'),
                'driver_contact_no' => ($vehicle->driver_contact_no) ? $vehicle->driver_contact_no : old('driver_contact_no'),
                'helper_name'       => ($vehicle->helper_name) ? $vehicle->helper_name : old('helper_name'),
                'helper_contact_no' => ($vehicle->helper_contact_no) ? $vehicle->helper_contact_no : old('helper_contact_no'),
                'vehicle_type_list'    => VehicleType::getAllVehicleTypeForListing(),
                'vehicle_type_id'       => $vehicle->vehicle_type->id,
                'vehicle_no' => ($vehicle->vehicle_no) ? $vehicle->vehicle_no : old('vehicle_no'),
            ];
            return $data;
        } catch(\Exception $err){ 
            Log::error('message error in edit on VehicleRepository :'. $err->getMessage());
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
            $vehicle  = Vehicle::findOrFail($request->vehicle_id); //Fetch vehicle data
            $vehicle->driver_name        =  $request->driver_name;
            $vehicle->driver_contact_no  =  $request->driver_contact_no;
            $vehicle->helper_name        =  $request->helper_name;
            $vehicle->helper_contact_no  =  $request->helper_contact_no;
            $vehicle->vehicle_type_id    =  $request->vehicle_type_id;
            $vehicle->vehicle_no         =  $request->vehicle_no;
            $vehicle->save(); // Update data
            if ($vehicle->wasChanged()) { //Check if data was updated
               return true;
            } else {
               return false;
            }
        } catch(\Exception $err){
            Log::error('message error in update on VehicleRepository :'. $err->getMessage());
            return back()->with('error', $err->getMessage());
        }
    }


    /**
    * Method to delete resource
    * @param Illuminate\Http\Request
    * @return boolean
    */
    public function delete($vehicle_id)
    {
        try {
            $vehicle = Vehicle::destroy($vehicle_id);
            if ($vehicle) { //Check if data was deleted
               return true;
            } else {
               return false;
            }
        } catch(\Exception $err){
            Log::error('message error in delete on VehicleRepository :'. $err->getMessage());
            return back()->with('error', $err->getMessage());
        }
    }


    /**
    * Method to delete resource
    * @param Illuminate\Http\Request
    * @return boolean
    */
    public function restore($vehicle_id)
    {
        try {
            $vehicle = Vehicle::withTrashed()->find($vehicle_id)->restore();
            if ($vehicle) { //Check if data was restored
               return true;
            } else {
               return false;
            }
        } catch(\Exception $err){
            Log::error('message error in restore on VehicleRepository :'. $err->getMessage());
            return back()->with('error', $err->getMessage());
        }
    }

    
    
}