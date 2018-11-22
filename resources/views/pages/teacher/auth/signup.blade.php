@extends('layouts.teacher.application', ['noFrame' => true, 'bodyClasses' => ''])

@section('metadata')
@stop

@section('styles')
@stop

@section('scripts')
@stop

@section('title')
    Sign In
@stop

@section('header')
    Sign In
@stop

@section('content')
    <form action="{!! action('Teacher\AuthController@postSignUp') !!}" method="post">
        {!! csrf_field() !!}
        <input type="email" name="email" placeholder="@lang('teacher.pages.auth.messages.email')">
        @if ($errors->has('email'))<p class="alert" >{!! $errors->first('email') !!}</p> @endif
        <input type="password" name="password" placeholder="@lang('teacher.pages.auth.messages.password')">
        @if ($errors->has('password'))<p class="alert" >{!! $errors->first('password') !!}</p> @endif
        <input type="checkbox" name="remember_me" value="1"> @lang('teacher.pages.auth.messages.remember_me')
        <button type="submit">@lang('teacher.pages.auth.buttons.sign_up')</button>
    </form>
    <br>
@stop
