<html>
<header>

</header>
<body>

<content>
    <p>@lang('user.emails.templates.teacher_cancel_for_user.dear', ['name' => $booking->present()->userName])</p>
    <p>@lang('user.emails.templates.teacher_cancel_for_user.thank_you')</p>
    <p>@lang('user.emails.templates.teacher_cancel_for_user.please_confirm')</p>
    <br>
    <p>@lang('user.emails.templates.teacher_cancel_for_user.title')</p>
    <br>

    <p>@lang('user.emails.templates.teacher_cancel_for_user.reservation_date'){{$booking->timeSlot->present()->dateFormatBookingExpert}} {{$booking->timeSlot->present()->timeFormatBookingExpert}}</p>
    <p>@lang('user.emails.templates.teacher_cancel_for_user.teacher_name') {{$booking->present()->teacherName}}</p>
    <p>@lang('user.emails.templates.teacher_cancel_for_user.teacher_skype') {{$booking->teacher->skype_id}} </p>
    <br>
    <p>@lang('user.emails.templates.teacher_cancel_for_user.point_note')</p>
    @include('emails.user.layout_footer')
</content>
</body>
</html>
