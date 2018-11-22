<html>
<header>

</header>
<body>

<content>
    <p>@lang('user.emails.templates.user_cancel_for_teacher.dear', ['name' => $booking->present()->teacherName])</p>
    <p>@lang('user.emails.templates.user_cancel_for_teacher.thank_you')</p>
    <p>@lang('user.emails.templates.user_cancel_for_teacher.please_confirm')</p>
    <br>
    <br>
    <p>@lang('user.emails.templates.user_cancel_for_teacher.reservation_date') {{$booking->timeSlot->present()->dateFormatBookingExpert}} {{$booking->timeSlot->present()->timeFormatBookingExpert}}</p>
    <p>@lang('user.emails.templates.user_cancel_for_teacher.user_name'){{$booking->present()->userName}}</p>
    <p>@lang('user.emails.templates.user_cancel_for_teacher.user_skype') {{$booking->user->skype_id}} </p>
    @include('emails.user.layout_footer')
</content>
</body>
</html>
