<aside id="sidr-menu" class="navarea">
    <nav>
        <dl class="nav-profile">
            <dt><img src="{!! $authUser->getProfileImageUrl() !!}" alt="{!! $authUser->name !!}" class="photo"></dt>
            <dd>{!! $authUser->name !!}</dd>
        </dl>
        <ul>
            <li><a href="{!! action('Teacher\IndexController@getReservations') !!}" @if( isset($menu) && $menu=='booking') class="navon" @endif>@lang('teacher.pages.widgets.menu.reservation')</a></li>
            <li><a href="{!! action('Teacher\ProfileController@show') !!}" @if( isset($menu) && $menu=='profile') class="navon" @endif>@lang('teacher.pages.widgets.menu.edit_profile')</a></li>
            <li><a href="{!! action('Teacher\IndexController@calendarRegistration', $nowInTimeZone->format('Y-m-d')) !!}" @if( isset($menu) && $menu=='calendar') class="navon" @endif>@lang('teacher.pages.widgets.menu.calendar_booking_able')</a></li>
            <li><a class="logout" href="#">@lang('teacher.pages.widgets.menu.logout')</a></li>
            <li><a class="slide-menu btn-close" href="#">@lang('teacher.pages.widgets.menu.close')</a></li>
        </ul>
    </nav>
</aside>