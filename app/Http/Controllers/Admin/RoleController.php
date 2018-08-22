<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Role;
use App\Models\Permission;

class RoleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $landing_page = \Config::get('admin.landing_page');
        $roles = Role::with('permissions')->get();
        $permissions = Permission::all();
        return view('admin.roles.index',compact('roles','permissions','landing_page'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        return view('admin.roles.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
        $this->validate($request,$this->roles());
        $data = $request->only(['name','title','role_for','landing_page','description']);
        $data['description'] = $data['description']?$data['description']:'';        
        Role::create($data);
        return redirect('admin/role')->with('success','Role has been created successfully.');
    }

    /**
     * Assign the permission to the selected role.
     * @param  \Illuminate\Http\Request  $request
     * @param int $id - Roleid
     * @return \Illuminate\Http\Response
     */
    public function assignPermission(Request $request,$id)
    {

        $role = Role::find($id);
        $data = $role->permissions()->sync($request->allow_permissions);

        \Cache::forget('role_access.'.$id);
        $permissions_name = [];

        if(!empty($request->allow_permissions)){

            $permissions_name = Permission::whereIn('id',$request->allow_permissions)->select('name')->pluck('name')->toArray();
        }


        \Cache::forever('role_access.'.$id, $permissions_name);
        
        return \Response::json(['status'=>'success','message'=>'Permission has been assigned successfully.','data'=>$data]);
    }

    
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
        $rule = $this->roles($request->name,$id);
        if($rule){

            $validator = \Validator::make($request->all(),['value'=>$rule]);

            if($validator->fails()){
               
               return \Response::json(['success'=>false,'msg'=>$validator->errors()->first()]);
               
            }

            $value = $request->value;

            if($request->name =='description' && !$value)
                $value = '';

            Role::find($id)->update([$request->name=>$value]);
            return \Response::json(['success'=>true,'msg'=>$request->name.' has been updated.']);
            

        }

        return \Response::json(['success'=>false,'msg'=>'The field rule is not found.']);
    }

    private  function roles($name=null,$id=null)
    {
        $rules = [
            'name'=>'required|string|max:50|unique:roles,name|regex:/^[a-z]+[a-z0-9\-]+$/',
            'title'=>'required|string|max:50',
            'role_for'=>'required:in:backend,frontend',
            'landing_page'=>'required|max:200',
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
