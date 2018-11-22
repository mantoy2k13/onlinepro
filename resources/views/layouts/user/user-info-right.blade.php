<div class="rightside">
    <dl class="r-profilearea">
        <dt>
            <img src="{!! $authUser->getProfileImageUrl() !!}" alt="{!! $authUser->name !!}">
        </dt>
        <dd>{!! $authUser->name !!}</dd>
    </dl>
    <dl class="r-point">
        <dt class="h-point"><img src="{!! \URLHelper::asset('img/icon-ticket.png', 'user') !!}" alt="ticket"><strong>残りのポイント</strong></dt>
        <dd><strong>{!! $authUser->points !!}</strong>P</dd>
    </dl>
    <ul>
        <li><a href="{!! action('User\ProfileController@index') !!}"
               class="{{ Request::is('me') ? 'btn-ps arrow-ps' : 'btn-gs  arrow-gs' }}">マイページへ</a></li>
        <li><a href="{!! action('User\ProfileController@show') !!}" class="{{ Request::is('profile') ? 'btn-ps arrow-ps' : 'btn-gs  arrow-gs' }}">プロフィール編集</a></li>
    </ul>
</div>