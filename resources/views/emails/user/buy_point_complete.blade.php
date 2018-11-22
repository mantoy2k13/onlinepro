<html>
<header>

</header>
<body>

<content>
    <p>@lang('user.emails.templates.buy_point_complete.dear', ['name' => $user->name])</p>
    <p>@lang('user.emails.templates.buy_point_complete.thank_you')</p>
    <p>@lang('user.emails.templates.buy_point_complete.please_confirm')</p>
    <br>

    <p>@lang('user.emails.templates.buy_point_complete.purchased_package')@lang($package['name'])</p>
    <p>@lang('user.emails.templates.buy_point_complete.added_points') {{$package['value']['point']}}</p>
    <p>@lang('user.emails.templates.buy_point_complete.point_balance') {{$user->points}}</p>
    @include('emails.user.layout_footer')
</content>
</body>
</html>
