@extends('layouts.teacher.application', ['noFrame' => true, 'bodyClasses' => ''])

@section('metadata')
@stop

@section('styles')
@stop

@section('scripts')
@stop

@section('title')
    @lang('teacher.pages.signin.page_title')
@stop

@section('header')
@stop

@section('content')

    <?php if(Session::has('message-failed')): ?>
    <div class="alert alert-danger alert-dismissible">
        <h4><i class="icon fa fa-check"></i> @lang('user.messages.general.failed')</h4>
        <?php echo e(Session::get('message-failed')); ?>

    </div>
    <?php endif; ?>
    <div class="contents">

        <form action="{!! action('Teacher\AuthController@postSignIn') !!}" method="post">
            <section>
                <table class="form-a">
                    {!! csrf_field() !!}
                    <tr>
                        <th>@lang('teacher.pages.signin.email')</th>
                        <td><input type="text" name="email" placeholder="@lang('teacher.pages.signin.email')">
                            @if ($errors->has('email'))<p class="alert">{!! $errors->first('email') !!}</p> @endif
                        </td>
                    </tr>
                    <tr>
                        <th>@lang('teacher.pages.signin.password')</th>
                        <td><input style="width: 100%" type="password" name="password" placeholder="@lang('teacher.pages.signin.password')">
                            @if ($errors->has('password'))<p class="alert">{!! $errors->first('password') !!}</p> @endif
                        </td>
                    </tr>
                    <tr>
                        <td></td>
                        <td><input type="checkbox" name="remember_me" id="checkcontent" value="1">
                            <label for="checkcontent" class="checkbox">@lang('teacher.pages.signin.keep_signin')</label>
                            <label style="padding: 3px; display:inline-block"><a
                                        href="{!! action('Teacher\PasswordController@getForgotPassword') !!}">@lang('teacher.pages.auth.messages.forgot_password')</a></label>
                        </td>

                    </tr>
                </table>
            </section>
            <p><a href="#" onclick="$(this).parents('form:first').submit(); return false;"
                  class="btn-o">@lang('teacher.pages.signin.submit') </a>
            </p>


        </form>
    </div>
@stop
