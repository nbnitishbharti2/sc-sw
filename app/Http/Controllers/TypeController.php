<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repositories\TypeRepository;
use App\Http\Requests\TypeRequest;
use App\Models\Type;
use Validator;
use Auth;
use Log;
use App;
use Session;
use Helper;


class TypeController extends Controller
{
   	public function __construct(TypeRepository $type)
	{
		$this->type = $type;
	}

	/**
    * Method for show list of resources
    * 
    * @return Illuminate\Http\Response
    */
	public function index()
	{
		try {
			if(!Helper::checkPermission('view-type')) {
                return back()->with('error', trans('error.unauthorized'));
            }
			$data['type'] = $this->type->getAllType(); // Fetch all type data
			return view('type.index', $data);
		} catch(\Exception $err){
    		Log::error('Error in index on TypeController :'. $err->getMessage());
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
			if(!Helper::checkPermission('add-type')) {
                return back()->with('error', trans('error.unauthorized'));
            }
			$data = $this->type->create();
			return view('type.form', $data);
		} catch(\Exception $err){
    		Log::error('Error in create on TypeController :'. $err->getMessage());
    		return back()->with('error', $err->getMessage());
    	}
	}

	/**
	* Method to create resource
	* @param App\Http\Requests\TypeRequest $type_request
	* @return Illuminate\Http\Response
	*/
	public function store(TypeRequest $type_request)
	{
		try {
			if(!Helper::checkPermission('add-type')) {
                return back()->with('error', trans('error.unauthorized'));
            }
			$result = $this->type->store($type_request);
			if($result == true) {
				return back()->with('success', trans('success.type_added_successfully'));
			}
			return back()->with('error', trans('error.type_not_added'));
		} catch(\Exception $err){
    		Log::error('Error in store on TypeController :'. $err->getMessage());
    		return back()->with('error', $err->getMessage());
    	}
	}

	/**
	* Method to show form for edit resource
	* @param int $type_id
	* @return Illuminate\Http\Response
	*/
	public function edit($type_id = 0)
	{
		try {
			if(!Helper::checkPermission('edit-type')) {
                return back()->with('error', trans('error.unauthorized'));
            }
			if($type_id == 0){
				return back()->with('error', trans('error.type_not_found'));
			}
			$data = $this->type->edit($type_id);
			return view('type.form', $data);
		} catch(\Exception $err){
    		Log::error('Error in edit on TypeController :'. $err->getMessage());
    		return back()->with('error', $err->getMessage());
    	}
	}

	/**
	* Method to update resource
	* @param Illuminate\Http\Request
	* @return Illuminate\Http\Response
	*/
	public function update(TypeRequest $request)
	{
		try {
			if(!Helper::checkPermission('edit-type')) {
                return back()->with('error', trans('error.unauthorized'));
            }
			$result = $this->type->update($request);
			if($result == true) {
				return redirect('view-type')->with('success', trans('success.type_updated_successfully'));
			}
			return back()->with('error', trans('error.type_not_updated'));
		} catch(\Exception $err){
			Log::error('Error in update on TypeController :'. $err->getMessage());
    		return back()->with('error', $err->getMessage());
    	}
	}

	/**
	* Method to delete resource
	* @param int $type_id
	* @return Illuminate\Http\Response
	*/
	public function delete($type_id = 0)
	{
		try {
			if(!Helper::checkPermission('delete-type')) {
                return back()->with('error', trans('error.unauthorized'));
            }
			if($type_id == 0){
				return back()->with('error', trans('error.type_not_found'));
			}
			$result = $this->type->delete($type_id);
			if($result == true) {
				return back()->with('success', trans('success.type_deleted_successfully'));
			}
			return back()->with('error', trans('error.type_not_deleted'));
		} catch(\Exception $err){
    		Log::error('Error in delete on TypeController :'. $err->getMessage());
    		return back()->with('error', $err->getMessage());
    	}
	}

	/**
	* Method to restore resource
	* @param int $type_id
	* @return Illuminate\Http\Response
	*/
	public function restore($type_id = 0)
	{
		try {
			if(!Helper::checkPermission('delete-type')) {
                return back()->with('error', trans('error.unauthorized'));
            }
			if($type_id == 0){
				return back()->with('error', trans('error.type_not_found'));
			}
			$result = $this->type->restore($type_id);
			if($result == true) {
				return back()->with('success', trans('success.type_restored_successfully'));
			}
			return back()->with('error', trans('error.type_not_restored'));
		} catch(\Exception $err){
    		Log::error('Error in restore on TypeController :'. $err->getMessage());
    		return back()->with('error', $err->getMessage());
    	}
	}

	
}
