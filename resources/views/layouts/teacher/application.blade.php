<!DOCTYPE html>
<html lang="{{ \App::getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', config('site.name', ''))</title>
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    @include('layouts.teacher.metadata')
    @section('metadata')
    @show
    @include('layouts.teacher.styles')
    @section('styles')
    @show

    <meta name="csrf-token" content="{!! csrf_token() !!}">
</head>
<body class="{!! isset($bodyClasses) ? $bodyClasses : '' !!}">
@include('layouts.teacher.header')
@if( isset($noFrame) && $noFrame == true )
    @yield('content')
@else
    @include('layouts.teacher.frame')
@endif
@include('layouts.teacher.footer')

@include('layouts.teacher.scripts')
@yield('scripts')
</body>
</html>

