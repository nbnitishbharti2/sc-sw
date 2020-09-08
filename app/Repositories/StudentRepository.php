<?php 

namespace App\Repositories;

use App\Models\Category;
use App\Models\BloodGroup;
use App\Models\Gender;
use App\Models\Classes;
use App\Models\Section;
use App\Models\Education;
use App\Models\Occupation;
use App\Models\FeeSetting;
use App\Models\StudentDetail;
use App\Models\StudentSessionDetail;
use App\Models\StudentRegistration;
use App\Models\StudentRegistrationMap;
use App\Models\FeeForClass;
use App\Models\StudentTransportDetail;
use App\Models\StudentTransportChargeDetail;
use App\Models\Fee;
use App\Models\FeeHead;
use App\Models\FeeType;
use App\Models\Root;
use App\Models\VehicleType;
use App\Models\Vehicle;
use App\Models\VehicleRootMap;
use App\Models\Stopage;
use App\Models\StudentRegistrationPayment;
use App\Models\StudentRegistrationTransaction;
use App\Models\StudentDocumentDetail;
use App\Models\StudentHostelDetail;
use App\Models\StudentHostelChargeDetail;
use App\Models\Hostel;
use App\Models\HostelFee;
use App\Models\Room;
use App\Models\StudentAdmissionTransaction;
use App\Models\StudentAdmissionPayment;
use App\Helpers\CommanHelper;
use Log;
use Lang;
use Session;
use Auth;
use File;


class StudentRepository {

    
    public function getAllStudentAdmissions($request)
    {
        try {
            $class=null;
            $session=null;
            $date1 = null;
            $date2 = null;

            $query = StudentDetail::with(['student_session_detail'])->where('session_id',Session::get('session'))->withTrashed(); 

            if(isset($request->class)){
                $class=$request->class;
                $query = $query->whereHas('student_session_detail', function ($q) use($class){
                    $q->Where('class_id', '=', $class);
                });
            }
            if(isset($request->session)){
                $session=$request->session;
                $query = $query->whereHas('student_session_detail', function($q) use ($session){
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
          Log::error('message error in getAllStudentAdmissions on StudentRepository :'. $err->getMessage());
          return back()->with('error', $err->getMessage());
        }
    }


    /**
    * Method to fetch create resource data
    *
    * @return array $data
    */
    public function create($id, $session_map_id, $type)
    {   
        try {
            $session_id=CommanHelper::getSessionId(CommanHelper::getCurrentSessionForAdmission());

            if($type=='register' && $id!=0 && $session_map_id!=0)
            {
                //admissin with registerd student case : all 3 ids(i.e. type, admission id, session map id )

                //here $id = registration id and $session_map_id = registration sesion map id

                $admission_no=$this->getAdmissionNo($session_id);
    
                $roll_no=$this->getRollNo($session_id);
            
                $registration = StudentRegistration::with(['student_registration_map'])->find($id);

                $data = [
                    'action'             => route('store.student.admission'),
                    'page_title'         => Lang::get('label.student_admission'),
                    'title'              => Lang::get('title.student_admission'),
                    'class_list'         => Classes::getAllClassForListing($session_id),
                    'class_id'           => (old('class')) ? old('class') : $registration->student_registration_map->class_id,
                    'section_list'       => Section::getAllSectionForListing($session_id,$registration->student_registration_map->class_id),
                    'section_id'         => (old('section')) ? old('section') : $registration->student_registration_map->section_id,
                    'gender_list'        => Gender::getAllGenderListing(),
                    'gender_id'          => (old('gender')) ? old('gender') : $registration->gender_id,
                    'category_list'      => Category::getAllCategoryListing(),
                    'category_id'        => (old('category')) ? old('category') : $registration->category_id,
                    'blood_group_list'   => BloodGroup::getAllBloodGroupListing(),
                    'blood_group_id'     => (old('blood_group')) ? old('blood_group') : $registration->blood_group_id,
                    'admission_no'       => (old('admission_no')) ? old('admission_no') : $admission_no,
                    'roll_no'            => (old('roll_no')) ? old('roll_no') : $roll_no,
                    'name'               => (old('name')) ? old('name') : $registration->name,
                    'dob'                => (old('dob')) ? old('dob') : $registration->dob,
                    'cast'               => (old('cast')) ? old('cast') : $registration->cast,
                    'mobile_no'          => (old('mobile_no')) ? old('mobile_no') : $registration->mobile_no,
                    'email'              => (old('email')) ? old('email') : $registration->email,
                    'aadhar_no'          => (old('aadhar_no')) ? old('aadhar_no') : $registration->aadhar_no,
                    'siblings'           => (old('siblings')) ? old('siblings') : 0,
                    'image'              => '',
                    'student_id'         => $id,  // registration id 
                    'student_admission_id'     => 0,  //$id
                    'type'     => 'register',
                    'student_session_detail_id' => $session_map_id,
                    'tab'                      => 'student_details'
                ];
            }
            else if( $id!=0 )  // && $type==null && $session_map_id==0
            { 
                //edit case : only admission id
                //here $id = admission id
                $student=StudentDetail::FindOrFail($id); 

                $student_session=StudentSessionDetail::where('student_detail_id','=',$id)->orderBy('id','desc')->first();

                $admission_no=$this->getAdmissionNo($session_id);

                $roll_no=$this->getRollNo($session_id);

                $registration = StudentRegistration::with(['student_registration_map'])->find($student->student_registration_id);

                $data = [
                    'action'           => route('update.student.admission'),
                    'page_title'       => Lang::get('label.student_admission'),
                    'title'            => Lang::get('title.student_admission'),
                    'class_list'       => Classes::getAllClassForListing($session_id),
                    'class_id'         => (old('class')) ? old('class') : $student_session->class_id,
                    'section_list'     => Section::getAllSectionForListing($session_id,$registration->student_registration_map->class_id),
                    'section_id'       => (old('section')) ? old('section') :  $student_session->section_id,
                    'gender_list'      => Gender::getAllGenderListing(),
                    'gender_id'        => (old('gender')) ? old('gender') : $student->gender_id,
                    'category_list'    => Category::getAllCategoryListing(),
                    'category_id'      => (old('category')) ? old('category') : $student->category_id,
                    'blood_group_list' => BloodGroup::getAllBloodGroupListing(),
                    'blood_group_id'   => (old('blood_group')) ? old('blood_group') : $student->blood_group_id,
                    'admission_no'     => (old('admission_no')) ? old('admission_no') : $student->admission_no,
                    'roll_no'          => (old('roll_no')) ? old('roll_no') : $student->roll_no,
                    'name'             => (old('name')) ? old('name') : $student->name,
                    'dob'              => (old('dob')) ? old('dob') : $student->dob,
                    'cast'             => (old('cast')) ? old('cast') : $student->cast,
                    'mobile_no'        => (old('mobile_no')) ? old('mobile_no') : $student->mobile_no,
                    'email'            => (old('email')) ? old('email') : $student->email,
                    'aadhar_no'        => (old('aadhar_no')) ? old('aadhar_no') : $student->aadhar_no,
                    'siblings'         => (old('siblings')) ? old('siblings') : $student_session->siblings, 
                    'image'            =>  ($student->image) ? $student->image : '',
                    'student_id'       => $id,  // admission id 
                    'student_admission_id'      => $id,  //$id
                    'type'                      => '',
                    'student_session_detail_id' => $session_map_id,
                    'tab'                       => 'student_details',  
                ];      
            }
            else // if($id!=0 && $type=='register' && $session_map_id!=0)
            {
                //Add student case : no id
                //dd('3 ids');
                $admission_no=$this->getAdmissionNo($session_id);

                $roll_no=$this->getRollNo($session_id);

                $data = [
                    'action'                => route('store.student.admission'),
                    'page_title'            => Lang::get('label.student_admission'),
                    'title'                 => Lang::get('title.student_admission'),
                    'class_list'            => Classes::getAllClassForListing($session_id),
                    'class_id'              => (old('class')) ? old('class') : 0,
                    //'section_list'          => Section::getAllSectionForListing($session_id,$registration->student_registration_map->class_id),
                    'section_list'          => array(),
                    'section_id'            => (old('section')) ? old('section') :0,
                    'gender_list'           => Gender::getAllGenderListing(),
                    'gender_id'             => (old('gender')) ? old('gender') : 0,
                    'category_list'         => Category::getAllCategoryListing(),
                    'category_id'           => (old('category')) ? old('category') : 0,
                    'blood_group_list'      => BloodGroup::getAllBloodGroupListing(),
                    'blood_group_id'        => (old('blood_group')) ? old('blood_group') : 0,
                    'admission_no'          => (old('admission_no')) ? old('admission_no') : $admission_no,
                    'roll_no'               => (old('roll_no')) ? old('roll_no') : $roll_no,
                    'name'                  => (old('name')) ? old('name') : '',
                    'dob'                   => (old('dob')) ? old('dob') : '',
                    'cast'                  => (old('cast')) ? old('cast') : '',
                    'mobile_no'             => (old('mobile_no')) ? old('mobile_no') : '',
                    'email'                 => (old('email')) ? old('email') : '',
                    'aadhar_no'             => (old('aadhar_no')) ? old('aadhar_no') : '',
                    'siblings'              => (old('siblings')) ? old('siblings') : 0,
                    'image'                     => '',
                    'student_id'                => 0,  // registration id 
                    'student_admission_id'      => 0,  //$id
                    'type'     => '',
                    'student_session_detail_id' => 0,
                    'tab'                       => 'student_details',  
                ];
            }
            return $data;
        } catch(\Exception $err){
            Log::error('message error in create on StudentRepository :'. $err->getMessage());
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
            $cdate=date("Y-m-d");
            $response['status']=false;

            $image = $request['image'];
            $image_ext = $image->getClientOriginalExtension();
            $destinationImagePath = public_path().'/student_image'; // upload path

            if (!File::exists($destinationImagePath)){
                File::makeDirectory($destinationImagePath);
            } 

            $image_nn = "Student".time() . "." . $image_ext;

            $image->move($destinationImagePath, $image_nn);
            
            if($request->student_id!=0)
            {
                //create admissin with registerd student

                $registration = StudentRegistration::with(['student_registration_map'])->find($request->student_id);
                
                $register_session_map=StudentRegistrationMap::FindOrFail($request->student_session_map_id);
    
                $data = [
                    'session_id'=>$request->session,
                    // 'class_id'=>$request->class,
                    // 'section_id'=>$request->section,
                    'student_registration_id' =>$request->student_id,
                    'gender_id' =>$request->gender,
                    'category_id'=>$request->category,
                    'blood_group_id'=>$request->blood_group,
                    'admission_no'=>$request->admission_no,
                    'roll_no'=>$request->roll_no,
                    'name'=>$request->name,
                    'dob'=>$request->dob, 
                    'mobile_no'=>$request->mobile_no,
                    'email'=>$request->email,
                    'aadhar_no'=>$request->aadhar_no,
                    'primary_mobile_no'=>$registration->primary_mobile_no,  
                    'cast'=>$request->cast,
                    'date_of_admission'=>$cdate,
                    'image'=>$image_nn,

                    'date_of_registration' => date('Y-m-d', strtotime($registration->created_at)),
                    'country' =>$registration->country, 
                    'state' =>$registration->state,
                    'district' =>$registration->district,
                    'city' =>$registration->city,
                    'address' =>$registration->address,
                    'zip_code' =>$registration->zip_code,

                    'father_name' =>$registration->father_name, 
                    'father_mobile_no' =>$registration->father_mobile_no,
                    'father_occupation_id' =>$registration->father_occupation_id,
                    'father_education_id' =>$registration->father_education_id,
                    'mother_name' =>$registration->mother_name,
                    'mother_mobile_no' =>$registration->mother_mobile_no, 
                    'mother_occupation_id' =>$registration->mother_occupation_id,
                    'mother_education_id' =>$registration->mother_education_id,  

                    //'status'=>'Admissioned'
                ];

                $student = StudentDetail::create($data);

                if ($student->exists) { 
                    $session_data=[
                        'session_id'=>$request->session,
                        'class_id'=>$request->class,
                        'section_id'=>$request->section,
                        'student_detail_id'=>$student->id,
                        'admission_by'=>Auth::user()->id,
                        'register_by'=>$registration->student_registration_map->register_by,
                        'admission_no'=>$request->admission_no,
                        'roll_no'=>$request->roll_no,  
                        'date_of_admission'=>$cdate,
                        'siblings'=>$request->siblings, 
                        'type'=>'Admission',
                        'transport'=>'No',
                        'hostel'=>'No'
                    ];
                    
                    $registration->status='Admited';
                    $registration->admission_date=$cdate;
                    $registration->save();

                    $register_session_map->admission_by = Auth::user()->id;
                    $register_session_map->save();

                    $data=StudentSessionDetail::create($session_data);
                    if($data->exists) {
                        $response['status']=true;
                        $response['student_admission_id']=$student->id;
                        $response['student_session_detail_id']=$data->id;
                        return $response;
                    }else{
                        return $response;
                    }
                } else {
                   return $response;
                }

            }else{
                //create admission

                $data = [
                    'session_id'=>$request->session,
                    // 'class_id'=>$request->class,
                    // 'section_id'=>$request->section,
                    // 'student_registration_id' =>$request->student_registration_id,
                    'gender_id' =>$request->gender,
                    'category_id'=>$request->category,
                    'blood_group_id'=>$request->blood_group,
                    'admission_no'=>$request->admission_no,
                    'roll_no'=>$request->roll_no,
                    'name'=>$request->name,
                    'dob'=>$request->dob, 
                    'mobile_no'=>$request->mobile_no,
                    'email'=>$request->email,
                    'aadhar_no'=>$request->aadhar_no,
                    'primary_mobile_no'=>$request->mobile_no,  //changed
                    'cast'=>$request->cast,
                    'date_of_admission'=>$cdate,
                    'image'=>$image_nn,

                ];

                $student = StudentDetail::create($data);

                if ($student->exists) { 
                    $session_data=[
                        'session_id'=>$request->session,
                        'class_id'=>$request->class,
                        'section_id'=>$request->section,
                        'student_detail_id'=>$student->id,
                        'admission_by'=>Auth::user()->id,
                        //'register_by'=>$registration->student_registration_map->register_by,
                        'admission_no'=>$request->admission_no,
                        'roll_no'=>$request->roll_no,  
                        'date_of_admission'=>$cdate,
                        'siblings'=>$request->siblings, 
                        'type'=>'Admission',
                        'transport'=>'No',
                        'hostel'=>'No'
                    ];

                    $data=StudentSessionDetail::create($session_data);
                    if($data->exists) {
                        $response['status']=true;
                        $response['student_admission_id']=$student->id;
                        $response['student_session_detail_id']=$data->id;
                        return $response;
                    }else{
                        return $response;
                    }
                } else {
                   return $response;
                }

            }
            
        } catch(\Exception $err){
            Log::error('message error in store on StudentRepository :'. $err->getMessage());
            return back()->with('error', $err->getMessage());
        }
    }


    public function update($request)
    {

        try {
            $student = StudentDetail::find($request->student_id);

            $cdate=date("Y-m-d");
            $response['status']=false;

            $oldimage=$student->image;

            if(isset($request['image']))
            {
                $image = $request['image'];
                $image_ext = $image->getClientOriginalExtension();
                $destinationImagePath = public_path() . '/student_image'; // upload path

                if (!File::exists($destinationImagePath)){
                    File::makeDirectory($destinationImagePath);
                } 

                $image_nn = "Student".time() . "." . $image_ext;
                $image->move($destinationImagePath, $image_nn);
                $student->image = $image_nn;

                $old_image_path = public_path() . '/student_image/'.$oldimage;

                if (File::exists($old_image_path)) {
                    File::delete($old_image_path); 
                }
            }


            $student->session_id = $request->session;
            //$student->student_registration_id = $request->student__id;
            $student->gender_id = $request->gender;
            $student->category_id = $request->category;
            $student->blood_group_id = $request->blood_group;
            $student->admission_no = $request->admission_no;
            $student->roll_no = $request->roll_no;
            $student->name = $request->name;
            $student->dob = $request->dob; 
            $student->mobile_no = $request->mobile_no;
            $student->email = $request->email;
            $student->aadhar_no = $request->aadhar_no;
            $student->primary_mobile_no =($student->father_mobile_no=="" && $student->mother_mobile_no=="")?$request->mobile_no: $student->primary_mobile_no;  
            $student->cast = $request->cast;
            $student->save();

            if ($student->exists) { 
                //session work is remaining to change

                $data=StudentSessionDetail::find($student->student_session_detail->id);

                $data->session_id = $request->session;  // for future update 
                $data->class_id = $request->class;
                $data->section_id = $request->section;
                $data->siblings = $request->siblings; 
                
                if($data->save()) {
                    $response['status']=true;
                    $response['student_admission_id']=$student->id;
                    $response['student_session_detail_id']=$data->id;
                    return $response;
                }else{
                    return $response;
                }
            } else {
               return $response;
            } 
        } catch(\Exception $err){
            Log::error('message error in update on StudentRepository :'. $err->getMessage());
            return back()->with('error', $err->getMessage());
        }
    }


    public function getAdmissionNo($session_id)
    {
        $admission_no='';
        $feeDetails=FeeSetting::getFeeDetails($session_id);
        if($feeDetails->admission_no_auto=='Yes'){

            $last_admissioned_student=StudentDetail::getLastAdmissionedStudent($session_id);
            if(isset($last_admissioned_student->id)){
                $admission_no=$last_admissioned_student->admission_no+1;
            }else{
               $admission_no=$feeDetails->admission_no_start;
            }
        }  
        return $admission_no; 
    }


    public function getRollNo($session_id)
    {
        $roll_no='';
        $feeDetails=FeeSetting::getFeeDetails($session_id);
        if($feeDetails->roll_no_auto=='Yes'){

            $last_admissioned_student=StudentDetail::getLastAdmissionedStudent($session_id);
            if(isset($last_admissioned_student->id)){
                $roll_no=$last_admissioned_student->roll_no+1;
            }else{
               $roll_no=$feeDetails->roll_no_start;
           }
       }  
       return $roll_no; 
    }


    public function edit_address($id,$map_id)
    {
        try {
            $student=StudentDetail::FindOrFail($id); 
            $data = [
                'action'        => route('update.student.admission.address'),
                'page_title'    => Lang::get('label.address'),
                'title'         => Lang::get('title.address'), 
                'address'       => (old('address')) ? old('address') : $student->address,
                'city'          => (old('city')) ? old('city') : $student->city,
                'district'      => (old('district')) ? old('district') : $student->district,
                'state'         => (old('state')) ? old('state') : $student->state,
                'country'       => (old('country')) ? old('country') : $student->country,
                'pin_code'      => (old('pin_code')) ? old('pin_code') : $student->zip_code,
                'tab'           => 'student_address',   
                'student_admission_id'      => $id, 
                'student_session_detail_id'  => $map_id,
            ];
            return $data;
        } catch(\Exception $err){
            Log::error('message error in edit_address on StudentRepository :'. $err->getMessage());
            return back()->with('error', $err->getMessage());
        }
    }


    public function update_address($request)
    {

        try {
            $student = StudentDetail::find($request->id);

            $response['status']=false;

            $student->country = $request->country;
            $student->state = $request->state;
            $student->district = $request->district;
            $student->city = $request->city;
            $student->address = $request->address;
            $student->zip_code = $request->pin_code;
            $student->save();

            if ($student->exists) { 
                $response['status']=true;
                $response['student_admission_id']=$student->id;
                $response['student_session_detail_id']=$request['map_id'];
                return $response;
            }else {
               return $response;
            }  
        } catch(\Exception $err){
            Log::error('message error in update_address on StudentRepository :'. $err->getMessage());
            return back()->with('error', $err->getMessage());
        }
    }


    public function edit_parent($id,$map_id)
    {
        try {
            $student=StudentDetail::FindOrFail($id); 
            $data = [
                'action'                    => route('update.student.admission.parent'),
                'page_title'                => Lang::get('label.guardians_details'),
                'title'                     => Lang::get('title.guardians_details'), 
                'father_name'               => (old('father_name')) ? old('father_name') : $student->father_name,
                'father_mobile_no'          => (old('father_mobile_no')) ? old('father_mobile_no') : $student->father_mobile_no,
                'father_occupation'         => (old('father_occupation')) ? old('father_occupation') : $student->father_occupation_id,
                'father_education'          => (old('father_education')) ? old('father_education') : $student->father_education_id,
                'mother_name'               => (old('mother_name')) ? old('mother_name') : $student->mother_name,
                'mother_mobile_no'          => (old('mother_mobile_no')) ? old('mother_mobile_no') : $student->mother_mobile_no,
                'mother_occupation'         => (old('mother_occupation')) ? old('mother_occupation') : $student->mother_occupation_id,
                'mother_education'          => (old('mother_education')) ? old('mother_education') : $student->mother_education_id,
                'education_list'            => Education::getAllEducationForListing(),
                'occupation_list'           => Occupation::getAllOccupationForListing(),
                'tab'                       => 'student_parent',   
                'student_admission_id'      => $id, 
                'student_session_detail_id' => $map_id,
            ];
            return $data;
        } catch(\Exception $err){
            Log::error('message error in edit_parent on StudentRepository :'. $err->getMessage());
            return back()->with('error', $err->getMessage());
        }
    }


    public function update_parent($request)
    {

        try {
            $student = StudentDetail::find($request->id);

            $response['status']=false;

            $student->father_name = $request->father_name;
            $student->father_mobile_no = $request->father_mobile_no;
            $student->father_education_id = $request->father_education_id;
            $student->father_occupation_id = $request->father_occupation_id;
            $student->mother_name = $request->mother_name;
            $student->mother_mobile_no = $request->mother_mobile_no;
            $student->mother_education_id = $request->mother_education_id;
            $student->mother_occupation_id = $request->mother_occupation_id;
            $student->save();

            if ($student->exists) { 
                $response['status']=true;
                $response['student_admission_id']=$student->id;
                $response['student_session_detail_id']=$request['map_id'];
                return $response;
            }else {
               return $response;
            } 
        } catch(\Exception $err){
            Log::error('message error in update_address on StudentRepository :'. $err->getMessage());
            return back()->with('error', $err->getMessage());
        }
    }


    public function edit_multiple_upload($id,$map_id)
    {
        try {
            $student=StudentDetail::FindOrFail($id); 
            $data = [
                'action'                    => route('update.student.admission.multiple_upload'),
                'page_title'                => trans('label.multiple_document_upload'),
                'title'                     => Lang::get('title.multiple_document_upload'), 
                'file_name'                 => '',
                'file'                      => '',
                'tab'                       => 'multiple_document_upload',   
                'student_admission_id'      => $id, 
                'student_session_detail_id' => $map_id,
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
            $response['status']=false;
            $student  = StudentDetail::findOrFail($request->id);
            
            $file_names = $request->file_name;
            $files = $request->file; // $request->file('file')  not worked.

            $student_documents=array();
            foreach($files as $key=>$file)  
            {
                $file_ext = $file->getClientOriginalExtension();
                
                $destinationImagePath = public_path().'/student_file_details'; // upload path

                if (!File::exists($destinationImagePath)){
                    File::makeDirectory($destinationImagePath);
                } 

                $file_nn = "Student".time().".".$file_ext;
                $file->move($destinationImagePath, $file_nn);

                $student_documents[]=new StudentDocumentDetail(array('student_detail_id'=>$request->id, 'file_name'=>$file_names[$key], 'file'=>$file_nn));
            }

            //student_document_detail() is defined on student detail model
            if ($student->student_document_detail()->saveMany($student_documents)) {  
                $response['status']=true;
                $response['student_admission_id']=$request->id;
                $response['student_session_detail_id']=$request->map_id;
                return $response; 
            }else {
               return $response;
            }
        } catch(\Exception $err){
            Log::error('message error in update_multiple_upload on StudentRepository :'. $err->getMessage());
            return back()->with('error', $err->getMessage());
        }
    }


    public function edit_transport($id,$map_id)
    {
        try {
            $student=StudentDetail::FindOrFail($id); 
            $student_transport= StudentTransportDetail::where('student_session_detail_id',$map_id)->first();
            $student_transport_charge = StudentTransportChargeDetail::where('st_session_detail_id',$map_id)->first();
            
            if($student_transport == null){
                $data = [
                    'action'                    => route('update.student.admission.transport'),
                    'page_title'                => trans('label.transport'),
                    'title'                     => Lang::get('title.transport'), 
                    'root_list'                 => Root::getAllRootForListing(),
                    'root_id'                   => 0,
                    'vehicle_type_list'         => VehicleRootMap::getVehicleTypeForListing((old('root_id')) ? old('root_id') : 0),
                    'vehicle_type_id'           => 0,
                    'vehicle_list'              => VehicleRootMap::getVehicleForListing((old('root_id')) ? old('root_id') : 0, (old('vehicle_type_id')) ? old('vehicle_type_id') : 0),
                    'vehicle_id'                => 0,
                    'stopage_list'              => Stopage::getStopageForListing((old('root_id')) ? old('root_id') : 0, (old('vehicle_type_id')) ? old('vehicle_type_id') : 0, (old('vehicle_id')) ? old('vehicle_id') : 0),
                    'stopage_id'                => 0,
                    'amount'                    => 0,
                    'tab'                       => 'transport',   
                    'student_admission_id'      => $id, 
                    'student_session_detail_id' => $map_id,
                ];
            }else{
                $data = [
                    'action'                    => route('update.student.admission.transport'),
                    'page_title'                => trans('label.transport'),
                    'title'                     => Lang::get('title.transport'), 
                    'root_list'                 => Root::getAllRootForListing(),
                    'root_id'                   => (old('root_id')) ? old('root_id') : $student_transport->root_id,
                    'vehicle_type_list'         => VehicleRootMap::getVehicleTypeForListing((old('root_id')) ? old('root_id') : $student_transport->root_id),
                    'vehicle_type_id'           => (old('vehicle_type_id')) ? old('vehicle_type_id') : $student_transport->vehicle_type_id,
                    'vehicle_list'              => VehicleRootMap::getVehicleForListing((old('root_id')) ? old('root_id') : $student_transport->root_id, (old('vehicle_type_id')) ? old('vehicle_type_id') : $student_transport->vehicle_type_id),
                    'vehicle_id'                => (old('vehicle_id')) ? old('vehicle_id') : $student_transport->vehicle_id,
                    'stopage_list'              => Stopage::getStopageForListing((old('root_id')) ? old('root_id') : $student_transport->root_id, (old('vehicle_type_id')) ? old('vehicle_type_id') : $student_transport->vehicle_type_id, (old('vehicle_id')) ? old('vehicle_id') : $student_transport->vehicle_id),
                    'stopage_id'                => (old('stopage_id')) ? old('stopage_id') : $student_transport->stopage_id,
                    'amount'                    => (old('amount')) ? old('amount') : $student_transport->amount,
                    'tab'                       => 'transport',   
                    'student_admission_id'      => $id, 
                    'student_session_detail_id' => $map_id,
                ];
            }
            return $data;
        } catch(\Exception $err){
            Log::error('message error in edit_transport on StudentRepository :'. $err->getMessage());
            return back()->with('error', $err->getMessage());
        }
    }


    public function update_transport($request)
    {

        try {
            $student = StudentDetail::find($request->id);

            $student_transport= StudentTransportDetail::where('student_session_detail_id',$request->map_id)->first();
            $student_transport_charge = StudentTransportChargeDetail::where('st_session_detail_id',$request->map_id)->first();

            $response['status']=false;

            if($student_transport == null){
                $data = [
                    'session_id'                => $student->session_id,
                    'student_session_detail_id' => $request->map_id,
                    'root_id'                   => $request->root_id,
                    'vehicle_type_id'           => $request->vehicle_type_id,
                    'vehicle_id'                => $request->vehicle_id,
                    'stopage_id'                => $request->stopage_id,
                    'fee_head_id'               => $request->fee_head_id,
                    'fee_type_id'               => $request->fee_type_id,
                    'amount'                    => $request->amount,
                ];
                
                $transport = StudentTransportDetail::create($data);

                if($transport->exists)
                {
                    $response['status']=true;
                    $response['student_admission_id']=$student->id;
                    $response['student_session_detail_id']=$request['map_id'];
                    return $response;
                }else {
                   return $response;
                } 
                
            }else{

                $student_transport->session_id                 = $student->session_id;
                $student_transport->student_session_detail_id  = $request->map_id;
                $student_transport->root_id                    = $request->root_id;
                $student_transport->vehicle_type_id            = $request->vehicle_type_id;
                $student_transport->vehicle_id                 = $request->vehicle_id;
                $student_transport->stopage_id                 = $request->stopage_id;
                $student_transport->fee_head_id                = $request->fee_head_id;
                $student_transport->fee_type_id                = $request->fee_type_id;
                $student_transport->amount                     = $request->amount;
                $student_transport->save();

                if($student_transport->exists)
                {
                    $response['status']=true;
                    $response['student_admission_id']=$student->id;
                    $response['student_session_detail_id']=$request['map_id'];
                    return $response;
                }else {
                   return $response;
                } 
                
            }
        } catch(\Exception $err){
            Log::error('message error in update_transport on StudentRepository :'. $err->getMessage());
            return back()->with('error', $err->getMessage());
        }
    }


    public function edit_hostel($id,$map_id)
    {
        try {
            $student=StudentDetail::FindOrFail($id); 
           
            $student_hostel= StudentHostelDetail::where('st_session_detail_id',$map_id)->first();
            $student_hostel_charge = StudentHostelChargeDetail::where('student_session_detail_id',$map_id)->first();
 
            if($student_hostel == null){
                $hostel_fee_ids = array();
                $data = [
                    'action'                    => route('update.student.admission.hostel'),
                    'page_title'                => trans('label.hostel'),
                    'title'                     => Lang::get('title.transport'),
                    'session_id'                => $student->session_id,
                    'hostel_list'               => Hostel::getAllHostelForListing(),
                    'hostel_id'                 => 0,
                    'room_list'                 => Room::get_room_list((old('hostel_id')) ? old('hostel_id') : 0, $student->session_id),
                    'room_id'                   => 0,
                    'bed_no_list'               => array(),
                    'bed_no'                    => 0,
                    'amount'                    => 0,
                    'hostel_fee_list'           => HostelFee::getAllHostelFeeForListing(),
                    'hostel_fee_ids'            => $hostel_fee_ids,
                    'tab'                       => 'hostel',   
                    'student_admission_id'      => $id, 
                    'student_session_detail_id' => $map_id,
                ];
            }else{
                $hostel_fee_ids = StudentHostelChargeDetail::where('student_session_detail_id',$map_id)->pluck('hostel_fee_id','hostel_fee_id')->toArray();
                
                $data = [
                    'action'                    => route('update.student.admission.hostel'),
                    'page_title'                => trans('label.hostel'),
                    'title'                     => Lang::get('title.hostel'),
                    'session_id'                => $student->session_id, 
                    'hostel_list'               => Hostel::getAllHostelForListing(),
                    'hostel_id'                 => (old('hostel_id')) ? old('hostel_id') : $student_hostel->hostel_id,
                    'room_list'                 => Room::get_room_list((old('hostel_id')) ? old('hostel_id') : $student_hostel->hostel_id, $student->session_id),
                    'room_id'                   => (old('room_id')) ? old('room_id') : $student_hostel->room_id,
                    'bed_no_list'               => Room::getCharge((old('room_id')) ? old('room_id') : $student_hostel->room_id, $student->session_id, (old('bed_no')) ? old('bed_no') : $student_hostel->bed_no),
                    'bed_no'                    => (old('bed_no')) ? old('bed_no') : $student_hostel->bed_no,
                    'amount'                    => (old('amount')) ? old('amount') : $student_hostel->amount,
                    'fee_head_id'               => (old('fee_head_id')) ? old('fee_head_id') : $student_hostel_charge->fee_head_id,
                    'fee_type_list'             => FeeType::getAllFeeTypeForListing(),
                    'fee_type_id'               => (old('fee_type_id')) ? old('fee_type_id') : $student_hostel_charge->fee_type_id,
                    'hostel_fee_list'           => HostelFee::getAllHostelFeeForListing(),
                    'hostel_fee_ids'            => $hostel_fee_ids,
                    'tab'                       => 'hostel',    
                    'student_admission_id'      => $id, 
                    'student_session_detail_id' => $map_id,
                ];
            }
            return $data;
        } catch(\Exception $err){
            Log::error('message error in edit_hostel on StudentRepository :'. $err->getMessage());
            return back()->with('error', $err->getMessage());
        }
    }


    public function update_hostel($request)
    {
        try {
            $student = StudentDetail::find($request->id);

            $student_hostel= StudentHostelDetail::where('st_session_detail_id',$request->map_id)->first();

            $student_hostel_charge = StudentHostelChargeDetail::where('student_session_detail_id',$request->map_id)->first();

            $response['status']=false;

            if($student_hostel == null){
                $data = [
                    'session_id'                => $student->session_id,
                    'st_session_detail_id'      => $request->map_id,
                    'hostel_id'                 => $request->hostel_id,
                    'room_id'                   => $request->room_id,
                    'bed_no'                    => $request->bed_no,
                    'amount'                    => $request->amount,
                ];
    
                $hostel_detail = StudentHostelDetail::create($data);

                if($hostel_detail->exists)
                {
                    $new_data=array(); 
                    foreach ($request->hostel_fee_ids as $key => $hostel_fee_id) {
                        $new_record=array();
                        $new_record['session_id']=$student->session_id;
                        $new_record['student_session_detail_id']=$request->map_id;
                        $new_record['student_hostel_detail_id']=$hostel_detail->id;
                        $new_record['hostel_fee_id']=$hostel_fee_id;
                        $new_record['fee_head_id']=$hostel_fee->fee_head_id;
                        $new_record['fee_type_id']=$hostel_fee->fee_type_id;
                        $new_record['amount']=$hostel_fee->amount;
                        array_push($new_data,$new_record);
                    }
                    $hostel_fee_charge = StudentHostelChargeDetail::insert($new_data); 

                    // foreach($request->hostel_fee_ids as $key=>$hostel_fee_id)
                    // {
                    //     $hostel_fee = HostelFee::find($hostel_fee_id);
                    //     $hostel_charge_data = [
                    //         'session_id'                 => $student->session_id,
                    //         'student_session_detail_id'  => $request->map_id,
                    //         'student_hostel_detail_id'   => $hostel_detail->id,
                    //         // 'fee_head_id'             =>  3,
                    //         // 'fee_type_id'             =>  $request->fee_type_id,
                    //         'hostel_fee_id'              =>  $hostel_fee_id,
                    //         'fee_head_id'                =>  $hostel_fee->fee_head_id,
                    //         'fee_type_id'                =>  $hostel_fee->fee_type_id,
                    //         'amount'                     =>  $hostel_fee->amount,
                    //     ];
                    //     //dd($hostel_charge_data);

                    //     $hostel_fee_charge = StudentHostelChargeDetail::create($hostel_charge_data);
                    // }

                    if($hostel_fee_charge){
                        $response['status']=true;
                        $response['student_admission_id']=$student->id;
                        $response['student_session_detail_id']=$request['map_id'];
                        return $response;
                    }else{
                        return $response;
                    }  
                }else {
                   return $response;
                }  
            }else{
                
                $student_hostel->session_id             = $request->session_id;
                $student_hostel->st_session_detail_id   = $request->map_id;
                $student_hostel->hostel_id              = $request->hostel_id;
                $student_hostel->room_id                = $request->room_id;
                $student_hostel->bed_no                 = $request->bed_no;
                $student_hostel->amount                 = $request->amount;
                $student_hostel->save();

                if($student_hostel->exists)
                {
                    
                    $old_hostel_fee_ids=StudentHostelChargeDetail::where('student_session_detail_id',$request->map_id)->pluck('hostel_fee_id')->toArray(); 

                    $new_hostel_fee_ids=array_diff($request->hostel_fee_ids, $old_hostel_fee_ids); 
                
                    $remove_hostel_fee_ids=array_diff($old_hostel_fee_ids,$request->hostel_fee_ids);
                    
                    $removed_hostel_fee_ids = StudentHostelChargeDetail::where('student_session_detail_id',$request->map_id)->whereIn('hostel_fee_id',$remove_hostel_fee_ids)->delete(); 

                    $new_data=array(); 
                    foreach ($new_hostel_fee_ids as $key => $hostel_fee_id) {
                        $new_record=array();
                        $hostel_fee = HostelFee::find($hostel_fee_id);

                        $new_record['session_id']=$student->session_id;
                        $new_record['student_session_detail_id']=$request->map_id;
                        $new_record['student_hostel_detail_id']=$student_hostel->id;
                        $new_record['hostel_fee_id']=$hostel_fee_id;
                        $new_record['fee_head_id']=$hostel_fee->fee_head_id;
                        $new_record['fee_type_id']=$hostel_fee->fee_type_id;
                        $new_record['amount']=$hostel_fee->amount;
                        array_push($new_data,$new_record);
                    }
        
                    $inserted_hostel_fee_ids = StudentHostelChargeDetail::insert($new_data);
            
                    if($removed_hostel_fee_ids || $inserted_hostel_fee_ids){ 
                        //Check if data was updated
                        $response['status']=true;
                        $response['student_admission_id']=$student->id;
                        $response['student_session_detail_id']=$request['map_id'];
                        return $response;
                     }else{
                        return $response;
                     }

                    // foreach($request->hostel_fee_ids as $key=>$hostel_fee_id)
                    // {
                    //     $hostel_fee = HostelFee::find($hostel_fee_id);

                    //     $student_hostel_charge->session_id  = $student->session_id;
                    //     $student_hostel_charge->student_session_detail_id = $request->map_id;
                    //     $student_hostel_charge->student_hostel_detail_id = $student_hostel->id;
                    //     $student_hostel_charge->hostel_fee_id =  $hostel_fee_id;
                    //     $student_hostel_charge->fee_head_id =  $hostel_fee->fee_head_id;
                    //     $student_hostel_charge->fee_type_id =  $hostel_fee->fee_type_id;
                    //     $student_hostel_charge->amount =  $hostel_fee->amount;
                    //     $student_hostel_charge->save();
                    // }
                    
                    // $response['status']=true;
                    // $response['student_admission_id']=$student->id;
                    // $response['student_session_detail_id']=$request['map_id'];
                    // return $response;
                }else {
                   return $response;
                } 
                
            }
        } catch(\Exception $err){
            Log::error('message error in update_hostel on StudentRepository :'. $err->getMessage());
            return back()->with('error', $err->getMessage());
        }
    }


    public function edit_charge($id,$map_id)
    {
        try {
            $student=StudentDetail::FindOrFail($id); 
            $student_session=StudentSessionDetail::FindOrFail($map_id);

            $fee=$this->getAdmissionFee($student_session->session_id,$student_session->class_id,1,2);
            $student_admission_transaction=StudentAdmissionTransaction::where('session_id','=', $student_session->session_id)->where('student_detail_id','=',$id)->get();
            $student_admission_payment=StudentAdmissionPayment::where('session_id','=',$student_session->session_id)->where('session_id','=', $student_session->session_id)->get();
            $data = [
                'action'        => route('update.student.admission.charge'),
                'page_title'    => Lang::get('label.charge'),
                'title'         => Lang::get('title.charge'), 
                'session_id'    => $student->session_id,
                'hostel_fee_list'   => HostelFee::getAllHostelFeeForListing(),
                'hostel_fee_ids'    => $hostel_fee_ids,
                'fee'               => $fee,
                'student_admission_transaction'  => $student_admission_transaction,
                'student_admission_payment'      => $student_admission_payment,
                'tab'                            => 'student_charge',   
                'student_admission_id'           => $id, 
                'student_session_detail_id'      => $map_id,
            ];
            //dd($data);
            return $data;
        } catch(\Exception $err){
            Log::error('message error in edit_charge on StudentRepository :'. $err->getMessage());
            return back()->with('error', $err->getMessage());
        }
    }


    public function getAdmissionFee($session_id,$class,$fee_head,$fee_type)
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
            Log::error('message error in getAdmissionFee on StudentRepository :'. $err->getMessage());
        } 
        return $data;   
    }



    public function delete($student_admission_id)
    {
        try {
            $student = StudentDetail::destroy($student_admission_id);
            if ($student) { //Check if data was updated
                return true;
            } else {
                return false;
            }
        } catch(\Exception $err){
            Log::error('message error in delete on StudentRepository :'. $err->getMessage());
            return back()->with('error', $err->getMessage());
        }
    }

    

    /**
    * Method to delete resource
    * @param Illuminate\Http\Request
    * @return boolean
    */
    public function restore($student_admission_id)
    {
        try {
            $student = StudentDetail::withTrashed()->find($student_admission_id)->restore();
            if ($student) { //Check if data was updated
                return true;
            } else {
                return false;
            }
        } catch(\Exception $err){
            Log::error('message error in restore on StudentRepository :'. $err->getMessage());
            return back()->with('error', $err->getMessage());
        }
    }



}