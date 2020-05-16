<?php

namespace App\Http\Controllers;
use App\Repositories\RoleRepository;
use App\Http\Requests\RolesRequest;
use App\Http\Requests\PermissionRequest;
use Illuminate\Http\Request;
use Helper;
use Log;

class RoleController extends Controller
{
    public function __construct(RoleRepository $role)
	{
        $this->role = $role;
        $this->middleware('auth');
    }
    
    /**
    * Method for show list of resources
    * 
    * @return Illuminate\Http\Response
    */
	public function index()
	{
		try {
            if(!Helper::checkPermission('view-roles')) {
                return back()->with('error', trans('error.unauthorized'));
            }
            $data['roles'] = $this->role->getRoles(); // Fetch all roles data
            return view('role.index', $data);
		} catch(\Exception $err){
    		Log::error('Error in index on RoleController :'. $err->getMessage());
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
            if(!Helper::checkPermission('add-roles')) {
                return back()->with('error', trans('error.unauthorized'));
            }
            $data = $this->role->create();
            return view('role.form', $data);
		} catch(\Exception $err){
    		Log::error('Error in index on RoleController :'. $err->getMessage());
    		return back()->with('error', $err->getMessage());
    	}
    }
    
    /**
	* Method to create resource
	* @param App\Http\Requests\RolesRequest $roles_request
	* @return Illuminate\Http\Response
	*/
	public function store(RolesRequest $roles_request)
	{
		try {
            if(!Helper::checkPermission('add-roles')) { // Check permission
                return back()->with('error', trans('error.unauthorized'));
            }
			$result = $this->role->store($roles_request);
			if($result == true) {
				return back()->with('success', trans('success.roles_added_successfully'));
			}
			return back()->with('error', trans('error.roles_not_added'));
		} catch(\Exception $err){
    		Log::error('Error in store on RoleController :'. $err->getMessage());
    		return back()->with('error', $err->getMessage());
    	}
	}

	/**  
	* Method to show form for edit resource
	* @param int $roles_id
	* @return Illuminate\Http\Response
	*/
	public function edit($roles_id = 0)
	{
		try {
			if(!Helper::checkPermission('edit-roles')) { // Check permission
                return back()->with('error', trans('error.unauthorized'));
            }
			if($roles_id == 0) { // If role id is not 0 then return the user
				return back()->with('error', trans('error.roles_not_found'));
			}
			$data = $this->role->edit($roles_id);
			return view('role.edit', $data);
		} catch(\Exception $err){
    		Log::error('Error in edit on RoleController :'. $err->getMessage());
    		return back()->with('error', $err->getMessage());
    	}
	}

	/**
	* Method to show form for create resource
	*
	* @return Illuminate\Http\Response
	*/
	public function permission()
	{
		try {
			$data = $this->role->permission();
			return view('permission.form', $data);
		} catch(\Exception $err){
    		Log::error('Error in permission on RoleController :'. $err->getMessage());
    		return back()->with('error', $err->getMessage());
    	}
	}
	
	/**
	* Method to create resource
	* @param App\Http\Requests\PermissionRequest $permission_request
	* @return Illuminate\Http\Response
	*/
	public function storePermission(PermissionRequest $permission_request)
	{
		try {
            $result = $this->role->storePermission($permission_request);
			if($result == true) {
				return back()->with('success', trans('success.permission_added_successfully'));
			}
			return back()->with('error', trans('error.permission_not_added'));
		} catch(\Exception $err){
    		Log::error('Error in store on RoleController :'. $err->getMessage());
    		return back()->with('error', $err->getMessage());
    	}
	}
	public function update(Request $request)
	{ 
		try {
            $result = $this->role->update($request);
			if($result == true) {
				return back()->with('success', trans('success.role_updated_successfully'));
			}
			return back()->with('error', trans('error.role_not_updated'));
		} catch(\Exception $err){
    		Log::error('Error in update on RoleController :'. $err->getMessage());
    		return back()->with('error', $err->getMessage());
    	}
	}
}
