<!DOCTYPE html>
<html lang="en-US">
<head>
    <meta charset="utf-8">
</head>
<body>
<div>
    <p>@lang('user.emails.templates.verify_email.thank_you')</p>

    <p>@lang('user.emails.templates.verify_email.registration_complete')</p>
    <p>@lang('user.emails.templates.verify_email.please')
        <a href="{{ URL::action('User\AuthController@verify', $validationCode) }}" title="Verify email">
            @lang('user.emails.templates.verify_email.click_here')</a>@lang('user.emails.templates.verify_email.to_complete')</p>
    <br/>

</div>
@include('emails.user.layout_footer')
</body>
</html>
