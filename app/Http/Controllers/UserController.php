<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repositories\UserRepository;
use App\User;
use Validator;
use Auth;
use Lang;
use Log;
use App;
use Storage;
use App\Models\SchoolDetails; 
use App\Models\SaveOtp;
use Illuminate\Support\Facades\Hash;
class UserController extends Controller
{
	public function __construct(UserRepository $user)
	{
		$this->user = $user;
		/*if(!Auth::user()->locale)
		{
			App::setLocale('en');
		}*/
		App::setLocale('en');
	}
    public $message='';
    public $type='';
	/**
	* Method for show resource for user profile
	* 
	* @return Illuminate\Http\Response
    */
    public function showProfile()
    { 
    	try {
            $data['user'] = Auth::user(); // Fetching Auth user
            return view('user.profile', $data); //Return response
    	} catch(\Exception $err){
            Log::error('Error in showProfile on UserController :'. $err->getMessage());
    		return back()->with('error', $err->getMessage());
    	}
    }

    /**
    * Method for show list of users
    * 
    * @return Illuminate\Http\Response
    */
    public function allUsers()
    {
    	$data['users'] = $this->user->getAllUsers();
    	return view('user.all-users', $data);
    }

    /**
	* Method for update resocurce 
	* @param Illuminate\Http\Request $request
	* @return Illuminate\Http\Response
    */
    public function updateUserProfile(Request $request)
    {
    	try {
    		// Validate request
	    	$validator = Validator::make($request->all(), [
	            'name' => 'string|required|min:4',
				'email'=>'required|email',
				'profile_image' => 'image|mimes:jpeg,png,jpg|max:2048',
	        ]);
	    	// Return if validation failed
	        if ($validator->fails()) {
	        	return back()->withErrors($validator)->withInput();
	        }
	        //Check if user uploaded profile pic
	        if($request->hasfile('profile_image')) {
	         	$image = $request->file('profile_image');
				$name = $image->getClientOriginalName();
				$image->storeAs('public/user_profile', $name); // Store image in storage
			}
	        $input = $request->except('_token, profile_image');
    		$result = $this->user->updateProfile($input);
    		if($result == true) {
    			return redirect('profile')->with('success', Lang::get('success.profile_updated'));
    		}
    		return redirect('profile')->with('error', Lang::get('error.profile_not_updated'));
    	} catch(\Exception $err){
    		Log::error('Error in updateUserProfile on UserController :'. $err->getMessage());
    		return back()->with('error', $err->getMessage());
    	}
    }
    public function verify_otp()
    {
        $data=SchoolDetails::first(); 
        return view('auth.passwords.verify-otp', compact('data'));
    }
    public function reset_password(Request $request)
    {
         try {
            $validator = Validator::make($request->all(), [
                'mobile' => 'required', 
                'otp' => 'required', 
                'password' => 'required|string|min:8|confirmed',
            ]);
            if ($validator->fails()) {
                return back()->withErrors($validator)->withInput();
            }
            $user=User::where('mobile_no','=',$request->mobile)->first(); 
            if(isset($user->id)){ 
                $otp=SaveOtp::where('user_id','=', $user->id)->where('otp','=', $request->otp)->first(); 
                if(isset($otp->id)) {
                    $data = User::find($user->id); 
                    $data->password = Hash::make($request->password); 
                    if($data->save()) { 
                        SaveOtp::where('user_id','=',$user->id)->delete(); 
                        $this->message = Lang::get('success.password_changed_successfully'); 
                        $this->type="success"; 
                        return redirect('login')->with($this->type, $this->message); 
                    } else {
                       $this->message = Lang::get('error.somthing_wrong'); 
                        $this->type="error";  
                    }
                } else {
                    $this->message = Lang::get('error.invalid_otp'); 
                $this->type="error";  
                }
            } else {
                 $this->message = Lang::get('error.mobile_no_not_exist'); 
                $this->type="error"; 
            }
         }catch(\Exception $err){
            $this->message  = $err->getMessage(); 
            $this->type     = "error"; 
            Log::error('Error in reset password with otp on UserController :'. $err->getMessage());
            return back()->with('error', $err->getMessage());
        }
        return back()->with($this->type,  $this->message);
    }
}
