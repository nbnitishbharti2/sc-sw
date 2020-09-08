<?php 

namespace App\Repositories;

use App\Models\BloodGroup;
use Log;
use Session;

class BloodGroupRepository {

    /**
    * Method to fetch all resource data
    *
    * @return Collection $query
    */
    public function getAllBloodGroup()
    {
    	try {
    		return  $query = BloodGroup::withTrashed()->get();  
    	} catch(\Exception $err){
    		Log::error('message error in getAllBloodGroup on BloodGroupRepository :'. $err->getMessage());
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
                'action'          => route('store.blood_group'),
                'page_title'      => trans('label.blood_group'),
                'title'           => trans('title.add_blood_group'),
                'blood_group_id'  => 0,
                'name'            => (old('name')) ? old('name') : '',
            ];
            return $data;
        } catch(\Exception $err){
            Log::error('message error in create on BloodGroupRepository :'. $err->getMessage());
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
                'name'    => $request->name
            ];
            
            $blood_group = BloodGroup::create($data);
            if ($blood_group->exists) {
               return true;
            } else {
               return false;
            }
        } catch(\Exception $err){
            Log::error('message error in store on BloodGroupRepository :'.$err->getMessage());
            return back()->with('error', $err->getMessage());
        }
    }

    /**
    * Method to fetch edit resource data
    * @param int $blood_group_id
    * @return array $data
    */
    public function edit($blood_group_id)
    {
        try {
            $blood_group = BloodGroup::findOrFail($blood_group_id); //Fetch blood_group data 
            $data = [
                'action'          => route('update.blood_group'),
                'page_title'      => trans('label.blood_group'),
                'title'           => trans('title.edit_blood_group'),
                'blood_group_id'     => $blood_group->id,
                'name'            => ($blood_group->name) ? $blood_group->name : old('name')
            ];
            return $data;
        } catch(\Exception $err){ 
            Log::error('message error in edit on BloodGroupRepository :'. $err->getMessage());
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
            $blood_group  = BloodGroup::findOrFail($request->blood_group_id); //Fetch blood_group data
            $blood_group->name  = $request->name;
            $blood_group->save(); // Update data
            if ($blood_group->wasChanged()) { //Check if data was updated
               return true;
            } else {
               return false;
            }
        } catch(\Exception $err){
            Log::error('message error in update on BloodGroupRepository :'. $err->getMessage());
            return back()->with('error', $err->getMessage());
        }
    }

    /**
    * Method to delete resource
    * @param Illuminate\Http\Request
    * @return boolean
    */
    public function delete($blood_group_id)
    {
        try {
            $blood_group = BloodGroup::destroy($blood_group_id);
            if ($blood_group) { //Check if data was deleted
               return true;
            } else {
               return false;
            }
        } catch(\Exception $err){
            Log::error('message error in delete on BloodGroupRepository :'. $err->getMessage());
            return back()->with('error', $err->getMessage());
        }
    }

    /**
    * Method to delete resource
    * @param Illuminate\Http\Request
    * @return boolean
    */
    public function restore($blood_group_id)
    {
        try {
            $blood_group = BloodGroup::withTrashed()->find($blood_group_id)->restore();
            if ($blood_group) { //Check if data was restored
               return true;
            } else {
               return false;
            }
        } catch(\Exception $err){
            Log::error('message error in restore on BloodGroupRepository :'. $err->getMessage());
            return back()->with('error', $err->getMessage());
        }
    }

    
}