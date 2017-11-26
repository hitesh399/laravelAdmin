<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Auth\ThrottlesLogins;
use App\Http\Controllers\AuthenticatesUsers;

class LoginController extends Controller
{
    //
    use ThrottlesLogins,AuthenticatesUsers;


    /** 
    * Handling the Login Request
    **/

    public function login(Request $request)
    {   
        $this->validateLogin($request);       

        if($this->status =='failed'){

        	return $this->sendApiResponse();
        }

        // If the class is using the ThrottlesLogins trait, we can automatically throttle
        // the login attempts for this application. We'll key this by the username and
        // the IP address of the client making these requests into this application.
        if ($this->hasTooManyLoginAttempts($request)) {
            $this->fireLockoutEvent($request);

            return $this->sendLockoutResponse($request);
        }
        
        // Check the user's email or mobile number is verified or not.
        if($this->hasUnverifieldLabel($request)){
            
            $this->incrementLoginAttempts($request);
            return $this->sendUnverifieldLoginResponse($request);
        }

        if ($this->attemptLogin($request)) {
            return $this->sendLoginResponse($request);
        }

        // If the login attempt was unsuccessful we will increment the number of attempts
        // to login and redirect the user back to the login form. Of course, when this
        // user surpasses their maximum number of attempts they will get locked out.
        $this->incrementLoginAttempts($request);

        return $this->sendFailedLoginResponse($request);
    }

    /**
     * Validate the user login request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return void
     */
    protected function validateLogin(Request $request)
    {
        $validator = \Validator::make($request->all(), [
            $this->username() => 'required|string',
            'password' => 'required|string',
        ]);

        if($validator->fails()){

        	$this->status = 'failed';
        	$this->message = $validator->errors()->first();
        	$this->errors = $validator->errors();
        }
    }

    /**
     * Redirect the user after determining they are locked out.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    protected function sendLockoutResponse(Request $request)
    {
        $seconds = $this->limiter()->availableIn(
            $this->throttleKey($request)
        );

        $this->message = \Lang::get('auth.throttle', ['seconds' => $seconds]);
        $this->status = 'failed';
        return $this->sendApiResponse();
    }


    /**
     * Send the unverified label response
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    protected function sendUnverifieldLoginResponse(Request $request)
    {
        
        $this->message = 'Please verify the '.$this->getLoginLable($request).' before try to login.';
        $this->status = 'failed';
        return $this->sendApiResponse();
    }

    /**
     * Attempt to log the user into the application.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return bool
     */
    protected function attemptLogin(Request $request)
    {

        return \Auth::once($this->credentials($request));
    }

    /**
     * Send the response after the user was authenticated.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    protected function sendLoginResponse(Request $request)
    {
        $this->data = $this->user();
        $this->status ='success';
        return $this->sendApiResponse();
    }

    /**
     * Get the failed login response instance.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    protected function sendFailedLoginResponse(Request $request)
    {
		$this->message = trans('auth.failed');
		$this->status ='failed';
		return $this->sendApiResponse();
    }
}
