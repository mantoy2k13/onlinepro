<!DOCTYPE html>
<html lang="en-US">
<head>
    <meta charset="utf-8">
</head>
<body>
<div>
    <p>@lang('user.emails.templates.verify_change_email.thank_you')</p>
    <br>

    <p><a href="{{ URL::action('User\AuthController@verifyChangeEmail', $validationCode) }}" title="Verify email">
            @lang('teacher.emails.templates.verify_change_email.click_here')</a>
        @lang('teacher.emails.templates.verify_change_email.to_complete')</p>
    <br/>
    <p>@lang('user.emails.templates.verify_change_email.ignore_message')</p>

</div>
@include('emails.user.layout_footer')
</body>
</html>
