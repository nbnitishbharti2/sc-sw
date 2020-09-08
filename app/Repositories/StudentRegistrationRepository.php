<?php 

namespace App\Repositories;

use App\Models\Category;
use App\Models\BloodGroup;
use App\Models\Gender;
use App\Models\Classes;
use App\Models\Education;
use App\Models\Occupation;
use App\Models\FeeSetting;
use App\Models\StudentRegistration;
use App\Models\StudentRegistrationMap;
use App\Models\FeeForClass;
use App\Models\StudentRegistrationPayment;
use App\Models\StudentRegistrationTransaction;
use App\Models\StudentDocument;
use App\Helpers\CommanHelper;
use Log;
use Lang;
use Session;
use Auth;
use File;


class StudentRegistrationRepository {

    /**
    * Method to fetch all resource data
    *
    * @return Collection $query
    */
    public function getAllStudentRegistrations($request)
    {
        try {
            $class=null;
            $session=null;
            $date1 = null;
            $date2 = null;

            $query = StudentRegistration::with(['student_registration_map','student_document','student_registration_map.student_registration'])->where('session_id',Session::get('session'))->withTrashed(); 

            if(isset($request->class)){
                $class=$request->class;
                $query = $query->whereHas('student_registration_map', function ($q) use($class){
                    $q->Where('class_id', '=', $class);
                });
            }
            if(isset($request->session)){
                $session=$request->session;
                $query = $query->whereHas('student_registration_map', function($q) use ($session){
                    $q->where('session_id', '=', $session);
                }); 
            }
            if(isset($request->date1) && isset($request->date2)){
                $date1=date('Y-m-d',strtotime($request->date1));
                $date2=date('Y-m-d',strtotime($request->date2));
                $query = $query->whereBetween('created_at', [$date1,$date2]); 
            }

            if($request->query('search')){
                $query = $query->where(function($q) use ($request) {
                    $q->Where('name', 'like', '%'.$request->query('search').'%');
                    $q->orwhere('email', 'like', '%'.$request->query('search').'%');
                    $q->orwhere('father_mobile_no', '=', $request->query('search'));
                    $q->orwhere('mother_mobile_no', '=', $request->query('search'));
                    $q->orwhere('primary_mobile_no', '=', $request->query('search'));
                    $q->orwhere('mobile_no', '=', $request->query('search'));
                });
            }

            $query = $query->get();

            return  $query; 
        } catch(\Exception $err){
          Log::error('message error in getAllStudentRegistrations on StudentRegistrationRepository :'. $err->getMessage());
          return back()->with('error', $err->getMessage());
        }
    }


    /**
    * Method to fetch create resource data
    *
    * @return array $data
    */
    public function create($id)
    {   
        try {
            $session_id=CommanHelper::getSessionId(CommanHelper::getCurrentSessionForAdmission());
            if($id!=0){
                $student=StudentRegistration::FindOrFail($id); 
                $student_session=StudentRegistrationMap::where('student_registration_id','=',$id)->orderBy('id','desc')->first();
                $registration_no=$this->getRegistrationNo($session_id);
                $data = [
                    'action'          => route('update.student.registration'),
                    'page_title'      => Lang::get('label.student_registration'),
                    'title'           => Lang::get('title.student_registration'),
                    'class_list'      => Classes::getAllClassForListing($session_id),
                    'class_id'        => (old('class')) ? old('class') : $student_session->class_id,
                    // 'section_id'      => (old('section')) ? old('section') :  $student_session->section_id,
                    'gender_list'      => Gender::getAllGenderListing(),
                    'gender_id'        => (old('gender')) ? old('gender') : $student->gender_id,
                    'category_list'    => Category::getAllCategoryListing(),
                    'category_id'      => (old('category')) ? old('category') : $student->category_id,
                    'blood_group_list'    => BloodGroup::getAllBloodGroupListing(),
                    'blood_group_id'      => (old('blood_group')) ? old('blood_group') : $student->blood_group_id,
                    'tab'         => 'student_details',  
                    'registration_no'  => (old('registration_no')) ? old('registration_no') : $student->registration_no,
                    'name'  => (old('name')) ? old('name') : $student->name,
                    'dob'  => (old('dob')) ? old('dob') : $student->dob,
                    'cast'  => (old('cast')) ? old('cast') : $student->cast,
                    'mobile_no'  => (old('mobile_no')) ? old('mobile_no') : $student->mobile_no,
                    'email'  => (old('email')) ? old('email') : $student->email,
                    'aadhar_no'  => (old('aadhar_no')) ? old('aadhar_no') : $student->aadhar_no,
                    'student_registration_id'    => $id,
                    'map_id'=>$student_session->id,
                ];
            }else{
                $registration_no=$this->getRegistrationNo($session_id);
                $data = [
                    'action'        => route('store.student.registration'),
                    'page_title'    => Lang::get('label.student_registration'),
                    'title'         => Lang::get('title.student_registration'),
                    'class_list'    => Classes::getAllClassForListing($session_id),
                    'class_id'      => (old('class')) ? old('class') : 0,
                    // 'section_id'    => (old('section')) ? old('section') : 0,
                    'gender_list'    => Gender::getAllGenderListing(),
                    'gender_id'      => (old('gender')) ? old('gender') : 0,
                    'category_list'    => Category::getAllCategoryListing(),
                    'category_id'      => (old('category')) ? old('category') : 0,
                    'blood_group_list'    => BloodGroup::getAllBloodGroupListing(),
                    'blood_group_id'      => (old('blood_group')) ? old('blood_group') : 0,
                    'tab'         => 'student_details',  
                    'registration_no'  => (old('registration_no')) ? old('registration_no') : $registration_no,
                    'name'  => (old('name')) ? old('name') : '',
                    'dob'  => (old('dob')) ? old('dob') : '',
                    'cast'  => (old('cast')) ? old('cast') : '',
                    'mobile_no'  => (old('mobile_no')) ? old('mobile_no') : '',
                    'email'  => (old('email')) ? old('email') : '',
                    'aadhar_no'  => (old('aadhar_no')) ? old('aadhar_no') : '',
                    'student_registration_id'    => $id,

                ];
            }
            return $data;
        } catch(\Exception $err){
            Log::error('message error in create on StudentRegistrationRepository :'. $err->getMessage());
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

        $responce['status']=false;
        $data = [
            'session_id'=>$request->session,
            // 'class_id'=>$request->class,
            // 'section_id'=>$request->section,
            'gender_id' =>$request->gender,
            'category_id'=>$request->category,
            'blood_group_id'=>$request->blood_group,
            'registration_no'=>$request->registration_no,
            'name'=>$request->name,
            'dob'=>$request->dob, 
            'mobile_no'=>$request->mobile_no,
            'email'=>$request->email,
            'aadhar_no'=>$request->aadhar_no,
            'primary_mobile_no'=>$request->mobile_no,
            'status'=>'Registerd'
        ];

        $student = StudentRegistration::create($data);

        if ($student->exists) { 
            $session_data=[
                'session_id'=>$request->session,
                'class_id'=>$request->class,
                // 'section_id'=>$request->section,
                'student_registration_id'=>$student->id,
                'register_by'=>Auth::user()->id
            ];
            $data=StudentRegistrationMap::create($session_data);
            if($student->exists) {
                $responce['status']=true;
                $responce['id']=$student->id;
                $responce['map_id']=$data->id;
                return $responce;
            }else{
                return $responce;
            }
        } else {
           return $responce;
       }
   } catch(\Exception $err){
    Log::error('message error in store on StudentRegistrationRepository :'. $err->getMessage());
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

    }

    /**
    * Method to update resource
    * @param Illuminate\Http\Request
    * @return boolean
    */
    public function update($request)
    {

    }

    
    public function getRegistrationNo($session_id)
    {

        $registration_no='';
        $feeDetails=FeeSetting::getFeeDetails($session_id);
        if($feeDetails->registration_no_auto=='Yes'){

            $last_registerd_student=StudentRegistration::getLastRegisterdStudent();
            if(isset($last_registerd_student->id)){
                $registration_no=$last_registerd_student->registration_no+1;
            }else{
               $registration_no=$feeDetails->registration_no_start;
           }
       }  
       return $registration_no; 
   }

   public function edit_address($id,$map_id)
   {
        try {
            $student=StudentRegistration::FindOrFail($id); 
            $data = [
                'action'            => route('update.student.registration.address'),
                'page_title'    => Lang::get('label.address'),
                'title'         => Lang::get('title.address'), 
                'address'      => (old('address')) ? old('address') : $student->address,
                'city'      => (old('city')) ? old('city') : $student->city,
                'district'      => (old('district')) ? old('district') : $student->district,
                'state'      => (old('state')) ? old('state') : $student->state,
                'country'      => (old('country')) ? old('country') : $student->country,
                'pin_code'      => (old('pin_code')) ? old('pin_code') : $student->zip_code,
                'tab'         => 'student_address',   
                'student_registration_id'    => $id, 
                'map_id'=>$map_id,
            ];
            return $data;
        } catch(\Exception $err){
            Log::error('message error in edit_address on StudentRegistrationRepository :'. $err->getMessage());
            return back()->with('error', $err->getMessage());
        }
    }


    public function update_address($request)
    { 
        try { 
            $responce['status']=false;
            $student  = StudentRegistration::findOrFail($request->student_registration_id);
            $student->country =$request->country; 
            $student->state =$request->state;
            $student->district =$request->district;
            $student->city =$request->city;
            $student->address =$request->address;
            $student->zip_code =$request->pin_code; 
            $student->save(); // Update data  
            if ($student->wasChanged()) {  
                $responce['status']=true;
                $responce['id']=$student->id;
                $responce['map_id']=$request->map_id;
                return $responce; 
            } else {
               return $responce;
           }
        } catch(\Exception $err){
            Log::error('message error in update_address on StudentRegistrationRepository :'. $err->getMessage());
            return back()->with('error', $err->getMessage());
        }
    }

   public function edit_parent($id,$map_id)
   {
        try {
            $student=StudentRegistration::FindOrFail($id); 
            $data = [
                'action'        => route('update.student.registration.parent'),
                'page_title'    => trans('label.guardians_details'),
                'title'         => Lang::get('title.guardians_details'), 
                'father_name'      => (old('father_name')) ? old('father_name') : $student->father_name,
                'father_mobile_no'      => (old('father_mobile_no')) ? old('father_mobile_no') : $student->father_mobile_no,
                'father_occupation'      => (old('father_occupation')) ? old('father_occupation') : $student->father_occupation_id,
                'father_education'      => (old('father_education')) ? old('father_education') : $student->father_education_id,
                'mother_name'      => (old('mother_name')) ? old('mother_name') : $student->mother_name,
                'mother_mobile_no'      => (old('mother_mobile_no')) ? old('mother_mobile_no') : $student->mother_mobile_no,
                'mother_occupation'      => (old('mother_occupation')) ? old('mother_occupation') : $student->mother_occupation_id,
                'mother_education'      => (old('mother_education')) ? old('mother_education') : $student->mother_education_id,
                'education_list'    => Education::getAllEducationForListing(),
                'occupation_list'    => Occupation::getAllOccupationForListing(),
                'tab'         => 'student_parent',   
                'student_registration_id'    => $id, 
                'map_id'=>$map_id,
            ];
            return $data;
        } catch(\Exception $err){
            Log::error('message error in edit_parent on StudentRegistrationRepository :'. $err->getMessage());
            return back()->with('error', $err->getMessage());
        }
    }


    public function update_parent($request)
    { 
        try { 
            $responce['status']=false;
            $student  = StudentRegistration::findOrFail($request->student_registration_id);
            $student->father_name =$request->father_name; 
            $student->father_mobile_no =$request->father_mobile_no;
            $student->father_occupation_id =$request->father_occupation;
            $student->father_education_id =$request->father_education;
            $student->mother_name =$request->mother_name;
            $student->mother_mobile_no =$request->mother_mobile_no; 
            $student->mother_occupation_id =$request->mother_occupation;
            $student->mother_education_id =$request->mother_education; 
            if($request->father_mobile_no!=null){
                 $student->primary_mobile_no=$request->father_mobile_no; 
            }else if($request->mother_mobile_no!=null){
                 $student->primary_mobile_no=$request->mother_mobile_no;
            }
            $student->save(); // Update data  
            if ($student->wasChanged()) {  
                $responce['status']=true;
                $responce['id']=$student->id;
                $responce['map_id']=$request->map_id;
                return $responce; 
            }else {
               return $responce;
            }
        } catch(\Exception $err){
            Log::error('message error in update_parent on StudentRegistrationRepository :'. $err->getMessage());
            return back()->with('error', $err->getMessage());
        }
    }

    public function edit_multiple_upload($id,$map_id)
    {
        try {
            $student=StudentRegistration::FindOrFail($id); 
            $data = [
                'action'                  => route('update.student.registration.multiple_upload'),
                'page_title'              => trans('label.multiple_document_upload'),
                'title'                   => Lang::get('title.multiple_document_upload'), 
                'file_name'               => '',
                'file'                    => '',
                'tab'                     => 'multiple_document_upload',   
                'student_registration_id' => $id, 
                'map_id'                  => $map_id,
            ];
            return $data;
        } catch(\Exception $err){
            Log::error('message error in edit_multiple_upload on StudentRegistrationRepository :'. $err->getMessage());
            return back()->with('error', $err->getMessage());
        }
    }
    public function update_multiple_upload($request)
    { 
        try { 
            $responce['status']=false;
            $student  = StudentRegistration::findOrFail($request->student_registration_id);
            
            $file_names = $request->file_name;
            $files = $request->file; // $request->file('file')  not worked.

            $student_documents=array();
            foreach($files as $key=>$file)  
            {
                $file_ext = $file->getClientOriginalExtension();
                
                $destinationImagePath = public_path().'/student_files'; // upload path

                if (!File::exists($destinationImagePath)){
                    File::makeDirectory($destinationImagePath);
                } 

                $file_nn = "Student".time().".".$file_ext;
                $file->move($destinationImagePath, $file_nn);

                // $student_document = new StudentDocument();
                // $student_document->student_reg_id = $request->student_registration_id;
                // $student_document->file_name = $file_names[$key];
                // $student_document->file = $file_nn;
                // $student_document->save();

                $student_documents[]=new StudentDocument(array('student_reg_id'=>$request->student_registration_id, 'file_name'=>$file_names[$key], 'file'=>$file_nn));
            }

            //student_document() is defined on student registration model
            //$student->student_document()->saveMany($student_documents);
            if ($student->student_document()->saveMany($student_documents)) {  
                $responce['status']=true;
                $responce['id']=$student->id;
                $responce['map_id']=$request->map_id;
                return $responce; 
            }else {
               return $responce;
            }
        } catch(\Exception $err){
            Log::error('message error in update_multiple_upload on StudentRegistrationRepository :'. $err->getMessage());
            return back()->with('error', $err->getMessage());
        }
    }


    public function edit_charge($id,$map_id)
    {
        try {
            $student=StudentRegistration::FindOrFail($id); 
            $student_session=StudentRegistrationMap::FindOrFail($map_id);

            $fee=$this->getRegistrationFee($student_session->session_id,$student_session->class_id,1,1);
            $student_registration_transaction=StudentRegistrationTransaction::where('session_id','=', $student_session->session_id)->where('st_regm_id','=',$map_id)->get();
            $student_registration_payment=StudentRegistrationPayment::where('session_id','=',$student_session->session_id)->where('st_regm_id','=',$map_id)->get();
            $data = [
                'action'        => route('update.student.registration.address'),
                'page_title'    => Lang::get('label.address'),
                'title'         => Lang::get('title.address'), 
                'fee'           => $fee,
                'student_registration_transaction'  => $student_registration_transaction,
                'student_registration_payment'      => $student_registration_payment,
                'tab'           => 'student_charge',   
                'student_registration_id'    => $id,
                'map_id'                     => $map_id, 
            ];
            return $data;
        } catch(\Exception $err){
            Log::error('message error in edit_charge on StudentRegistrationRepository :'. $err->getMessage());
            return back()->with('error', $err->getMessage());
        }
    }


    public function getRegistrationFee($session_id,$class,$fee_head,$fee_type)
    { 
        $data['fee']='No';
        try{
            $feeDetails=FeeSetting::getFeeDetails($session_id); 
            if($feeDetails->registration_fee=='Yes'){
                $data['fee']='Yes';
                $fee=FeeForClass::getFeeApplicable($session_id,$class,$fee_head,$fee_type);
                $data['fees']=$fee;
            }
        }catch(\Exception $err){
            Log::error('message error in getRegistrationFee on StudentRegistrationRepository :'. $err->getMessage());
        } 
        return $data;   
    }



    /**
    * Method to view resource
    * @param Illuminate\Http\Request
    * @return boolean
    */
    public function viewPersonalDetails($id)
    {
        try {
            $response['status'] = false;

            $student = StudentRegistration::with(['student_document','gender','blood_group','category'])->find($id);
            $student_reg_map = StudentRegistrationMap::with(['session','class','section'])->where('student_registration_id',$id)->first();

            $response['page_title']  = Lang::get('label.view_student_registration');
            $response['title']       = Lang::get('title.view_student_registration');

            $response['status'] = true;
            $response['student'] = $student;
            $response['student_reg_map'] = $student_reg_map;
            $response['id'] = $student->id;
            $response['map_id'] = $student_reg_map->id;
            $response['tab'] = 'student_details';

            return $response;
        } catch(\Exception $err){
            Log::error('message error in viewPersonalDetails on StudentRegistrationRepository :'. $err->getMessage());
            return back()->with('error', $err->getMessage());
        }
    }


    public function viewAddress($id,$map_id)
    {
        try {
            $response['status'] = false;

            $student = StudentRegistration::find($id);
            $student_reg_map = StudentRegistrationMap::find($map_id);

            $response['page_title']  = Lang::get('label.view_student_registration');
            $response['title']       = Lang::get('title.view_student_registration');
            
            $response['status'] = true;
            $response['student'] = $student;
            $response['student_reg_map'] = $student_reg_map;
            $response['id'] = $student->id;
            $response['map_id'] = $student_reg_map->id;
            $response['tab'] = 'student_address';

            return $response;
        } catch(\Exception $err){
            Log::error('message error in viewAddress on StudentRegistrationRepository :'. $err->getMessage());
            return back()->with('error', $err->getMessage());
        }
    }


    public function viewParent($id,$map_id)
    {
        try {
            $response['status'] = false;

            $student = StudentRegistration::with(['father_education','father_occupation','mother_education','mother_occupation'])->find($id);
            $student_reg_map = StudentRegistrationMap::find($map_id);

            $response['page_title']  = Lang::get('label.view_student_registration');
            $response['title']       = Lang::get('title.view_student_registration');
            
            $response['status'] = true;
            $response['student'] = $student;
            $response['student_reg_map'] = $student_reg_map;
            $response['id'] = $student->id;
            $response['map_id'] = $student_reg_map->id;
            $response['tab'] = 'student_parent';

            return $response;
        } catch(\Exception $err){
            Log::error('message error in viewParent on StudentRegistrationRepository :'. $err->getMessage());
            return back()->with('error', $err->getMessage());
        }
    }

    
    public function viewMultipleUpload($id,$map_id)
    {
        try {
            $response['status'] = false;

            $student = StudentRegistration::find($id);
            $student_reg_map = StudentRegistrationMap::find($map_id);

            $student_multiple_uploads = StudentDocument::with('student_registration')->where('student_reg_id',$id)->get();

            $response['page_title']  = Lang::get('label.view_student_registration');
            $response['title']       = Lang::get('title.view_student_registration');
            
            $response['status'] = true;
            $response['student'] = $student;
            $response['student_reg_map'] = $student_reg_map;
            $response['student_multiple_uploads'] = $student_multiple_uploads;
            $response['id'] = $student->id;
            $response['map_id'] = $student_reg_map->id;
            $response['tab'] = 'multiple_document_upload';

            return $response;
        } catch(\Exception $err){
            Log::error('message error in viewMultipleUpload on StudentRegistrationRepository :'. $err->getMessage());
            return back()->with('error', $err->getMessage());
        }
    }


    public function viewCharge($id,$map_id)
    {
        try {
            $response['status'] = false;

            $student = StudentRegistration::find($id);

            $student_reg_map = StudentRegistrationMap::find($map_id);

            $student_registration_transaction=StudentRegistrationTransaction::where('session_id','=', $student_reg_map->session_id)->where('st_regm_id','=',$map_id)->get();

            $student_registration_payment=StudentRegistrationPayment::where('session_id','=',$student_reg_map->session_id)->where('st_regm_id','=',$map_id)->get();

            $data['fee']='No';
            $feeDetails=FeeSetting::getFeeDetails($student_reg_map->session_id); 
            if($feeDetails->registration_fee=='Yes'){
                $data['fee']='Yes';
                
                $fee=FeeForClass::getFeeApplicable($student_reg_map->session_id,$student_reg_map->class_id,1,1);
                $data['fees']=$fee;
            }
            $fee = $data;

            $response['page_title']  = Lang::get('label.view_student_registration');
            $response['title']       = Lang::get('title.view_student_registration');
            
            $response['status'] = true;
            $response['student'] = $student;
            $response['student_reg_map'] = $student_reg_map;
            
            $response['fee'] = $fee;
            $response['student_registration_transaction']  = $student_registration_transaction;
            $response['student_registration_payment']      = $student_registration_payment;

            $response['id'] = $student->id;
            $response['map_id'] = $student_reg_map->id;
            $response['tab'] = 'student_charge';
            return $response;
        } catch(\Exception $err){
            Log::error('message error in viewCharge on StudentRegistrationRepository :'. $err->getMessage());
            return back()->with('error', $err->getMessage());
        }
    }


    public function delete($student_registration_id)
    {
        try {
            $student = StudentRegistration::destroy($student_registration_id);
            if ($student) { //Check if data was updated
                return true;
            } else {
                return false;
            }
        } catch(\Exception $err){
            Log::error('message error in delete on StudentRegistrationRepository :'. $err->getMessage());
            return back()->with('error', $err->getMessage());
        }
    }


    /**
    * Method to delete resource
    * @param Illuminate\Http\Request
    * @return boolean
    */
    public function restore($student_registration_id)
    {
        try {
            $student = StudentRegistration::withTrashed()->find($student_registration_id)->restore();
            if ($student) { //Check if data was updated
                return true;
            } else {
                return false;
            }
        } catch(\Exception $err){
            Log::error('message error in restore on StudentRegistrationRepository :'. $err->getMessage());
            return back()->with('error', $err->getMessage());
        }
    }

    

}