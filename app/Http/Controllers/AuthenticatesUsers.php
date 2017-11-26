<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

Trait AuthenticatesUsers
{
	/**
     * Validate the user login request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return void
     */

    protected $user;

    protected function validateLogin(Request $request)
    {
        $this->validate($request, [
            $this->username() => 'required|string',
            'password' => 'required|string',
        ]);
    }

    /**
     * Attempt to log the user into the application.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return bool
     */
    protected function attemptLogin(Request $request)
    {

        return $this->guard()->attempt(
            $this->credentials($request), $request->has('remember')
        );
    }

    /**
    * Get the user information
    * 
    * @param  \Illuminate\Http\Request  $request
    * @return instance of App\User
    **/

    protected function user(Request $request)
    {   
        if($this->user){

            return $this->user;
        }
        $this->user = \App\User::where('email',$request->{$this->username()})
        ->orWhere('mobile_no',$request->{$this->username()})
        ->orWhere('user_name',$request->{$this->username()})
        ->first();
        return $this->user;
    }


    /**
    * Check if user tring to login with unverified email or mobile.
    * @param  \Illuminate\Http\Request  $request
    * @return bool
    **/

    protected function hasUnverifieldLabel(Request $request)
    {
        $label = $this->getLoginLable($request);
        $user = $this->user($request);
        
        if(!$user){
            return false;
        }

        if($label =='email' && $user->is_email_verified =='N'){

            return true;

        }elseif($label =='mobile_no' && $user->is_mobile_no_verified =='N'){

            return true;
        }else{

            return false;
        }   
    }
   

    /**
     * Send the unverified label response
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    protected function sendUnverifieldLoginResponse(Request $request)
    {
        
        $errors = [$this->username()=> 'Please verify the '.$this->getLoginLable($request).' before try to login.'];

        if ($request->expectsJson()) {
            return response()->json($errors, 422);
        }

        return redirect()->back()
            ->withInput($request->only($this->username(), 'remember'))
            ->withErrors($errors);
    }

    /**
     * Get the needed authorization credentials from the request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    protected function credentials(Request $request)
    {  
       
       return [$this->getLoginLable($request)=>$request->{$this->username()},'password'=>$request->password];

    }

    /**
     * Send the response after the user was authenticated.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    protected function sendLoginResponse(Request $request)
    {
        session()->regenerate();

        $this->clearLoginAttempts($request);

        return $this->authenticated($request, $this->guard()->user())
                ?: redirect()->intended($this->redirectPath());
    }

    /** 
    * Finding the label, which is using by user to the login attamp like: email,mobile_no,password
    * @param  \Illuminate\Http\Request  $request
    * @return String
    */

    protected function getLoginLable(Request $request)
    {

        if(filter_var($request->{$this->username()}, FILTER_VALIDATE_EMAIL)){
            return 'email';

        }elseif(preg_match('/^(\+|[0-9]){1,3}(\-)([0-9]){6,10}$/', $request->{$this->username()})){

            return 'mobile_no';
        }else{

            return 'user_name';
        }
    } 

    /**
     * The user has been authenticated.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  mixed  $user
     * @return mixed
     */
    protected function authenticated(Request $request, $user)
    {
        //
    }

    /**
     * Get the failed login response instance.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    protected function sendFailedLoginResponse(Request $request)
    {
        $errors = [$this->username() => trans('auth.failed')];

        if ($request->expectsJson()) {
            return response()->json($errors, 422);
        }

        return redirect()->back()
            ->withInput($request->only($this->username(), 'remember'))
            ->withErrors($errors);
    }


    /**
     * Get the login username to be used by the controller.
     *
     * @return string
     */
    public function username()
    {
        return 'username';
    }

    /**
     * Log the user out of the application.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function logout(Request $request)
    {
        $this->guard()->logout();

        $request->session()->invalidate();

        return redirect('/');
    }

    /**
     * Get the guard to be used during authentication.
     *
     * @return \Illuminate\Contracts\Auth\StatefulGuard
     */
    protected function guard()
    {
        return Auth::guard();
    }

    /**
     * Get the post register / login redirect path.
     *
     * @return string
     */
    public function redirectPath()
    {       

        return '/';
    }
}