@extends('admin.layouts.admin-panel')

@section('content')

<!-- Multiple Items To Be Open -->
<div class="row clearfix">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">                    
        <div class="body">
            	<h4>Admin Panel Permissions</h4>
            	<div class="panel-group" id="accordion_1" role="tablist" aria-multiselectable="true">
                @php $i = 0; @endphp
            	@foreach($permissions->where('prefix','admin')->groupBy('section') as $section => $permission)

            		<div class="panel permission-panel">
            			
            			<!-- Panel Head -->
            			<div class="panel-heading role-heading" role="tab" id="permission_panel_admin{!!$section!!}">
                            <h4 class="panel-title">
                                <a role="button" data-toggle="collapse" data-parent="#accordion_1" href="#collapseOne_admin{!!$section!!}" aria-expanded="true" aria-controls="collapseOne_admin{!!$section!!}">
                                    <i class="material-icons">lock_outline</i> 
                                    {!!title_case($section)!!}
                                    <small>Admin Panel</small>
                                </a>
                            </h4>
                        </div>
                        <!-- End Panel Head -->

                        <!-- Collapse Body -->
                        <div id="collapseOne_admin{!!$section!!}" class="panel-collapse collapse {!!$i==0?'in':''!!}" role="tabpanel" aria-labelledby="permission_panel_admin{!!$section!!}">

                        	<div class="body table-responsive">
                        		<table class="table table-hover">
                    				<thead>
                    					<th>Name</th>
                    					<th>Title</th>
                    					<th>Descriptions</th>
                    					<th>Action</th>
                    				</thead>
                    				<tbody>
                        		@foreach($permission as $pl)
                        			<tr>
                        				<td>{!!$pl->name!!}</td>
                        				<td>
<a href="javascript:;" data-type="text" data-name="title" data-url="{!!url('admin/permission/'.$pl->id)!!}" data-pk ="{!!$pl->id!!}" data-original-title="Enter Title" class="editable editable-empty">{!!$pl->title!!}</a>                        				

                        				</td>
                        				<td>
<a href="javascript:;" data-type="textarea" data-name="description" data-url="{!!url('admin/permission/'.$pl->id)!!}" data-pk ="{!!$pl->id!!}" data-original-title="Enter Desciption" class="editable editable-empty">{!!$pl->description!!}</a>
                        				</td>
                        				<td><a href="javascript:;" data-id="{!!$pl->id!!}" class="delete-permission"><i class="material-icons">delete_forever</i></a></td>
                        			</tr>
                        				
                        		@endforeach
                        			</tbody>
                        		</table>
                        	</div>

                        </div>
                        <!-- ENd collapse Body -->

            		</div>                       	
                        	
                      @php $i++ @endphp  	
                @endforeach
                </div> 


    <!-- Front-end Permission -->

    			<h4>Frontend Permissions</h4>
            	<div class="panel-group" id="accordion_2" role="tablist" aria-multiselectable="true">
            	@foreach($permissions->whereNotIn('prefix',['admin'])->groupBy('section') as $section => $permission)
            		<div class="panel permission-panel">
            			
            			<!-- Panel Head -->
            			<div class="panel-heading role-heading" role="tab" id="permission_panel_front_end{!!$section!!}">
                            <h4 class="panel-title">
                                <a role="button" data-toggle="collapse" data-parent="#accordion_2" href="#collapseOne_front_end{!!$section!!}" aria-expanded="true" aria-controls="collapseOne_front_end{!!$section!!}">
                                    <i class="material-icons">lock_outline</i> 
                                    {!!title_case($section)!!}
                                    <small>Front-end</small>
                                </a>
                            </h4>
                        </div>
                        <!-- End Panel Head -->

                        <!-- Collapse Body -->
                        <div id="collapseOne_front_end{!!$section!!}" class="panel-collapse collapse" role="tabpanel" aria-labelledby="permission_panel_front_end{!!$section!!}">

                        	<div class="body table-responsive">
                        		<table class="table table-hover">
                    				<thead>
                    					<th>Name</th>
                    					<th>Title</th>
                    					<th>Descriptions</th>
                    					<th>Action</th>
                    				</thead>
                    				<tbody>
                        		@foreach($permission as $pl)
                        			<tr>
                        				<td>{!!$pl->name!!}</td>
                        				<td>
<a href="javascript:;" data-type="text" data-name="title" data-url="{!!url('admin/permission/'.$pl->id)!!}" data-pk ="{!!$pl->id!!}" data-original-title="Enter Title" class="editable editable-empty">{!!$pl->title!!}</a>                        				

                        				</td>
                        				<td>
<a href="javascript:;" data-type="textarea" data-name="description" data-url="{!!url('admin/permission/'.$pl->id)!!}" data-pk ="{!!$pl->id!!}" data-original-title="Enter Desciption" class="editable editable-empty">{!!$pl->description!!}</a>
                        				</td>
                        				<td><i class="material-icons">delete_forever</i></td>
                        			</tr>
                        				
                        		@endforeach
                        			</tbody>
                        		</table>
                        	</div>

                        </div>
                        <!-- ENd collapse Body -->

            		</div>                       	
                        	
                        	
                @endforeach
                </div> 
    <!-- End front-end permission list -->



        </div>
    </div>
</div>

@endsection
@push('css')
    <link rel="stylesheet" type="text/css" href="{!!asset('assets/admin/css/bootstrap-editable.min.css')!!}">
@endpush

@push('scripts')
<script type="text/javascript" src="{!!asset('assets/admin/js/bootstrap-editable.min.js')!!}"></script>
	<script type="text/javascript">
     var t;

     $(document).ready(function(){

        $.fn.editable.defaults.mode = 'inline';
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


        $('.delete-permission').click(function(){

          var url = '{!!url('admin/permission/')!!}'+'/'+$(this).attr('data-id');
          return $.laravel.form.delete($(this),url);

       });


     });

     </script>
  @endpush
       