@extends('admin.layouts.admin-panel')

@section('content')
	<div class="row clearfix">
	    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
	        <div class="card">
	            <div class="header">
	                <h2>
	                    Email Template List
	                    <small>Email Template</small>
	                </h2>	               
	            </div>
	            <div class="body">
	            
	            	 <div class="table-responsive">
	            	    {!! $dataTable->table(['class'=>'table table-bordered table-striped table-hover js-basic-example dataTable']) !!}
	            	   </div>
	            </div>
	        </div>
	    </div>
	</div>
@endsection
@push('css')
    <link rel="stylesheet" type="text/css" href="{!!asset('assets/admin/css/jquery.dataTables.min.css')!!}">
@endpush

@push('scripts')
	<script type="text/javascript" src="{!!asset('assets/admin/js/jquery.dataTables.min.js')!!}"></script>
	<script type="text/javascript" src="{!!asset('vendor/datatables/buttons.server-side.js')!!}"></script>
	{!! $dataTable->scripts() !!} 

	<script type="text/javascript">
		
		$('.table').on('click','.delete_datatable_row',function(){

			var _this = $(this);
			var url = _this.attr('href');
			return $.laravel.form.delete(_this,url,{
				'datatable':window.LaravelDataTables["dataTableBuilder"],
			});
		});
	</script>
@endpush