<?php 

namespace App\Repositories;

use App\Models\Type;
use Log;
use Session;

class TypeRepository {

    /**
    * Method to fetch all resource data
    *
    * @return Collection $query
    */
    public function getAllType()
    {
    	try {
    		return  $query = Type::withTrashed()->get();  
    	} catch(\Exception $err){
    		Log::error('message error in getAllType on TypeRepository :'. $err->getMessage());
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
                'action'          => route('store.type'),
                'page_title'      => trans('label.type'),
                'title'           => trans('title.add_type'),
                'type_id' => 0,
                'name'            => (old('name')) ? old('name') : '',
            ];
            return $data;
        } catch(\Exception $err){
            Log::error('message error in create on TypeRepository :'. $err->getMessage());
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
            
            $type = Type::create($data);
            if ($type->exists) {
               return true;
            } else {
               return false;
            }
        } catch(\Exception $err){
            Log::error('message error in store on TypeRepository :'. $err->getMessage());
            return back()->with('error', $err->getMessage());
        }
    }


    /**
    * Method to fetch edit resource data
    * @param int $type_id
    * @return array $data
    */
    public function edit($type_id)
    {
        try {
            $type = Type::findOrFail($type_id); //Fetch type data 
            $data = [
                'action'          => route('update.type'),
                'page_title'      => trans('label.type'),
                'title'           => trans('title.edit_type'),
                'type_id'         => $type->id,
                'name'            => ($type->name) ? $type->name : old('name')
            ];
            return $data;
        } catch(\Exception $err){ 
            Log::error('message error in edit on TypeRepository :'. $err->getMessage());
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
            $type  = Type::findOrFail($request->type_id); //Fetch type data
            $type->name  = $request->name;
            $type->save(); // Update data
            if ($type->wasChanged()) { //Check if data was updated
               return true;
            } else {
               return false;
            }
        } catch(\Exception $err){
            Log::error('message error in update on TypeRepository :'. $err->getMessage());
            return back()->with('error', $err->getMessage());
        }
    }


    /**
    * Method to delete resource
    * @param Illuminate\Http\Request
    * @return boolean
    */
    public function delete($type_id)
    {
        try {
            $type = Type::destroy($type_id);
            if ($type) { //Check if data was deleted
               return true;
            } else {
               return false;
            }
        } catch(\Exception $err){
            Log::error('message error in delete on TypeRepository :'. $err->getMessage());
            return back()->with('error', $err->getMessage());
        }
    }


    /**
    * Method to delete resource
    * @param Illuminate\Http\Request
    * @return boolean
    */
    public function restore($type_id)
    {
        try {
            $type = Type::withTrashed()->find($type_id)->restore();
            if ($type) { //Check if data was restored
               return true;
            } else {
               return false;
            }
        } catch(\Exception $err){
            Log::error('message error in restore on TypeRepository :'. $err->getMessage());
            return back()->with('error', $err->getMessage());
        }
    }
    

    
}