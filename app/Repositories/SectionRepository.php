<?php 

namespace App\Repositories;

use App\Models\Section;
use App\Models\Classes;
use Log;
use Auth;
use Session;

class SectionRepository {

    /**
    * Method to fetch all resource data
    *
    * @return Collection $query
    */
    public function getAllSection()
    {
    	try {
    		return $query = Section::where('session_id',Session::get('session'))->withTrashed()->with('class')->get();
    	} catch(\Exception $err){
    		Log::error('message error in getAllSection on SectionRepository :'. $err->getMessage());
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
                'action'        => route('store.section'),
                'page_title'    => trans('label.section'),
                'title'         => trans('title.add_section'),
                'section_id'    => 0,
                'class_list'    => Classes::getAllClassForListing(),
                'class_id'      => 0,
                'section_name'  => (old('section_name')) ? old('section_name') : '',
                'section_short' => (old('section_short')) ? old('section_short') : '',
            ]; 
            return $data;
        } catch(\Exception $err){
            Log::error('message error in create on SectionRepository :'. $err->getMessage());
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
                'classes_id'        => $request->class_id,
                'session_id'        => Session::get('session'),
                'section_name'      => $request->section_name,
                'section_short'     => $request->section_short,
                'added_by'          => Auth::user()->id,
                'updated_by'        => Auth::user()->id
            ];
            
            $class = Section::create($data);
            if ($class->exists) {
               return true;
            } else {
               return false;
            }
        } catch(\Exception $err){
            Log::error('message error in store on SectionRepository :'. $err->getMessage());
            return false;
        }
    }

    /**
    * Method to fetch edit resource data
    * @param int $section_id
    * @return array $data
    */
    public function edit($section_id)
    {
        try {
            $section = Section::select('sections.*')->leftjoin('sessions', 'sessions.id', 'sections.session_id')
                                                    ->withTrashed()
                                                    ->with('class')
                                                    ->where(['sessions.id' => Session::get('session'), 'sections.id' => $section_id])
                                                    ->first(); //Fetch section data
            // Create data for edit form
            $data = [
                'action'            => route('update.section'),
                'page_title'    => trans('label.section'),
                'title'         => trans('title.edit_section'),
                'class_id'          => $section->class->id,
                'section_id'        => $section->id,
                'class_list'        => Classes::getAllClassForListing(),
                'section_name'      => ($section->section_name) ? $section->section_name : old('section_name'),
                'section_short'     => ($section->section_short) ? $section->section_short : old('section_short'),
            ];
            return $data;
        } catch(\Exception $err){
            Log::error('message error in create on SectionRepository :'. $err->getMessage());
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
        //dd($request);
        try {
            $section                = Section::findOrFail($request->section_id); //Fetch section data

            $section->classes_id    = $request->class_id;
            $section->section_name  = $request->section_name;
            $section->section_short   = $request->section_short;
            $section->updated_by    = Auth::user()->id;
             
            $section->save(); // Update data
            if ($section->wasChanged()) { //Check if data was updated
               return true;
            } else {
               return false;
            }
        } catch(\Exception $err){
            Log::error('message error in update on SectionRepository :'. $err->getMessage());
            return back()->with('error', $err->getMessage());
        }
    }

    /**
    * Method to delete resource
    * @param Illuminate\Http\Request
    * @return boolean
    */
    public function delete($section_id)
    {
        try {
            $section = Section::destroy($section_id); // Delete resource
            if ($section) { //Check if data was updated
               return true;
            } else {
               return false;
            }
        } catch(\Exception $err){
            Log::error('message error in delete on SectionRepository :'. $err->getMessage());
            return back()->with('error', $err->getMessage());
        }
    }

    /**
    * Method to delete resource
    * @param Illuminate\Http\Request
    * @return boolean
    */
    public function restore($section_id)
    {
        try {
            $section = Section::withTrashed()->find($section_id)->restore();
            if ($section) { //Check if data was updated
               return true;
            } else {
               return false;
            }
        } catch(\Exception $err){
            Log::error('message error in restore on SectionRepository :'. $err->getMessage());
            return back()->with('error', $err->getMessage());
        }
    }
}