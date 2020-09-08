<?php 

namespace App\Repositories;

use App\Models\Role;
use App\Models\Permission;
use App\Models\Module;
use App\Models\RolePermission;
use Log;
use Session;


class RoleRepository {

    /**
    * Method to fetch all resource data
    *
    * @return Collection $query
    */
    public function getRoles()
    {
    	try {
            return $query = Role::get();
        } catch(\Exception $err){
          Log::error('message error in getRoles on RoleRepository :'. $err->getMessage());
          return back()->with('error', $err->getMessage());
      }
  }

    /**
    * Method to fetch create resource data
    *
    * @return array $data
    */
    public function create()
    {
        try {
            $data = [
                'action'        => route('store.roles'),
                'page_title'    => trans('label.roles'),
                'title'         => trans('title.add_roles'),
                'roles_id'      => 0,
                'name'          => (old('name')) ? old('name') : '',
            ];
            return $data;
        } catch(\Exception $err){
            Log::error('message error in create on RoleRepository :'. $err->getMessage());
            return back()->with('error', $err->getMessage());
        }
    }

    /**
    * Method to create resource
    * @param $request
    * @return boolean
    */
    public function store($request)
    {
        try {
            $data = [
                'name'          => $request->name,
                'guard_name'    => 'web'
            ];
            
            $roles = Role::create($data);
            if ($roles->exists) {
                return true;
            } else {
                return false;
            }
        } catch(\Exception $err){
            Log::error('message error in store on RoleRepository :'. $err->getMessage());
            return back()->with('error', $err->getMessage());
        }
    }


    /**
    * Method to fetch edit resource data
    * @param int $roles_id
    * @return array $data
    */
    public function edit($roles_id)
    { 
        try {
            $roles                  = Role::find($roles_id); //Fetch role data
            $permission_role        = [];
            foreach($roles->permission as $permission) { //create role permission data
                $permission_role[]  = $permission->id;
            }
            
            $data = [
                'action'            => route('update.roles'),
                'page_title'        => trans('label.roles'),
                'title'             => trans('title.edit_roles'),
                'roles_id'          => $roles->id,
                'name'              => ($roles->name) ? $roles->name : old('name'),
                'permissions'       => Permission::all(),
                'permission_role'   => $permission_role,
                'modules'           => Module::with('Permission')->get(),
            ];
            return $data;
        } catch(\Exception $err){ 
            Log::error('message error in edit on RoleRepository :'. $err->getMessage());
            return back()->with('error', $err->getMessage());
        }
    }

    /**
    * Method to update resource
    * @param Illuminate\Http\Request
    * @return boolean
    */ 
    public function update($request)
    {
        try {
            $data=RolePermission::where('role_id','=',$request->roles_id)->pluck('permission_id');
            $array = json_decode(json_encode($data), true); 
            $new_permission=array_diff($request->permission, $array); 
            $remove_permission=array_diff($array,$request->permission);
            $removed_permission = RolePermission::where('role_id','=',$request->roles_id)->whereIn('permission_id',$remove_permission)->delete(); 
            $new_data=array(); 
            foreach ($new_permission as $key => $value) {
                $new_record=array();
                $new_record['permission_id']=$value;
                $new_record['role_id']=$request->roles_id;
                array_push($new_data,$new_record);
            }
            
            $inserted_permission = RolePermission::insert($new_data);
            
            if ($removed_permission || $inserted_permission) { //Check if data was updated
                return true;
             } else {
                 return false;
             }
        } catch(\Exception $err){
            Log::error('message error in update on RoleRepository :'. $err->getMessage());
            return back()->with('error', $err->getMessage());
        }
}

    /**
    * Method to delete resource
    * @param Illuminate\Http\Request
    * @return boolean
    */
    public function delete($class_id)
    {
        try {
            $class = Classes::destroy($class_id);
            if ($class) { //Check if data was updated
             return true;
         } else {
             return false;
         }
     } catch(\Exception $err){
        Log::error('message error in delete on RoleRepository :'. $err->getMessage());
        return back()->with('error', $err->getMessage());
    }
}

    /**
    * Method to delete resource
    * @param Illuminate\Http\Request
    * @return boolean
    */
    public function restore($class_id)
    {
        try {
            $class = Classes::withTrashed()->find($class_id)->restore();
            if ($class) { //Check if data was updated
                return true;
            } else {
                return false;
            }
        } catch(\Exception $err){
            Log::error('message error in restore on RoleRepository :'. $err->getMessage());
            return back()->with('error', $err->getMessage());
        }
    }

    /**
    * Method to import previous session classes
    * @param Illuminate\Http\Request
    * @return boolean
    */
    public function importPreviousSessionClass()
    {
        try {
            $prevsession = Session::get('prevsession');
            $nextSession = Session::get('session');
            $class = Classes::where('session_id',$prevsession)->with('sections')->get();
            
            if ($class->count() == 0) { //Check if data was not found in previous session
                return false;
            } else {
                foreach ($class as $key => $value) {
                    $data = [
                        'session_id'    => $nextSession,
                        'class_name'    => $value->class_name,
                        'class_short'   => $value->class_short,
                        'added_by'      => Auth::user()->id,
                        'updated_by'    => Auth::user()->id
                    ];
                    $check_class = Classes::where(['class_name' => $value->class_name, 'session_id' => $nextSession])->count(); 
                    if($check_class == 0) { // If class is not inserted in current session
                        $class = Classes::create($data); //Insert classes data
                        // Insert Section data
                        
                        if (count($value->sections) > 0) { // If sections found for this class
                            foreach ($value->sections as $key => $section) {
                                $section_data = [
                                    'classes_id'    => $class->id,
                                    'session_id'    => $nextSession,                            
                                    'section_name'  => $section->section_name,
                                    'section_short' => $section->section_short,
                                    'added_by'      => Auth::user()->id,
                                    'updated_by'    => Auth::user()->id
                                ];
                                $check_section  = Section::where(['section_name' => $section->section_name, 'session_id' => $nextSession, 'classes_id' => $class->id])->count();
                                if ($check_section == 0) { // If section is not inserted in current session
                                    $insert_section = Section::create($section_data); //Insert section data
                                }
                            }
                        }
                    }
                }
                return true;
            }
        } catch(\Exception $err){
            Log::error('message error in delete on RoleRepository :'. $err->getMessage());
            return back()->with('error', $err->getMessage());
        }
    }


    /**
    * Method to fetch create resource data
    *
    * @return array $data
    */
    public function permission()
    {
        try {
            $data = [
                'action'        => route('store.permission'),
                'page_title'    => trans('title.permission'),
                'title'         => trans('title.add_permission'),
                'permission_id' => 0,
                'name'          => (old('name')) ? old('name') : '',
                'description'   => (old('description')) ? old('description') : '',
                'modules'        => Module::get(),
            ];
            return $data;
        } catch(\Exception $err){
            Log::error('message error in permission on RoleRepository :'. $err->getMessage());
            return back()->with('error', $err->getMessage());
        }
    }


    /**
    * Method to create resource
    * @param $request
    * @return boolean
    */
    public function storePermission($request)
    {
        try {
            $data = [
                'module_id'     => $request->module_id,
                'name'          => $request->name,
                'description'   => $request->description,
                'guard_name'    => 'web',
            ];
            
            $permission = Permission::create($data);
            if ($permission->exists) {
                return true;
            } else {
                return false;
            }
        } catch(\Exception $err){
            Log::error('message error in storePermission on RoleRepository :'. $err->getMessage());
            return back()->with('error', $err->getMessage());
        }
    }

    
}