@extends('layouts.teacher.application', ['noFrame' => true, 'bodyClasses' => ''])

@section('metadata')
@stop

@section('styles')
@stop

@section('scripts')
@stop

@section('title')
    @lang('teacher.pages.forgot_password.page_title')
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
        <section>
            <p class="cent em sp-btm">@lang('teacher.pages.forgot_password.enter_email_message')</p>
            <form action="{!! action('Teacher\PasswordController@postForgotPassword') !!}" method="post">
                <table class="form-a">
                    {!! csrf_field() !!}
                    <tr>
                        <th>@lang('teacher.pages.forgot_password.email')</th>
                        <td><input type="email" name="email" placeholder="@lang('teacher.pages.forgot_password.email')"></td>

                </table>
                <p><a href="#" onclick="$(this).parents('form:first').submit(); return false;"
                      class="btn-o">@lang('teacher.pages.forgot_password.forgot_password_button')</a></p>
            </form>
        </section>
    </div>
@stop
