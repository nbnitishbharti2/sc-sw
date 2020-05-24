<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repositories\CategoryRepository;
use App\Http\Requests\CategoryRequest;
use App\Models\Category;
use Validator;
use Auth;
use Log;
use App;
use Session;
use Helper;

class CategoryController extends Controller
{
   	public function __construct(CategoryRepository $category)
	{
		$this->category = $category;
	}

	/**
    * Method for show list of resources
    * 
    * @return Illuminate\Http\Response
    */
	public function index()
	{
		try {
			if(!Helper::checkPermission('view-category')) {
                return back()->with('error', trans('error.unauthorized'));
            }
			$data['category'] = $this->category->getAllCategory(); // Fetch all category data
			return view('category.index', $data);
		} catch(\Exception $err){
    		Log::error('Error in index on CategoryController :'. $err->getMessage());
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
			if(!Helper::checkPermission('add-category')) {
                return back()->with('error', trans('error.unauthorized'));
            }
			$data = $this->category->create();
			return view('category.form', $data);
		} catch(\Exception $err){
    		Log::error('Error in create on CategoryController :'. $err->getMessage());
    		return back()->with('error', $err->getMessage());
    	}
	}

	/**
	* Method to create resource
	* @param App\Http\Requests\CategoryRequest $category_request
	* @return Illuminate\Http\Response
	*/
	public function store(CategoryRequest $category_request)
	{
		try {
			if(!Helper::checkPermission('add-category')) {
                return back()->with('error', trans('error.unauthorized'));
            }
			$result = $this->category->store($category_request);
			if($result == true) {
				return back()->with('success', trans('success.category_added_successfully'));
			}
			return back()->with('error', trans('error.category_not_added'));
		} catch(\Exception $err){
    		Log::error('Error in store on CategoryController :'. $err->getMessage());
    		return back()->with('error', $err->getMessage());
    	}
	}

	/**
	* Method to show form for edit resource
	* @param int $category_id
	* @return Illuminate\Http\Response
	*/
	public function edit($category_id = 0)
	{
		try {
			if(!Helper::checkPermission('edit-category')) {
                return back()->with('error', trans('error.unauthorized'));
            }
			if($category_id == 0){
				return back()->with('error', trans('error.category_not_found'));
			}
			$data = $this->category->edit($category_id);
			return view('category.form', $data);
		} catch(\Exception $err){
    		Log::error('Error in edit on CategoryController :'. $err->getMessage());
    		return back()->with('error', $err->getMessage());
    	}
	}

	/**
	* Method to update resource
	* @param Illuminate\Http\Request
	* @return Illuminate\Http\Response
	*/
	public function update(CategoryRequest $request)
	{
		try {
			if(!Helper::checkPermission('edit-category')) {
                return back()->with('error', trans('error.unauthorized'));
            }
			$result = $this->category->update($request);
			if($result == true) {
				return redirect('view-category')->with('success', trans('success.category_updated_successfully'));
			}
			return back()->with('error', trans('error.category_not_updated'));
		} catch(\Exception $err){
			Log::error('Error in update on CategoryController :'. $err->getMessage());
    		return back()->with('error', $err->getMessage());
    	}
	}

	/**
	* Method to delete resource
	* @param int $category_id
	* @return Illuminate\Http\Response
	*/
	public function delete($category_id = 0)
	{
		try {
			if(!Helper::checkPermission('delete-category')) {
                return back()->with('error', trans('error.unauthorized'));
            }
			if($category_id == 0){
				return back()->with('error', trans('error.category_not_found'));
			}
			$result = $this->category->delete($category_id);
			if($result == true) {
				return back()->with('success', trans('success.category_deleted_successfully'));
			}
			return back()->with('error', trans('error.category_not_deleted'));
		} catch(\Exception $err){
    		Log::error('Error in delete on CategoryController :'. $err->getMessage());
    		return back()->with('error', $err->getMessage());
    	}
	}

	/**
	* Method to restore resource
	* @param int $category_id
	* @return Illuminate\Http\Response
	*/
	public function restore($category_id = 0)
	{
		try {
			if(!Helper::checkPermission('delete-category')) {
                return back()->with('error', trans('error.unauthorized'));
            }
			if($category_id == 0){
				return back()->with('error', trans('error.category_not_found'));
			}
			$result = $this->category->restore($category_id);
			if($result == true) {
				return back()->with('success', trans('success.category_restored_successfully'));
			}
			return back()->with('error', trans('error.category_not_restored'));
		} catch(\Exception $err){
    		Log::error('Error in restore on CategoryController :'. $err->getMessage());
    		return back()->with('error', $err->getMessage());
    	}
	}

	
}
