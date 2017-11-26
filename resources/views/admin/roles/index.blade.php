@extends('admin.layouts.admin-panel')

@section('content')

<!-- Multiple Items To Be Open -->
<div class="row clearfix">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">                    
        <div class="body">
            <div class="row clearfix">
                <div class="col-xs-12 ol-sm-12 col-md-12 col-lg-12">
                <a href="{!!url('admin/role/create')!!}" class="btn bg-red btn-circle-lg waves-effect waves-circle waves-float pull-right ">
                    <i class="material-icons">add</i>
                </a>
                @php $i = 0; @endphp
                @if($roles && $roles->isEmpty())
                    <label>No Role Found.</label>
                @endif
                    <div class="panel-group full-body" id="accordion_19" role="tablist" aria-multiselectable="true">
                    @foreach($roles as $role)
                        <div class="panel role-panel">
                            <div class="panel-heading role-heading" role="tab" id="role_panel_{!!$role->id!!}">
                                <h4 class="panel-title">
                                    <a role="button" data-toggle="collapse" data-parent="#accordion_19" href="#collapseOne_{!!$role->id!!}" aria-expanded="true" aria-controls="collapseOne_{!!$role->id!!}">
                                        <i class="material-icons">settings_input_composite</i> 
                                        {!!$role->title!!}
                                        <small>Total Assigned Permissions (<span class="total">{!!$role->permissions->count()!!}</span>)</small>
                                        <small>{!! ucfirst($role->role_for)!!}</small>
                                    </a>
                                </h4>
                            </div>
                            <div id="collapseOne_{!!$role->id!!}" class="panel-collapse collapse {!!$i==0?'in':''!!}" role="tabpanel" aria-labelledby="role_panel_{!!$role->id!!}">
                                <div class="panel-body">
                                    
                                    {!!Form::open(['url'=>'admin/role/'.$role->id.'/assign-permission','method'=>'PUT','class'=>'permission-assign-form'])!!}
                                    <div class="col-md-12">
                                      <div class="body table-responsive">
                                            <table class="table table-bordered">
                                              <thead>
                                                  <tr>
                                                    <th>Title</th>
                                                    <th>Description</th>
                                                    <th>Landing Page</th>
                                                     <th>Role For</th>
                                                  </tr>
                                              </thead>
                                              <tbody>
                                                  <tr>
                                                    <td>
<a href="javascript:;" data-type="text" data-name="title" data-url="{!!url('admin/role/'.$role->id)!!}" data-pk ="{!!$role->id!!}" data-original-title="Enter Role Title" class="editable editable-empty role-title" data-toggle="null">
                                                        {!!$role->title!!}
                                                      </a>  
                                                    </td>
                                                    <td>
<a href="javascript:;" data-type="textarea" data-name="description" data-url="{!!url('admin/role/'.$role->id)!!}" data-pk ="{!!$role->id!!}" data-original-title="Enter Role description" class="editable editable-empty" data-toggle="null">{!!$role->description!!}</a> 
                                                    </td>
                                                   
                                                     <td>
<a href="javascript:;" data-type="select" data-name="landing_page" data-url="{!!url('admin/role/'.$role->id)!!}" data-source="{{json_encode($landing_page)}}" data-value="{!!$role->landing_page!!}" data-pk ="{!!$role->id!!}" data-original-title="Select Landing Page" class="editable editable-empty role-landing-page" data-toggle="null">
                                                     {!!isset($landing_page[$role->landing_page])?$landing_page[$role->landing_page]:null!!}
</a>
                                                     </td>
                                                    <td>
<a href="javascript:;" data-type="select" data-name="landing_page" data-url="{!!url('admin/role/'.$role->id)!!}" data-source="{'backend':'Backend','frontend':'Front-end'}" data-value="{!!$role->role_for!!}" data-pk ="{!!$role->id!!}" data-original-title="Select Role For" class="editable editable-empty role-landing-page" data-toggle="null">{!!$role->role_for!!}</a>


                                                    </td>
                                                  </tr>
                                              </tbody>
                                            </table>
                                      </div>
		                            </div>
                                    <div class="col-md-12 m-b-10">
                                        <p class="font-bold col-blue-grey">Permissions List</p>
                                        <button class="btn btn-primary waves-effect pull-right" type="submit">Update Permissions</button>
                                    </div>   
                                    @php 
                                        $permissions = ($role->role_for=='backend')?$permissions->where('prefix','admin'):$permissions->whereNotIn('prefix',['admin']);
                                    @endphp 
                                    @foreach($permissions->groupBy('section') as $section =>$pl)
                                        @include('admin.roles.permission-list')
                                    @endforeach
                                    <div class="col-md-12 m-t-10">
                                    <button class="btn btn-primary waves-effect pull-right" type="submit">Update Permissions</button>
                                    </div>
                                    {!!Form::close()!!}
                                </div>
                            </div>
                        </div>
                         @php $i++; @endphp
                    @endforeach

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- #END# Multiple Items To Be Open -->

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

        $('.role_permissions_group_collapse').on('hide.bs.collapse', function () {
          $(this).prev().find('.material-icons').text('add');
        });


        $('.role_permissions_group_collapse').on('show.bs.collapse', function () {
            $(this).prev().find('.material-icons').text('remove');
        });

        $('input[type=checkbox][name="role_permissions_group[]"]').click(function(){

            if($(this).is(':checked')){

                $(this).closest('.dropdown').next().find('input[type=checkbox]').prop('checked',true);
            }else{

                $(this).closest('.dropdown').next().find('input[type=checkbox]').prop('checked',false);
            }
            var checked_item_length = $(this).closest('.dropdown').next().find('input[type=checkbox]:checked').length;
            var total_role_permission = $(this).closest('.role-panel').find('input[type=checkbox].allow_permissions:checked').length;

                 $(this).closest('.role-panel').find('.role-heading .total').text(total_role_permission);
            $(this).closest('.dropdown').find('.assigned').text(checked_item_length);
        });


        $('.allow_permissions').click(function(){
            
            var no_of_items = $(this).closest('.list-group').attr('data-length');
            no_of_items = parseInt(no_of_items);
            

                var checked_item_length = $(this).closest('.list-group').find('input[type=checkbox]:checked').length;
                checked_item_length = parseInt(checked_item_length);
               
                if(checked_item_length == no_of_items){
                    console.log($(this).closest('.list-group').prev().find('input[type=checkbox]').length);
                     $(this).closest('.collapse').prev().find('input[type=checkbox]').prop('checked',true);
                }else{

                     $(this).closest('.collapse').prev().find('input[type=checkbox]').prop('checked',false);
                }

                 var total_role_permission = $(this).closest('.role-panel').find('input[type=checkbox].allow_permissions:checked').length;

                 $(this).closest('.role-panel').find('.role-heading .total').text(total_role_permission);
                $(this).closest('.collapse').prev().find('.assigned').text(checked_item_length);

        });


     });

     $('.permission-assign-form').submit(function(){
        var _this = $(this);
        
        _this.closest('.role-panel').waitMe({
            effect : 'pulse'
        });
        var data = _this.serialize();
        var method = _this.attr('method');
        var url = _this.attr('action');
        $.ajax({
            url: url,
            dataType: 'json',
            type: method,
            data: data,
            processData: false,
            success: function( data, textStatus, jQxhr ){
                 _this.closest('.role-panel').waitMe('hide');
                //console.log(data);
                if(data.status =='success'){

                    var message = data.message+' Attached Permissions: '+data.data.attached.length+', Detached Permissions: '+Object.keys(data.data.detached).length;
                    $.notify({
                        // options
                        message: message
                    },{
                        // settings
                        type: 'success',
                        placement: {
                            from: "top",
                            align: "right"
                        },
                        animate: {
                            enter: 'animated zoomInRight',
                            exit: 'animated zoomOutRight'
                        },
                    });
                }
            },
            error: function( jqXhr, textStatus, errorThrown ){
                _this.closest('.role-panel').waitMe('hide');
            }
        });
        return false;
     });

    </script>
@endpush
