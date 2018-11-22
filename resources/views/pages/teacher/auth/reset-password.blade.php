@extends('layouts.teacher.application', ['noFrame' => true, 'bodyClasses' => ''])

@section('metadata')
@stop

@section('styles')
@stop

@section('scripts')
@stop

@section('title')
    @lang('teacher.pages.reset_password.page_title')
@stop

@section('header')
@stop

@section('content')
    @if(Session::has('status'))
        <div class="alert alert-success alert-dismissible">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
            <h4><i class="icon fa fa-check"></i>@lang('user.messages.general.success')</h4>
        </div>
    @endif
    <div class="contents">
        <form action="{!! action('Teacher\PasswordController@postResetPassword') !!}" method="post">
            {!! csrf_field() !!}
            <section>
                <h2 class="title-m cent">@lang('teacher.pages.reset_password.contents_input')</h2>
                <p class="cent em sp-btm">@lang('teacher.pages.reset_password.please_enter_new_password')</p>
                <table class="form-a">
                    <tr>
                        <th>@lang('teacher.pages.reset_password.email')</th>
                        <td><input type="email" name="email" placeholder="@lang('teacher.pages.reset_password.email')"
                                   class=" @if ($errors->has('email')) alert_outline @endif">
                            @if ($errors->has('email'))<p class="alert"> {!! $errors->first('email') !!}</p> @endif</td>
                    </tr>
                    <tr>
                        <th>@lang('teacher.pages.reset_password.password')</th>
                        <td><input type="password" name="password" placeholder="@lang('teacher.pages.reset_password.password')"
                                   class=" @if ($errors->has('password')) alert_outline @endif">
                            @if ($errors->has('password'))<p
                                    class="alert"> {!! $errors->first('password') !!}</p> @endif</td>
                    </tr>
                    <tr>
                        <th>@lang('teacher.pages.reset_password.password_confirm')</th>
                        <td><input type="password" class="form-control  @if ($errors->has('password_confirmation')) alert_outline @endif" name="password_confirmation">
                            @if ($errors->has('password_confirmation'))<p
                                    class="alert"> {!! $errors->first('password_confirmation') !!}</p> @endif</td>
                    </tr>
                    <input type="hidden" name="token" value="{{ $token }}">
                </table>
                <p><a  href="#" onclick="$(this).parents('form:first').submit(); return false;" class="btn-o">@lang('teacher.pages.reset_password.submit')</a></p>
            </section>
        </form>
    </div>
@stop
