@extends('admin.layouts.front-panel')
@section('meta-title','Forgot Password')
@section('body-class','fp-page')
@section('body-box-class','fp-box')

@section('content')

{!!Form::open(['url'=>'forgot-password','id'=>'forgot_password'])!!}
    <div class="msg">
        Enter your email address that you used to register. We'll send you an email with your account details and a
        link to reset your password.
    </div>
    <div class="input-group">
        <span class="input-group-addon">
            <i class="material-icons">email</i>
        </span>
        <div class="form-line">
        {!! Form::email('email',null,['class'=>'form-control','placeholder'=>'Email','required','autofocus']) !!}
        </div>
    </div>

    {!!Form::submit('Submit',['class'=>'tn btn-block btn-lg bg-pink waves-effect'])!!}

    <div class="row m-t-20 m-b--5 align-center">
        <a href="{!!url('admin/')!!}">Sign In!</a>
    </div>
{!!Form::close()!!}

@endsection