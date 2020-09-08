<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repositories\VehicleRootMapRepository;
use App\Http\Requests\VehicleRootMapRequest ;
use App\Models\VehicleRootMap;
use App\Models\Root;
use App\Models\VehicleType;
use App\Models\Vehicle;
use Validator;
use Auth;
use Log;
use App;
use Session;
use Helper;


class VehicleRootMapController extends Controller
{
   	public function __construct(VehicleRootMapRepository $vehicle_root_map)
	{
		$this->vehicle_root_map = $vehicle_root_map;
	}

	/**
    * Method for show list of resources
    * 
    * @return Illuminate\Http\Response
    */
	public function index()
	{
		try {
			if(!Helper::checkPermission('view-vehicle-root-map')) {
                return back()->with('error', trans('error.unauthorized'));
            }
			$data['vehicle_root_map'] = $this->vehicle_root_map->getAllVehicleRootMap(); // Fetch all Vehicle root map data
			return view('vehicle_root_map.index', $data);
		} catch(\Exception $err){
    		Log::error('Error in index on VehicleRootMapController :'. $err->getMessage());
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
			if(!Helper::checkPermission('add-vehicle-root-map')) {
                return back()->with('error', trans('error.unauthorized'));
            }
			$data = $this->vehicle_root_map->create();
			return view('vehicle_root_map.form', $data);
		} catch(\Exception $err){
    		Log::error('Error in create on VehicleRootMapController :'. $err->getMessage());
    		return back()->with('error', $err->getMessage());
    	}
	}

	public function getVehicleNo(Request $request)
    {
    	try {
			$data = $this->vehicle_root_map->getVehicleNo($request->vehicle_type_id);
			return json_encode($data);
		} catch(\Exception $err){
    		Log::error('Error in getVehicleNo on VehicleRootMapController :'. $err->getMessage());
    		return back()->with('error', $err->getMessage());
    	}
    }

	/**
	* Method to create resource
	* @param App\Http\Requests\VehicleRootMapRequest $vehicle_root_map_request
	* @return Illuminate\Http\Response
	*/
	public function store(VehicleRootMapRequest $vehicle_root_map_request)
	{
		try {
			if(!Helper::checkPermission('add-vehicle-root-map')) {
                return back()->with('error', trans('error.unauthorized'));
            }
			$result = $this->vehicle_root_map->store($vehicle_root_map_request);
			if($result == true) {
				return back()->with('success', trans('success.vehicle_root_map_added_successfully'));
			}
			return back()->with('error', trans('error.vehicle_root_map_not_added'));
		} catch(\Exception $err){
    		Log::error('Error in store on VehicleRootMapController :'. $err->getMessage());
    		return back()->with('error', $err->getMessage());
    	}
	}

	/**
	* Method to show form for edit resource
	* @param int $vehicle_root_map_id
	* @return Illuminate\Http\Response
	*/
	public function edit($vehicle_root_map_id = 0)
	{
		try {
			if(!Helper::checkPermission('edit-vehicle-root-map')) {
                return back()->with('error', trans('error.unauthorized'));
            }
			if($vehicle_root_map_id == 0){
				return back()->with('error', trans('error.vehicle_root_map_not_found'));
			}
			$data = $this->vehicle_root_map->edit($vehicle_root_map_id);
			return view('vehicle_root_map.form', $data);
		} catch(\Exception $err){
    		Log::error('Error in edit on VehicleRootMapController :'. $err->getMessage());
    		return back()->with('error', $err->getMessage());
    	}
	}

	/**
	* Method to update resource
	* @param Illuminate\Http\Request
	* @return Illuminate\Http\Response
	*/
	public function update(VehicleRootMapRequest $request)
	{
		try {
			if(!Helper::checkPermission('edit-vehicle-root-map')) {
                return back()->with('error', trans('error.unauthorized'));
            }
			$result = $this->vehicle_root_map->update($request);
			if($result == true) {
				return redirect('view-vehicle-root-map')->with('success', trans('success.vehicle_root_map_updated_successfully'));
			}
			return back()->with('error', trans('error.vehicle_root_map_not_updated'));
		} catch(\Exception $err){
			Log::error('Error in update on VehicleRootMapController :'. $err->getMessage());
    		return back()->with('error', $err->getMessage());
    	}
	}

	/**
	* Method to delete resource
	* @param int $vehicle_root_map_id
	* @return Illuminate\Http\Response
	*/
	public function delete($vehicle_root_map_id = 0)
	{
		try {
			if(!Helper::checkPermission('delete-vehicle-root-map')) {
                return back()->with('error', trans('error.unauthorized'));
            }
			if($vehicle_root_map_id == 0){
				return back()->with('error', trans('error.vehicle_root_map_not_found'));
			}
			$result = $this->vehicle_root_map->delete($vehicle_root_map_id);
			if($result == true) {
				return back()->with('success', trans('success.vehicle_root_map_deleted_successfully'));
			}
			return back()->with('error', trans('error.vehicle_root_map_not_deleted'));
		} catch(\Exception $err){
    		Log::error('Error in delete on VehicleRootMapController :'. $err->getMessage());
    		return back()->with('error', $err->getMessage());
    	}
	}

	/**
	* Method to restore resource
	* @param int $vehicle_root_map_id
	* @return Illuminate\Http\Response
	*/
	public function restore($vehicle_root_map_id = 0)
	{
		try {
			if(!Helper::checkPermission('delete-vehicle-root-map')) {
                return back()->with('error', trans('error.unauthorized'));
            }
			if($vehicle_root_map_id == 0){
				return back()->with('error', trans('error.vehicle_root_map_not_found'));
			}
			$result = $this->vehicle_root_map->restore($vehicle_root_map_id);
			if($result == true) {
				return back()->with('success', trans('success.vehicle_root_map_restored_successfully'));
			}
			return back()->with('error', trans('error.vehicle_root_map_not_restored'));
		} catch(\Exception $err){
    		Log::error('Error in restore on VehicleRootMapController :'. $err->getMessage());
    		return back()->with('error', $err->getMessage());
    	}
	}

	
}
