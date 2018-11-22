<!DOCTYPE html>
<html lang="{{ \App::getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', config('site.name', ''))</title>
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    @include('layouts.user.metadata')
    @section('metadata')
    @show
    @include('layouts.user.styles')
    @section('styles')
    @show
    <meta name="csrf-token" content="{!! csrf_token() !!}">
</head>
<body class="{!! isset($bodyClasses) ? $bodyClasses : '' !!}">
@if( isset($noFrame) && $noFrame == true )
    @yield('content')
@else
    @include('layouts.user.frame')
@endif
@include('layouts.user.scripts')
@section('scripts')
@show
<script type="text/javascript">
    @if(!empty(Session::get('error_code')) && Session::get('error_code') == config('constants.error_code.login_failed'))
        $(function() {
            $('#message-login').show();
            $('#lightbox').lightbox_me({centered: true, onLoad: function() { $('#lightbox').find('input:first').focus()}});
        });
    @endif
</script>
</body>
</html>

