<div class="wrap">
    @if( empty($authUser) )
        <div class="header-top">
            <h1 class="logo"><a href="{{ action('User\IndexController@index') }}"><img
                            src="{!! \URLHelper::asset('img/logo.png', 'user') !!}" alt="sekaihelogo"></a></h1>
            <ul class="headerlogin">
                <li><a href="{{ action('User\AuthController@getSignIn') }}" id="try-1" class="arrow-gs">ログイン</a></li>
                <li><a href="{{ action('User\AuthController@getSignUp') }}" class="arrow-gs">新規会員登録</a></li>
            </ul>
        </div>
    @else
        <div class="header-top">
            <h1 class="logo"><a href="{{ action('User\IndexController@index') }}"><img
                            src="{!! \URLHelper::asset('img/logo.png', 'user') !!}" alt="sekaihelogo"></a></h1>
            <ul class="h-afterlogin">
                <li class="h-facebook tooltip hover">
                    <a href="#">
                            <span><img src="{!! $authUser->getProfileImageUrl() !!}" alt="TakayaSuzuki"></span>
                        <p class="h-limit01">{!! $authUser->name !!}</p></a>
                    <ul>
                        <li><a href="{{ action('User\ProfileController@index') }}" class="arrow-gs">マイページへ</a></li>
                        <li><a href="{{ action('User\ProfileController@show') }}" class="arrow-gs">プロフィール編集</a></li>
                        <li><a class="logout" href="#">ログアウト</a></li>
                    </ul>
                </li>
                <li class="h-point"><span><img src="{!! \URLHelper::asset('img/icon-ticket.png', 'user') !!}"
                                               alt="ticket"></span>
                    <p class="h-limit02">{!! $authUser->points !!}</p>P
                </li>
            </ul>
        </div>
        <form id="logout" method="post" action="{!! action('User\AuthController@postSignOut') !!}">
            {!! csrf_field() !!}
        </form>
    @endif
    <nav>
        <div id="navigation">
            <div id="toggle"><a href="#">menu</a></div>
            <ul id="categorymenu">
                @foreach( $categories as $category )
                    <li><a href="{{ action('User\CategoryController@index', $category->slug) }}">{{ $category->present()->name }}</a></li>
                @endforeach
            </ul>
            <span id="slide-line"></span>
        </div>
    </nav>
</div>
@if( !empty($authUser) )
    <div id="subnavigation">
        <span class="subnav-arrow"><img src="{!! \URLHelper::asset('img/arrow-gray-m.png', 'user') !!}"
                                        alt="arrow"></span>
        <nav id="scroll-menu">
            <ul class="scroll-menu-inner">
                <li><a href="{!! action('User\PointController@index') !!}">@lang('user.pages.header.menu.get_points')</a></li>
                <li><a href="{!! action('User\BookingController@getReservations') !!}" @if( isset($menuUser) && $menuUser=='reservations') class="subnavi-on" @endif>
                        @lang('user.pages.header.menu.list_reservations')</a></li>
                <li><a href="{!! action('User\BookingController@getBookingHistories') !!}" @if( isset($menuUser) && $menuUser=='history-bookings') class="subnavi-on" @endif>
                        @lang('user.pages.header.menu.consultation_history')</a></li>
                <li><a href="{!! action('User\IndexController@favoriteTeachers') !!}">@lang('user.pages.header.menu.favorite_teachers')</a></li>
            </ul>
        </nav>
    </div>
@endif
