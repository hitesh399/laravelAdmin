@extends('admin.layouts.admin-panel')

@section('content')
	<div class="row clearfix">
	    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
	        <div class="card">
	            <div class="header">
	                <h2>
	                    Add New Role
	                    <small>Input the following detail to add a new role.</small>
	                </h2>
	               
	            </div>
	            <div class="body">
	            {!!Form::open(['url'=>'admin/role','method'=>'POST'])!!}

                    <div class="form-group form-float">
                        <div class="form-line {!!$errors->has('name')?'error':''!!}">
                        	{!!Form::text('name',null,['class'=>'form-control','maxlength'=>50])!!}
                        	<label class="form-label">Name</label>
                        </div>
                        
                        {!!$errors->first('name','<label id="name-error" class="error" for="name">:message</label>')!!}
                    </div>
                
                
                    <div class="form-group form-float">
                        <div class="form-line {!!$errors->has('title')?'error':''!!}">
                        	{!!Form::text('title',null,['class'=>'form-control','maxlength'=>200])!!}
                        	<label class="form-label">Title</label>
                        </div>
                        {!!$errors->first('title',' <label id="name-error" class="error" for="name">:message</label>')!!}
                    </div>
                
                    <div class="form-group form-float">
                        <div class="form-line {!!$errors->has('role_for')?'error':''!!}">
                        	{!!Form::select('role_for',['backend'=>'Backend','frontend'=>'Front-end'],null,['class'=>'form-control show-tick','placeholder'=>'Select Role For'])!!}
                        </div>
                        {!!$errors->first('role_for','<label id="name-error" class="error" for="name">:message</label>')!!}
                    </div>
                

                
                    <div class="form-group form-float">
                        <div class="form-line {!!$errors->has('landing_page')?'error':''!!}">
                       
                        {!!Form::select('landing_page',Config::get('admin.landing_page'),null,['class'=>'form-control show-tick','placeholder'=>'Select Landing Page'])!!}
                        </div>
                        {!!$errors->first('landing_page','<label id="name-error" class="error" for="name">:message</label>')!!}
                    </div>

	                <div class="form-group form-float">
                        <div class="form-line {!!$errors->has('description')?'error':''!!}">
                           
                            {!!Form::textarea('description',null,['class'=>"form-control no-resize auto-growth",'rows'=>'1','maxlength'=>'800','placeholder'=>'Explain about the Role'])!!}

                        </div>
                            {!!$errors->first('description','<label id="name-error" class="error" for="name">:message</label>')!!}
                    </div>

                    <button class="btn btn-primary waves-effect" type="submit">SUBMIT</button>

                    {!!Form::close()!!}
	            </div>
	        </div>
	    </div>
	</div>
@endsection

@push('scripts')
	<script type="text/javascript">
		
		$(function () {
    		autosize($('textarea.auto-growth'));
    		$('select').selectpicker();
    	});
	</script>
@endpush
