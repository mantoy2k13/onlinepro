<html>
<header>

</header>
<body>

<p>@lang('user.emails.templates.inquiry_received.title')</p>

<p>------</p>
<p>@lang('user.emails.templates.inquiry_received.web')Webでみる : <a href="{{ action('Admin\InquiryController@show', [$inquiry->id]) }}">{{ action('Admin\InquiryController@show', [$inquiry->id]) }}</a></p>
<p>------</p>
<p>@lang('user.emails.templates.inquiry_received.inquiry_number')問い合わせ番号: {{ $inquiry->id }}</p>
<p>@lang('user.emails.templates.inquiry_received.contact_type')お問い合わせタイプ: {{ \TypeHelper::getTypeName($inquiry->type, config('inquiry.type'))}}</p>
@if( $inquiry->user_id > 0 )
    <p>@lang('user.emails.templates.inquiry_received.user')ユーザー: <a href="{{ action('Admin\UserController@show', [$inquiry->user->id]) }}">{{ $inquiry->user->present()->name }}</a></p>
@endif

<p>@lang('user.emails.templates.inquiry_received.name')名前: {{ $inquiry->name }}</p>
<p>@lang('user.emails.templates.inquiry_received.email')メールアドレス: {{ $inquiry->email }}</p>

@if( $inquiry->type == 'contact')
    <p>@lang('user.emails.templates.inquiry_received.contact_category')お問い合わせカテゴリ: {{ \TypeHelper::getTypeName($inquiry->content_type, config('contact.inquiry_types'))}}</p>
@endif
<p>@lang('user.emails.templates.inquiry_received.contents')内容:</p>
<p>----------</p>
<p>{{ $inquiry->content }}</p>
<p>----------</p>
@include('emails.user.layout_footer')

</body>
</html>
