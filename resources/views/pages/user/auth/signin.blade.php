@extends('layouts.user.application', ['noFrame' => false, 'bodyClasses' => '', 'mainClasses' => 'auth-page'])

@section('metadata')
@stop

@section('styles')
@stop

@section('scripts')
@stop

@section('title')
    @lang('user.pages.signin.page_title')
@stop

@section('header')
@stop

@section('content')
@section('breadcrumbs', Breadcrumbs::render('signin'))

<div class="contents">

    @include('layouts.user.messagebox')
    <section>

        <form action="{!! action('User\AuthController@postSignIn') !!}" method="post">
            {!! csrf_field() !!}
            <table class="form-a">
                <tr>
                    <th>@lang('user.pages.signin.email')</th>
                    <td><input type="text" name="email" placeholder="Email address">
                        @if ($errors->has('email'))<p class="alert">{!! $errors->first('email') !!}</p> @endif
                    </td>
                <tr>
                    <th>@lang('user.pages.signin.password')</th>
                    <td>
                        <input type="password" name="password" placeholder="Password">
                        @if ($errors->has('password'))<p class="alert">{!! $errors->first('password') !!}</p> @endif
                    </td>
                </tr>
            </table>
            <p class="cent">※@lang('user.pages.signin.forgot_password')
                <a href="{{ action('User\PasswordController@getForgotPassword') }}">@lang('user.pages.signin.click_here')</a>@lang('user.pages.signin.from')</p>
            <p><a href="#" class="btn-o" onclick="$(this).parents('form:first').submit(); return false;">@lang('user.pages.auth.buttons.sign_in')</a></p>
            <dl class="account-regist">
                <dt class="em cent">@lang('user.pages.signin.do_not_have_an_account')</dt>
                <dd><a href="{{ action('User\AuthController@getSignUp') }}" class="btn-g">@lang('user.pages.signin.register_link')</a></dd>
            </dl>
            <ul class="signup-social">
                <li><a href="{{ action('User\FacebookServiceAuthController@redirect') }}" class="btn_facebook op"><span>@lang('user.pages.signin.facebook_login')</span></a></li>
                <li><a href="{{ action('User\GoogleServiceAuthController@redirect') }}" class="btn_google op"><span>@lang('user.pages.signin.google_login')</span></a></li>
            </ul>

        </form>

        <br>
    </section>
</div>


@stop
