<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repositories\FeeForClassRepository;
use App\Http\Requests\FeeForClassRequest ;
use App\Models\FeeForClass;
use Validator;
use Auth;
use Log;
use App;
use Session;
use Helper;

class FeeForClassController extends Controller
{
   	public function __construct(FeeForClassRepository $fee_for_class)
	{
		$this->fee_for_class = $fee_for_class;
	}

	/**
    * Method for show list of resources
    * 
    * @return Illuminate\Http\Response
    */
	public function index(Request $request) 
	{
		try {
			if(!Helper::checkPermission('view-fee-for-classes')) {
                return back()->with('error', trans('error.unauthorized'));
            }
			$data['fee_for_class'] = $this->fee_for_class->getAllFeeForClass($request); // Fetch all fee data 
			return view('fee_for_class.index', $data);
		} catch(\Exception $err){
    		Log::error('Error in index on FeeForClassController :'. $err->getMessage());
    		return back()->with('error', $err->getMessage());
    	}
	}

	
	public function addFeeForClasses($fee_id)
	{
		try {
			if(!Helper::checkPermission('add-fee-for-classes')) {
                return back()->with('error', trans('error.unauthorized'));
            }
			if($fee_id == 0){
				return back()->with('error', trans('error.fee_not_found'));
			}
			$data = $this->fee_for_class->addFeeForClasses($fee_id);
			return view('fee_for_class.form', $data);
		} catch(\Exception $err){
    		Log::error('Error in addFeeForClasses on FeeForClassController :'. $err->getMessage());
    		return back()->with('error', $err->getMessage());
    	}
	}

	public function storeFeeForClasses(FeeForClassRequest $request)
	{
		try {
			if(!Helper::checkPermission('add-fee-for-classes')) {
                return back()->with('error', trans('error.unauthorized'));
            }
			$result = $this->fee_for_class->storeFeeForClasses($request); 
			if($result == true) {
				return redirect()->route('view.fee')->with('success', trans('success.fee_for_class_added_successfully'));
			}
			return back()->with('error', trans('error.fee_for_class_not_added'));
		} catch(\Exception $err){
			Log::error('Error in storeFeeForClasses on FeeForClassController :'. $err->getMessage());
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
			if(!Helper::checkPermission('edit-fee-for-classes')) {
                return back()->with('error', trans('error.unauthorized'));
            }
			if($fee_id == 0){
				return back()->with('error', trans('error.fee_for_class_not_found'));
			}
			$data = $this->fee_for_class->edit($fee_id);
			return view('fee_for_class.form', $data);
		} catch(\Exception $err){
    		Log::error('Error in edit on FeeForClassController :'. $err->getMessage());
    		return back()->with('error', $err->getMessage());
    	}
	}

	/**
	* Method to update resource
	* @param Illuminate\Http\Request
	* @return Illuminate\Http\Response
	*/
	public function update(FeeForClassRequest $request)
	{
		try {
			if(!Helper::checkPermission('edit-fee-for-classes')) {
                return back()->with('error', trans('error.unauthorized'));
            }
			$result = $this->fee_for_class->update($request); 
			if($result == true) {
				return redirect('view-fee-for-classes')->with('success', trans('success.fee_for_class_updated_successfully'));
			}
			return back()->with('error', trans('error.fee_for_class_not_updated'));
		} catch(\Exception $err){
			Log::error('Error in update on FeeForClassController :'. $err->getMessage());
    		return back()->with('error', $err->getMessage());
    	}
	}

	
}
