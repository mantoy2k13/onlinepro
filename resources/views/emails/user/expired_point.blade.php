<html>
<header>

</header>
<body>

<content>
    <p>@lang('user.emails.templates.expired_point.dear', ['name' => $user->name])</p>
    <p>@lang('user.emails.templates.expired_point.title')</p>
    <p>@lang('user.emails.templates.expired_point.please_confirm')</p>
    <br>

    <p>@lang('user.emails.templates.expired_point.expired_point') {{$expiredPoints}})P</p>
    <p>@lang('user.emails.templates.expired_point.point_balance'){{$user->points}}</p>
    @include('emails.user.layout_footer')
</content>
</body>
</html>
