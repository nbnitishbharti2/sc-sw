<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repositories\RoomRepository;
use App\Http\Requests\RoomRequest ;
use App\Models\Type;
use App\Models\Hostel;
use App\Models\RoomType;
use Validator;
use Auth;
use Log;
use App;
use Session;
use Helper;

class RoomController extends Controller
{
   	public function __construct(RoomRepository $room)
	{
		$this->room = $room;
	}

	/**
    * Method for show list of resources
    * 
    * @return Illuminate\Http\Response
    */
	public function index()
	{
		try {
			if(!Helper::checkPermission('view-room')) {
                return back()->with('error', trans('error.unauthorized'));
            }
			$data['room'] = $this->room->getAllRoom(); // Fetch all room data 
			return view('room.index', $data);
		} catch(\Exception $err){
    		Log::error('Error in index on RoomController :'. $err->getMessage());
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
			if(!Helper::checkPermission('add-room')) {
                return back()->with('error', trans('error.unauthorized'));
            }
			$data = $this->room->create();
			return view('room.form', $data);
		} catch(\Exception $err){
    		Log::error('Error in create on RoomController :'. $err->getMessage());
    		return back()->with('error', $err->getMessage());
    	}
	}

	/**
	* Method to create resource
	* @param App\Http\Requests\RoomRequest $room_request
	* @return Illuminate\Http\Response
	*/
	public function store(RoomRequest $room_request)
	{
		try {
			if(!Helper::checkPermission('add-room')) {
                return back()->with('error', trans('error.unauthorized'));
            }
			$result = $this->room->store($room_request);
			if($result == true) {
				return back()->with('success', trans('success.room_added_successfully'));
			}
			return back()->with('error', trans('error.room_not_added'));
		} catch(\Exception $err){
    		Log::error('Error in store on RoomController :'. $err->getMessage());
    		return back()->with('error', $err->getMessage());
    	}
	}

	/**
	* Method to show form for edit resource
	* @param int $room_id
	* @return Illuminate\Http\Response
	*/
	public function edit($room_id = 0)
	{
		try {
			if(!Helper::checkPermission('edit-room')) {
                return back()->with('error', trans('error.unauthorized'));
            }
			if($room_id == 0){
				return back()->with('error', trans('error.room_not_found'));
			}
			$data = $this->room->edit($room_id);
			return view('room.form', $data);
		} catch(\Exception $err){
    		Log::error('Error in edit on RoomController :'. $err->getMessage());
    		return back()->with('error', $err->getMessage());
    	}
	}

	/**
	* Method to update resource
	* @param Illuminate\Http\Request
	* @return Illuminate\Http\Response
	*/
	public function update(RoomRequest $request)
	{
		try {
			if(!Helper::checkPermission('edit-room')) {
                return back()->with('error', trans('error.unauthorized'));
            }
			$result = $this->room->update($request);
			if($result == true) {
				return redirect('view-room')->with('success', trans('success.room_updated_successfully'));
			}
			return back()->with('error', trans('error.room_not_updated'));
		} catch(\Exception $err){
			Log::error('Error in update on RoomController :'. $err->getMessage());
    		return back()->with('error', $err->getMessage());
    	}
	}

	/**
	* Method to delete resource
	* @param int $room_id
	* @return Illuminate\Http\Response
	*/
	public function delete($room_id = 0)
	{
		try {
			if(!Helper::checkPermission('delete-room')) {
                return back()->with('error', trans('error.unauthorized'));
            }
			if($room_id == 0){
				return back()->with('error', trans('error.room_not_found'));
			}
			$result = $this->room->delete($room_id);
			if($result == true) {
				return back()->with('success', trans('success.room_deleted_successfully'));
			}
			return back()->with('error', trans('error.room_not_deleted'));
		} catch(\Exception $err){
    		Log::error('Error in delete on RoomController :'. $err->getMessage());
    		return back()->with('error', $err->getMessage());
    	}
	}

	/**
	* Method to restore resource
	* @param int $room_id
	* @return Illuminate\Http\Response
	*/
	public function restore($room_id = 0)
	{
		try {
			if(!Helper::checkPermission('delete-room')) {
                return back()->with('error', trans('error.unauthorized'));
            }
			if($room_id == 0){
				return back()->with('error', trans('error.room_not_found'));
			}
			$result = $this->room->restore($room_id);
			if($result == true) {
				return back()->with('success', trans('success.room_restored_successfully'));
			}
			return back()->with('error', trans('error.room_not_restored'));
		} catch(\Exception $err){
    		Log::error('Error in restore on RoomController :'. $err->getMessage());
    		return back()->with('error', $err->getMessage());
    	}
	}


	public function getRoomList(Request $request)
	{
		try {
			$data = $this->room->getRoomList($request->hostel_id,$request->session_id);
			return json_encode($data);
		} catch(\Exception $err){
			Log::error('Error in getRoomList on RoomController :'. $err->getMessage());
			return back()->with('error', $err->getMessage());
		}
	}

	public function getCharge(Request $request)
	{
		try {
			$data = $this->room->getCharge($request->room_id,$request->session_id);
			return json_encode($data);
		} catch(\Exception $err){
			Log::error('Error in getCharge on RoomController :'. $err->getMessage());
			return back()->with('error', $err->getMessage());
		}
	}

	
}
