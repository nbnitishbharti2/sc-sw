<?php 

namespace App\Repositories;

use App\User;
use Log;
use Auth;
class UserRepository {

    
    public function getAllUsers()
    {
    	try {
    		return User::all();
    	} catch(\Exception $err){
    		Log::error('message error in getAllUsers on UserRepository :'. $err->getMessage());
    		return back()->with('error', $err->getMessage());
    	}
    }


    public function updateProfile($input)
    {
        try {
            $user = Auth::user(); // Fetch logged in user
            $result = $user->update($input);
            return ($result == true) ? true : false;
        } catch(\Exception $err){
            Log::error('message error in getAllUsers on UserRepository :'. $err->getMessage());
            return back()->with('error', $err->getMessage());
        }
    }


    
}