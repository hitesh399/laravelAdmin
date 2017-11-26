<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">

	<head>
	    <meta charset="UTF-8">
	    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
	    <title>@yield('meta-title',config('app.name') )</title>
	    <!-- Favicon-->
	    <link rel="icon" href="{!! asset('assets/images/favicon.ico') !!}" type="image/x-icon">
	    <meta name="csrf-token" content="{{ csrf_token() }}">
	    <link href="{!! asset(mix('assets/admin/css/admin.base.min.css')) !!}" rel="stylesheet">    
	    @stack('css')

	    <script type="text/javascript">
	        window.site = {
	        	'site_url':'{!!url('/')!!}',
	        	'base_url':'{!!asset('/')!!}',
	        	'admin_url':'{!!url('/admin')!!}',
	        	'storage_url':'{!!App\Lib\GetData::storageUrl()!!}',
	        	'timezone':'{!!App\Lib\GetData::setting('APP_TIMEZONE')!!}',
	        	'date_format':'{!!App\Lib\GetData::setting('date_format')!!}',
	        	'time_format':'{!!App\Lib\GetData::setting('time_format')!!}',
	        	'datetime_format':'{!!App\Lib\GetData::setting('datetime_format')!!}',
	        };
	    </script>
	</head>
	<body class="theme-red">

		<!-- Page Loader -->
	    <div class="page-loader-wrapper">
	        <div class="loader">
	            <div class="preloader">
	                <div class="spinner-layer pl-red">
	                    <div class="circle-clipper left">
	                        <div class="circle"></div>
	                    </div>
	                    <div class="circle-clipper right">
	                        <div class="circle"></div>
	                    </div>
	                </div>
	            </div>
	            <p>Please wait...</p>
	        </div>
	    </div>
	    <!-- #END# Page Loader -->

	    <!-- Overlay For Sidebars -->
	    <div class="overlay"></div>
	    <!-- #END# Overlay For Sidebars -->

	    <!-- Search Bar -->
	    <div class="search-bar">
	        <div class="search-icon">
	            <i class="material-icons">search</i>
	        </div>
	        <input type="text" placeholder="START TYPING...">
	        <div class="close-search">
	            <i class="material-icons">close</i>
	        </div>
	    </div>
	    <!-- #END# Search Bar -->
	    <!-- Top Bar -->
	    <nav class="navbar">
	        <div class="container-fluid">
	            <div class="navbar-header">
	                <a href="javascript:void(0);" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar-collapse" aria-expanded="false"></a>
	                <a href="javascript:void(0);" class="bars"></a>
	                <a class="navbar-brand" href="../../index.html">ADMINBSB - MATERIAL DESIGN</a>
	            </div>
	            <div class="collapse navbar-collapse" id="navbar-collapse">
	                <ul class="nav navbar-nav navbar-right">
	                    <!-- Call Search -->
	                    <li><a href="javascript:void(0);" class="js-search" data-close="true"><i class="material-icons">search</i></a></li>
	                    <!-- #END# Call Search -->
	                    
	                    <!-- Notifications -->
	                    <li class="dropdown">
	                        <a href="javascript:void(0);" class="dropdown-toggle" data-toggle="dropdown" role="button">
	                            <i class="material-icons">notifications</i>
	                            <span class="label-count">7</span>
	                        </a>
	                        <ul class="dropdown-menu">
	                            <li class="header">NOTIFICATIONS</li>
	                            <li class="body">
	                                <ul class="menu">
	                                    <li>
	                                        <a href="javascript:void(0);">
	                                            <div class="icon-circle bg-light-green">
	                                                <i class="material-icons">person_add</i>
	                                            </div>
	                                            <div class="menu-info">
	                                                <h4>12 new members joined</h4>
	                                                <p>
	                                                    <i class="material-icons">access_time</i> 14 mins ago
	                                                </p>
	                                            </div>
	                                        </a>
	                                    </li>	                                    
	                                </ul>
	                            </li>
	                            <li class="footer">
	                                <a href="javascript:void(0);">View All Notifications</a>
	                            </li>
	                        </ul>
	                    </li>
	                    <!-- #END# Notifications -->
	                    
	                    <li class="pull-right"><a href="javascript:void(0);" class="js-right-sidebar" data-close="true"><i class="material-icons">more_vert</i></a></li>
	                </ul>
	            </div>
	        </div>
	    </nav>
	    <!-- #Top Bar -->

	    <section>
	        <!-- Left Sidebar -->
	        <aside id="leftsidebar" class="sidebar">
	            <!-- User Info -->
	            <div class="user-info">
	                <div class="image">
	                    <img src="{!! asset('assets/admin/images/user.png') !!}" width="48" height="48" alt="User" />
	                </div>
	                <div class="info-container">
	                    <div class="name" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">John Doe</div>
	                    <div class="email">john.doe@example.com</div>
	                    <div class="btn-group user-helper-dropdown">
	                        <i class="material-icons" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">keyboard_arrow_down</i>
	                        <ul class="dropdown-menu pull-right">
	                            <li><a href="javascript:void(0);"><i class="material-icons">person</i>Profile</a></li>
	                            <li role="seperator" class="divider"></li>
	                            <li role="seperator" class="divider"></li>
	                            <li><a href="javascript:void(0);"><i class="material-icons">input</i>Sign Out</a></li>
	                        </ul>
	                    </div>
	                </div>
	            </div>
	            <!-- #User Info -->
	            <!-- Menu -->
	            <div class="menu">
	                {!!$adminMenu->print()!!}

	            </div>
	            <!-- #Menu -->
	            <!-- Footer -->
	            <div class="legal">
	                <div class="copyright">
	                    &copy; {!!date('Y')!!} <a href="javascript:void(0);">{!!config('app.name')!!}</a>.
	                </div>
	                <div class="version">
	                    <b>Version: </b> 5.1
	                </div>
	            </div>
	            <!-- #Footer -->
	        </aside>
	        <!-- #END# Left Sidebar -->
	        <!-- Right Sidebar -->
	        	{{-- @include('admin.partials.settings') --}}
	        <!-- #END# Right Sidebar -->
	    </section>

	    <section class="content">
	        <div class="container-fluid">

	        	@if(Session::has('success'))
				<div class="alert alert-success alert-dismissible" role="alert">
				    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>
				   {!!Session::get('success')!!}
				</div>
				@endif

				@if(Session::has('info'))
				<div class="alert alert-info alert-dismissible" role="alert">
				    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>
				    {!!Session::get('info')!!}
				</div>
				@endif

				@if(Session::has('warning'))
				<div class="alert alert-warning alert-dismissible" role="alert">
				    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>
				    {!!Session::get('warning')!!}
				</div>
				@endif

				@if(Session::has('failed'))
				<div class="alert alert-danger alert-dismissible" role="alert">
				    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>
				    {!!Session::get('failed')!!}
				</div>
				@endif

				@if(Session::has('error'))
				<div class="alert alert-danger alert-dismissible" role="alert">
				    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>
				    {!!Session::get('error')!!}
				</div>
				@endif

	            @yield('content')
	        </div>
	    </section>

		<script src="{!! asset(mix('assets/admin/js/admin.base.min.js')) !!}"></script>
		<script type="text/javascript">
			
			$.ajaxSetup({
			    headers: {
			        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
			    }
			});
		</script>
		@stack('scripts')
	</body>
</html>