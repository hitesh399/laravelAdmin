@extends('admin.layouts.front-panel')
@section('meta-title','Login')

@section('content')
{!!Form::open(['url'=>'admin','id'=>'sign_in'])!!}

<div class="msg">Sign in to start your session</div>
<div class="input-group {!!$errors->has('username')?'has-error':''!!}">
    <span class="input-group-addon">
        <i class="material-icons">person</i>
    </span>
    <div class="form-line">
        {!!Form::text('username',null,['class'=>'form-control','placeholder'=>'Username/Email','required','autofocus'])!!}
    </div>
    @if($errors->has('username'))
        <span class="help-inline with-errors">{!!$errors->first('username')!!}</span>
    @endif
</div>
<div class="input-group {!!$errors->has('password')?'has-error':''!!}">
    <span class="input-group-addon">
        <i class="material-icons">lock</i>
    </span>
    <div class="form-line">
    {!!Form::password('password',['class'=>'form-control','placeholder'=>'Password','required'])!!}
    </div>

     @if($errors->has('password'))
        <span class="help-inline with-errors">{!!$errors->first('password')!!}</span>
    @endif
</div>
<div class="row">
    <div class="col-xs-8 p-t-5">
        <input type="checkbox" name="remember" id="remember" class="filled-in chk-col-pink">
       {{--  {!!Form::checkbox('remember','Y',['class'=>'filled-in chk-col-pink','id'=>'remember'])!!} --}}
        <label for="remember">Remember Me</label>
    </div>
    <div class="col-xs-4">
        <button class="btn btn-block bg-pink waves-effect" type="submit">SIGN IN</button>
    </div>
</div>
<div class="row m-t-15 m-b--20">
    {{-- <div class="col-xs-6">
        <a href="">Register Now!</a>
    </div> --}}
    <div class="col-xs-6 align-right pull-right">
        <a href="{!!url('forgot-password')!!}">Forgot Password?</a>
    </div>
</div>
{!!Form::close()!!}

@endsection