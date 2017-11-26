<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\File;
use App\Lib\DragDropUpload;

class FileController extends Controller
{
    //

    /**
    * This function uses to display the File manager page. 
    * @param Instance of Illuminate\Http\Request
    * @return Instance of View
    */

    public function index(Request $request)
    {
    	return view('file-manager-dragdrop');
    }

    /**
    * This function uses to upload the file in chunck
    * @param Instance of Illuminate\Http\Request
    * @return Instance of Response
    */

    public function uploader(Request $request)
    {
    	$uploader = new DragDropUpload();
    	return $uploader->doUpload($request);				 
    }
    
}
