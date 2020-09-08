<?php 

namespace App\Repositories;

use App\Models\Facilities;
use Log;
use Session;

class FacilityRepository {

    /**
    * Method to fetch all resource data
    *
    * @return Collection $query
    */
    public function getAllFacility()
    {
    	try {
    		return  $query = Facilities::withTrashed()->get();  
    	} catch(\Exception $err){
    		Log::error('message error in getAllFacility on FacilityRepository :'. $err->getMessage());
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
                'action'          => route('store.facility'),
                'page_title'      => trans('label.facility'),
                'title'           => trans('title.add_facility'),
                'facility_id' => 0,
                'name'            => (old('name')) ? old('name') : '',
            ];
            return $data;
        } catch(\Exception $err){
            Log::error('message error in create on FacilityRepository :'. $err->getMessage());
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
            
            $facility = Facilities::create($data);
            if ($facility->exists) {
               return true;
            } else {
               return false;
            }
        } catch(\Exception $err){
            Log::error('message error in store on FacilityRepository :'. $err->getMessage());
            return back()->with('error', $err->getMessage());
        }
    }


    /**
    * Method to fetch edit resource data
    * @param int $facility_id
    * @return array $data
    */
    public function edit($facility_id)
    {
        try {
            $facility = Facilities::findOrFail($facility_id); //Fetch facility data 
            $data = [
                'action'          => route('update.facility'),
                'page_title'      => trans('label.facility'),
                'title'           => trans('title.edit_facility'),
                'facility_id'     => $facility->id,
                'name'            => ($facility->name) ? $facility->name : old('name')
            ];
            return $data;
        } catch(\Exception $err){ 
            Log::error('message error in edit on FacilityRepository :'. $err->getMessage());
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
            $facility  = Facilities::findOrFail($request->facility_id); //Fetch facility data
            $facility->name  = $request->name;
            $facility->save(); // Update data
            if ($facility->wasChanged()) { //Check if data was updated
               return true;
            } else {
               return false;
            }
        } catch(\Exception $err){
            Log::error('message error in update on FacilityRepository :'. $err->getMessage());
            return back()->with('error', $err->getMessage());
        }
    }


    /**
    * Method to delete resource
    * @param Illuminate\Http\Request
    * @return boolean
    */
    public function delete($facility_id)
    {
        try {
            $facility = Facilities::destroy($facility_id);
            if ($facility) { //Check if data was deleted
               return true;
            } else {
               return false;
            }
        } catch(\Exception $err){
            Log::error('message error in delete on FacilityRepository :'. $err->getMessage());
            return back()->with('error', $err->getMessage());
        }
    }
    

    /**
    * Method to delete resource
    * @param Illuminate\Http\Request
    * @return boolean
    */
    public function restore($facility_id)
    {
        try {
            $facility = Facilities::withTrashed()->find($facility_id)->restore();
            if ($facility) { //Check if data was restored
               return true;
            } else {
               return false;
            }
        } catch(\Exception $err){
            Log::error('message error in restore on FacilityRepository :'. $err->getMessage());
            return back()->with('error', $err->getMessage());
        }
    }

    
}