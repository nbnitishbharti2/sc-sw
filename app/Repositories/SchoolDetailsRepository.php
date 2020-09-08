<?php 

namespace App\Repositories;

use App\Models\SchoolDetails;
use App\Models\SmsCretedantials;
use App\Models\SmtpCretedantials;
use Log;
use Auth;
use Session;

class SchoolDetailsRepository {

    /**
    * Method to fetch all resource data
    *
    * @return Collection $query
    */
    public function getSchoolDetails()
    {
    	try {
    		$schoolDetails = SchoolDetails::first(); //Fetch School Details data
            // Create data for edit form
             $data = [
                'action'            => route('update.school-details'),
                'page_title'        => trans('label.setting'),
                'title'             => trans('title.school_details'),
                'tab'               => 'school_details',  
                'school_details'    => $schoolDetails, 
            ];
            return $data;
        } catch(\Exception $err){
            Log::error('message error in getSchoolDetails on SchoolDetailsRepository :'.$err->getMessage());
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
            if(isset($request->id)){
                $school_details = SchoolDetails::findOrFail($request->id); //Fetch section data
            }else{
                $school_details = new SchoolDetails(); //create new School Details
            } 
            $school_details->school_name        = $request->school_name;
            $school_details->school_short_name  = $request->school_short_name;
            $school_details->mobile_no          = $request->mobile_no;
            $school_details->mobile_no2         = $request->mobile_no_2;
            $school_details->phone_no           = $request->phone_no;
            $school_details->email              = $request->email;
            $school_details->web_site           = $request->web_site;
            $school_details->city               = $request->city;
            $school_details->state              = $request->state;
            $school_details->country            = $request->country;
            $school_details->pin_code           = $request->pin_code;
            $school_details->country_code       = $request->country_code;
            $school_details->country_phone_code = $request->country_phone_code;
            $school_details->currency           = $request->currency;
            $school_details->address            = $request->address;
            
            if($request->hasfile('logo')){ 
                $logoName = time().'.'.request()->logo->getClientOriginalExtension();
                $destinationPath = public_path('school-image');
                File::makeDirectory($destinationPath, $mode = 0777, true, true);
                if(request()->image->move($destinationPath, $logoName))
                {
                    $school_details->logo    = $logoName;
                }   
            }
            if($request->hasfile('water_mark')){ 
                $water_mark = time().'.'.request()->water_mark->getClientOriginalExtension();
                $destinationPath = public_path('school-image');
                File::makeDirectory($destinationPath, $mode = 0777, true, true);
                if(request()->image->move($destinationPath, $water_mark))
                {
                    $school_details->water_mark    = $request->water_mark;
                }
            }
            if($school_details->save()) // Update data
            {
               if(isset($request->id)){ 
                    if ($school_details->wasChanged()) { //Check if data was updated
                        return true;
                    } else {
                        return false;
                    }
                }else{
                    return true;
                }  
            }else{
                return false;
            } 
        } catch(\Exception $err){
            Log::error('message error in update on SchoolDetailsRepository :'. $err->getMessage());
            return back()->with('error', $err->getMessage());
        }
    }


    public function getSmsDetails()
    {
        try {
            $SmsCretedantials = SmsCretedantials::first(); //Fetch School Details data
            // Create data for edit form
             $data = [
                'action'            => route('update.sms-details'),
                'page_title'        => trans('label.setting'),
                'title'             => trans('title.school_details'),
                'tab'               => 'sms',  
                'sms_cretedantials' => $SmsCretedantials, 
            ];
            return $data;
        } catch(\Exception $err){
            Log::error('message error in getSchoolDetails on SchoolDetailsRepository :'.$err->getMessage());
            return back()->with('error', $err->getMessage());
        }
    }


    public function updateSmsDetails($request)
    {
        try {
            if(isset($request->id)){
                $Sms_cretedantials                = SmsCretedantials::findOrFail($request->id); //Fetch SMS Cretedantial  data
            }else{
                 $Sms_cretedantials                = new SmsCretedantials; //create new SMS Cretedantial 
            } 
            //dd($Sms_cretedantials);
            $Sms_cretedantials->user_name       = $request->user_name;
            $Sms_cretedantials->password        = $request->password;
            $Sms_cretedantials->api_key         = $request->api_key;
            $Sms_cretedantials->sender_id       = $request->sender_id;
            $Sms_cretedantials->sms_gateway_url = $request->sms_url; 

            if($Sms_cretedantials->save()) // Update data
            {
                if(isset($request->id)){ 
                    if ($Sms_cretedantials->wasChanged()) { //Check if data was updated
                        return true;
                    } else {
                        return false;
                    }
                }else{
                    return true;
                }  
            }else{
                return false;
            }
        } catch(\Exception $err){
            Log::error('message error in updateSmsDetails on SchoolDetailsRepository :'. $err->getMessage());
            return back()->with('error', $err->getMessage());
        }
    }


    public function getSmtpDetails()
    {
        try {
            $SmtpCretedantials = SmtpCretedantials::first(); //Fetch School Details data
            // Create data for edit form
             $data = [
                'action'            => route('update.smtp-details'),
                'page_title'    => trans('label.setting'),
                'title'         => trans('title.school_details'),
                'tab'         => 'smtp',  
                'smtp_cretedantials'      => $SmtpCretedantials, 
            ];
            return $data;
        } catch(\Exception $err){
            Log::error('message error in getSmtpDetails on SchoolDetailsRepository :'. $err->getMessage());
            return back()->with('error', $err->getMessage());
        }
    }


    public function updateSmtpDetails($request)
    {
        try {
            if(isset($request->id)){
                $Smtp_cretedantials = SmtpCretedantials::findOrFail($request->id); //Fetch SMS Cretedantial  data
            }else{
                $Smtp_cretedantials = new SmtpCretedantials(); //create new SMS Cretedantial 
            }  
             
            $Smtp_cretedantials->email     = $request->email;
            $Smtp_cretedantials->password  = $request->password;
            $Smtp_cretedantials->smtp_type = $request->smtp_type;
            $Smtp_cretedantials->host      = $request->host;
            $Smtp_cretedantials->port      = $request->port; 
             
            if($Smtp_cretedantials->save()) // Update data
            {
                if(isset($request->id)){ 
                    if ($Smtp_cretedantials->wasChanged()) { //Check if data was updated
                        return true;
                    } else {
                        return false;
                    }
                }else{
                    return true;
                }  
            }else{
                return false;
            }  
        } catch(\Exception $err){
            Log::error('message error in updateSmtpDetails on SchoolDetailsRepository :'. $err->getMessage());
            return back()->with('error', $err->getMessage());
        }
    }


}