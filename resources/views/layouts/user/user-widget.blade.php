<aside id="sidr-menu" class="navarea">
    <nav>
        <dl class="nav-profile">
            <dt><img class="photo" src="{!! $authUser->getProfileImageUrl() !!}" alt="{!! $authUser->name !!}"></dt>
            <dd>{!! $authUser->name !!}</dd>
        </dl>
        <dl class="nav-point">
            <dt>@lang('user.pages.widgets.user_right.remaining_points')</dt>
            <dd>
                <p><strong>{!! $authUser->points !!}</strong>P</p>
                @if($authUser->points > 0 && !empty($expiredTime))
                <p><span>@lang('user.pages.widgets.user_right.expiration_date')</span><span>{{ $authUser->present()->expiredTimePoint($expiredTime) }}</span></p>
                @endif
            </dd>
        </dl>
        <ul>
            <li><a href="{!! action('User\IndexController@index') !!}" @if( isset($menuUser) && $menuUser=='home') class="navon" @endif>@lang('user.pages.widgets.user_right.make_a_reservation')</a></li>
            <li><a href="{!! action('User\PointController@index') !!}" @if( isset($menuUser) && $menuUser=='point') class="navon" @endif>@lang('user.pages.widgets.user_right.purchase_points')</a></li>
            <li><a href="{!! action('User\BookingController@getReservations') !!}" @if( isset($menuUser) && $menuUser=='reservations') class="navon" @endif>@lang('user.pages.widgets.user_right.list_booking')</a></li>
            <li><a href="{!! action('User\BookingController@getBookingHistories') !!}" @if( isset($menuUser) && $menuUser=='log') class="navon" @endif>@lang('user.pages.widgets.user_right.booking_history')</a></li>
            <li><a href="{!! action('User\IndexController@favoriteTeachers') !!}" @if( isset($menuUser) && $menuUser=='favorites') class="navon" @endif>@lang('user.pages.widgets.user_right.favorite_teachers')</a></li>
            <li><a href="{!! action('User\TextBookController@index') !!}" @if( isset($menuUser) && $menuUser=='textbook') class="navon" @endif>@lang('user.pages.widgets.user_right.textbooks')</a></li>
            <li><a href="{!! action('User\ProfileController@show') !!}"@if( isset($menuUser) && $menuUser=='profile') class="navon" @endif>@lang('user.pages.widgets.user_right.member_profile')</a></li>
            <li><a class="logout" href="#">@lang('user.pages.widgets.user_right.signout')</a></li>
            <li><a class="slide-menu btn-close" href="#">@lang('user.pages.widgets.user_right.close')</a></li>
        </ul>
    </nav>
</aside>