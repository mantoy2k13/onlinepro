@extends('layouts.user.application', ['noFrame' => false, 'bodyClasses' => '', 'menuUser' => 'history-bookings'])

@section('metadata')
@stop

@section('styles')
@stop

@section('scripts')

@stop

@section('title')
    @lang('user.pages.complete_review.page_title')
@stop

@section('header')
@stop
@section('breadcrumbs', Breadcrumbs::render('reviews-complete', $booking->id))
@section('content')
    <main>

        <div class="content">
            <section>
                <div class="content">
                    <p class="em cent">@lang('user.pages.complete_review.complete_message')</p>
                </div>
            </section>
        </div>
    </main>
@stop
