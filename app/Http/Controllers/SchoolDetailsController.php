<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repositories\SchoolDetailsRepository;
use App\Http\Requests\SchoolDetailsRequest;
use App\Http\Requests\SmsDetails;
use App\Http\Requests\SmtpDetails;
use App\User;
use Validator;
use Auth;
use Lang;
use Log;
use App;
use Session;

class SchoolDetailsController extends Controller
{
    public function __construct(SchoolDetailsRepository $schoolDetails)
    {
        $this->schoolDetails = $schoolDetails;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        try {
            $data = $this->schoolDetails->getSchoolDetails(); // Fetch school Details  
            return view('school_details.index',$data);
        } catch(\Exception $err){
            Log::error('Error in index on SchoolDetailsController :'. $err->getMessage());
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
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
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
    public function update(SchoolDetailsRequest $request, $id=null)
    {
        try {
            $result = $this->schoolDetails->update($request); 
            if($result == true) {
                return redirect('sms-details')->with('success', Lang::get('success.school_detaisl_updated_successfully')); 
            }
            return back()->with('error', Lang::get('error.school_detaisl_updated'));
        } catch(\Exception $err){
            Log::error('Error in update on SchoolDetailsController :'. $err->getMessage());
            return back()->with('error', $err->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
    public function sms_details()
    {
        try {
            $data = $this->schoolDetails->getSmsDetails(); // Fetch school Details  
            return view('school_details.index',$data);
        } catch(\Exception $err){
            Log::error('Error in sms_details on SchoolDetailsController :'. $err->getMessage());
            return back()->with('error', $err->getMessage());
        }
    }
    public function update_sms(SmsDetails $request)
    {
       try {
            $result = $this->schoolDetails->updateSmsDetails($request); 
            if($result == true) {
                return redirect('smtp-details')->with('success', Lang::get('success.sms_detaisl_updated_successfully')); 
            }
            return back()->with('error', Lang::get('error.sms_detaisl_updated'));
        } catch(\Exception $err){
            Log::error('Error in update_sms on SchoolDetailsController :'. $err->getMessage());
            return back()->with('error', $err->getMessage());
        }
    }
    public function smtp_details()
    {
        try {
            $data = $this->schoolDetails->getSmtpDetails(); // Fetch school Details  
            return view('school_details.index',$data);
        } catch(\Exception $err){
            Log::error('Error in smtp_details on SchoolDetailsController :'. $err->getMessage());
            return back()->with('error', $err->getMessage());
        }
    }
    public function update_smtp(SmtpDetails $request)
    {
       try {
            $result = $this->schoolDetails->updateSmtpDetails($request); 
            if($result == true) {
                return redirect('smtp-details')->with('success', Lang::get('success.smtp_detaisl_updated_successfully')); 
            }
            return back()->with('error', Lang::get('error.smtp_detaisl_updated'));
        } catch(\Exception $err){
            Log::error('Error in update_smtp on SchoolDetailsController :'. $err->getMessage());
            return back()->with('error', $err->getMessage());
        }
    }
}
