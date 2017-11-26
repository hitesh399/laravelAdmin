<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">

<head>
    <meta charset="UTF-8">
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <title>@yield('meta-title',config('app.name') )</title>
    <!-- Favicon-->
    <link rel="icon" href="{!! asset('assets/images/favicon.ico') !!}" type="image/x-icon"> 
    <link href="{!! asset('assets/admin/css/admin_login.base.min.css') !!}" rel="stylesheet">    
    @stack('css')

     <script type="text/javascript">
            window.site = {
                'site_url':'{!!url('/')!!}',
                'base_url':'{!!asset('/')!!}',
                'admin_url':'{!!url('/admin')!!}',
                'timezone':'{!!Cache::get('settings.APP_TIMEZONE')!!}'
            };
        </script>

</head>

<body class="@yield('body-class','login-page')">
    <div class="@yield('body-box-class','login-box')">
        <div class="logo">
            <a href="javascript:void(0);">{!!config('app.name')!!}</a>
            <small>Admin BootStrap Based - Material Design</small>
        </div>
        <div class="card">
            <div class="body">
                @yield('content')
            </div>
        </div>
    </div>

<script src="{!! asset('assets/admin/js/admin_login.base.min.js') !!}"></script>


@stack('scripts')
    
</body>

</html>