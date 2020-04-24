<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repositories\ClassRepository;
use App\Http\Requests\ClassRequest;
use App\User;
use Validator;
use Auth;
use Lang;
use Log;
use App;
use Session;
class ClassController extends Controller
{
   	public function __construct(ClassRepository $class)
	{
		$this->class = $class;
		// if(!Auth::user()->lang) {
		// 	App::setLocale('en');
		// }
		App::setLocale('en');
	}

	/**
    * Method for show list of resources
    * 
    * @return Illuminate\Http\Response
    */
	public function index()
	{
		try {
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
			$result = $this->class->store($class_request);
			if($result == true) {
				return back()->with('success', Lang::get('success.class_added_successfully'));
			}
			return back()->with('error', Lang::get('error.class_not_added'));
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
			if($class_id == 0){
				return back()->with('error', Lang::get('error.class_not_found'));
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
			$result = $this->class->update($request);
			if($result == true) {
				return redirect('view-class')->with('success', Lang::get('success.class_updated_successfully'));
			}
			return back()->with('error', Lang::get('error.class_not_updated'));
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
			if($class_id == 0){
				return back()->with('error', Lang::get('error.class_not_found'));
			}
			$result = $this->class->delete($class_id);
			if($result == true) {
				return back()->with('success', Lang::get('success.class_deleted_successfully'));
			}
			return back()->with('error', Lang::get('error.class_not_deleted'));
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
			if($class_id == 0){
				return back()->with('error', Lang::get('error.class_not_found'));
			}
			$result = $this->class->restore($class_id);
			if($result == true) {
				return back()->with('success', Lang::get('success.class_restored_successfully'));
			}
			return back()->with('error', Lang::get('error.class_not_restored'));
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
			if(Session::get('nextsession')==null){
				return back()->with('error', Lang::get('error.previous_session_not_found'));
			}
			$result = $this->class->importPreviousSessionClass(); //Import previous session classes
			if($result == true) {
				return back()->with('success', Lang::get('success.all_previous_session_class_imported'));
			}
			return back()->with('error', Lang::get('error.class_not_found_in_previous_session'));
		} catch(\Exception $err){
    		Log::error('Error in index on ClassController :'. $err->getMessage());
    		return back()->with('error', $err->getMessage());
    	}
	}
}