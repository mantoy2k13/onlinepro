@extends('layouts.user.application', ['noFrame' => false, 'bodyClasses' => '', 'mainClasses' => 'auth-page'])

@section('metadata')
@stop

@section('styles')
@stop

@section('scripts')
@stop

@section('title')
    @lang('user.pages.signup.page_title')
@stop

@section('header')
@stop

@section('content')
@section('breadcrumbs', Breadcrumbs::render('signup'))

<div class="content">

    @if (count($errors) > 0)
        <div class="alert alert-danger alert-dismissible">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    <div class="contents">
        <h2 class="title-m cent">@lang('user.pages.signup.content_input')</h2>
        <form action="{!! action('User\AuthController@postSignUp') !!}" method="post">
            {!! csrf_field() !!}
            <table class="form-a">
                <tbody>
                <tr>
                    <th>@lang('user.pages.signup.nick_name')<span class="required">(※)</span></th>
                    <td><input type="text" value="{{ old('name') ? old('name') : '' }}"
                               name="name" class=" @if ($errors->has('name')) alert_outline @endif">
                        @if ($errors->has('name'))<p class="alert"> {!! $errors->first('name') !!}</p> @endif
                    </td>
                </tr>
                <tr>
                    <th>@lang('user.pages.signup.email')<span class="required">(※)</span></th>
                    <td><input type="text" class=" @if ($errors->has('email')) alert_outline @endif"
                               name="email" value="{{ old('email') ? old('email') : '' }}">
                        @if ($errors->has('email'))<p class="alert"> {!! $errors->first('email') !!}</p> @endif
                    </td>
                </tr>
                <tr>
                    <th>@lang('user.pages.signup.password')<span class="required">(※)</span></th>
                    <td><input type="password" class=" @if ($errors->has('password')) alert_outline @endif"
                               name="password" value="{{ old('password') ? old('password') : '' }}">
                        @if ($errors->has('password'))<p class="alert"> {!! $errors->first('password') !!} </p>@endif
                    </td>
                </tr>
                <tr>
                    <th>@lang('user.pages.signup.password_confirm')<span class="required">(※)</span></th>
                    <td><input type="password" class=" @if ($errors->has('password_confirmation')) alert_outline @endif"
                               name="password_confirmation">
                        @if ($errors->has('password_confirmation'))<p
                                class="alert">{!! $errors->first('password_confirmation') !!}</p> @endif
                    </td>
                </tr>
                <tr>
                    <th>@lang('user.pages.signup.skype_id')<span class="required">(※)</span></th>
                    <td><input type="text" name="skype_id" value="{{ old('skype_id') ? old('skype_id') : '' }}">
                        @if ($errors->has('skype_id'))<p
                                class="alert">{!! $errors->first('skype_id') !!}</p> @endif
                    </td>
                </tr>
                </tbody>
            </table>
            <p class="cent">
                <input type="checkbox" name="accept_terms_and_privacy_policy" value="@lang('user.pages.signup.input_value_agree_term_privacy')" checked
                       id="checkcontent"/>
                <label for="checkcontent" class="checkbox">
                    <a href="{{ action('User\StaticPageController@terms') }}">@lang('user.pages.signup.term_of_service')</a>@lang('user.pages.signup.and')
                    <a href="{{ action('User\StaticPageController@privacy') }}">@lang('user.pages.signup.privacy_policy')</a>@lang('user.pages.signup.term_privacy_agree')</label>
            </p>
            <p><a href="#" onclick="$(this).parents('form:first').submit(); return false;"
                  class="btn-o">@lang('user.pages.signup.submit')</a></p>
        </form>
    </div>
</div>
@stop
