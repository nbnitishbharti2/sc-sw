<?php
 
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\AcademicYear;

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
}
