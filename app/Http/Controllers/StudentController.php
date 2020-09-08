<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repositories\StudentRepository;
use App\Http\Requests\Admission\StudentAdmission;
use App\Http\Requests\Admission\StudentAddress;
use App\Http\Requests\Admission\StudentParent;
use App\Http\Requests\Admission\StudentMultiipleUpload;
use Log;
use Lang;
use Helper;


class StudentController extends Controller
{
    public function __construct(StudentRepository $student)
    {
        $this->student = $student;
    }



    public function index(Request $request)
    {
        try {
            if(!Helper::checkPermission('view-student')) {
                return back()->with('error', trans('error.unauthorized'));
            }
            $data['student_admission'] = $this->student->getAllStudentAdmissions($request); // Fetch all student admission data
            return view('student.admission.index', $data);
        } catch(\Exception $err){
            Log::error('Error in index on StudentController :'. $err->getMessage());
            return back()->with('error', $err->getMessage());
        }
    }
    

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($id=0, $session_map_id=0, $type=null)
    {
        try { 
            if(!Helper::checkPermission('add-student')) {
                return back()->with('error', trans('error.unauthorized'));
            }
            $data = $this->student->create($id, $session_map_id, $type);  
            return view('student.admission.student-details', $data);
        } catch(\Exception $err){
            Log::error('Error in create on StudentController :'. $err->getMessage());
            return back()->with('error', $err->getMessage());
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StudentAdmission $request)
    {
        try {
            if(!Helper::checkPermission('add-student')) {
                return back()->with('error', trans('error.unauthorized'));
            }
            $result = $this->student->store($request);
            if($result['status'] == true) {
                 return redirect()->route('edit.student.admission.address',['id' => $result['student_admission_id'],'map_id' => $result['student_session_detail_id']])->with('success', Lang::get('success.student_admitted_successfully')); 
            }
            return back()->with('error', Lang::get('error.student_not_admitted'));
        } catch(\Exception $err){
            Log::error('Error in store on StudentController :'. $err->getMessage());
            return back()->with('error', $err->getMessage());
        }
    }


    public function update(StudentAdmission $request)
    {
        try {
            if(!Helper::checkPermission('edit-student')) {
                return back()->with('error', trans('error.unauthorized'));
            }
            $result = $this->student->update($request);
            if($result['status'] == true) {
                 return redirect()->route('edit.student.admission.address',['id' => $result['student_admission_id'],'map_id' => $result['student_session_detail_id']])->with('success', Lang::get('success.student_admitted_successfully')); 
            }
            return back()->with('error', Lang::get('error.student_not_admitted'));
        } catch(\Exception $err){
            Log::error('Error in update on StudentController :'. $err->getMessage());
            return back()->with('error', $err->getMessage());
        }
    }



    public function edit_address($id,$map_id)
    {
       
        try {
            $data = $this->student->edit_address($id,$map_id); 
            return view('student.admission.student-details', $data);
        } catch(\Exception $err){
            Log::error('Error in edit_address on StudentController :'. $err->getMessage());
            return back()->with('error', $err->getMessage());
        }
    }


    public function update_address(StudentAddress $request)
    {
        try {
            $result = $this->student->update_address($request);
            if($result['status'] == true) {
                 return redirect()->route('edit.student.admission.parent',['id' => $result['student_admission_id'],'map_id' => $result['student_session_detail_id']])->with('success', Lang::get('success.student_address_updated_successfully')); 
            }
            return back()->with('error', Lang::get('error.student_not_admitted'));
        } catch(\Exception $err){
            Log::error('Error in update_address on StudentController :'. $err->getMessage());
            return back()->with('error', $err->getMessage());
        }
    }


    public function edit_parent($id,$map_id)
    {
        try {
            $data = $this->student->edit_parent($id,$map_id); 
            return view('student.admission.student-details', $data);
        } catch(\Exception $err){
            Log::error('Error in edit_parent on StudentController :'. $err->getMessage());
            return back()->with('error', $err->getMessage());
        }
    }


    public function update_parent(StudentParent $request)
    {
        try {
            $result = $this->student->update_parent($request);
            if($result['status'] == true) {
                 return redirect()->route('edit.student.admission.multiple_upload',['id' => $result['student_admission_id'],'map_id' => $result['student_session_detail_id']])->with('success', Lang::get('success.student_parent_updated_successfully')); 
            }
            return back()->with('error', Lang::get('error.student_not_admitted'));
        } catch(\Exception $err){
            Log::error('Error in update_parent on StudentController :'. $err->getMessage());
            return back()->with('error', $err->getMessage());
        }
    }


    public function edit_multiple_upload($id,$map_id)
    { 
        try {
            $data = $this->student->edit_multiple_upload($id,$map_id); 
            return view('student.admission.student-details', $data);
        } catch(\Exception $err){
            Log::error('Error in edit_multiple_upload on StudentController :'. $err->getMessage());
            return back()->with('error', $err->getMessage());
        }
    }


    public function update_multiple_upload(Request $request)  
    {
        //StudentMultipleUploadRequest
        try {
            $result = $this->student->update_multiple_upload($request);
            if($result['status'] == true) {
                 return redirect()->route('edit.student.admission.transport',['id' => $result['student_admission_id'],'map_id' => $result['student_session_detail_id']])->with('success', Lang::get('success.student_multiple_upload_updated_successfully')); 
            }
            return back()->with('error', Lang::get('error.student_multiple_upload_not_updated'));
        } catch(\Exception $err){
            Log::error('Error in update_multiple_upload on StudentController :'. $err->getMessage());
            return back()->with('error', $err->getMessage());
        }
    }


    public function edit_transport($id,$map_id)
    { 
        try {
            $data = $this->student->edit_transport($id,$map_id); 
            return view('student.admission.student-details', $data);
        } catch(\Exception $err){
            Log::error('Error in edit_transport on StudentController :'. $err->getMessage());
            return back()->with('error', $err->getMessage());
        }
    }


    public function update_transport(Request $request)  
    {
        try {
            $result = $this->student->update_transport($request);
            if($result['status'] == true) {
                 return redirect()->route('edit.student.admission.hostel',['id' => $result['student_admission_id'],'map_id' => $result['student_session_detail_id']])->with('success', Lang::get('success.student_transport_updated_successfully')); 
            }
            return back()->with('error', Lang::get('error.student_transport_not_updated'));
        } catch(\Exception $err){
            Log::error('Error in update_transport on StudentController :'. $err->getMessage());
            return back()->with('error', $err->getMessage());
        }
    }


    public function edit_hostel($id,$map_id)
    { 
        try {
            $data = $this->student->edit_hostel($id,$map_id); 
            return view('student.admission.student-details', $data);
        } catch(\Exception $err){
            Log::error('Error in edit_hostel on StudentController :'. $err->getMessage());
            return back()->with('error', $err->getMessage());
        }
    }


    public function update_hostel(Request $request)  
    {
        try {
            $result = $this->student->update_hostel($request);
            if($result['status'] == true) {
                 return redirect()->route('edit.student.admission.charge',['id' => $result['student_admission_id'],'map_id' => $result['student_session_detail_id']])->with('success', Lang::get('success.student_charge_updated_successfully')); 
            }
            return back()->with('error', Lang::get('error.student_hostel_not_updated'));
        } catch(\Exception $err){
            Log::error('Error in update_hostel on StudentController :'. $err->getMessage());
            return back()->with('error', $err->getMessage());
        }
    }


    public function edit_charge($id,$map_id)
    { 
        try {
            $data = $this->student->edit_charge($id,$map_id); 
            return view('student.admission.student-details', $data);
        } catch(\Exception $err){
            Log::error('Error in edit_charge on StudentController :'. $err->getMessage());
            return back()->with('error', $err->getMessage());
        }
    }



    public function delete($student_admission_id = 0)
    {
        try {
            if(!Helper::checkPermission('delete-student')) {
                return back()->with('error', trans('error.unauthorized'));
            }
            if($student_admission_id == 0){
                return back()->with('error', trans('error.student_admission_not_found'));
            }
            $result = $this->student->delete($student_admission_id);
            if($result == true) {
                return back()->with('success', trans('success.student_admission_deleted_successfully'));
            }
            return back()->with('error', trans('error.student_admission_not_deleted'));
        } catch(\Exception $err){
            Log::error('Error in delete on StudentController :'. $err->getMessage());
            return back()->with('error', $err->getMessage());
        }
    }

    /**
    * Method to restore resource
    * @param int $student_admission_id
    * @return Illuminate\Http\Response
    */
    public function restore($student_admission_id = 0)
    {
        try {
            if(!Helper::checkPermission('delete-student')) {
                return back()->with('error', trans('error.unauthorized'));
            }
            if($student_admission_id == 0){
                return back()->with('error', trans('error.student_admission_not_found'));
            }
            $result = $this->student->restore($student_admission_id);
            if($result == true) {
                return back()->with('success', trans('success.student_admission_restored_successfully'));
            }
            return back()->with('error', trans('error.student_admission_not_restored'));
        } catch(\Exception $err){
            Log::error('Error in restore on StudentController :'. $err->getMessage());
            return back()->with('error', $err->getMessage());
        }
    }

    
}
