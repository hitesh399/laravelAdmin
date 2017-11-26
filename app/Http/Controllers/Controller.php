<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;


    protected $status ='success';  // success,failed
    protected $message;
    protected $errors=[];
    protected $data =[];


    /**
    * This function will use to send the API response.
    * @param function
    **/

    public function sendApiResponse($callback =null)
    {
    	$response = [

    		'status'=>$this->status,
    		'message'=>$this->message,
    		'errors'=>$this->errors,
    		'data'=>$this->data,
    	];

    	if(is_callable($callback)){

    		return call_user_func($callback,$response);
    	}

    	return \Response::json($response);
    }
}
