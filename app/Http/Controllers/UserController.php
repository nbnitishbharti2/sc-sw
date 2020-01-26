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
	/**
	* Method for show resource for user profile
	* 
	* @return Illuminate\Http\Response
    */
    public function showProfile()
    {
    	try
    	{
    		$user = Auth::user(); // Fetching Auth user
    		return view('user.profile', $user); //Return response
    	} catch(\Exception $err){
    		Log::error('Error in showProfile on UserController :'. $err->getMessage());
    		return back()->with('error', $err->getMessage());
    	}
    }
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
    	try
    	{
    		// Validate request
	    	$validator = Validator::make($request->all(), [
	            'name' => 'string|required|min:4',
				'email'=>'required|email',
				'profile_image' => 'image|mimes:jpeg,png,jpg|max:2048',
	        ]);
	    	// Return if validation failed
	        if ($validator->fails()) 
	        {
	        	return back()->withErrors($validator)->withInput();
	        }
	        //Check if user uploaded profile pic
	        if($request->hasfile('profile_image'))
	        {
	         	$image = $request->file('profile_image');
				$name = $image->getClientOriginalName();
				$image->storeAs('public/user_profile', $name); // Store image in storage
			}
	        $input = $request->except('_token, profile_image');
    		$result = $this->user->updateProfile($input);
    		if($result == true)
    		{
    			return redirect('profile')->with('success', Lang::get('success.profile_updated'));
    		}
    		return redirect('profile')->with('error', Lang::get('error.profile_not_updated'));
    	} catch(\Exception $err){
    		Log::error('Error in updateUserProfile on UserController :'. $err->getMessage());
    		return back()->with('error', $err->getMessage());
    	}
    }
}
