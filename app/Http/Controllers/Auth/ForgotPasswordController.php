<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\SendsPasswordResetEmails;
use App\Models\SchoolDetails; 
use Illuminate\Support\Facades\Password;
use Illuminate\Http\Request;
use App\User;
use App\Models\SaveOtp;
use Lang;
use Log;
class ForgotPasswordController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Password Reset Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling password reset emails and
    | includes a trait which assists in sending these notifications from
    | your application to your users. Feel free to explore this trait.
    |
    */
    public $message='';
    public $type='';
    use SendsPasswordResetEmails;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

     public function showLinkRequestForm()
    {
        $data=SchoolDetails::first(); 
        return view('auth.passwords.email', compact('data'));
    }
     public function sendResetLinkEmail(Request $request)
    {
        $this->validateEmail($request);

        // We will send the password reset link to this user. Once we have attempted
        // to send the link, we will examine the response then see the message we
        // need to show to the user. Finally, we'll send out a proper response.
        $response = $this->broker()->sendResetLink(
            $this->credentials($request)
        );
         $login_type = filter_var($request->input('email'), FILTER_VALIDATE_EMAIL ) 
        ? 'email' 
        : 'mobile_no';

    $request->merge([
        $login_type => $request->input('email')
    ]); 
    if($login_type=='email'){
        return $response == Password::RESET_LINK_SENT
                    ? $this->sendResetLinkResponse($request, $response)
                    : $this->sendResetLinkFailedResponse($request, $response);
    }else if($login_type=='mobile_no'){ 
         $this->checkuser($request->input('email')); 
         if($this->type=='success'){
             return redirect('verify-otp')->with($this->type, $this->message);
        //return view('auth.passwords.verify-otp', compact('data'))->with($this->type, $this->message); 
         }else{
            return back()->with($this->type, $this->message);  
         }  
    }else{ 
       return back()->with('status', 0);  
    }
    }

    /**
     * Validate the email for the given request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return void
     */
    protected function validateEmail(Request $request)
    {
        $request->validate(['email' => 'required']);
    }

    /**
     * Get the needed authentication credentials from the request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    protected function credentials(Request $request)
    {
        return $request->only('email');
    }

    /**
     * Get the response for a successful password reset link.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  string  $response
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Http\JsonResponse
     */
    protected function sendResetLinkResponse(Request $request, $response)
    { 
        return back()->with('status', trans($response));
    }

    /**
     * Get the response for a failed password reset link.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  string  $response
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Http\JsonResponse
     */
    protected function sendResetLinkFailedResponse(Request $request, $response)
    { 
        return back()
                ->withInput($request->only('email'))
                ->withErrors(['email' => trans($response)]);
    }

    /**
     * Get the broker to be used during password reset.
     *
     * @return \Illuminate\Contracts\Auth\PasswordBroker
     */
    public function broker()
    {
        return Password::broker();
    }
    public function checkuser($mobile)
    { 
        try{
            $user=User::where('mobile_no','=',$mobile)->first(); 
            if($user->id>0){ 
            if($this->sendOtp($mobile,$user->id)){ 

                $this->message=Lang::get('success.otp_send_successfully_varify_otp');
                $this->type="success";
            }else{
                $this->message=Lang::get('error.mobile_no_not_valid');
                $this->type="error"; 
            }
        }else{ 
            $this->message=Lang::get('error.mobile_no_not_exist'); 
                $this->type="error"; 
        }
        }catch(\Exception $err){ 
           $this->message=Lang::get('error.mobile_no_not_exist'); 
             Log::error('Error in forgote on ForgotePasswordController :'. $err->getMessage());
                $this->type="error"; 
}
 
return;
    }
    public function sendOtp($mobile,$id)
    { 
        $otp=rand(100000,999999);
        if($this->saveotp($id,$otp)){ 
             $this->message=Lang::get('message.forgote_password_otp').' '.$otp;
             return 1; 
        }else{ 
            return 0;
        } 
    }
    public function saveotp($user_id,$otp)
    {
        $data=new SaveOtp; 
        $data->otp=$otp;
        $data->user_id=$user_id;
        if($data->save()){
            return 1;
        }else{
            return 0;
        }
    } 
}
