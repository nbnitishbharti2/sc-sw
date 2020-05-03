<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use App\Http\Requests\LoginRequest;
use App\Models\User;
use Log;
use App\Models\UserSessionMap;
use App\Models\SchoolDetails;
use App\Models\AcademicYear;
use Illuminate\Validation\ValidationException;
use Session;
class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

     use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    


    public function showLoginForm()
    {
        $data = SchoolDetails::first(); 
        if(!empty($data)){
             return view('auth.login', compact('data')); 
        }else{
            return view('auth.login', $data);
        }
       
    }
    public function login(LoginRequest $request)
    { 
        try {
            $login_type = filter_var($request->input('email'), FILTER_VALIDATE_EMAIL )  ? 'email' : 'mobile_no';

            $request->merge([
                $login_type => $request->input('email')
            ]);

            $session=request('session'); 
            if (Auth::attempt($request->only($login_type, 'password'))) {
                $users = User::whereHas('UserSessionMap', function($q) use($session){ 
                    $q->where('session_id', '=', $session);  
                })->with('UserSessionMap')->where('id','=',Auth::user()->id)->first();
                if(isset($users->id)){
                    // $users->assignRole('administrator');
                    return $this->sendLoginResponse($request);
                } else {
                    return $this->logoutUserSession($request);
                } 
            } else {
                return $this->sendFailedLoginResponse($request);  
            }
        } catch(\Exception $err){
            Log::error('Error in login on LoginController :'. $err->getMessage());
            return back()->with('error', $err->getMessage());
        }
}

protected function sendFailedLoginResponse(Request $request)
{
    throw ValidationException::withMessages([
        $this->username() => [trans('auth.failed')],
    ]);
}

protected function sendLoginResponse(Request $request)
{
    $request->session()->regenerate(); 
    $this->clearLoginAttempts($request); 
    //$this->guard()->user()->put('session2', $request->session);
   $this->guard()->user()->setAttribute('session', $request->session);
     if($this->checksessionMap()){
        $this->nextSession();
        Session::put('session', $request->session);
        $this->prevSession();  
         return redirect()->intended($this->redirectPath());
     }else{
        return $this->logoutUserSession($request);
     } 
   /* return $this->authenticated($request, $this->guard()->user())
    ?: redirect()->intended($this->redirectPath());*/
}
public function logoutUserSession(Request $request)
{
    $this->guard()->logout(); 
    $request->session()->invalidate(); 
    return $this->loggedOut($request) ?: redirect('/')->with(['error'=>'Session Not Assige']);
}
public function checksessionMap(){
    $check_session=UserSessionMap::where('user_id','=',Auth::user()->id)->where('session_id','=',Auth::user()->session)->count();
    if($check_session>0){
        return 1;
    }else{
        return 0;
    }
}
public function nextSession()
{ 
    $session_id=Auth::user()->session+1;
  // $check_session=UserSessionMap::where('user_id','=',Auth::user()->id)->where('session_id','=',$session_id)->first();
    $check_session=AcademicYear::find($session_id);
    if(isset($check_session->id)){
        Session::put('nextsession', $check_session->id);  
    }else{
       Session::put('nextsession', null);
    }  
}
public function prevSession()
{ 
  $session_id=Auth::user()->session-1;
  // $check_session=UserSessionMap::where('user_id','=',Auth::user()->id)->where('session_id','=',$session_id)->first();
   $check_session=AcademicYear::find($session_id);
    if(isset($check_session->id)){
        Session::put('prevsession', $check_session->id);  
    }else{
       Session::put('nextsession', null);
    }  
}
}