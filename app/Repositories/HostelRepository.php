<?php 

namespace App\Repositories;

use App\Models\Hostel;
use App\Models\Facilities;
use Log;
use Lang;
use Session;

class HostelRepository {

    /**
    * Method to fetch all resource data
    *
    * @return Collection $query
    */
    public function getAllHostel()
    {
       
    	try {
            $data = [
                'hostels'          =>  Hostel::withTrashed()->get(), 
                'facilities_list' => Facilities::getAllFacilitiesForListing(), 
            ];
            return $data;
               
    	} catch(\Exception $err){
    		Log::error('message error in getAllHostel on HostelRepository :'. $err->getMessage());
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
        $facilities_ids = array();
        try {
            $data = [
                'action'          => route('store.hostel'),
                'page_title'      => Lang::get('label.hostel'),
                'title'           => Lang::get('title.add_hostel'),
                'hostel_id'       => 0,
                'name'            => (old('name')) ? old('name') : '',
                'address'         => (old('address')) ? old('address') : '',
                'facilities_list' => Facilities::getAllFacilitiesForListing(),
                'facilities_ids'  => $facilities_ids,
                'no_of_rooms'     => (old('no_of_rooms')) ? old('no_of_rooms') : '',
                'warden_name'     => (old('warden_name')) ? old('warden_name') : '',

            ];
            return $data;
        } catch(\Exception $err){
            Log::error('message error in create on HostelRepository :'. $err->getMessage());
            return back()->with('error', $err->getMessage());
        }
    }

    /**
    * Method to create resource
    * @param $request
    * @return boolean
    */
    public function store($request,$facilities_ids)
    {
        try {
            $data = [
                'name'               => $request->name,
                'address'            => $request->address,
                'facilities_ids'     => $facilities_ids,
                'no_of_rooms'        => $request->no_of_rooms,
                'warden_name'        => $request->warden_name
            ];
            
            $hostel = Hostel::create($data);
            if ($hostel->exists) {
               return true;
            } else {
               return false;
            }
        } catch(\Exception $err){
            Log::error('message error in store on HostelRepository :'. $err->getMessage());
            return back()->with('error', $err->getMessage());
        }
    }

    /**
    * Method to fetch edit resource data
    * @param int $hostel_id
    * @return array $data
    */
    public function edit($hostel_id)
    {
        try {
            $hostel = Hostel::withTrashed()->where('id',$hostel_id)->first(); //Fetch hostel data
            $facilities_ids = ($hostel->facilities_ids) ? (explode(',',$hostel->facilities_ids)) : old('facilities_ids');
            // Create data for edit form
            $data = [
                'action'          => route('update.hostel'),
                'page_title'      => Lang::get('label.hostel'),
                'title'           => Lang::get('title.edit_hostel'),
                'hostel_id'       => $hostel->id,
                'name'            => ($hostel->name) ? $hostel->name : old('name'),
                'address'         => ($hostel->name) ? $hostel->name : old('address'),
                'facilities_list' => Facilities::getAllFacilitiesForListing(),
                'facilities_ids'  => $facilities_ids,
                'no_of_rooms'     => ($hostel->no_of_rooms) ? $hostel->no_of_rooms : old('no_of_rooms'),
                'warden_name'         => ($hostel->warden_name) ? $hostel->warden_name : old('warden_name'),
            ];
            return $data;
        } catch(\Exception $err){ 
            Log::error('message error in edit on HostelRepository :'. $err->getMessage());
            return back()->with('error', $err->getMessage());
        }
    }

    /**
    * Method to update resource
    * @param Illuminate\Http\Request
    * @return boolean
    */
    public function update($request,$facilities_ids)
    {
        try {
            $hostel  = Hostel::findOrFail($request->hostel_id); //Fetch hostel data
            $hostel->name   =  $request->name;
            $hostel->address   =  $request->address;
            $hostel->facilities_ids   =  $facilities_ids;
            $hostel->no_of_rooms   =  $request->no_of_rooms;
            $hostel->warden_name   =  $request->warden_name;
            $hostel->save(); // Update data
            if ($hostel->wasChanged()) { //Check if data was updated
               return true;
            } else {
               return false;
            }
        } catch(\Exception $err){
            Log::error('message error in update on HostelRepository :'. $err->getMessage());
            return back()->with('error', $err->getMessage());
        }
    }

    /**
    * Method to delete resource
    * @param Illuminate\Http\Request
    * @return boolean
    */
    public function delete($hostel_id)
    {
        try {
            $hostel = Hostel::destroy($hostel_id);
            if ($hostel) { //Check if data was deleted
               return true;
            } else {
               return false;
            }
        } catch(\Exception $err){
            Log::error('message error in delete on HostelRepository :'. $err->getMessage());
            return back()->with('error', $err->getMessage());
        }
    }

    /**
    * Method to delete resource
    * @param Illuminate\Http\Request
    * @return boolean
    */
    public function restore($hostel_id)
    {
        try {
            $hostel = Hostel::withTrashed()->find($hostel_id)->restore();
            if ($hostel) { //Check if data was restored
               return true;
            } else {
               return false;
            }
        } catch(\Exception $err){
            Log::error('message error in restore on HostelRepository :'. $err->getMessage());
            return back()->with('error', $err->getMessage());
        }
    }

    
}