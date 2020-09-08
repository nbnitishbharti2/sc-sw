<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repositories\VehicleTypeRepository;
use App\Http\Requests\VehicleTypeRequest;
use App\Models\VehicleType;
use Validator;
use Auth;
use Log;
use App;
use Session;
use Helper;


class VehicleTypeController extends Controller
{
   	public function __construct(VehicleTypeRepository $vehicle_type)
	{
		$this->vehicle_type = $vehicle_type;
	}

	/**
    * Method for show list of resources
    * 
    * @return Illuminate\Http\Response
    */
	public function index()
	{
		try {
			if(!Helper::checkPermission('view-vehicle-type')) {
                return back()->with('error', trans('error.unauthorized'));
            }
			$data['vehicle_type'] = $this->vehicle_type->getAllVehicleType(); // Fetch all vehicle type data
			return view('vehicle_type.index', $data);
		} catch(\Exception $err){
    		Log::error('Error in index on VehicleTypeController :'. $err->getMessage());
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
			if(!Helper::checkPermission('add-vehicle-type')) {
                return back()->with('error', trans('error.unauthorized'));
            }
			$data = $this->vehicle_type->create();
			return view('vehicle_type.form', $data);
		} catch(\Exception $err){
    		Log::error('Error in create on VehicleTypeController :'. $err->getMessage());
    		return back()->with('error', $err->getMessage());
    	}
	}

	/**
	* Method to create resource
	* @param App\Http\Requests\VehicleTypeRequest $vehicle_type_request
	* @return Illuminate\Http\Response
	*/
	public function store(VehicleTypeRequest $vehicle_type_request)
	{
		try {
			if(!Helper::checkPermission('add-vehicle-type')) {
                return back()->with('error', trans('error.unauthorized'));
            }
			$result = $this->vehicle_type->store($vehicle_type_request);
			if($result == true) {
				return back()->with('success', trans('success.vehicle_type_added_successfully'));
			}
			return back()->with('error', trans('error.vehicle_type_not_added'));
		} catch(\Exception $err){
    		Log::error('Error in store on VehicleTypeController :'. $err->getMessage());
    		return back()->with('error', $err->getMessage());
    	}
	}

	/**
	* Method to show form for edit resource
	* @param int $vehicle_type_id
	* @return Illuminate\Http\Response
	*/
	public function edit($vehicle_type_id = 0)
	{
		try {
			if(!Helper::checkPermission('edit-vehicle-type')) {
                return back()->with('error', trans('error.unauthorized'));
            }
			if($vehicle_type_id == 0){
				return back()->with('error', trans('error.vehicle_type_not_found'));
			}
			$data = $this->vehicle_type->edit($vehicle_type_id);
			return view('vehicle_type.form', $data);
		} catch(\Exception $err){
    		Log::error('Error in edit on VehicleTypeController :'. $err->getMessage());
    		return back()->with('error', $err->getMessage());
    	}
	}

	/**
	* Method to update resource
	* @param Illuminate\Http\Request
	* @return Illuminate\Http\Response
	*/
	public function update(VehicleTypeRequest $request)
	{
		try {
			if(!Helper::checkPermission('edit-vehicle-type')) {
                return back()->with('error', trans('error.unauthorized'));
            }
			$result = $this->vehicle_type->update($request);
			if($result == true) {
				return redirect('view-vehicle-type')->with('success', trans('success.vehicle_type_updated_successfully'));
			}
			return back()->with('error', trans('error.vehicle_type_not_updated'));
		} catch(\Exception $err){
			Log::error('Error in update on VehicleTypeController :'. $err->getMessage());
    		return back()->with('error', $err->getMessage());
    	}
	}

	/**
	* Method to delete resource
	* @param int $vehicle_type_id
	* @return Illuminate\Http\Response
	*/
	public function delete($vehicle_type_id = 0)
	{
		try {
			if(!Helper::checkPermission('delete-vehicle-type')) {
                return back()->with('error', trans('error.unauthorized'));
            }
			if($vehicle_type_id == 0){
				return back()->with('error', trans('error.vehicle_type_not_found'));
			}
			$result = $this->vehicle_type->delete($vehicle_type_id);
			if($result == true) {
				return back()->with('success', trans('success.vehicle_type_deleted_successfully'));
			}
			return back()->with('error', trans('error.vehicle_type_not_deleted'));
		} catch(\Exception $err){
    		Log::error('Error in delete on VehicleTypeController :'. $err->getMessage());
    		return back()->with('error', $err->getMessage());
    	}
	}

	/**
	* Method to restore resource
	* @param int $vehicle_type_id
	* @return Illuminate\Http\Response
	*/
	public function restore($vehicle_type_id = 0)
	{
		try {
			if(!Helper::checkPermission('delete-vehicle-type')) {
                return back()->with('error', trans('error.unauthorized'));
            }
			if($vehicle_type_id == 0){
				return back()->with('error', trans('error.vehicle_type_not_found'));
			}
			$result = $this->vehicle_type->restore($vehicle_type_id);
			if($result == true) {
				return back()->with('success', trans('success.vehicle_type_restored_successfully'));
			}
			return back()->with('error', trans('error.vehicle_type_not_restored'));
		} catch(\Exception $err){
    		Log::error('Error in restore on VehicleTypeController :'. $err->getMessage());
    		return back()->with('error', $err->getMessage());
    	}
	}

	
}
