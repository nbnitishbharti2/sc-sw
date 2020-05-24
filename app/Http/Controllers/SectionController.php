<?php

namespace App\Http\Controllers;

use App\Section;
use Illuminate\Http\Request;
use App\Repositories\SectionRepository;
use App\Http\Requests\SectionRequest;
use App\User;
use Validator;
use Auth;
use Log;
use App;
use Helper;


class SectionController extends Controller
{
    public function __construct(SectionRepository $section)
    {
        $this->section = $section;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        try {
            if(!Helper::checkPermission('view-section')) {
                return back()->with('error', trans('error.unauthorized'));
            }
            $data['section'] = $this->section->getAllSection(); // Fetch all section data
            return view('section.index', $data);
        } catch(\Exception $err){
            Log::error('Error in index on SectionController :'. $err->getMessage());
            return back()->with('error', $err->getMessage());
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
       
        try {
            if(!Helper::checkPermission('add-section')) {
                return back()->with('error', trans('error.unauthorized'));
            }
            $data = $this->section->create();
            return view('section.form', $data);
        } catch(\Exception $err){
            Log::error('Error in create on SectionController :'. $err->getMessage());
            return back()->with('error', $err->getMessage());
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  App\Http\Requests\SectionRequest $section_request
     * @return \Illuminate\Http\Response
     */
    public function store(SectionRequest $section_request)
    {
        try {
            if(!Helper::checkPermission('add-section')) {
                return back()->with('error', trans('error.unauthorized'));
            }
			$result = $this->section->store($section_request);
			if($result == true) {
				return back()->with('success', trans('success.section_added_successfully'));
			}
			return back()->with('error', trans('error.section_not_added'));
		} catch(\Exception $err){
    		Log::error('Error in index on SectionController :'. $err->getMessage());
    		return back()->with('error', $err->getMessage());
    	}
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Section  $section
     * @return \Illuminate\Http\Response
     */
    public function show(Section $section)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Section  $section
     * @return \Illuminate\Http\Response
     */
    public function edit($section_id = 0)
    {
        try {
            if(!Helper::checkPermission('edit-section')) {
                return back()->with('error', trans('error.unauthorized'));
            }
			if($section_id == 0){
				return back()->with('error', trans('error.section_not_found'));
            }
            $data = $this->section->edit($section_id);
			return view('section.form', $data);
		} catch(\Exception $err){
    		Log::error('Error in edit on SectionController :'. $err->getMessage());
    		return back()->with('error', $err->getMessage());
    	}
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \App\Section $section
     * @return \Illuminate\Http\Response
     */
    public function update(SectionRequest $section_request)
    {
        try {
            if(!Helper::checkPermission('edit-section')) {
                return back()->with('error', trans('error.unauthorized'));
            }
			$result = $this->section->update($section_request);
			if($result == true) {
				return redirect('view-section')->with('success', trans('success.section_updated_successfully'));
			}
			return back()->with('error', trans('error.section_not_updated'));
		} catch(\Exception $err){
			Log::error('Error in update on SectionController :'. $err->getMessage());
    		return back()->with('error', $err->getMessage());
    	}
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Section  $section
     * @return \Illuminate\Http\Response
     */
    public function destroy($section_id = 0)
    {
        try {
            if(!Helper::checkPermission('delete-section')) {
                return back()->with('error', trans('error.unauthorized'));
            }
			if($section_id == 0){
				return back()->with('error', trans('error.section_not_found'));
			}
			$result = $this->section->delete($section_id);
			if($result == true) {
				return back()->with('success', trans('success.section_deleted_successfully'));
			}
			return back()->with('error', trans('error.section_not_deleted'));
		} catch(\Exception $err){
    		Log::error('Error in index on SectionController :'. $err->getMessage());
    		return back()->with('error', $err->getMessage());
    	}
    }

    /**
	* Method to restore resource
	* @param int $section_id
	* @return Illuminate\Http\Response
	*/
	public function restore($section_id = 0)
	{
		try {
            if(!Helper::checkPermission('delete-section')) {
                return back()->with('error', trans('error.unauthorized'));
            }
			if($section_id == 0) {
				return back()->with('error', trans('error.section_not_found'));
			}
			$result = $this->section->restore($section_id);
			if($result == true) {
				return back()->with('success', trans('success.section_restored_successfully'));
			}
			return back()->with('error', trans('error.section_not_restored'));
		} catch(\Exception $err){
    		Log::error('Error in restore on SectionController :'. $err->getMessage());
    		return back()->with('error', $err->getMessage());
    	}
    }

    public function getSessionList(Request $request)
    { 
        try {
            $data = $this->section->getSectionList($request->class_id,$request->session_id); 
            return json_encode($data);
        } catch(\Exception $err){
            Log::error('Error in getSessionList on SectionController :'. $err->getMessage());
            return back()->with('error', $err->getMessage());
        }
    }
}
