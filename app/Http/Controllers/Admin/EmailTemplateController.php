<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\EmailTemplate;
use Cache;
use App\DataTables\EmailTemplateDataTable;

class EmailTemplateController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(EmailTemplateDataTable $dataTable)
    {
        
        return $dataTable->render('admin.email_templates.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        return view('admin.email_templates.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        
        $this->validate($request,[
            'name'=>'required|unique:email_templates|max:150|regex:/^[0-9\-\_a-z\.]+$/i',
            'subject'=>'required|max:500',
            'cc'=>'max:500',
            'bcc'=>'max:500',
            'body'=>'required',
        ]);

        $data = $request->only(['name','subject','cc','bcc','body']);
        $email_template = EmailTemplate::create($data);

        $email_template->subject = \Blade::compileString($email_template->subject);   
        $email_template->body = str_replace("\r\n","<br>",\Blade::compileString($email_template->body));   

        Cache::forever('email_template.'.$email_template->name, $email_template->toArray());
        return redirect('admin/email-template')->with('success','Email Template has been created successfully.');
    }



    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $email_template = EmailTemplate::find($id);
        return view('admin.email_templates.edit',compact('email_template'));
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
        $this->validate($request,[
            'name'=>'required|unique:email_templates,name,'.$id.',id|max:150|regex:/^[0-9\-\_a-z\.]+$/i',
            'subject'=>'required|max:500',
            'cc'=>'max:500',
            'bcc'=>'max:500',
            'body'=>'required',
        ]);

        $data = $request->only(['name','subject','cc','bcc','body']);
        $email_template = EmailTemplate::find($id);

        $email_template->update($data);
        $email_template->subject = \Blade::compileString($email_template->subject);   
        $email_template->body = str_replace("\r\n","<br>",\Blade::compileString($email_template->body));   

        Cache::forget('email_template.'.$email_template->name);
        Cache::forever('email_template.'.$email_template->name, $email_template->toArray());

        return redirect('admin/email-template')->with('success','Email Template has been updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $email_template = EmailTemplate::find($id);
        $email_template->delete();
        Cache::forget('email_template.'.$email_template->name);
        return \Response::json(['status'=>'success','message'=>'Email Template has been deleted successfully.']);
    }
}
