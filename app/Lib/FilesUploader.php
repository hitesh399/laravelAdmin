<?php

namespace App\Lib;

use Illuminate\Support\Facades\File;
use Storage;

class FilesUploader
{
	protected $store_path;
	protected $internal_path = 'storage';
	protected $tmp_path = 'tmp';

	function __construct()
	{
		$this->store_path = public_path($this->internal_path);
	}

	/**
	* This function returns the temporary path for storing the files part.
	*/
	public function getTempPath()
	{	
		$tmp_path = $this->store_path.'/'.$this->tmp_path;

		if(!File::exists($tmp_path)) {
            File::makeDirectory($tmp_path, 0775, true, true);
        }
        return $tmp_path;
	}

	/**
	* This function provides the path to store the file.
	*/
	public function getDestinationPath()
	{
		$destination_path =  $this->store_path.'/'.date('Y/m');
		if(!File::exists($destination_path)) {
            File::makeDirectory($destination_path, 0775, true, true);
        }
        return $destination_path;
	}

	public function getFullUrl($file_name)
	{
		return asset($this->internal_path.'/'.date('Y/m').'/'.$file_name);
	}

	public function getInternalPath($file_name)
	{
		return $this->internal_path.'/'.date('Y/m').'/'.$file_name;
	}

	/** 
	* This function checks the writable permission on the given path
	* @param String - The path
	* @return boolean
	*/
	function isWritablePath($path=null) 
	{
		$path = $path?$path:$this->store_path;	
	    $is_oK = false;

	    if ( ($path!="") && is_dir($path) && is_writable($path) ) {
	      
	        $tmp_file = "mPC_".uniqid(mt_rand()).'.writable';
	        $full_pathname = str_replace('//','/',$path."/".$tmp_file);
	        $fp = @fopen($full_pathname,"w");
	        if ($fp !== false) {
	            $is_oK = true;
	        }
	        @fclose($fp);
	        @unlink($full_pathname);
	    }
	    return $is_oK;	    
	}

	/**	 
	* Delete a directory RECURSIVELY
	* @param string $dir - directory path.	* 
	*/

	public function rrmdir($dir) {
	    
	    if (is_dir($dir)) {
	        $objects = scandir($dir);
	        foreach ($objects as $object) {
	            if ($object != "." && $object != "..") {
	                if (filetype($dir . "/" . $object) == "dir") {
	                    rrmdir($dir . "/" . $object); 
	                } else {
	                    unlink($dir . "/" . $object);
	                }
	            }
	        }
	        reset($objects);
	        rmdir($dir);
	    }
	}

	/**
	* This function provides a unique file name
	* @param String - Folder Path
	* @param String - File Name
	*/

	public function getFileName($dir,$name)
	{	
		$name = preg_replace('/[^a-zA-Z0-9\-\_\.]+/', '', $name);

		if(file_exists($dir.'/'. $name )){

			$fName = explode('.', $name);
			$ext = end($fName);
			$last_index = count($fName)-1;
			unset($fName[$last_index]);
			$f_name = implode('.', $fName);

			$f_name_arr = explode('_', $f_name);
			$last_num = end($f_name_arr);
			$last_index = count($f_name_arr)-1;
			unset($f_name_arr[$last_index]);

			if(is_numeric($last_num)){
				$f_name_arr[$last_index] = $last_num+1;
				
			}else{

				$f_name_arr[$last_index] =  $last_num.'_1';
			}
			$f_name  = implode('_', $f_name_arr);

			$name = $f_name.'.'.$ext;

			return $this->getFileName($dir,$name);
		}

		return $name;
	}

	/**
	 * Move file one location to another location in the same disk
	 * @param  [string] $from source path
	 * @param  [string] $to   Destination path
	 * @return [bool]     
	 */
	public static function move($from,$to)
	{
		return Storage::move($from, $to);
	}
	/**
	 * Delete the temporary file
	 * @param  string $temp_file temporary file path
	 * @return boolean          
	 */
	public static function deleteTempFile($temp_file)
	{
		return Storage::delete($temp_file);
	}
}