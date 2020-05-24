<?php

namespace App\Helpers;

use Illuminate\Support\Facades\Auth;
use App\Models\AcademicYear;
use App\Models\Permission;
use App\Models\RolePermission;
use Log;

class CommanHelper
{
	public static function getSession()
	{
		return $session = AcademicYear::where('status','=','Active')->orderBy('academic_year','asc')->get(['id','academic_year']);
	}
	
	
	public static function getCurrentSession()
	{
		$year		= date('Y');
		$month		= date('m');
		$session	= '';
		if($month>3){
			$session = $year.'-'.($year+1);
		}else{
			$session = ($year-1).'-'.$year;
		}
		return $session;
	}
	public static function getCurrentSessionForAdmission()
	{
		$year		= date('Y');
		$month		= date('m');
		$session	= ''; 
		$session = $year.'-'.($year+1);
		return $session;
	}
	public static function getSessionId($academic_year)
	{
		$session=AcademicYear::where('academic_year','=',$academic_year)->first();
		$session_id=$session->id;
		return $session_id;
	}
	/**
	* Method to check user permission
	* @param string $permission
	* @return boolean 
	*/
	public static function checkPermission($permission)
	{
		try {
			$permission_id 		= Permission::where('name', $permission)->first();
			$check_permission 	= RolePermission::where(['permission_id' => $permission_id->id, 'role_id' => Auth::user()->roles->role_id])->count();
			return ($check_permission == 1) ? true : false;
		} catch (\Throwable $th) {
			Log::error('error on checkPermission in CommanHelper '. $th->getMessage());
		}
	}

	/**
	* Method to get User role
	* 
	* @return string 
	*/
	public static function userRole()
	{
		try {
			return ucfirst(Auth::user()->roles->role->name);
		} catch (\Throwable $th) {
			Log::error('error on userRole in CommanHelper '. $th->getMessage());
		}
	}
}
