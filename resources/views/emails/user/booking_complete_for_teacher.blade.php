<html>
<header>

</header>
<body>

<content>
    <p>@lang('user.emails.templates.booking_complete_teacher.dear', ['name' => $booking->present()->teacherName]) </p>
    <p>{{config('site.name', '')}} @lang('user.emails.templates.booking_complete_teacher.thank_you')</p>
    <p>@lang('user.emails.templates.booking_complete_teacher.please_confirm')</p>
    <br>
    <p>@lang('user.emails.templates.booking_complete_teacher.reservation_complete')</p>
    <br>
    <p>※@lang('user.emails.templates.booking_complete_teacher.remind_time')</p>
    <br>
    <p>@lang('user.emails.templates.booking_complete_teacher.datetime',
     ['date' => $booking->timeSlot->present()->dateFormatBookingExpert,
      'time' => $booking->timeSlot->present()->timeFormatBookingExpert ])</p>
    <p>@lang('user.emails.templates.booking_complete_teacher.user_name', ['userName' => $booking->present()->userName])</p>
    <p>@lang('user.emails.templates.booking_complete_teacher.user_skype', ['skype' => $booking->user->skype_id]) </p>
    <br>
    <p>@lang('user.emails.templates.booking_complete_teacher.remind_online')</p>
    @include('emails.user.layout_footer')
</content>
</body>
</html>
