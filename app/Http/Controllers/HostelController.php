<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repositories\HostelRepository;
use App\Http\Requests\HostelRequest;
use App\Models\Hostel;
use Validator;
use Auth;
use Lang;
use Log;
use App;
use Session;

class HostelController extends Controller
{
   	public function __construct(HostelRepository $hostel)
	{
		$this->hostel = $hostel;
	}

	/**
    * Method for show list of resources
    * 
    * @return Illuminate\Http\Response
    */
	public function index()
	{
		try {
			$data['hostel'] = $this->hostel->getAllHostel(); // Fetch all hostel data
			return view('hostel.index',$data);
		} catch(\Exception $err){
    		Log::error('Error in index on HostelController :'. $err->getMessage());
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
			$data = $this->hostel->create();
			return view('hostel.form', $data);
		} catch(\Exception $err){
    		Log::error('Error in create on HostelController :'. $err->getMessage());
    		return back()->with('error', $err->getMessage());
    	}
	}

	/**
	* Method to create resource
	* @param App\Http\Requests\HostelRequest $hostel_request
	* @return Illuminate\Http\Response
	*/
	public function store(HostelRequest $hostel_request)
	{
		$facilities_ids=implode(',',$hostel_request->facilities_ids);
		try {
			$result = $this->hostel->store($hostel_request,$facilities_ids);
			if($result == true) {
				return back()->with('success', Lang::get('success.hostel_added_successfully'));
			}
			return back()->with('error', Lang::get('error.hostel_not_added'));
		} catch(\Exception $err){
    		Log::error('Error in store on HostelController :'. $err->getMessage());
    		return back()->with('error', $err->getMessage());
    	}
	}

	/**
	* Method to show form for edit resource
	* @param int $hostel_id
	* @return Illuminate\Http\Response
	*/
	public function edit($hostel_id = 0)
	{
		try {
			if($hostel_id == 0){
				return back()->with('error', Lang::get('error.hostel_not_found'));
			}
			$data = $this->hostel->edit($hostel_id);
			return view('hostel.form', $data);
		} catch(\Exception $err){
    		Log::error('Error in edit on HostelController :'. $err->getMessage());
    		return back()->with('error', $err->getMessage());
    	}
	}

	/**
	* Method to update resource
	* @param Illuminate\Http\Request
	* @return Illuminate\Http\Response
	*/
	public function update(HostelRequest $request)
	{
		$facilities_ids=implode(',',$request->facilities_ids);
		try {
			$result = $this->hostel->update($request,$facilities_ids);
			if($result == true) {
				return redirect('view-hostel')->with('success', Lang::get('success.hostel_updated_successfully'));
			}
			return back()->with('error', Lang::get('error.hostel_not_updated'));
		} catch(\Exception $err){
			Log::error('Error in update on HostelController :'. $err->getMessage());
    		return back()->with('error', $err->getMessage());
    	}
	}

	/**
	* Method to delete resource
	* @param int $hostel_id
	* @return Illuminate\Http\Response
	*/
	public function delete($hostel_id = 0)
	{
		try {
			if($hostel_id == 0){
				return back()->with('error', Lang::get('error.hostel_not_found'));
			}
			$result = $this->hostel->delete($hostel_id);
			if($result == true) {
				return back()->with('success', Lang::get('success.hostel_deleted_successfully'));
			}
			return back()->with('error', Lang::get('error.hostel_not_deleted'));
		} catch(\Exception $err){
    		Log::error('Error in delete on HostelController :'. $err->getMessage());
    		return back()->with('error', $err->getMessage());
    	}
	}

	/**
	* Method to restore resource
	* @param int $hostel_id
	* @return Illuminate\Http\Response
	*/
	public function restore($hostel_id = 0)
	{
		try {
			if($hostel_id == 0){
				return back()->with('error', Lang::get('error.hostel_not_found'));
			}
			$result = $this->hostel->restore($hostel_id);
			if($result == true) {
				return back()->with('success', Lang::get('success.hostel_restored_successfully'));
			}
			return back()->with('error', Lang::get('error.hostel_not_restored'));
		} catch(\Exception $err){
    		Log::error('Error in restore on HostelController :'. $err->getMessage());
    		return back()->with('error', $err->getMessage());
    	}
	}

	
}
