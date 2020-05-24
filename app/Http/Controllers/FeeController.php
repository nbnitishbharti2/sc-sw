<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repositories\FeeRepository;
use App\Http\Requests\FeeRequest ;
use App\Models\Fee;
use Validator;
use Auth;
use Log;
use App;
use Session;
use Helper;

class FeeController extends Controller
{
   	public function __construct(FeeRepository $fee)
	{
		$this->fee = $fee;
	}

	/**
    * Method for show list of resources
    * 
    * @return Illuminate\Http\Response
    */
	public function index()
	{
		try {
			if(!Helper::checkPermission('view-fee')) {
                return back()->with('error', trans('error.unauthorized'));
            }
			$data['fee'] = $this->fee->getAllFee(); // Fetch all fee data 
			return view('fee.index', $data);
		} catch(\Exception $err){
    		Log::error('Error in index on FeeController :'. $err->getMessage());
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
			if(!Helper::checkPermission('add-fee')) {
                return back()->with('error', trans('error.unauthorized'));
            }
			$data = $this->fee->create();
			return view('fee.form', $data);
		} catch(\Exception $err){
    		Log::error('Error in create on FeeController :'. $err->getMessage());
    		return back()->with('error', $err->getMessage());
    	}
	}

	public function getFeeHeadFrequency(Request $request)
	{
		try {
			$data = $this->fee->getFeeHeadFrequency($request->fee_head_id);
			return json_encode($data);
		} catch(\Exception $err){
    		Log::error('Error in getFeeFrequency on FeeController :'. $err->getMessage());
    		return back()->with('error', $err->getMessage());
    	}
	}

	public function getFeeFrequency(Request $request)
	{
		try {
			$data = $this->fee->getFeeFrequency($request->fee_setting_id);
			return $data;
		} catch(\Exception $err){
    		Log::error('Error in getFeeFrequency on FeeController :'. $err->getMessage());
    		return back()->with('error', $err->getMessage());
    	}
	}

	public function getFeeFrequencyValue(Request $request)
	{
		try {
			$data = $this->fee->getFeeFrequencyValue($request->frequency_id);
			return $data;
		} catch(\Exception $err){
    		Log::error('Error in getFeeFrequencyValue on FeeController :'. $err->getMessage());
    		return back()->with('error', $err->getMessage());
    	}
	}

	/**
	* Method to create resource
	* @param App\Http\Requests\FeeRequest $fee_request
	* @return Illuminate\Http\Response
	*/
	public function store(FeeRequest $fee_request)
	{
		try {
			if(!Helper::checkPermission('add-fee')) {
                return back()->with('error', trans('error.unauthorized'));
            }
			$result = $this->fee->store($fee_request);

			if($result == true) {
				return back()->with('success', trans('success.fee_added_successfully'));
			}
			return back()->with('error', trans('error.fee_not_added'));
		} catch(\Exception $err){
    		Log::error('Error in store on FeeController :'. $err->getMessage());
    		return back()->with('error', $err->getMessage());
    	}
	}

	/**
	* Method to show form for edit resource
	* @param int $fee_id
	* @return Illuminate\Http\Response
	*/
	public function edit($fee_id = 0)
	{
		try {
			if(!Helper::checkPermission('edit-fee')) {
                return back()->with('error', trans('error.unauthorized'));
            }
			if($fee_id == 0){
				return back()->with('error', trans('error.fee_not_found'));
			}
			$data = $this->fee->edit($fee_id);
			return view('fee.form', $data);
		} catch(\Exception $err){
    		Log::error('Error in edit on FeeController :'. $err->getMessage());
    		return back()->with('error', $err->getMessage());
    	}
	}

	/**
	* Method to update resource
	* @param Illuminate\Http\Request
	* @return Illuminate\Http\Response
	*/
	public function update(FeeRequest $request)
	{
		try {
			if(!Helper::checkPermission('edit-fee')) {
                return back()->with('error', trans('error.unauthorized'));
            }
			$result = $this->fee->update($request); 
			if($result == true) {
				return redirect('view-fee')->with('success', trans('success.fee_updated_successfully'));
			}
			return back()->with('error', trans('error.fee_not_updated'));
		} catch(\Exception $err){
			Log::error('Error in update on FeeController :'. $err->getMessage());
    		return back()->with('error', $err->getMessage());
    	}
	}
	

	/**
	* Method to delete resource
	* @param int $fee_id
	* @return Illuminate\Http\Response
	*/
	public function delete($fee_id = 0)
	{
		try {
			if(!Helper::checkPermission('delete-fee')) {
                return back()->with('error', trans('error.unauthorized'));
            }
			if($fee_id == 0){
				return back()->with('error', trans('error.fee_not_found'));
			}
			$result = $this->fee->delete($fee_id);
			if($result == true) {
				return back()->with('success', trans('success.fee_deleted_successfully'));
			}
			return back()->with('error', trans('error.fee_not_deleted'));
		} catch(\Exception $err){
    		Log::error('Error in delete on FeeController :'. $err->getMessage());
    		return back()->with('error', $err->getMessage());
    	}
	}

	/**
	* Method to restore resource
	* @param int $fee_id
	* @return Illuminate\Http\Response
	*/
	public function restore($fee_id = 0)
	{
		try {
			if(!Helper::checkPermission('delete-fee')) {
                return back()->with('error', trans('error.unauthorized'));
            }
			if($fee_id == 0){
				return back()->with('error', trans('error.fee_not_found'));
			}
			$result = $this->fee->restore($fee_id);
			if($result == true) {
				return back()->with('success', trans('success.fee_restored_successfully'));
			}
			return back()->with('error', trans('error.fee_not_restored'));
		} catch(\Exception $err){
    		Log::error('Error in restore on FeeController :'. $err->getMessage());
    		return back()->with('error', $err->getMessage());
    	}
	}


	
}
