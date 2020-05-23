<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repositories\FacilityRepository;
use App\Http\Requests\FacilityRequest;
use App\Models\Facilities;
use Validator;
use Auth;
use Log;
use App;
use Session;
use Helper;

class FacilityController extends Controller
{
   	public function __construct(FacilityRepository $facility)
	{
		$this->facility = $facility;
	}

	/**
    * Method for show list of resources
    * 
    * @return Illuminate\Http\Response
    */
	public function index()
	{
		try {
			if(!Helper::checkPermission('view-facility')) {
                return back()->with('error', trans('error.unauthorized'));
            }
			$data['facility'] = $this->facility->getAllFacility(); // Fetch all facility data
			return view('facility.index', $data);
		} catch(\Exception $err){
    		Log::error('Error in index on FacilityController :'. $err->getMessage());
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
			if(!Helper::checkPermission('add-facility')) {
                return back()->with('error', trans('error.unauthorized'));
            }
			$data = $this->facility->create();
			return view('facility.form', $data);
		} catch(\Exception $err){
    		Log::error('Error in create on FacilityController :'. $err->getMessage());
    		return back()->with('error', $err->getMessage());
    	}
	}

	/**
	* Method to create resource
	* @param App\Http\Requests\FacilityRequest $facility_request
	* @return Illuminate\Http\Response
	*/
	public function store(FacilityRequest $facility_request)
	{
		try {
			if(!Helper::checkPermission('add-facility')) {
                return back()->with('error', trans('error.unauthorized'));
            }
			$result = $this->facility->store($facility_request);
			if($result == true) {
				return back()->with('success', trans('success.facility_added_successfully'));
			}
			return back()->with('error', trans('error.facility_not_added'));
		} catch(\Exception $err){
    		Log::error('Error in store on FacilityController :'. $err->getMessage());
    		return back()->with('error', $err->getMessage());
    	}
	}

	/**
	* Method to show form for edit resource
	* @param int $facility_id
	* @return Illuminate\Http\Response
	*/
	public function edit($facility_id = 0)
	{
		try {
			if(!Helper::checkPermission('edit-facility')) {
                return back()->with('error', trans('error.unauthorized'));
            }
			if($facility_id == 0){
				return back()->with('error', trans('error.facility_not_found'));
			}
			$data = $this->facility->edit($facility_id);
			return view('facility.form', $data);
		} catch(\Exception $err){
    		Log::error('Error in edit on FacilityController :'. $err->getMessage());
    		return back()->with('error', $err->getMessage());
    	}
	}

	/**
	* Method to update resource
	* @param Illuminate\Http\Request
	* @return Illuminate\Http\Response
	*/
	public function update(FacilityRequest $request)
	{
		try {
			if(!Helper::checkPermission('edit-facility')) {
                return back()->with('error', trans('error.unauthorized'));
            }
			$result = $this->facility->update($request);
			if($result == true) {
				return redirect('view-facility')->with('success', trans('success.facility_updated_successfully'));
			}
			return back()->with('error', trans('error.facility_not_updated'));
		} catch(\Exception $err){
			Log::error('Error in update on FacilityController :'. $err->getMessage());
    		return back()->with('error', $err->getMessage());
    	}
	}

	/**
	* Method to delete resource
	* @param int $facility_id
	* @return Illuminate\Http\Response
	*/
	public function delete($facility_id = 0)
	{
		try {
			if(!Helper::checkPermission('delete-facility')) {
                return back()->with('error', trans('error.unauthorized'));
            }
			if($facility_id == 0){
				return back()->with('error', trans('error.facility_not_found'));
			}
			$result = $this->facility->delete($facility_id);
			if($result == true) {
				return back()->with('success', trans('success.facility_deleted_successfully'));
			}
			return back()->with('error', trans('error.facility_not_deleted'));
		} catch(\Exception $err){
    		Log::error('Error in delete on FacilityController :'. $err->getMessage());
    		return back()->with('error', $err->getMessage());
    	}
	}

	/**
	* Method to restore resource
	* @param int $facility_id
	* @return Illuminate\Http\Response
	*/
	public function restore($facility_id = 0)
	{
		try {
			if(!Helper::checkPermission('delete-facility')) {
                return back()->with('error', trans('error.unauthorized'));
            }
			if($facility_id == 0){
				return back()->with('error', trans('error.facility_not_found'));
			}
			$result = $this->facility->restore($facility_id);
			if($result == true) {
				return back()->with('success', trans('success.facility_restored_successfully'));
			}
			return back()->with('error', trans('error.facility_not_restored'));
		} catch(\Exception $err){
    		Log::error('Error in restore on FacilityController :'. $err->getMessage());
    		return back()->with('error', $err->getMessage());
    	}
	}

	
}
