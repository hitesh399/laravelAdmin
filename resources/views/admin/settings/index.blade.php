@extends('admin.layouts.admin-panel')

@section('content')

<!-- Multiple Items To Be Open -->
<div class="row clearfix">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">    

    <a href="javascript:void(0);" data-toggle="modal" data-target="#create-setting-modal" class="btn bg-red btn-circle-lg waves-effect waves-circle waves-float pull-right add-new-setting">
        <i class="material-icons">add</i>
    </a>

	    <div class="body">
			<h4>Website Settings</h4>
			<div class="panel-group" id="accordion_1" role="tablist" aria-multiselectable="true">
				@php $i = 0; @endphp
				@foreach($settings->groupBy('category') as $category=>$categories_setting)
					<div class="panel permission-panel">
						<!-- Panel Head -->
            			<div class="panel-heading role-heading" role="tab" id="permission_panel_admin{!!str_slug($category)!!}">
                            <h4 class="panel-title">
                                <a role="button" data-toggle="collapse" data-parent="#accordion_1" href="#collapseOne_admin{!!str_slug($category)!!}" aria-expanded="true" aria-controls="collapseOne_admin{!!str_slug($category)!!}">
                                    <i class="material-icons">perm_data_setting</i> 
                                    {!!title_case($category)!!}
                                    <small class="font-italic col-blue-grey">{!!$categories_setting->implode('title',', ')!!}</small>
                                </a>
                            </h4>
                        </div>
                        <!-- End Panel Head -->

                         <!-- Collapse Body -->
                        <div id="collapseOne_admin{!!str_slug($category)!!}" class="panel-collapse collapse {!!$i==0?'in':''!!}" role="tabpanel" aria-labelledby="permission_panel_admin{!!str_slug($category)!!}">
                        	<div class="panel-body">
                        		<div class="body table-responsive">
                        		<table class="table">
                    				<thead>
                    					<th>Name</th>
                    					<th>Value</th>
                    					<th>Action</th>
                    				</thead>
                    				<tbody>
                    					@foreach($categories_setting as $category_setting)
	                        				<tr>
	                        					<td>{!!$category_setting->title!!}</td>
      					<td>

<a href="javascript:;" data-source="{{$category_setting->dd_values}}" data-option="{{json_encode($category_setting->options)}}" data-type="{!!$category_setting->field_type!!}" data-name="{!!$category_setting->data_key!!}" data-url="{!!url('admin/setting/change/'.$category_setting->id)!!}" data-pk ="{!!$category_setting->id!!}" data-original-title="{!!$category_setting->title!!}" data-value="{{$category_setting->data}}" class="editable editable-empty"></a>
	                        					</td>
	                        					<td>
	                        						<a href="javascript:void(0);" data-id="{!!$category_setting->id!!}" class="delete-setting"><i class="material-icons">delete_forever</i></a>
	                        					</td>
	                        				</tr>
	                        			@endforeach
                    				</tbody>
                    			</table>	                        	
                        		</div>
                        	</div>
                        </div>
                        <!-- Collapse End-->
					</div>
					@php $i++ @endphp
				@endforeach
			</div>
	    </div>

    </div>
</div>     

<a href="javascript:void(0)" id="t1" onclick="return $.LaravelMedia.openModal(this)">Open Media</a>   


@endsection

@push('css')
    <link rel="stylesheet" type="text/css" href="{!!asset('assets/admin/css/bootstrap-editable.min.css')!!}">
    <link rel="stylesheet" type="text/css" href="{!!asset('assets/admin/css/bootstrap-tagsinput.css')!!}">
@endpush

@push('scripts')
<div class="modal fade" id="create-setting-modal" tabindex="-1" role="dialog">
<div class="modal-dialog" role="document">
    <div class="modal-content">
        <div class="modal-header">
            <h4 class="modal-title" id="defaultModalLabel">Create Setting</h4>
        </div>
        <div class="modal-body">
           {!!Form::open(['url'=>'admin/setting','method'=>'POST' ,'onSubmit'=>'return $.laravel.form.submit(this)','reset_form'=>'1'])!!}
				
				<div class="form-group form-float">                
					<div class="form-line">
					{!!Form::text('data_key',null,['class'=>'form-control','maxlength'=>50])!!}
					<label class="form-label" for="data_key">Data Key</label>
					</div>
				</div>
				<div class="form-group form-float">                
					<div class="form-line">
					{!!Form::text('title',null,['class'=>'form-control','maxlength'=>50])!!}
					<label class="form-label" for="title">Title</label>
					</div>
				</div>

				<div class="form-group form-float form-field-type "> 
	                <div class="form-line">
	                	{!!Form::select('field_type',
	                	[
	                		'Text'=>'Text',
	                		'Address'=>'Address',
	                		'Date'=>'Date',
	                		'Date Time'=>'Date Time',
	                		'Time'=>'Time',
	                		'Email'=>'Email',
	                		'Multiple Email'=>'Multiple Email',
	                		'Dropdown'=>'Dropdown',
	                		'Text Area'=>'Text Area',
	                		'Timezone'=>'Timezone',
	                		'File'=>'File'
	                	],null,['class'=>'form-control','placeholder'=>'Select Field Type','data-live-search'=>"true"])!!}
	                </div>
                </div>

				<div class="form-group form-float">                
					<div class="form-line">
					{!!Form::text('regex',null,['class'=>'form-control'])!!}
					<label class="form-label" for="regex">Regex</label>
					</div>
				</div>					

				<div class="form-group form-float "> 
	                <div class="form-line">
	                	{!!Form::select('storage_type',
	                	[
	                		'env'=>'ENV',
	                		'only_db'=>'Only Database',
	                	],null,['class'=>'form-control','maxlength'=>50,'placeholder'=>'Select Storage Type'])!!}
	                </div>
                </div>
                
                <div class="form-group form-float"> 
	                <div class="form-line">
	                	{!!Form::text('hints',null,['class'=>'form-control','maxlength'=>200])!!}
	                	<label class="form-label" for="hints">Hints</label>
	                </div>
                </div>

                <div class="form-group form-float"> 
	                <div class="form-line">
	                	{!!Form::text('category',null,['class'=>'form-control','maxlength'=>100])!!}
	                	<label class="form-label" for="category">Category</label>
	                </div>
                </div>                

                <button class="btn btn-primary waves-effect" type="submit">Create</button>
                <button type="button" class="btn btn-link waves-effect" data-dismiss="modal">Cancel</button>
            
           {!!Form::close()!!}
        </div>
        {{-- <div class="modal-footer">
            <button type="button" class="btn btn-link waves-effect">SAVE CHANGES</button>
            <button type="button" class="btn btn-link waves-effect" data-dismiss="modal">CLOSE</button>
        </div> --}}
    </div>


</div>
</div>

	<script type="text/javascript" src="{!!asset(mix('assets/admin/js/bootstrap-editable.min.js'))!!}"></script>
	{{-- <script type="text/javascript" src="{!!asset('assets/admin/js/multiple_email-input-editable.js')!!}"></script>
	<script type="text/javascript" src="{!!asset('assets/admin/js/address-input-editable.js')!!}"></script> --}}
	<script type="text/javascript" src="{!!asset('assets/admin/js/bootstrap-tagsinput.min.js')!!}"></script>
	<script type="text/javascript" src="{!!asset('assets/admin/js/media.js')!!}"></script>
	<script type="text/javascript" src="{!!asset('assets/admin/plugins/AdminBSB/js/file-input-editable.js')!!}"></script>

	<script type="text/javascript">
		
		$(function () {
    		$('select').selectpicker();

    		$('.delete-setting').click(function(){
    			var url = '{!!url('admin/setting/')!!}'+'/'+$(this).attr('data-id');
    			return $.laravel.form.delete($(this),url);
    		});

			$.fn.editable.defaults.mode = 'inline';
			try{
				$('.editable').editable({
					ajaxOptions: {
					type: 'PUT',
					dataType: 'json'

					},
					success: function(response, config) {
						if(!response.success){
						    return response.msg;
						}
					}
				});
			}
			catch(e){

				console.log(e);
			}

    		$('select[name="field_type"]').change(function(){

    			var _val = $(this).val();

    			if(_val =='Dropdown'){

    				var dropdown_option = '<div class="form-group form-float form-dropdown-values">'+
	                '<div class="form-line">'+
	                	'<input type="text" name="dropdown_values" class="form-control" />'+
	                	'<label class="form-label" for="dropdown_values">Enter JSON value</label>'+
	                '</div>'+
                	'</div>'+
                	'<div class="form-dropdown-type m-b-10">'+
	                '<div class="form-line ">'+
	                	'<input type="checkbox" name="dropdown_multi_select" class="chk-col-light-blue " id="dropdown_multi_select" />'+
	                	'<label class="form-label" for="dropdown_multi_select">Check it, if you want to choose muliple value for this field.</label>'+
	                '</div>'+
                	'</div>';

                	$(this).closest('.form-group').after(dropdown_option);	
    			}
    			else if(_val =='File'){

    				var file_option = '<div class="form-group form-float form-file_type">'+
	                '<div class="form-line">'+	                	
	                	'<select class="form-control" name="file_type">'+
	                		'<option value="any">Any</option>'+
	                		'<option value="image">Image</option>'+
	                		'<option value="pdf">PDF</option>'+
	                		'<option value="doc">Doc</option>'+
	                		'<option value="xlx">xlx</option>'+
	                		'<option value="csv">csv</option>'+
	                	'</select>'+	
	                '</div>'+
                	'</div>'+
                	'<div class="form-file_type_max_size">'+
	                '<div class="form-line ">'+
	                	'<div class="row clearfix">'+
						    '<div class="col-sm-6">'+
						        '<div class="form-group">'+
						            '<div class="form-line">'+
						                '<input type="text" class="form-control" name="file_max_size" placeholder="File Max Size in MB">'+
						            '</div>'+
						        '</div>'+
						    '</div>'+
						    '<div class="col-sm-6">'+
						        '<div class="form-group">'+
						            '<div class="form-line">'+
						                '<input type="text" class="form-control" name="file_min_size" placeholder="File Min Size in MB">'+
						            '</div>'+
						        '</div>'+
						    '</div>'+
						'</div>'+
	                '</div>'+
                	'</div>';

                	$(this).closest('.form-group').after(file_option);

    			}else{

    				$('body').find('.form-dropdown-values').remove();
    				$('body').find('.form-dropdown-type').remove();
    				$('body').find('.form-file_type').remove();
    				$('body').find('.form-file_type_max_size').remove();
    				$('body').find('.form-file_type_image_dimensions').remove();
    			}
    		});


    		$('#create-setting-modal').on('change','select[name=file_type]',function(){

    			var _val = $(this).val();

    			if(_val =='image'){

    				var image_dimensions = '<div class="form-file_type_image_dimensions">'+
	                '<div class="form-line ">'+
	                	'<div class="row clearfix">'+
						    '<div class="col-sm-6">'+
						        '<div class="form-group">'+
						            '<div class="form-line">'+
						                '<input type="text" class="form-control" name="image_width" placeholder="Image Width in PX">'+
						            '</div>'+
						        '</div>'+
						    '</div>'+
						    '<div class="col-sm-6">'+
						        '<div class="form-group">'+
						            '<div class="form-line">'+
						                '<input type="text" class="form-control" name="image_height" placeholder="Images Height in PX">'+
						            '</div>'+
						        '</div>'+
						    '</div>'+
						'</div>'+
	                '</div>'+
                	'</div>';	
                	$(this).closest('.form-group').after(image_dimensions);

    			}else{

    				$('body').find('.form-file_type_image_dimensions').remove();

    			}
    		});
    	});





	</script>
@endpush

