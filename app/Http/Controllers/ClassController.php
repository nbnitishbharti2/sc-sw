<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repositories\ClassRepository;
use App\Http\Requests\ClassRequest;
use Log;
use App;
use Session;
use Helper;

class ClassController extends Controller
{
   	public function __construct(ClassRepository $class)
	{
		$this->class = $class;
	}

	/**
    * Method for show list of resources
    * 
    * @return Illuminate\Http\Response
    */
	public function index()
	{
		try {
			if(!Helper::checkPermission('view-class')) {
                return back()->with('error', trans('error.unauthorized'));
            }
			$data['class'] = $this->class->getAllClass(); // Fetch all class data
			return view('class.index', $data);
		} catch(\Exception $err){
    		Log::error('Error in index on ClassController :'. $err->getMessage());
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
			if(!Helper::checkPermission('add-class')) {
                return back()->with('error', trans('error.unauthorized'));
            }
			$data = $this->class->create();
			return view('class.form', $data);
		} catch(\Exception $err){
    		Log::error('Error in index on ClassController :'. $err->getMessage());
    		return back()->with('error', $err->getMessage());
    	}
	}

	/**
	* Method to create resource
	* @param App\Http\Requests\ClassRequest $class_request
	* @return Illuminate\Http\Response
	*/
	public function store(ClassRequest $class_request)
	{
		try {
			if(!Helper::checkPermission('add-class')) {
                return back()->with('error', trans('error.unauthorized'));
            }
			$result = $this->class->store($class_request);
			if($result == true) {
				return back()->with('success', trans('success.class_added_successfully'));
			}
			return back()->with('error', trans('error.class_not_added'));
		} catch(\Exception $err){
    		Log::error('Error in store on ClassController :'. $err->getMessage());
    		return back()->with('error', $err->getMessage());
    	}
	}

	/**
	* Method to show form for edit resource
	* @param int $class_id
	* @return Illuminate\Http\Response
	*/
	public function edit($class_id = 0)
	{
		try {
			// Check permission
			if(!Helper::checkPermission('edit-class')) {
                return back()->with('error', trans('error.unauthorized'));
            }
			if($class_id == 0){
				return back()->with('error', trans('error.class_not_found'));
			}
			$data = $this->class->edit($class_id);
			return view('class.form', $data);
		} catch(\Exception $err){
    		Log::error('Error in edit on ClassController :'. $err->getMessage());
    		return back()->with('error', $err->getMessage());
    	}
	}

	/**
	* Method to update resource
	* @param Illuminate\Http\Request
	* @return Illuminate\Http\Response
	*/
	public function update(Request $request)
	{
		try {
			if(!Helper::checkPermission('edit-class')) {
                return back()->with('error', trans('error.unauthorized'));
            }
			$result = $this->class->update($request);
			if($result == true) {
				return redirect('view-class')->with('success', trans('success.class_updated_successfully'));
			}
			return back()->with('error', trans('error.class_not_updated'));
		} catch(\Exception $err){
			Log::error('Error in update on ClassController :'. $err->getMessage());
    		return back()->with('error', $err->getMessage());
    	}
	}

	/**
	* Method to delete resource
	* @param int $class_id
	* @return Illuminate\Http\Response
	*/
	public function delete($class_id = 0)
	{
		try {
			if(!Helper::checkPermission('delete-class')) {
                return back()->with('error', trans('error.unauthorized'));
            }
			if($class_id == 0){
				return back()->with('error', trans('error.class_not_found'));
			}
			$result = $this->class->delete($class_id);
			if($result == true) {
				return back()->with('success', trans('success.class_deleted_successfully'));
			}
			return back()->with('error', trans('error.class_not_deleted'));
		} catch(\Exception $err){
    		Log::error('Error in index on ClassController :'. $err->getMessage());
    		return back()->with('error', $err->getMessage());
    	}
	}

	/**
	* Method to restore resource
	* @param int $class_id
	* @return Illuminate\Http\Response
	*/
	public function restore($class_id = 0)
	{
		try {
			if(!Helper::checkPermission('delete-class')) {
                return back()->with('error', trans('error.unauthorized'));
            }
			if($class_id == 0){
				return back()->with('error', trans('error.class_not_found'));
			}
			$result = $this->class->restore($class_id);
			if($result == true) {
				return back()->with('success', trans('success.class_restored_successfully'));
			}
			return back()->with('error', trans('error.class_not_restored'));
		} catch(\Exception $err){
    		Log::error('Error in index on ClassController :'. $err->getMessage());
    		return back()->with('error', $err->getMessage());
    	}
	}

	/**
	* Method to import previous session resource
	* 
	* @return Illuminate\Http\Response
	*/
	public function importPreviousSessionClassSection()
	{
		try {
			if(!Helper::checkPermission('import.class.section')) {
                return back()->with('error', trans('error.unauthorized'));
            }
			if(Session::get('nextsession')==null){
				return back()->with('error', trans('error.previous_session_not_found'));
			}
			$result = $this->class->importPreviousSessionClass(); //Import previous session classes
			if($result == true) {
				return back()->with('success', trans('success.all_previous_session_class_imported'));
			}
			return back()->with('error', trans('error.class_not_found_in_previous_session'));
		} catch(\Exception $err){
    		Log::error('Error in index on ClassController :'. $err->getMessage());
    		return back()->with('error', $err->getMessage());
    	}
	}
	public function getClassListSession(Request $request)
	{ 
		try {
			$data = $this->class->getClassList($request->session_id);
			return json_encode($data);
		} catch(\Exception $err){
			Log::error('Error in getClassListSession on ClassController :'. $err->getMessage());
			return back()->with('error', $err->getMessage());
		}
	}
}
