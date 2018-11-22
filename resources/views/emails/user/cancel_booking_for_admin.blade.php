<html>
<header>

</header>
<body>

<content>
    <p>admin</p>
    <br>

    <br>
    <p>@lang('user.emails.templates.cancel_booking_admin.user_cancel') {{$booking->present()->userName}}</p>
    <p>@lang('user.emails.templates.cancel_booking_admin.teacher_lesson') {{$booking->present()->teacherName}}</p>
    <p>@lang('user.emails.templates.cancel_booking_admin.cancel_lesson') {{$booking->timeSlot->present()->dateFormatBookingExpert}} {{$booking->timeSlot->present()->timeFormatBookingExpert}}</p>

    <br>
</content>
</body>
</html>
