<?php 

namespace App\Repositories;

use App\Models\Room;
use App\Models\Type;
use App\Models\Hostel;
use App\Models\RoomType;
use Log;
use Session;

class RoomRepository {

    /**
    * Method to fetch all resource data
    *
    * @return Collection $query
    */
    public function getAllRoom()
    {

    	try {
           return  $query = Room::where('session_id',Session::get('session'))->with(['type','hostel','room_type'])->withTrashed()->get();  
       } catch(\Exception $err){
          Log::error('message error in getAllRoom on RoomRepository :'. $err->getMessage());
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
                'action'          => route('store.room'),
                'page_title'      => trans('label.room'),
                'title'           => trans('title.add_room'),
                'room_id'         => 0,
                'name'            => (old('name')) ? old('name') : '',
                'type_list'       => Type::getAllTypeForListing(),
                'type_id'         => 0,
                'hostel_list'     => Hostel::getAllHostelForListing(),
                'hostel_id'       => 0,
                'room_type_list'  => RoomType::getAllRoomTypeForListing(),
                'room_type_id'    => 0,
                'room_capacity'   => (old('room_capacity')) ? old('room_capacity') : '',
                'charge'          => (old('charge')) ? old('charge') : '',

            ];
            return $data;
        } catch(\Exception $err){
            Log::error('message error in create on RoomRepository :'. $err->getMessage());
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
                'session_id'            => Session::get('session'),
                'name'                  => $request->name,
                'type_id'               => $request->type_id,
                'hostel_id'             => $request->hostel_id,
                'room_type_id'          => $request->room_type_id,
                'room_capacity'         => $request->room_capacity,
                'current_room_capacity' => 0,
                'charge'                => $request->charge
            ];
            
            $room = Room::create($data);
            if ($room->exists) {
                return true;
            } else {
                return false;
            }
        } catch(\Exception $err){
            Log::error('message error in store on RoomRepository :'. $err->getMessage());
            return back()->with('error', $err->getMessage());
        }
    }

    /**
    * Method to fetch edit resource data
    * @param int $room_id
    * @return array $data
    */
    public function edit($room_id)
    {
        try {
            $room = Room::withTrashed()->with(['type','hostel','room_type'])->where('id',$room_id)->first(); //Fetch room data
            // Create data for edit form
            $data = [
                'action'                => route('update.room'),
                'page_title'            => trans('label.room'),
                'title'                 => trans('title.edit_room'),
                'room_id'               => $room->id,
                'name'                  => ($room->name) ? $room->name : old('name'),
                'type_list'             => Type::getAllTypeForListing(),
                'type_id'               => $room->type->id,
                'hostel_list'           => Hostel::getAllHostelForListing(),
                'hostel_id'             => $room->hostel->id,
                'room_type_list'        => RoomType::getAllRoomTypeForListing(),
                'room_type_id'          => $room->room_type->id,
                'room_capacity'         => ($room->room_capacity) ? $room->room_capacity : old('room_capacity'),
                'current_room_capacity' => 0,
                'charge'                => ($room->charge) ? $room->charge : old('charge'),
            ];
            return $data;
        } catch(\Exception $err){ 
            Log::error('message error in edit on RoomRepository :'. $err->getMessage());
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
            $room  = Room::findOrFail($request->room_id); //Fetch room data
            $room->name                  = $request->name;
            $room->type_id               = $request->type_id;
            $room->hostel_id             = $request->hostel_id;
            $room->room_type_id          = $request->room_type_id;
            $room->room_capacity         = $request->room_capacity;
            $room->current_room_capacity = 0;
            $room->charge                = $request->charge;
            $room->save(); // Update data
            if ($room->wasChanged()) { //Check if data was updated
                return true;
            } else {
                return false;
            }
        } catch(\Exception $err){
            Log::error('message error in update on RoomRepository :'. $err->getMessage());
            return back()->with('error', $err->getMessage());
        }
    }

    /**
    * Method to delete resource
    * @param Illuminate\Http\Request
    * @return boolean
    */
    public function delete($room_id)
    {
        try {
            $room = Room::destroy($room_id);
            if ($room) { //Check if data was deleted
                 return true;
            } else {
                 return false;
            }
        } catch(\Exception $err){
            Log::error('message error in delete on RoomRepository :'. $err->getMessage());
            return back()->with('error', $err->getMessage());
        }
    }

    /**
    * Method to delete resource
    * @param Illuminate\Http\Request
    * @return boolean
    */
    public function restore($room_id)
    {
        try {
            $room = Room::withTrashed()->find($room_id)->restore();
            if ($room) { //Check if data was restored
               return true;
            } else {
               return false;
            }
        } catch(\Exception $err){
            Log::error('message error in restore on RoomRepository :'. $err->getMessage());
            return back()->with('error', $err->getMessage());
        }
    }


}