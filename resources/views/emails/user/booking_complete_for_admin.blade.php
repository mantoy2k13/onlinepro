<html>
<header>

</header>
<body>

<content>
    <p>admin</p>
    <br>

    <p>@lang('user.emails.templates.booking_complete_admin.user', ['userName' => $booking->present()->userName])</p>
    <p>@lang('user.emails.templates.booking_complete_admin.teacher', ['teacherName' => $booking->present()->teacherName])</p>
    <p>@lang('user.emails.templates.booking_complete_admin.date_and_time') {{$booking->timeSlot->present()->dateFormatBookingExpert}} {{$booking->timeSlot->present()->timeFormatBookingExpert}}</p>
    <p>@lang('admin.pages.bookings.columns.message')<br>{{ $booking->present()->message }}</p>

    <br>
</content>
</body>
</html>
