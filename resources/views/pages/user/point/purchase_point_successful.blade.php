@extends('layouts.user.application', ['noFrame' => false, 'bodyClasses' => ''])

@section('metadata')
@stop

@section('styles')
@stop

@section('scripts')
@stop

@section('title')
    @lang('user.pages.points.purchase_success_title_m')
@stop

@section('header')
    @lang('user.pages.points.purchase_success_title_m')
@stop

@section('content')

    <div class="content">
        <h3 class="title-s cent under-pink">@lang('user.pages.points.purchase_success_title_s')</h3>
        <div class="content">
            <p class="em cent">@lang('user.pages.points.purchase_success_buyed',['points'=>$points])P</p>
        </div>
    </div>

@stop