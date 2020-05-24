<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repositories\StudentRegistrationRepository;
use App\Http\Requests\StudentRegistration;
use App\Http\Requests\StudentAddress;
use App\Http\Requests\StudentParent;
use Log;
use Lang;
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
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($id=0)
    {
        try { 
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
                 return redirect()->route('edit.student.registration.charge',['id' => $result['id'],'map_id' => $result['map_id']])->with('success', Lang::get('success.student_parent_updated_successfully')); 

            }
            return back()->with('error', Lang::get('error.student_parent_not_updated'));
        } catch(\Exception $err){
            Log::error('Error in update_parent on StudentRegistrationController :'. $err->getMessage());
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
}
