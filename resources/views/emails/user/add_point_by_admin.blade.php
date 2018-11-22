<html>
<header>

</header>
<body>

<content>
    <p>@lang('user.emails.templates.add_point_by_admin.dear', ['name' => $pointLog->user->name])</p>
    <p>{{config('site.name', '')}} @lang('user.emails.templates.add_point_by_admin.title')</p>

    <p>@if($pointLog->point_amount > 0)
            @lang('user.emails.templates.add_point_by_admin.added_point', ['points' => $pointLog->point_amount])
        @else
            @lang('user.emails.templates.add_point_by_admin.deducted_point', ['points' => $pointLog->point_amount])
        @endif
    </p>
    <p>@lang('user.emails.templates.add_point_by_admin.point_balance', ['points' => $pointLog->user->points])</p>
    @include('emails.user.layout_footer')
</content>
</body>
</html>
