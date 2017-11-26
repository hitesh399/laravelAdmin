<?php 
namespace App\Lib;

use Cache;
use App\Models\Setting;

class GetData{

 	/**
 	 * Get the setting data and store in cache 
 	 * @param  string $name setting data key name
 	 * @return Array|String       It should be depend on setting value
 	 */
 	public static function setting($name){

 		return Cache::rememberForever('settings.'.$name, function() use($name) {
		    
		    $data = Setting::where('data_key',$name)->first(['data']);
		    return ($data && self::isJSON($data))?json_decode($data):$data;
		});
 	}

 	/**
 	 * Get the Email Template data and store in cache
 	 * @param  string $name Email template key name
 	 * @return Array       Email Template data
 	 */
 	public static function emailTemplate($name){}

 	/**
 	 * check string is json or not.
 	 * @param  [type]  $string [description]
 	 * @return boolean         [description]
 	 */
 	public static function isJSON($string){
	   return is_string($string) && is_array(json_decode($string, true)) && (json_last_error() == JSON_ERROR_NONE) ? true : false;
	}

	/**
	 * Get the Storage URL
	 */
	public static function storageUrl($file='/')
	{
		return \Storage::url($file);
	}
 }