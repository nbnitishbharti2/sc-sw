<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repositories\StopageRepository;
use App\Http\Requests\StopageRequest;
use App\Models\Stopage;
use App\Models\VehicleRootMap;
use App\Models\Root;
use App\Models\VehicleType;
use App\Models\Vehicle;
use Validator;
use Auth;
use Lang;
use Log;
use App;
use Session;

class StopageController extends Controller
{
	public function __construct(StopageRepository $stopage)
	{
		$this->stopage = $stopage;
	}

	/**
    * Method for show list of resources
    * 
    * @return Illuminate\Http\Response
    */
	public function index()
	{
		try {
			$data['stopage'] = $this->stopage->getAllStopage(); // Fetch all stopage data
			return view('stopage.index', $data);
		} catch(\Exception $err){
			Log::error('Error in index on StopageController :'. $err->getMessage());
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
			$data = $this->stopage->create();
			return view('stopage.form', $data);
		} catch(\Exception $err){
			Log::error('Error in create on StopageController :'. $err->getMessage());
			return back()->with('error', $err->getMessage());
		}
	}

	public function getVehicleType(Request $request)
	{
		try {
			$data = $this->stopage->getVehicleType($request->root_id);
			return json_encode($data);
		} catch(\Exception $err){
			Log::error('Error in getVehicleType on StopageController :'. $err->getMessage());
			return back()->with('error', $err->getMessage());
		}
	}

	public function getVehicleNo(Request $request)
	{
		try {
			$data = $this->stopage->getVehicleNo($request->vehicle_type_id,$request->root_id);
			return json_encode($data);
		} catch(\Exception $err){
			Log::error('Error in getVehicleNo on StopageController :'. $err->getMessage());
			return back()->with('error', $err->getMessage());
		}
	}

	/**
	* Method to create resource
	* @param App\Http\Requests\StopageRequest $stopage_request
	* @return Illuminate\Http\Response
	*/
	public function store(StopageRequest $stopage_request)
	{
		try {
			$result = $this->stopage->store($stopage_request);
			if($result == true) {
				return back()->with('success', Lang::get('success.stopage_added_successfully'));
			}
			return back()->with('error', Lang::get('error.stopage_not_added'));
		} catch(\Exception $err){
			Log::error('Error in store on StopageController :'. $err->getMessage());
			return back()->with('error', $err->getMessage());
		}
	}

	/**
	* Method to show form for edit resource
	* @param int $stopage_id
	* @return Illuminate\Http\Response
	*/
	public function edit($stopage_id = 0)
	{
		try {
			if($stopage_id == 0){
				return back()->with('error', Lang::get('error.stopage_not_found'));
			}
			$data = $this->stopage->edit($stopage_id);
			return view('stopage.form', $data);
		} catch(\Exception $err){
			Log::error('Error in edit on StopageController :'. $err->getMessage());
			return back()->with('error', $err->getMessage());
		}
	}

	/**
	* Method to update resource
	* @param Illuminate\Http\Request
	* @return Illuminate\Http\Response
	*/
	public function update(StopageRequest $request)
	{
		try {
			$result = $this->stopage->update($request);
			if($result == true) {
				return redirect('view-stopage')->with('success', Lang::get('success.stopage_updated_successfully'));
			}
			return back()->with('error', Lang::get('error.stopage_not_updated'));
		} catch(\Exception $err){
			Log::error('Error in update on StopageController :'. $err->getMessage());
			return back()->with('error', $err->getMessage());
		}
	}

	/**
	* Method to delete resource
	* @param int $stopage_id
	* @return Illuminate\Http\Response
	*/
	public function delete($stopage_id = 0)
	{
		try {
			if($stopage_id == 0){
				return back()->with('error', Lang::get('error.stopage_not_found'));
			}
			$result = $this->stopage->delete($stopage_id);
			if($result == true) {
				return back()->with('success', Lang::get('success.stopage_deleted_successfully'));
			}
			return back()->with('error', Lang::get('error.stopage_not_deleted'));
		} catch(\Exception $err){
			Log::error('Error in delete on StopageController :'. $err->getMessage());
			return back()->with('error', $err->getMessage());
		}
	}

	/**
	* Method to restore resource
	* @param int $stopage_id
	* @return Illuminate\Http\Response
	*/
	public function restore($stopage_id = 0)
	{
		try {
			if($stopage_id == 0){
				return back()->with('error', Lang::get('error.stopage_not_found'));
			}
			$result = $this->stopage->restore($stopage_id);
			if($result == true) {
				return back()->with('success', Lang::get('success.stopage_restored_successfully'));
			}
			return back()->with('error', Lang::get('error.stopage_not_restored'));
		} catch(\Exception $err){
			Log::error('Error in restore on StopageController :'. $err->getMessage());
			return back()->with('error', $err->getMessage());
		}
	}
	public function import()
	{
		try {
			if(Session::get('nextsession')==null){
				return back()->with('error', Lang::get('error.previous_session_not_found'));
			}
			$result = $this->stopage->importPreviousSessionStopages(); //Import previous session classes
			if($result == true) {
				return back()->with('success', Lang::get('success.all_previous_session_stopages_imported'));
			}
			return back()->with('error', Lang::get('error.stopages_not_found_in_previous_session'));
		} catch(\Exception $err){
			Log::error('Error in import on StopageController :'. $err->getMessage());
			return back()->with('error', $err->getMessage());
		}
	}

	
}
