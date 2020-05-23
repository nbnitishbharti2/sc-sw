<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repositories\EducationRepository;
use App\Http\Requests\EducationRequest;
use App\Models\Education;
use Validator;
use Auth;
use Log;
use App;
use Session;
use Helper;

class EducationController extends Controller
{
   	public function __construct(EducationRepository $education)
	{
		$this->education = $education;
	}

	/**
    * Method for show list of resources
    * 
    * @return Illuminate\Http\Response
    */
	public function index()
	{
		try {
			if(!Helper::checkPermission('view-education')) {
                return back()->with('error', trans('error.unauthorized'));
            }
			$data['education'] = $this->education->getAllEducation(); // Fetch all education data
			return view('education.index', $data);
		} catch(\Exception $err){
    		Log::error('Error in index on EducationController :'. $err->getMessage());
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
			if(!Helper::checkPermission('add-education')) {
                return back()->with('error', trans('error.unauthorized'));
            }
			$data = $this->education->create();
			return view('education.form', $data);
		} catch(\Exception $err){
    		Log::error('Error in create on EducationController :'. $err->getMessage());
    		return back()->with('error', $err->getMessage());
    	}
	}

	/**
	* Method to create resource
	* @param App\Http\Requests\EducationRequest $education_request
	* @return Illuminate\Http\Response
	*/
	public function store(EducationRequest $education_request)
	{
		try {
			if(!Helper::checkPermission('add-education')) {
                return back()->with('error', trans('error.unauthorized'));
            }
			$result = $this->education->store($education_request);
			if($result == true) {
				return back()->with('success', trans('success.education_added_successfully'));
			}
			return back()->with('error', trans('error.education_not_added'));
		} catch(\Exception $err){
    		Log::error('Error in store on EducationController :'. $err->getMessage());
    		return back()->with('error', $err->getMessage());
    	}
	}

	/**
	* Method to show form for edit resource
	* @param int $education_id
	* @return Illuminate\Http\Response
	*/
	public function edit($education_id = 0)
	{
		try {
			if(!Helper::checkPermission('edit-education')) {
                return back()->with('error', trans('error.unauthorized'));
            }
			if($education_id == 0){
				return back()->with('error', trans('error.education_not_found'));
			}
			$data = $this->education->edit($education_id);
			return view('education.form', $data);
		} catch(\Exception $err){
    		Log::error('Error in edit on EducationController :'. $err->getMessage());
    		return back()->with('error', $err->getMessage());
    	}
	}

	/**
	* Method to update resource
	* @param Illuminate\Http\Request
	* @return Illuminate\Http\Response
	*/
	public function update(EducationRequest $request)
	{
		try {
			if(!Helper::checkPermission('edit-education')) {
                return back()->with('error', trans('error.unauthorized'));
            }
			$result = $this->education->update($request);
			if($result == true) {
				return redirect('view-education')->with('success', trans('success.education_updated_successfully'));
			}
			return back()->with('error', trans('error.education_not_updated'));
		} catch(\Exception $err){
			Log::error('Error in update on EducationController :'. $err->getMessage());
    		return back()->with('error', $err->getMessage());
    	}
	}

	/**
	* Method to delete resource
	* @param int $education_id
	* @return Illuminate\Http\Response
	*/
	public function delete($education_id = 0)
	{
		try {
			if(!Helper::checkPermission('delete-education')) {
                return back()->with('error', trans('error.unauthorized'));
            }
			if($education_id == 0){
				return back()->with('error', trans('error.education_not_found'));
			}
			$result = $this->education->delete($education_id);
			if($result == true) {
				return back()->with('success', trans('success.education_deleted_successfully'));
			}
			return back()->with('error', trans('error.education_not_deleted'));
		} catch(\Exception $err){
    		Log::error('Error in delete on EducationController :'. $err->getMessage());
    		return back()->with('error', $err->getMessage());
    	}
	}

	/**
	* Method to restore resource
	* @param int $education_id
	* @return Illuminate\Http\Response
	*/
	public function restore($education_id = 0)
	{
		try {
			if(!Helper::checkPermission('delete-education')) {
                return back()->with('error', trans('error.unauthorized'));
            }
			if($education_id == 0){
				return back()->with('error', trans('error.education_not_found'));
			}
			$result = $this->education->restore($education_id);
			if($result == true) {
				return back()->with('success', trans('success.education_restored_successfully'));
			}
			return back()->with('error', trans('error.education_not_restored'));
		} catch(\Exception $err){
    		Log::error('Error in restore on EducationController :'. $err->getMessage());
    		return back()->with('error', $err->getMessage());
    	}
	}

	
}
