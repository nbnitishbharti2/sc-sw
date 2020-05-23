<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repositories\BloodGroupRepository;
use App\Http\Requests\BloodGroupRequest;
use App\Models\BloodGroup;
use Validator;
use Auth;
use Log;
use App;
use Session;
use Helper;

class BloodGroupController extends Controller
{
   	public function __construct(BloodGroupRepository $blood_group)
	{
		$this->blood_group = $blood_group;
	}

	/**
    * Method for show list of resources
    * 
    * @return Illuminate\Http\Response
    */
	public function index()
	{
		try {
			if(!Helper::checkPermission('view-blood-group')) {
                return back()->with('error', trans('error.unauthorized'));
            }
			$data['blood_group'] = $this->blood_group->getAllBloodGroup(); // Fetch all blood_group data
			return view('blood_group.index', $data);
		} catch(\Exception $err){
    		Log::error('Error in index on BloodGroupController :'. $err->getMessage());
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
			if(!Helper::checkPermission('add-blood-group')) {
                return back()->with('error', trans('error.unauthorized'));
            }
			$data = $this->blood_group->create();
			return view('blood_group.form', $data);
		} catch(\Exception $err){
    		Log::error('Error in create on BloodGroupController :'. $err->getMessage());
    		return back()->with('error', $err->getMessage());
    	}
	}

	/**
	* Method to create resource
	* @param App\Http\Requests\BloodGroupRequest $blood_group_request
	* @return Illuminate\Http\Response
	*/
	public function store(BloodGroupRequest $blood_group_request)
	{
		try {
			if(!Helper::checkPermission('add-blood-group')) {
                return back()->with('error', trans('error.unauthorized'));
            }
			$result = $this->blood_group->store($blood_group_request);
			if($result == true) {
				return back()->with('success', trans('success.blood_group_added_successfully'));
			}
			return back()->with('error', trans('error.blood_group_not_added'));
		} catch(\Exception $err){
    		Log::error('Error in store on BloodGroupController :'. $err->getMessage());
    		return back()->with('error', $err->getMessage());
    	}
	}

	/**
	* Method to show form for edit resource
	* @param int $blood_group_id
	* @return Illuminate\Http\Response
	*/
	public function edit($blood_group_id = 0)
	{
		try {
			if(!Helper::checkPermission('edit-blood-group')) {
                return back()->with('error', trans('error.unauthorized'));
            }
			if($blood_group_id == 0){
				return back()->with('error', trans('error.blood_group_not_found'));
			}
			$data = $this->blood_group->edit($blood_group_id);
			return view('blood_group.form', $data);
		} catch(\Exception $err){
    		Log::error('Error in edit on BloodGroupController :'. $err->getMessage());
    		return back()->with('error', $err->getMessage());
    	}
	}

	/**
	* Method to update resource
	* @param Illuminate\Http\Request
	* @return Illuminate\Http\Response
	*/
	public function update(BloodGroupRequest $request)
	{
		try {
			if(!Helper::checkPermission('edit-blood-group')) {
                return back()->with('error', trans('error.unauthorized'));
            }
			$result = $this->blood_group->update($request);
			if($result == true) {
				return redirect('view-blood-group')->with('success', trans('success.blood_group_updated_successfully'));
			}
			return back()->with('error', trans('error.blood_group_not_updated'));
		} catch(\Exception $err){
			Log::error('Error in update on BloodGroupController :'. $err->getMessage());
    		return back()->with('error', $err->getMessage());
    	}
	}

	/**
	* Method to delete resource
	* @param int $blood_group_id
	* @return Illuminate\Http\Response
	*/
	public function delete($blood_group_id = 0)
	{
		try {
			if(!Helper::checkPermission('delete-blood-group')) {
                return back()->with('error', trans('error.unauthorized'));
            }
			if($blood_group_id == 0){
				return back()->with('error', trans('error.blood_group_not_found'));
			}
			$result = $this->blood_group->delete($blood_group_id);
			if($result == true) {
				return back()->with('success', trans('success.blood_group_deleted_successfully'));
			}
			return back()->with('error', trans('error.blood_group_not_deleted'));
		} catch(\Exception $err){
    		Log::error('Error in delete on BloodGroupController :'. $err->getMessage());
    		return back()->with('error', $err->getMessage());
    	}
	}

	/**
	* Method to restore resource
	* @param int $blood_group_id
	* @return Illuminate\Http\Response
	*/
	public function restore($blood_group_id = 0)
	{
		try {
			if(!Helper::checkPermission('delete-blood-group')) {
                return back()->with('error', trans('error.unauthorized'));
            }
			if($blood_group_id == 0){
				return back()->with('error', trans('error.blood_group_not_found'));
			}
			$result = $this->blood_group->restore($blood_group_id);
			if($result == true) {
				return back()->with('success', trans('success.blood_group_restored_successfully'));
			}
			return back()->with('error', trans('error.blood_group_not_restored'));
		} catch(\Exception $err){
    		Log::error('Error in restore on BloodGroupController :'. $err->getMessage());
    		return back()->with('error', $err->getMessage());
    	}
	}

	
}
