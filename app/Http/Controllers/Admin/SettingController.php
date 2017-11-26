<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Setting;
use App\Lib\FilesUploader;

class SettingController extends Controller
{
    
    /**
     * List of all setting.
     * @return \Illuminate\Http\Response
     */

    public function index()
    {
    	$settings = Setting::all();
        //dd($settings->toArray());
    	return view('admin.settings.index',compact('settings'));
    }

    /**
     * Store the new setting data.
     * @return \Illuminate\Http\Response
     */    
    public function store(Request $request)
    {	

    	$this->validate($request,[
    		'data_key'=>'required|max:50|unique:settings|regex:/^[a-z]+[a-z0-9\-\_]+$/i',
    		'title'=>'required|string|max:50',
    		'storage_type'=>'required|in:env,only_db',
    		'field_type'=>'required|max:30',
    		'category'=>'nullable|regex:/^[a-z]+[a-z0-9\-\s]+$/i',
    		'hints'=>'nullable|string',
    		'dropdown_values'=>'required_if:field_type,Dropdown|json'
    	]);
    	
    	$dropdown_values = $request->dropdown_values?json_decode($request->dropdown_values):[];
    	
    	$options = [
    		'values'=>$dropdown_values,
    		'multi_select'=>$request->dropdown_multi_select?'yes':'no',
            'field_type'=>$request->field_type,
    		'file_type'=>$request->file_type,
    		'regex'=>$request->regex,
            'image_width'=>$request->image_width,
            'image_height'=>$request->image_height,
            'file_max_size'=>$request->file_max_size,
            'file_min_size'=>$request->file_min_size,
    	];

    	$hints = $request->hints?$request->hints:'';

    	$data = [
    		'data_key'=>$request->data_key,
    		'title'=>$request->title,
    		'storage_type'=>$request->storage_type,
    		'category'=>$request->category,
    		'hints'=>$hints,
    		'data'=>'',
    		'options'=>json_encode($options)
    	];

    	Setting::create($data);

    	return \Response::json(['status'=>'success','message'=>'Setting has been created.']);
    }
    
    /**
     * To update the Setting values
     * @param  Request $request 
     * @param  integer  $id      Setting perimary key
     * @return JSon           
     */
    public function change(Request $request,$id)
    {

        $setting = Setting::find($id);
        $rules = [
            'name'=>'required',
            'pk'=>'required|integer'
        ];

        $validator = \Validator::make($request->all(),$rules);

        $validator->after(function($v) use($setting){
            
            $path = base_path('.env');

            if($setting->storage_type =='env'){
                if (!file_exists($path) || !is_writable($path))
                    $v->errors()->add('name','ENV file is not writable or not exist.');
            }
        });


        if($validator->fails())              
        return \Response::json(['success'=>false,'msg'=>$validator->errors()->first()]);

        $value = $request->value;

         if($setting->options['field_type'] == 'File'){

            $value = $this->storeFile($setting,$request);
         }
        
        \Cache::forget('settings.'.$setting->data_key);
        \Cache::forever('settings.'.$setting->data_key, $value);

        if(is_array($value)){
            $value = json_encode($value);
        }        

        $setting->update(['data'=>$value]);
        if($setting->storage_type =='env')
            $this->updateEnvFile($setting->data_key,$value);        
        
        return \Response::json(['success'=>true,'msg'=>$request->name.' has been updated.']);
    }

    /**
     * To delete the setting row, the method clears the data from database, cache and also env
     * @param  Request $request [description]
     * @param  [type]  $id      [description]
     * @return [type]           [description]
     */
    public function destroy(Request $request,$id)
    {
        $setting = Setting::find($id);
        $setting->delete();
        \Cache::forget('settings.'.$setting->data_key);

         if($setting->storage_type =='env')
            $this->deleteEnvKey($setting->data_key);

        return \Response::json(['status'=>'success','message'=>'Setting has been deleted successfully.']);
    }

    /**
     * To the update the .env file data
     * @param  string $key       Env key name
     * @param  string $new_value New value
     * @return void            
     */
    private function updateEnvFile($key,$new_value)
    {
        $path = base_path('.env');

        if (file_exists($path) && is_writable($path)) {
            $env_data = file_get_contents($path);
            if(strrpos($env_data, $key) !== false){

                file_put_contents($path, str_replace(
                    $key.'='.env($key), $key.'='.$new_value,$env_data
                ));

            }else{

                file_put_contents($path,$env_data.PHP_EOL.$key.'='.$new_value);
            }
        }
    }

    /**
     * To delete the .env file key value
     * @param  string $key ENV Key Name
     * @return void    
     */
    private function deleteEnvKey($key)
    {
        $path = base_path('.env');

        if (file_exists($path) && is_writable($path)) {
            $env_data = file_get_contents($path);
            if(strrpos($env_data, $key) !== false){

                file_put_contents($path, str_replace(
                    PHP_EOL.$key.'='.env($key), '',$env_data
                ));
            }
        }
    }
    /**
     * Move the Temporary file to permanent location
     * @param  Setting $setting Settign object
     * @param  Request $request Request Object
     * @return string          FilePath
     */
    private function storeFile(Setting $setting,Request $request)
    {
        if($setting->options['field_type'] != 'File')
            return null;
        
        $file = $request->value[0];
        $file_name = uniqid();
        $file_org_name = $file['fileOrignalName'];
        $file_ext = explode('.', $file_org_name);

        $ext = end($file_ext);
        $file_destination_path = 'settings/'.$file_name.'.'.$ext;

        FilesUploader::move($file['file'],$file_destination_path);

        if($file['thumbs'] && isset($file['thumbs'][0]) ){
            $w = $setting->options['image_width'];
            $h = $setting->options['image_height'];
            $thumb = $file['thumbs'][0];
            $thumb_name = 'settings/'.$file_name.'-'.$w.'x'.$h.'.'.$ext;
            FilesUploader::move($thumb,$thumb_name);
            return $thumb_name;
        }

        return $file;        
    }
}