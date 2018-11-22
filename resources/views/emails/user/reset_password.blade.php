<!DOCTYPE html>
<html lang="en-US">
<head>
    <meta charset="utf-8">
</head>
<body>
<div>
    <p><a href="{!! action('User\PasswordController@getResetPassword', $token) !!}">
            @lang('user.emails.templates.reset_password.click_here')
        </a> @lang('user.emails.templates.reset_password.to_complete')</p>
    <br/>

</div>
@include('emails.user.layout_footer')
</body>
</html>