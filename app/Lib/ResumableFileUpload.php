<?php

namespace App\Lib;

use Illuminate\Support\Facades\File;
use Illuminate\Http\Request;

class ResumableFileUpload  extends FilesUploader
{

	private $fileType;

	public function __construct()
	{
		parent::__construct();
	}

	/**
	 *
	 * Check if all the parts exist, and 
	 * gather all the parts of the file together
	 * @param string $fileName - the original file name
	 * @param string $chunkSize - each chunk size (in bytes)
	 * @param string $totalSize - original file size (in bytes)
	 */
	public function createFileFromChunks($temp_dir,$fileName, $chunkSize, $totalSize,$total_files) 
	{
	    # count all the parts of this file
	    $total_files_on_server_size = 0;
	    $temp_total = 0;

	    $dest_dir = $this->getDestinationPath();

	    if(!file_exists($temp_dir.'/'.$fileName.'.part'.$total_files)){
	    	//\Log::info($temp_dir.'/'.$fileName.'.part'.$total_files);
	    	return;
	    }

	    foreach(scandir($temp_dir) as $file) {
	        $temp_total = $total_files_on_server_size;
	        $tempfilesize = filesize($temp_dir.'/'.$file);
	        $total_files_on_server_size = $temp_total + $tempfilesize;
	    }
	    // \Log::info($total_files_on_server_size);
	    // \Log::info($totalSize);
	    # check that all the parts are present
	    # If the Size of all the chunks on the server is equal to the size of the file uploaded.
	    if ($total_files_on_server_size >= $totalSize) {
	    # create the final destination file 
	    	//\Log::info("Ready..");

	    	$uniqeFileName = $this->getFileName($dest_dir,$fileName);

	        if (($fp = fopen($dest_dir.'/'.$uniqeFileName, 'w')) !== false) {
	            for ($i=1; $i<=$total_files; $i++) {
	                fwrite($fp, file_get_contents($temp_dir.'/'.$fileName.'.part'.$i));
	                \Log::info('writing chunk '.$i);
	            }
	            fclose($fp);
	        } else {
	        	//\Log::info("Unable to write content..");
	            return false;
	        }

	        # rename the temporary directory (to avoid access from other 
	        # concurrent chunks uploads) and than delete it
	        if (rename($temp_dir, $temp_dir.'_UNUSED')) {
	            $this->rrmdir($temp_dir.'_UNUSED');
	        } else {
	            $this->rrmdir($temp_dir);
	        }

	        return \Response::json(['file_name'=>$uniqeFileName,
	        	'path'=>$dest_dir,
	        	'totalSize'=>$totalSize,
	        	'fullurl'=>$this->getFullUrl($uniqeFileName),
	        	'internal_path'=>$this->getInternalPath($uniqeFileName),
	        	'fileType'=>$this->fileType,
	        	],200);
	    }
	}

	/**
	* This function handles the proccess of file uploading..
	* @param Instance of Illuminate\Http\Request
	* @return Instance Of file.
	*/

	public function doUpload(Request $request)
	{	
		# Check path is writable or not.
		if(!$this->isWritablePath()){

			return \Response::json(['message'=>'The store path ('.$this->store_path.') is not writable.','success'=>false],500);
		}

		$tmp_path    = $this->getTempPath();

        $resumableIdentifier = $request->resumableIdentifier?$request->resumableIdentifier:'';
		$resumableFilename = $request->resumableFilename?$request->resumableFilename:'';
		$resumableChunkNumber = $request->resumableChunkNumber;
		$temp_dir = $tmp_path.'/'.$resumableIdentifier;
		$this->fileType = $request->resumableType;

		if(!File::exists($temp_dir)) {
            File::makeDirectory($temp_dir,0775, true, true);
        }

        if ($request->getMethod() === 'GET') {
		 		   
			$chunk_file = $temp_dir.'/'.$resumableFilename.'.part'.$resumableChunkNumber;
			if (file_exists($chunk_file)) {

				if(file_exists($temp_dir.'/'.$resumableFilename.'.part'.$request->resumableTotalChunks)){

					 return $this->createFileFromChunks($temp_dir,$resumableFilename,$request->resumableChunkSize, $request->resumableTotalSize,$request->resumableTotalChunks);
				}
				return \Response::json([],200);

			}else{

				return \Response::json([],404);
			}
		}

		if (!empty($_FILES)) foreach ($_FILES as $file) {

		    # check the error status
		    if ($file['error'] != 0) {
		     //   \Log::info('error '.$file['error'].' in file '.$resumableFilename);		        
		        continue;
		    }


		    $dest_file = $temp_dir.'/'.$resumableFilename.'.part'.$resumableChunkNumber;		    

		    # move the temporary file
		    if (!move_uploaded_file($file['tmp_name'], $dest_file)) {
		    	
		    	$error_msg  = 'Error saving (move_uploaded_file) chunk '.$resumableChunkNumber.' for file '.$resumableFilename;
		        //\Log::info($error_msg);		        
		        return \Response::json(['message'=>$error_msg],500);

		    } else {
		        
		        # check if all the parts present, and create the final destination file		        
		        return $this->createFileFromChunks($temp_dir,$resumableFilename,$request->resumableChunkSize, $request->resumableTotalSize,$request->resumableTotalChunks);
		    }
		}
	}
}