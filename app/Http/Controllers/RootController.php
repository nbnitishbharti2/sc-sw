<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repositories\RootRepository;
use App\Http\Requests\RootRequest;
use App\Models\Root;
use Validator;
use Auth;
use Lang;
use Log;
use App;
use Session;

class RootController extends Controller
{
   	public function __construct(RootRepository $root)
	{
		$this->root = $root;
	}

	/**
    * Method for show list of resources
    * 
    * @return Illuminate\Http\Response
    */
	public function index()
	{
		try {
			$data['root'] = $this->root->getAllRoot(); // Fetch all root data
			return view('root.index', $data);
		} catch(\Exception $err){
    		Log::error('Error in index on RootController :'. $err->getMessage());
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
			$data = $this->root->create();
			return view('root.form', $data);
		} catch(\Exception $err){
    		Log::error('Error in create on RootController :'. $err->getMessage());
    		return back()->with('error', $err->getMessage());
    	}
	}

	/**
	* Method to create resource
	* @param App\Http\Requests\RootRequest $root_request
	* @return Illuminate\Http\Response
	*/
	public function store(RootRequest $root_request)
	{
		try {
			$result = $this->root->store($root_request);
			if($result == true) {
				return back()->with('success', Lang::get('success.root_added_successfully'));
			}
			return back()->with('error', Lang::get('error.root_not_added'));
		} catch(\Exception $err){
    		Log::error('Error in store on RootController :'. $err->getMessage());
    		return back()->with('error', $err->getMessage());
    	}
	}

	/**
	* Method to show form for edit resource
	* @param int $root_id
	* @return Illuminate\Http\Response
	*/
	public function edit($root_id = 0)
	{
		try {
			if($root_id == 0){
				return back()->with('error', Lang::get('error.root_not_found'));
			}
			$data = $this->root->edit($root_id);
			return view('root.form', $data);
		} catch(\Exception $err){
    		Log::error('Error in edit on RootController :'. $err->getMessage());
    		return back()->with('error', $err->getMessage());
    	}
	}

	/**
	* Method to update resource
	* @param Illuminate\Http\Request
	* @return Illuminate\Http\Response
	*/
	public function update(RootRequest $request)
	{
		try {
			$result = $this->root->update($request);
			if($result == true) {
				return redirect('view-root')->with('success', Lang::get('success.root_updated_successfully'));
			}
			return back()->with('error', Lang::get('error.root_not_updated'));
		} catch(\Exception $err){
			Log::error('Error in update on RootController :'. $err->getMessage());
    		return back()->with('error', $err->getMessage());
    	}
	}

	/**
	* Method to delete resource
	* @param int $root_id
	* @return Illuminate\Http\Response
	*/
	public function delete($root_id = 0)
	{
		try {
			if($root_id == 0){
				return back()->with('error', Lang::get('error.root_not_found'));
			}
			$result = $this->root->delete($root_id);
			if($result == true) {
				return back()->with('success', Lang::get('success.root_deleted_successfully'));
			}
			return back()->with('error', Lang::get('error.root_not_deleted'));
		} catch(\Exception $err){
    		Log::error('Error in delete on RootController :'. $err->getMessage());
    		return back()->with('error', $err->getMessage());
    	}
	}

	/**
	* Method to restore resource
	* @param int $root_id
	* @return Illuminate\Http\Response
	*/
	public function restore($root_id = 0)
	{
		try {
			if($root_id == 0){
				return back()->with('error', Lang::get('error.root_not_found'));
			}
			$result = $this->root->restore($root_id);
			if($result == true) {
				return back()->with('success', Lang::get('success.root_restored_successfully'));
			}
			return back()->with('error', Lang::get('error.root_not_restored'));
		} catch(\Exception $err){
    		Log::error('Error in restore on RootController :'. $err->getMessage());
    		return back()->with('error', $err->getMessage());
    	}
	}


	
}
