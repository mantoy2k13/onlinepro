@extends('layouts.user.application', ['noFrame' => false, 'bodyClasses' => ''])

@section('metadata')
@stop

@section('styles')
@stop

@section('scripts')
@stop

@section('title')
    予約する | 格安オンライン英会話なら英会話プロ
@stop

@section('header')
@stop
@section('breadcrumbs', Breadcrumbs::render('booking_success', $timeSlotId))
@section('content')
    <main>
        <div class="content">
            <h3 class="title-s cent under-pink">@lang('user.pages.booking.success_done')</h3>
            <div class="content">
                <p class="em cent">@lang('user.pages.booking.success_complete')</p>
            </div>
        </div>
    </main>
@stop