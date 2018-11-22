@extends('layouts.user.application', ['noFrame' => false, 'bodyClasses' => ''])

@section('metadata')
@stop

@section('styles')
@stop

@section('scripts')
@stop

@section('title')
    @lang('user.pages.signup_success.page_title')
@stop

@section('header')
@stop

@section('content')
    <main>

        <div class="contents">
            <section>
                <h2 class="title-m cent">@lang('user.pages.signup_success.success_message_second')</h2>
                <p class="cent em">@lang('user.pages.signup_success.success_message_third')</p>
                <p><a href="{{ action('User\AuthController@getSignIn') }}" class="btn-o">@lang('user.pages.signup_success.back_signin_page')</a></p>
            </section>
        </div>
    </main>
@stop