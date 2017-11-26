@extends('admin.layouts.admin-panel')

@section('content')
	<div class="row clearfix">
	    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
	        <div class="card">
	            <div class="header">
	                <h2>
	                    Update Email Template
	                    <small>Fill the following detail to update Email template.</small>
	                </h2>	               
	            </div>
	            <div class="body">
	            	{!!Form::model($email_template,['url'=>'admin/email-template/'.$email_template->id,'method'=>'POST'])!!}
	            		{!!Form::hidden('_method', 'PUT');!!}
		            	<div class="form-group form-float">
	                        <div class="form-line {!!$errors->has('name')?'error':''!!}">
	                        	{!!Form::text('name',null,['class'=>'form-control','maxlength'=>150])!!}
	                        	<label class="form-label">Name</label>
	                        </div>
	                        
	                        {!!$errors->first('name','<label id="name-error" class="error" for="name">:message</label>')!!}
	                    </div>

		                <div class="form-group form-float">
	                        <div class="form-line {!!$errors->has('subject')?'error':''!!}">
	                        	{!!Form::text('subject',null,['class'=>'form-control','maxlength'=>500])!!}
	                        	<label class="form-label">Subject</label>
	                        </div>
	                        {!!$errors->first('subject',' <label id="name-error" class="error" for="name">:message</label>')!!}
	                    </div>

	                    <div class="form-group form-float">
	                        <div class="form-line {!!$errors->has('cc')?'error':''!!}">
	                        	{!!Form::text('cc',null,['class'=>'form-control','maxlength'=>500])!!}
	                        	<label class="form-label">cc</label>
	                        </div>
	                        {!!$errors->first('cc',' <label id="name-error" class="error" for="name">:message</label>')!!}
	                    </div>

	                    <div class="form-group form-float">
	                        <div class="form-line {!!$errors->has('bcc')?'error':''!!}">
	                        	{!!Form::text('bcc',null,['class'=>'form-control','maxlength'=>500])!!}
	                        	<label class="form-label">bcc</label>
	                        </div>
	                        {!!$errors->first('bcc',' <label id="name-error" class="error" for="name">:message</label>')!!}
	                    </div>

	                    <div class="form-group form-float">
	                    	<label class="form-label">Email Body</label>
	                        <div class="form-line {!!$errors->has('body')?'error':''!!}">
	                           
	                            {!!Form::textarea('body',null,['class'=>"form-control no-resize auto-growth",'id'=>'body','rows'=>'1','placeholder'=>'Email Body'])!!}

	                        </div>
	                        {!!$errors->first('body','<label id="name-error" class="error" for="name">:message</label>')!!}
	                    </div>

	                    <button class="btn btn-primary waves-effect" type="submit">Update</button>

	            	{!!Form::close()!!}
	            </div>
	        </div>
	    </div>
	</div>
@endsection
@push('css')
    <link rel="stylesheet" type="text/css" href="{!!asset('assets/admin/css/codemirror.min.css')!!}">
@endpush

@push('scripts')
	<script type="text/javascript" src="{!!asset('assets/admin/js/codemirror.min.js')!!}"></script>
	<script type="text/javascript">
		
		 var editor = CodeMirror.fromTextArea(document.getElementById("body"), {
		    lineNumbers: true,
		    styleActiveLine: true,
		    matchBrackets: true,
		    theme:'hopscotch',
		  });

	</script>
@endpush