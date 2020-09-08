<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repositories\StudentRegistrationRepository;
use App\Http\Requests\StudentRegistration;
use App\Http\Requests\StudentAddress;
use App\Http\Requests\StudentParent;
use App\Http\Requests\StudentMultipleUpload;
use Log;
use Lang;
use Helper;


class StudentRegistrationController extends Controller
{
    public function __construct(StudentRegistrationRepository $studentRegistration)
    {
        $this->studentRegistration = $studentRegistration;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        try {
            if(!Helper::checkPermission('view-student-registration')) {
                return back()->with('error', trans('error.unauthorized'));
            }
            $data['student_registration'] = $this->studentRegistration->getAllStudentRegistrations($request); // Fetch all student registration data
            return view('student.registration.index', $data);
        } catch(\Exception $err){
            Log::error('Error in index on StudentRegistrationController :'. $err->getMessage());
            return back()->with('error', $err->getMessage());
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($id=0)
    {
        try {
            if(!Helper::checkPermission('add-student-registration')) {
                return back()->with('error', trans('error.unauthorized'));
            } 
            $data = $this->studentRegistration->create($id);  
            return view('student.registration.student-details', $data);
        } catch(\Exception $err){
            Log::error('Error in create on StudentRegistrationController :'. $err->getMessage());
            return back()->with('error', $err->getMessage());
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StudentRegistration $request)
    {
        try {
            if(!Helper::checkPermission('add-student-registration')) {
                return back()->with('error', trans('error.unauthorized'));
            }
            $result = $this->studentRegistration->store($request);
            if($result['status'] == true) {
                 return redirect()->route('edit.student.registration.address',['id' => $result['id'],'map_id' => $result['map_id']])->with('success', Lang::get('success.student_registerd_successfully')); 
            }
            return back()->with('error', Lang::get('error.student_not_registerd'));
        } catch(\Exception $err){
            Log::error('Error in store on StudentRegistrationController :'. $err->getMessage());
            return back()->with('error', $err->getMessage());
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    
    public function edit_address($id,$map_id)
    {
       
        try {
            $data = $this->studentRegistration->edit_address($id,$map_id); 
            return view('student.registration.student-details', $data);
        } catch(\Exception $err){
            Log::error('Error in edit_address on StudentRegistrationController :'. $err->getMessage());
            return back()->with('error', $err->getMessage());
        }
    }
    public function update_address(StudentAddress $request)
    {
        try {
            $result = $this->studentRegistration->update_address($request);
            if($result['status'] == true) {
                 return redirect()->route('edit.student.registration.parent',['id' => $result['id'],'map_id' => $result['map_id']])->with('success', Lang::get('success.student_address_updated_successfully')); 
            }
            return back()->with('error', Lang::get('error.student_address_not_updated'));
        } catch(\Exception $err){
            Log::error('Error in update_address on StudentRegistrationController :'. $err->getMessage());
            return back()->with('error', $err->getMessage());
        }
    }
    
    public function edit_parent($id,$map_id)
    { 
        try {
            $data = $this->studentRegistration->edit_parent($id,$map_id); 
            return view('student.registration.student-details', $data);
        } catch(\Exception $err){
            Log::error('Error in edit_parent on StudentRegistrationController :'. $err->getMessage());
            return back()->with('error', $err->getMessage());
        }
    }
    public function update_parent(StudentParent $request)
    {
        try {
            $result = $this->studentRegistration->update_parent($request);
            if($result['status'] == true) {
                 return redirect()->route('edit.student.registration.multiple_upload',['id' => $result['id'],'map_id' => $result['map_id']])->with('success', Lang::get('success.student_parent_updated_successfully')); 
            }
            return back()->with('error', Lang::get('error.student_parent_not_updated'));
        } catch(\Exception $err){
            Log::error('Error in update_parent on StudentRegistrationController :'. $err->getMessage());
            return back()->with('error', $err->getMessage());
        }
    }


    public function edit_multiple_upload($id,$map_id)
    { 
        try {
            $data = $this->studentRegistration->edit_multiple_upload($id,$map_id); 
            return view('student.registration.student-details', $data);
        } catch(\Exception $err){
            Log::error('Error in edit_multiple_upload on StudentRegistrationController :'. $err->getMessage());
            return back()->with('error', $err->getMessage());
        }
    }


    public function update_multiple_upload(Request $request)  
    {
        //StudentMultipleUploadRequest
        try {
            $result = $this->studentRegistration->update_multiple_upload($request);
            if($result['status'] == true) {
                 return redirect()->route('edit.student.registration.charge',['id' => $result['id'],'map_id' => $result['map_id']])->with('success', Lang::get('success.student_multiple_upload_updated_successfully')); 
            }
            return back()->with('error', Lang::get('error.student_multiple_upload_not_updated'));
        } catch(\Exception $err){
            Log::error('Error in update_multiple_upload on StudentRegistrationController :'. $err->getMessage());
            return back()->with('error', $err->getMessage());
        }
    }


    public function edit_charge($id,$map_id)
    { 
        try {
            $data = $this->studentRegistration->edit_charge($id,$map_id); 
            return view('student.registration.student-details', $data);
        } catch(\Exception $err){
            Log::error('Error in edit_charge on StudentRegistrationController :'. $err->getMessage());
            return back()->with('error', $err->getMessage());
        }
    }


    /**
    * Method to view resource
    * @param int $student_registration_id
    * @return Illuminate\Http\Response
    */
    public function viewPersonalDetails($id = 0)
    {
        try {
            if(!Helper::checkPermission('delete-student-registration')) {
                return back()->with('error', trans('error.unauthorized'));
            }
            if($id == 0){
                return back()->with('error', trans('error.student_registration_not_found'));
            }
            $data = $this->studentRegistration->viewPersonalDetails($id);
            return view('student.registration.view_student_details', $data);
        } catch(\Exception $err){
            Log::error('Error in viewPersonalDetails on StudentRegistrationController :'. $err->getMessage());
            return back()->with('error', $err->getMessage());
        }
    }

    
    public function viewAddress($id, $map_id)
    {
        try {
            if($id == 0){
                return back()->with('error', trans('error.student_registration_not_found'));
            }
            $data = $this->studentRegistration->viewAddress($id, $map_id);
            return view('student.registration.view_student_details', $data);
        } catch(\Exception $err){
            Log::error('Error in viewAddress on StudentRegistrationController :'. $err->getMessage());
            return back()->with('error', $err->getMessage());
        }
    }


    public function viewParent($id, $map_id)
    {
        try {
            if($id == 0){
                return back()->with('error', trans('error.student_registration_not_found'));
            }
            $data = $this->studentRegistration->viewParent($id, $map_id);
            return view('student.registration.view_student_details', $data);
        } catch(\Exception $err){
            Log::error('Error in viewParent on StudentRegistrationController :'. $err->getMessage());
            return back()->with('error', $err->getMessage());
        }
    }


    public function viewMultipleUpload($id, $map_id)
    {
        try {
            if($id == 0){
                return back()->with('error', trans('error.student_registration_not_found'));
            }
            $data = $this->studentRegistration->viewMultipleUpload($id, $map_id);
            return view('student.registration.view_student_details', $data);
        } catch(\Exception $err){
            Log::error('Error in viewMultipleUpload on StudentRegistrationController :'. $err->getMessage());
            return back()->with('error', $err->getMessage());
        }
    }


    public function viewCharge($id, $map_id)
    {
        try {
            if($id == 0){
                return back()->with('error', trans('error.student_registration_not_found'));
            }
            $data = $this->studentRegistration->viewCharge($id, $map_id);
            return view('student.registration.view_student_details', $data);
        } catch(\Exception $err){
            Log::error('Error in viewCharge on StudentRegistrationController :'. $err->getMessage());
            return back()->with('error', $err->getMessage());
        }
    }




    /**
    * Method to delete resource
    * @param int $student_registration_id
    * @return Illuminate\Http\Response
    */
    public function delete($student_registration_id = 0)
    {
        try {
            if(!Helper::checkPermission('delete-student-registration')) {
                return back()->with('error', trans('error.unauthorized'));
            }
            if($student_registration_id == 0){
                return back()->with('error', trans('error.student_registration_not_found'));
            }
            $result = $this->studentRegistration->delete($student_registration_id);
            if($result == true) {
                return back()->with('success', trans('success.student_registration_deleted_successfully'));
            }
            return back()->with('error', trans('error.student_registration_not_deleted'));
        } catch(\Exception $err){
            Log::error('Error in delete on StudentRegistrationController :'. $err->getMessage());
            return back()->with('error', $err->getMessage());
        }
    }

    /**
    * Method to restore resource
    * @param int $student_registration_id
    * @return Illuminate\Http\Response
    */
    public function restore($student_registration_id = 0)
    {
        try {
            if(!Helper::checkPermission('delete-student-registration')) {
                return back()->with('error', trans('error.unauthorized'));
            }
            if($student_registration_id == 0){
                return back()->with('error', trans('error.student_registration_not_found'));
            }
            $result = $this->studentRegistration->restore($student_registration_id);
            if($result == true) {
                return back()->with('success', trans('success.student_registration_restored_successfully'));
            }
            return back()->with('error', trans('error.student_registration_not_restored'));
        } catch(\Exception $err){
            Log::error('Error in restore on StudentRegistrationController :'. $err->getMessage());
            return back()->with('error', $err->getMessage());
        }
    }

    
}
