<?php
 
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Model\Session;

class CommanHelper
{
	public static function getSession()
	{
		return $session = Session::where('status','=','Active')->orderBy('name','asc')->get(['id','name']);
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
