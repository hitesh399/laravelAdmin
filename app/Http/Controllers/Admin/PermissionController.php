<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Permission;

class PermissionController extends Controller
{
    //

    public function index()
    {

    	$permissions = Permission::all();
    	return view('admin.permissions.index',compact('permissions'));
    }

    public function update(Request $request,$id)
    {

    	$rule = $this->roles($request->name,$id);
    	
        if($rule){

            $validator = \Validator::make($request->all(),['value'=>$rule]);

            if($validator->fails()){
               
               return \Response::json(['success'=>false,'msg'=>$validator->errors()->first()]);
               
            }

            $value = $request->value;

            if($request->name =='description' && !$value)
                $value = '';

            Permission::find($id)->update([$request->name=>$value]);
            return \Response::json(['success'=>true,'msg'=>$request->name.' has been updated.']);
            

        }

        return \Response::json(['success'=>false,'msg'=>'The field rule is not found.']);

    }

    public function destroy(Request $request,$id)
    {
        Permission::find($id)->delete();
        return \Response::json(['status'=>'success','message'=>'Permission has been deleted successfully.']);
    }

    private  function roles($name=null,$id=null)
    {
        $rules = [
            'title'=>'required|string|max:200',
            'description'=>'max:800'
        ];

        if($name){

            if(isset($rules[$name])){
                return $rules[$name];
            }else{

                return null;
            }
        }

        return $rules;
    }
}
