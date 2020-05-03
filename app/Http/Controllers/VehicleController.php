<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repositories\VehicleRepository;
use App\Http\Requests\VehicleRequest ;
use App\Models\Vehicle;
use App\Models\VehicleType;
use Validator;
use Auth;
use Lang;
use Log;
use App;
use Session;

class VehicleController extends Controller
{
   	public function __construct(VehicleRepository $vehicle)
	{
		$this->vehicle = $vehicle;
	}

	/**
    * Method for show list of resources
    * 
    * @return Illuminate\Http\Response
    */
	public function index()
	{
		try {
			$data['vehicle'] = $this->vehicle->getAllVehicle(); // Fetch all vehicle data
			return view('vehicle.index', $data);
		} catch(\Exception $err){
    		Log::error('Error in index on VehicleController :'. $err->getMessage());
    		return back()->with('error', $err->getMessage());
    	}
	}

	/**
	* Method to show form for create resource
	*
	* @return Illuminate\Http\Response
	*/
	public function create()
	{
		try {
			$data = $this->vehicle->create();
			return view('vehicle.form', $data);
		} catch(\Exception $err){
    		Log::error('Error in create on VehicleController :'. $err->getMessage());
    		return back()->with('error', $err->getMessage());
    	}
	}

	/**
	* Method to create resource
	* @param App\Http\Requests\VehicleRequest $vehicle_request
	* @return Illuminate\Http\Response
	*/
	public function store(VehicleRequest $vehicle_request)
	{
		try {
			$result = $this->vehicle->store($vehicle_request);
			if($result == true) {
				return back()->with('success', Lang::get('success.vehicle_added_successfully'));
			}
			return back()->with('error', Lang::get('error.vehicle_not_added'));
		} catch(\Exception $err){
    		Log::error('Error in store on VehicleController :'. $err->getMessage());
    		return back()->with('error', $err->getMessage());
    	}
	}

	/**
	* Method to show form for edit resource
	* @param int $vehicle_id
	* @return Illuminate\Http\Response
	*/
	public function edit($vehicle_id = 0)
	{
		try {
			if($vehicle_id == 0){
				return back()->with('error', Lang::get('error.vehicle_not_found'));
			}
			$data = $this->vehicle->edit($vehicle_id);
			return view('vehicle.form', $data);
		} catch(\Exception $err){
    		Log::error('Error in edit on VehicleController :'. $err->getMessage());
    		return back()->with('error', $err->getMessage());
    	}
	}

	/**
	* Method to update resource
	* @param Illuminate\Http\Request
	* @return Illuminate\Http\Response
	*/
	public function update(VehicleRequest $request)
	{
		try {
			$result = $this->vehicle->update($request);
			if($result == true) {
				return redirect('view-vehicle')->with('success', Lang::get('success.vehicle_updated_successfully'));
			}
			return back()->with('error', Lang::get('error.vehicle_not_updated'));
		} catch(\Exception $err){
			Log::error('Error in update on VehicleController :'. $err->getMessage());
    		return back()->with('error', $err->getMessage());
    	}
	}

	/**
	* Method to delete resource
	* @param int $vehicle_id
	* @return Illuminate\Http\Response
	*/
	public function delete($vehicle_id = 0)
	{
		try {
			if($vehicle_id == 0){
				return back()->with('error', Lang::get('error.vehicle_not_found'));
			}
			$result = $this->vehicle->delete($vehicle_id);
			if($result == true) {
				return back()->with('success', Lang::get('success.vehicle_deleted_successfully'));
			}
			return back()->with('error', Lang::get('error.vehicle_not_deleted'));
		} catch(\Exception $err){
    		Log::error('Error in delete on VehicleController :'. $err->getMessage());
    		return back()->with('error', $err->getMessage());
    	}
	}

	/**
	* Method to restore resource
	* @param int $vehicle_id
	* @return Illuminate\Http\Response
	*/
	public function restore($vehicle_id = 0)
	{
		try {
			if($vehicle_id == 0){
				return back()->with('error', Lang::get('error.vehicle_not_found'));
			}
			$result = $this->vehicle->restore($vehicle_id);
			if($result == true) {
				return back()->with('success', Lang::get('success.vehicle_restored_successfully'));
			}
			return back()->with('error', Lang::get('error.vehicle_not_restored'));
		} catch(\Exception $err){
    		Log::error('Error in restore on VehicleController :'. $err->getMessage());
    		return back()->with('error', $err->getMessage());
    	}
	}

	
}
