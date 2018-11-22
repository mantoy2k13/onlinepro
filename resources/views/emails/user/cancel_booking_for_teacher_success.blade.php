<html>
<header>

</header>
<body>

<content>
    <p>@lang('user.emails.templates.teacher_cancel_success.dear', ['name' => $booking->present()->teacherName])</p>
    <p>@lang('user.emails.templates.teacher_cancel_success.thank_you')</p>
    <p>@lang('user.emails.templates.teacher_cancel_success.please_confirm')</p>
    <br>
    <br>
    <p>@lang('user.emails.templates.teacher_cancel_success.reservation_date'){{$booking->timeSlot->present()->dateFormatBookingExpert}} {{$booking->timeSlot->present()->timeFormatBookingExpert}}</p>
    <p>@lang('user.emails.templates.teacher_cancel_success.user_name') {{$booking->present()->userName}}</p>
    <p>@lang('user.emails.templates.teacher_cancel_success.user_skype') {{$booking->user->skype_id}} </p>
    @include('emails.user.layout_footer')
</content>
</body>
</html>
