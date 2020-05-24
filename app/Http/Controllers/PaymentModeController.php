<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repositories\PaymentModeRepository;
use App\Http\Requests\PaymentModeRequest;
use App\Models\PaymentMode;
use Validator;
use Auth;
use Log;
use App;
use Session;
use Helper;

class PaymentModeController extends Controller
{
   	public function __construct(PaymentModeRepository $payment_mode)
	{
		$this->payment_mode = $payment_mode;
	}

	/**
    * Method for show list of resources
    * 
    * @return Illuminate\Http\Response
    */
	public function index()
	{
		try {
			if(!Helper::checkPermission('view-payment-mode')) {
                return back()->with('error', trans('error.unauthorized'));
            }
			$data['payment_mode'] = $this->payment_mode->getAllPaymentMode(); // Fetch all Payment Mode data
			return view('payment_mode.index', $data);
		} catch(\Exception $err){
    		Log::error('Error in index on PaymentModeController :'. $err->getMessage());
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
			if(!Helper::checkPermission('add-payment-mode')) {
                return back()->with('error', trans('error.unauthorized'));
            }
			$data = $this->payment_mode->create();
			return view('payment_mode.form', $data);
		} catch(\Exception $err){
    		Log::error('Error in create on PaymentModeController :'. $err->getMessage());
    		return back()->with('error', $err->getMessage());
    	}
	}

	/**
	* Method to create resource
	* @param App\Http\Requests\PaymentModeRequest $payment_mode_request
	* @return Illuminate\Http\Response
	*/
	public function store(PaymentModeRequest $payment_mode_request)
	{
		try {
			if(!Helper::checkPermission('add-payment-mode')) {
                return back()->with('error', trans('error.unauthorized'));
            }
			$result = $this->payment_mode->store($payment_mode_request);
			if($result == true) {
				return back()->with('success', trans('success.payment_mode_added_successfully'));
			}
			return back()->with('error', trans('error.payment_mode_not_added'));
		} catch(\Exception $err){
    		Log::error('Error in store on PaymentModeController :'. $err->getMessage());
    		return back()->with('error', $err->getMessage());
    	}
	}

	/**
	* Method to show form for edit resource
	* @param int $payment_mode_id
	* @return Illuminate\Http\Response
	*/
	public function edit($payment_mode_id = 0)
	{
		try {
			if(!Helper::checkPermission('edit-payment-mode')) {
                return back()->with('error', trans('error.unauthorized'));
            }
			if($payment_mode_id == 0){
				return back()->with('error', trans('error.payment_mode_not_found'));
			}
			$data = $this->payment_mode->edit($payment_mode_id);
			return view('payment_mode.form', $data);
		} catch(\Exception $err){
    		Log::error('Error in edit on PaymentModeController :'. $err->getMessage());
    		return back()->with('error', $err->getMessage());
    	}
	}

	/**
	* Method to update resource
	* @param Illuminate\Http\Request
	* @return Illuminate\Http\Response
	*/
	public function update(PaymentModeRequest $request)
	{
		try {
			if(!Helper::checkPermission('edit-payment-mode')) {
                return back()->with('error', trans('error.unauthorized'));
            }
			$result = $this->payment_mode->update($request);
			if($result == true) {
				return redirect('view-payment-mode')->with('success', trans('success.payment_mode_updated_successfully'));
			}
			return back()->with('error', trans('error.payment_mode_not_updated'));
		} catch(\Exception $err){
			Log::error('Error in update on PaymentModeController :'. $err->getMessage());
    		return back()->with('error', $err->getMessage());
    	}
	}

	/**
	* Method to delete resource
	* @param int $payment_mode_id
	* @return Illuminate\Http\Response
	*/
	public function delete($payment_mode_id = 0)
	{
		try {
			if(!Helper::checkPermission('delete-payment-mode')) {
                return back()->with('error', trans('error.unauthorized'));
            }
			if($payment_mode_id == 0){
				return back()->with('error', trans('error.payment_mode_not_found'));
			}
			$result = $this->payment_mode->delete($payment_mode_id);
			if($result == true) {
				return back()->with('success', trans('success.payment_mode_deleted_successfully'));
			}
			return back()->with('error', trans('error.payment_mode_not_deleted'));
		} catch(\Exception $err){
    		Log::error('Error in delete on PaymentModeController :'. $err->getMessage());
    		return back()->with('error', $err->getMessage());
    	}
	}

	/**
	* Method to restore resource
	* @param int $payment_mode_id
	* @return Illuminate\Http\Response
	*/
	public function restore($payment_mode_id = 0)
	{
		try {
			if(!Helper::checkPermission('delete-payment-mode')) {
                return back()->with('error', trans('error.unauthorized'));
            }
			if($payment_mode_id == 0){
				return back()->with('error', trans('error.payment_mode_not_found'));
			}
			$result = $this->payment_mode->restore($payment_mode_id);
			if($result == true) {
				return back()->with('success', trans('success.payment_mode_restored_successfully'));
			}
			return back()->with('error', trans('error.payment_mode_not_restored'));
		} catch(\Exception $err){
    		Log::error('Error in restore on PaymentModeController :'. $err->getMessage());
    		return back()->with('error', $err->getMessage());
    	}
	}

	
}
