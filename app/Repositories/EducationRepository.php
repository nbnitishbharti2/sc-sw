<?php 

namespace App\Repositories;

use App\Models\Education;
use Log;
use Session;

class EducationRepository {

    /**
    * Method to fetch all resource data
    *
    * @return Collection $query
    */
    public function getAllEducation()
    {
    	try {
    		return  $query = Education::withTrashed()->get();  
    	}catch(\Exception $err){
    		Log::error('message error in getAllEducation on EducationRepository :'. $err->getMessage());
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
                'action'          => route('store.education'),
                'page_title'      => trans('label.education'),
                'title'           => trans('title.add_education'),
                'education_id'    => 0,
                'name'            => (old('name')) ? old('name') : '',
            ];
            return $data;
        } catch(\Exception $err){
            Log::error('message error in create on EducationRepository :'. $err->getMessage());
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
            
            $education = Education::create($data);
            if ($education->exists) {
               return true;
            } else {
               return false;
            }
        } catch(\Exception $err){
            Log::error('message error in store on EducationRepository :'. $err->getMessage());
            return back()->with('error', $err->getMessage());
        }
    }


    /**
    * Method to fetch edit resource data
    * @param int $education_id
    * @return array $data
    */
    public function edit($education_id)
    {
        try {
            $education = Education::findOrFail($education_id); //Fetch education data 
            $data = [
                'action'          => route('update.education'),
                'page_title'      => trans('label.education'),
                'title'           => trans('title.edit_education'),
                'education_id'     => $education->id,
                'name'            => ($education->name) ? $education->name : old('name')
            ];
            return $data;
        } catch(\Exception $err){ 
            Log::error('message error in edit on EducationRepository :'. $err->getMessage());
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
            $education  = Education::findOrFail($request->education_id); //Fetch education data
            $education->name  = $request->name;
            $education->save(); // Update data
            if ($education->wasChanged()) { //Check if data was updated
               return true;
            } else {
               return false;
            }
        } catch(\Exception $err){
            Log::error('message error in update on EducationRepository :'. $err->getMessage());
            return back()->with('error', $err->getMessage());
        }
    }


    /**
    * Method to delete resource
    * @param Illuminate\Http\Request
    * @return boolean
    */
    public function delete($education_id)
    {
        try {
            $education = Education::destroy($education_id);
            if ($education) { //Check if data was deleted
               return true;
            } else {
               return false;
            }
        } catch(\Exception $err){
            Log::error('message error in delete on EducationRepository :'. $err->getMessage());
            return back()->with('error', $err->getMessage());
        }
    }
    

    /**
    * Method to delete resource
    * @param Illuminate\Http\Request
    * @return boolean
    */
    public function restore($education_id)
    {
        try {
            $education = Education::withTrashed()->find($education_id)->restore();
            if ($education) { //Check if data was restored
               return true;
            } else {
               return false;
            }
        } catch(\Exception $err){
            Log::error('message error in restore on EducationRepository :'. $err->getMessage());
            return back()->with('error', $err->getMessage());
        }
    }

    
}