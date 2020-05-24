<?php 

namespace App\Repositories;

use App\Models\Category;
use App\Models\BloodGroup;
use App\Models\Gender;
use App\Models\Classes;
use App\Models\Education;
use App\Models\Occupation;
use App\Helpers\CommanHelper;
use App\Models\FeeSetting;
use App\Models\StudentRegistration;
use App\Models\StudentRegistrationMap;
use Log;
use Lang;
use Session;
use Auth;
class StudentRegistrationRepository {

    /**
    * Method to fetch all resource data
    *
    * @return Collection $query
    */
    public function getAllRoom()
    {

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
                $registration_no=$this->getRegistrationNo($session_id);
                $data = [
                    'action'            => route('update.student.registration'),
                    'page_title'    => Lang::get('label.student_registration'),
                    'title'         => Lang::get('title.student_registration'),
                    'class_list'    => Classes::getAllClassForListing($session_id),
                    'class_id'      => (old('class')) ? old('class') : $student->class_id,
                    'section_id'      => (old('section')) ? old('section') :  $student->section_id,
                    'gender_list'    => Gender::getAllGenderListing(),
                    'gender_id'      => (old('gender')) ? old('gender') : $student->gender_id,
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
                ];
            }else{
                $registration_no=$this->getRegistrationNo($session_id);
                $data = [
                    'action'            => route('store.student.registration'),
                    'page_title'    => Lang::get('label.student_registration'),
                    'title'         => Lang::get('title.student_registration'),
                    'class_list'    => Classes::getAllClassForListing($session_id),
                    'class_id'      => (old('class')) ? old('class') : 0,
                    'section_id'      => (old('section')) ? old('section') : 0,
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
                'section_id'=>$request->section,
                'student_registration_id'=>$student->id,
                'register_by'=>Auth::user()->id
            ];
            $data=StudentRegistrationMap::create($session_data);
            if($student->exists) {
                $responce['status']=true;
                $responce['id']=$student->id;
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

    /**
    * Method to delete resource
    * @param Illuminate\Http\Request
    * @return boolean
    */
    public function delete($room_id)
    {

    }

    /**
    * Method to delete resource
    * @param Illuminate\Http\Request
    * @return boolean
    */
    public function restore($room_id)
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
   public function edit_address($id)
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
        return $responce; 
    } else {
       return $responce;
   }
} catch(\Exception $err){
    Log::error('message error in update_address on StudentRegistrationRepository :'. $err->getMessage());
    return back()->with('error', $err->getMessage());
}
}
   public function edit_parent($id)
   {
      try {
        $student=StudentRegistration::FindOrFail($id); 
        $data = [
            'action'            => route('update.student.registration.parent'),
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
        return $responce; 
    } else {
       return $responce;
   }
} catch(\Exception $err){
    Log::error('message error in update_parent on StudentRegistrationRepository :'. $err->getMessage());
    return back()->with('error', $err->getMessage());
}
}
   public function edit_charge($id)
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
            'tab'         => 'student_charge',   
            'student_registration_id'    => $id, 
        ];
        return $data;
    } catch(\Exception $err){
        Log::error('message error in edit_charge on StudentRegistrationRepository :'. $err->getMessage());
        return back()->with('error', $err->getMessage());
    }
}
}