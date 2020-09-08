<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repositories\HostelFeeRepository;
use App\Http\Requests\HostelFeeRequest ;
use App\Models\HostelFee;
use Validator;
use Auth;
use Log;
use App;
use Session;
use Helper;


class HostelFeeController extends Controller
{
   	public function __construct(HostelFeeRepository $hostel_fee)
	{
		$this->hostel_fee = $hostel_fee;
	}

	/**
    * Method for show list of resources
    * 
    * @return Illuminate\Http\Response
    */
	public function index()
	{
		try {
			if(!Helper::checkPermission('view-hostel-fee')) {
   				return back()->with('error', trans('error.unauthorized'));
   			}
			$data['hostel_fee'] = $this->hostel_fee->getAllFee(); // Fetch all fee data 
			return view('hostel_fee.index', $data);
		} catch(\Exception $err){
    		Log::error('Error in index on HostelFeeController :'. $err->getMessage());
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
			if(!Helper::checkPermission('add-hostel-fee')) {
                return back()->with('error', trans('error.unauthorized'));
            }
			$data = $this->hostel_fee->create();
			return view('hostel_fee.form', $data);
		} catch(\Exception $err){
    		Log::error('Error in create on HostelFeeController :'. $err->getMessage());
    		return back()->with('error', $err->getMessage());
    	}
	}



	/**
	* Method to create resource
	* @param App\Http\Requests\HostelFeeRequest $hostel_fee_request
	* @return Illuminate\Http\Response
	*/
	public function store(HostelFeeRequest $hostel_fee_request)
	{
		try {
			if(!Helper::checkPermission('add-hostel-fee')) {
                return back()->with('error', trans('error.unauthorized'));
            }
			$result = $this->hostel_fee->store($hostel_fee_request);
			if($result == true) {
				return back()->with('success', trans('success.hostel_fee_added_successfully'));
			}
			return back()->with('error', trans('error.hostel_fee_not_added'));
		} catch(\Exception $err){
    		Log::error('Error in store on HostelFeeController :'. $err->getMessage());
    		return back()->with('error', $err->getMessage());
    	}
	}

	/**
	* Method to show form for edit resource
	* @param int $hostel_fee_id
	* @return Illuminate\Http\Response
	*/
	public function edit($hostel_fee_id = 0)
	{
		try {
			if(!Helper::checkPermission('edit-hostel-fee')) {
                return back()->with('error', trans('error.unauthorized'));
            }
			if($hostel_fee_id == 0){
				return back()->with('error', trans('error.hostel_fee_not_found'));
			}
			$data = $this->hostel_fee->edit($hostel_fee_id);
			return view('hostel_fee.form', $data);
		} catch(\Exception $err){
    		Log::error('Error in edit on HostelFeeController :'. $err->getMessage());
    		return back()->with('error', $err->getMessage());
    	}
	}

	/**
	* Method to update resource
	* @param Illuminate\Http\Request
	* @return Illuminate\Http\Response
	*/
	public function update(HostelFeeRequest $request)
	{
		try {
			if(!Helper::checkPermission('edit-hostel-fee')) {
                return back()->with('error', trans('error.unauthorized'));
            }
			$result = $this->hostel_fee->update($request); 
			if($result == true) { 
				return redirect('view-hostel-fee')->with('success', trans('success.hostel_fee_updated_successfully'));
			}
			return back()->with('error', trans('error.hostel_fee_not_updated'));
		} catch(\Exception $err){
			Log::error('Error in update on HostelFeeController :'. $err->getMessage());
    		return back()->with('error', $err->getMessage());
    	}
	}
	

	/**
	* Method to delete resource
	* @param int $hostel_fee_id
	* @return Illuminate\Http\Response
	*/
	public function delete($hostel_fee_id = 0)
	{
		try {
			if(!Helper::checkPermission('delete-hostel-fee')) {
                return back()->with('error', trans('error.unauthorized'));
            }
			if($hostel_fee_id == 0){
				return back()->with('error', trans('error.hostel_fee_not_found'));
			}
			$result = $this->hostel_fee->delete($hostel_fee_id);
			if($result == true) {
				return back()->with('success', trans('success.hostel_fee_deleted_successfully'));
			}
			return back()->with('error', trans('error.hostel_fee_not_deleted'));
		} catch(\Exception $err){
    		Log::error('Error in delete on HostelFeeController :'. $err->getMessage());
    		return back()->with('error', $err->getMessage());
    	}
	}

	/**
	* Method to restore resource
	* @param int $hostel_fee_id
	* @return Illuminate\Http\Response
	*/
	public function restore($hostel_fee_id = 0)
	{
		try {
			if(!Helper::checkPermission('delete-hostel-fee')) {
                return back()->with('error', trans('error.unauthorized'));
            }
			if($hostel_fee_id == 0){
				return back()->with('error', trans('error.hostel_fee_not_found'));
			}
			$result = $this->hostel_fee->restore($hostel_fee_id);
			if($result == true) {
				return back()->with('success', trans('success.hostel_fee_restored_successfully'));
			}
			return back()->with('error', trans('error.hostel_fee_not_restored'));
		} catch(\Exception $err){
    		Log::error('Error in restore on HostelFeeController :'. $err->getMessage());
    		return back()->with('error', $err->getMessage());
    	}
	}


	
}
