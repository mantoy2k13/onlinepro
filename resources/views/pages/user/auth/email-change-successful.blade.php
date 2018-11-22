@extends('layouts.user.application', ['noFrame' => false, 'bodyClasses' => ''])

@section('metadata')
@stop

@section('styles')
@stop

@section('scripts')
@stop

@section('title')
    {{config('site.name', '')}} | Your email account have been changed
@stop

@section('header')
    {{config('site.name', '')}} | Your email account have been changed
@stop

@section('content')

    <div class="content">

        <div class="grayarea">
            <h2 class="title-m">@lang('user.pages.auth.messages.change_email_successful_title')</h2>
        </div>
        <div class="content">
            <h3 class="title-s cent under-pink">@lang('user.pages.auth.messages.change_email_successful_title')</h3>
            <div class="content">
                <p class="em cent">@lang('user.pages.auth.messages.change_email_successful_content')</p>
            </div>
        </div>
    </div>

@stop
