<?php 

namespace App\Repositories;

use App\Models\Root;
use Log;
use Session;

class RootRepository {

    /**
    * Method to fetch all resource data
    *
    * @return Collection $query
    */
    public function getAllRoot()
    {
       
    	try {
    		return  $query = Root::withTrashed()->get();  
    	} catch(\Exception $err){
    		Log::error('message error in getAllRoot on RootRepository :'. $err->getMessage());
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
                'action'          => route('store.root'),
                'page_title'      => trans('label.root'),
                'title'           => trans('title.add_root'),
                'root_id' => 0,
                'name'            => (old('name')) ? old('name') : '',
            ];
            return $data;
        } catch(\Exception $err){
            Log::error('message error in create on RootRepository :'. $err->getMessage());
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
            
            $root = Root::create($data);
            if ($root->exists) {
               return true;
            } else {
               return false;
            }
        } catch(\Exception $err){
            Log::error('message error in store on RootRepository :'. $err->getMessage());
            return back()->with('error', $err->getMessage());
        }
    }

    /**
    * Method to fetch edit resource data
    * @param int $root_id
    * @return array $data
    */
    public function edit($root_id)
    {
        try {
            $root = Root::findOrFail($root_id); //Fetch root data 
            $data = [
                'action'          => route('update.root'),
                'page_title'      => trans('label.root'),
                'title'           => trans('title.edit_root'),
                'root_id' => $root->id,
                'name'      => ($root->name) ? $root->name : old('name')
            ];
            return $data;
        } catch(\Exception $err){ 
            Log::error('message error in edit on RootRepository :'. $err->getMessage());
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
            $root  = Root::findOrFail($request->root_id); //Fetch root data
            $root->name  = $request->name;
            $root->save(); // Update data
            if ($root->wasChanged()) { //Check if data was updated
               return true;
            } else {
               return false;
            }
        } catch(\Exception $err){
            Log::error('message error in update on RootRepository :'. $err->getMessage());
            return back()->with('error', $err->getMessage());
        }
    }

    /**
    * Method to delete resource
    * @param Illuminate\Http\Request
    * @return boolean
    */
    public function delete($root_id)
    {
        try {
            $root = Root::destroy($root_id);
            if ($root) { //Check if data was deleted
               return true;
            } else {
               return false;
            }
        } catch(\Exception $err){
            Log::error('message error in delete on RootRepository :'. $err->getMessage());
            return back()->with('error', $err->getMessage());
        }
    }

    /**
    * Method to delete resource
    * @param Illuminate\Http\Request
    * @return boolean
    */
    public function restore($root_id)
    {
        try {
            $root = Root::withTrashed()->find($root_id)->restore();
            if ($root) { //Check if data was restored
               return true;
            } else {
               return false;
            }
        } catch(\Exception $err){
            Log::error('message error in restore on RootRepository :'. $err->getMessage());
            return back()->with('error', $err->getMessage());
        }
    }


    
}