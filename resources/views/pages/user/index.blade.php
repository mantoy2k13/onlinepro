@extends('layouts.user.application', ['noFrame' => false, 'bodyClasses' => '', 'menuUser' => 'home'])

@section('metadata')
@stop

@section('styles')
@parent
@stop

@section('title')
    @lang('user.pages.home.page_title')
@stop

@section('scripts')
    <script type="text/javascript" src="{!! \URLHelper::asset('js/readmore.js', 'user') !!}"></script>
    <script type="text/javascript">
        if (!navigator.userAgent.match(/(iPhone|iPad|Android)/)) {
            $(function () {
                $('.readmore').readmore({
                    speed: 1000,
                    collapsedHeight: 700,
                    moreLink: '<a href="#" class="btn-gs">@lang('user.pages.home.see_more')</a>',
                    lessLink: '<a href="#" class="btn-gs">@lang('user.pages.home.close_up')</a>',
                    maxHeight: 1000
                });
            });
        }
    </script>
    <script type="text/javascript">
        if (navigator.userAgent.match(/(iPhone|iPad|iPod|Android)/)) {
            $(function () {
                $('div').removeClass('pagiationarea');
            });
        }
    </script>
@parent
@stop

@section('breadcrumbs', Breadcrumbs::render('home'))
@section('content')
            <a class="slide-menu" href="#sidr" id="panel-btn"><span class="panel-btn-menu">Menu</span></a>
                    <div class="wrap">

                        <div class="box-g">
                            <form action="{!! action('User\IndexController@index') !!}">
                                <input type="hidden" name="date" value="{{$date->format('Y-m-d')}}">
                            <ul class="weekselect">

                                @foreach( range(0,6) as $index )
                                    <li>
                                        <a href="{{URL::action('User\IndexController@index')}}?date={{$date->format('Y-m-d')}}" class="{{$index == 0 ? 'weekon' : ''}}"><strong>{{$date->format('d')}}</strong>{{ \DateTimeHelper::getDayOfWeekNameByDate($date, trans('config.locale.time'))}}</a></li>
                                    @php($date->addDays(1))
                                @endforeach
                            </ul>
                            <ul>
                                <li class="back-day"><a href="{{URL::action('User\IndexController@index')}}?date={{$back->format('Y-m-d')}}" ><strong> << </strong></a></li></li>
                                <li class="next-day"><a href="{{URL::action('User\IndexController@index')}}?date={{$forward->format('Y-m-d')}}" ><strong> >> </strong></a></li></li>
                            </ul>

                            <p class="cent">
                                <select name="order" class="select">
                                    <option value="rating-down">@lang('user.pages.home.sort_review_high_to_low')</option>
                                    <option value="rating-up">@lang('user.pages.home.sort_review_low_to_high')</option>
                                </select>
                            </p>
                            <p><a href="#" class="btn-o"  onclick="$(this).parents('form:first').submit(); return false;">@lang('user.pages.home.search')</a></p>
                            </form>

                        </div>
                    </div>

                    @if(sizeof($teachers) <= 0)
                        <p class="message-teacher-empty">@lang('user.messages.general.empty_teacher_available')</p>
                    @else
                        <div class="wrap readmore">
                            <ul class="searchresult">
                                <li class="borderless times">
                                    <div class="heightLine-group1">&nbsp;</div>
                                    <table class="categorytable">
                                        @php
                                            $timeArray = config('timeslot.timeSlot');
                                        @endphp
                                        @foreach($timeArray as $indexTime => $time)
                                            <tr><td class="@if($indexTime%2 != 0)grayarea @endif" data-label="">{!! $time !!}</td></tr>

                                        @endforeach
                                    </table>
                                </li>

                                @foreach($teachers as $index => $teacher)
                                    @if($index <= 3 )
                                        <li>
                                            <div class="heightLine-group1">
                                                @if( !empty($authUser) )
                                                    @if($teacher->isMyFavorite)
                                                        <div class="star-favorite"><img src="{{ \URLHelper::asset('img/icon-star-full.png', 'user') }}"
                                                                                        alt="star"></div>
                                                    @endif
                                                @endif
                                                <dl class="teachertable">
                                                    <dt><span class="teachertable-photo" style="background-image: url('{!! $teacher->getProfileImageUrl(130, 95) !!}')"></span></dt>
                                                    <dd>
                                                        <p class="teachertabele-name">{{ $teacher->present()->name }}</p>
                                                        <ul class="reviewstar">
                                                            @for( $i = 1; $i <= 5; $i++ )
                                                                @if( $i <= $teacher->present()->getAverageRating )
                                                                    <li>
                                                                        <img src="{{ \URLHelper::asset('img/icon-star-full.png', 'user') }}"
                                                                             alt="star"></li>
                                                                @else
                                                                    <li>
                                                                        <img src="{{ \URLHelper::asset('img/icon-star-empty.png', 'user') }}"
                                                                             alt="star"></li>
                                                                @endif
                                                            @endfor
                                                        </ul>
                                                        <p>
                                                            <a href="{{ action('User\IndexController@teacherProfile', $teacher->id) }}"
                                                               class="btn-gs arrow-gs">@lang('user.pages.home.teacher_profile')</a></p>
                                                    </dd>
                                                </dl>
                                            </div>
                                            <table class="categorytable">
                                                @php
                                                    $trClass = 0;
                                                @endphp
                                                @foreach($teacher->timeSlots as $timeSlot)
                                                    @if($timeSlot['timeSlot']['status'] == config('constants.timeslot_status.reserved'))
                                                        <tr>
                                                            <td @if($trClass % 2 != 0) class="grayarea"
                                                                @endif data-label="{{ $timeSlot['value'] }}"><p>@lang('user.pages.home.timeslot_status_reserved')</p></td>
                                                        </tr>
                                                    @elseif($timeSlot['timeSlot']['status'] == config('constants.timeslot_status.open'))
                                                        <tr>
                                                            <td @if($trClass % 2 != 0) class="grayarea"
                                                                @endif data-label="{{ $timeSlot['value'] }}">
                                                                <p>
                                                                    @if($teacher->present()->bookable($timeSlot['datetime-value']))
                                                                        <a href="{!! URL::action('User\BookingController@index', [$timeSlot['timeSlot']['timeSlotId']]) !!}"
                                                                           class=" btn-grs  @if(!$bookingAbleToday) none-booking modal-syncer @else booking-button @endif" data-target="none-booking" >@lang('user.pages.home.timeslot_status_available')
                                                                        </a>
                                                                    @else
                                                                        x
                                                                    @endif
                                                                </p></td>
                                                        </tr>
                                                    @else
                                                        <tr>
                                                            <td @if($trClass % 2 != 0) class="grayarea"
                                                                @endif data-label="{{ $timeSlot['value'] }}"><p>x</p></td>
                                                        </tr>
                                                    @endif
                                                    @php
                                                        $trClass += 1;
                                                    @endphp

                                                @endforeach

                                            </table>
                                        </li>
                                    @endif
                                @endforeach

                            </ul>
                        </div>
                        @if(sizeof($teachers)>4)
                            <div class="wrap readmore">
                                <ul class="searchresult">
                                    <li class="borderless times">
                                        <div class="heightLine-group1">&nbsp;</div>
                                        <table class="categorytable">
                                            @foreach($timeArray as $indexTime => $time)
                                                <tr><td class="@if($indexTime%2 != 0)grayarea @endif" data-label="">{!! $time !!}</td></tr>

                                            @endforeach
                                        </table>
                                    </li>

                                    @foreach($teachers as $index => $teacher)

                                        @if($index > 3 )
                                            <li>
                                                <div class="heightLine-group1">
                                                    @if( !empty($authUser) )
                                                        @if($teacher->isMyFavorite)
                                                            <div class="star-favorite"><img src="{{ \URLHelper::asset('img/icon-star-full.png', 'user') }}"
                                                                                            alt="star"></div>
                                                        @endif
                                                    @endif
                                                    <dl class="teachertable">
                                                        <dt><span class="teachertable-photo" style="background-image: url('{!! $teacher->getProfileImageUrl(130, 95) !!}')"></span></dt>
                                                        <dd>
                                                            <p class="teachertabele-name">{{ $teacher->present()->name }}</p>
                                                            <ul class="reviewstar">
                                                                @for( $i = 1; $i <= 5; $i++ )
                                                                    @if( $i <= $teacher->present()->getAverageRating )
                                                                        <li>
                                                                            <img src="{{ \URLHelper::asset('img/icon-star-full.png', 'user') }}"
                                                                                 alt="star"></li>
                                                                    @else
                                                                        <li>
                                                                            <img src="{{ \URLHelper::asset('img/icon-star-empty.png', 'user') }}"
                                                                                 alt="star"></li>
                                                                    @endif
                                                                @endfor
                                                            </ul>
                                                            <p>
                                                                <a href="{{ action('User\IndexController@teacherProfile', $teacher->id) }}"
                                                                   class="btn-gs arrow-gs">@lang('user.pages.home.teacher_profile')</a></p>
                                                        </dd>
                                                    </dl>
                                                </div>
                                                <table class="categorytable">
                                                    @php
                                                        $trClass = 0;
                                                    @endphp
                                                    @foreach($teacher->timeSlots as $timeSlot)
                                                        @if($timeSlot['timeSlot']['status'] == config('constants.timeslot_status.reserved'))
                                                            <tr>
                                                                <td @if($trClass % 2 != 0) class="grayarea"
                                                                    @endif data-label="{{ $timeSlot['value'] }}"><p>@lang('user.pages.home.timeslot_status_reserved')</p>
                                                                </td>
                                                            </tr>
                                                        @elseif($timeSlot['timeSlot']['status'] == config('constants.timeslot_status.open'))
                                                            <tr>
                                                                <td @if($trClass % 2 != 0) class="grayarea"
                                                                    @endif data-label="{{ $timeSlot['value'] }}">
                                                                    <p>
                                                                        @if($teacher->present()->bookable($timeSlot['datetime-value']))
                                                                            <a href="{!! URL::action('User\BookingController@index', [$timeSlot['timeSlot']['timeSlotId']]) !!}"
                                                                               class=" btn-grs  @if(!$bookingAbleToday) none-booking modal-syncer @else booking-button @endif" @if(!$bookingAbleToday) data-target="none-booking" @endif>@lang('user.pages.home.timeslot_status_available')
                                                                            </a>
                                                                        @else
                                                                            x
                                                                        @endif
                                                                    </p></td>
                                                            </tr>
                                                        @else
                                                            <tr>
                                                                <td @if($trClass % 2 != 0) class="grayarea"
                                                                    @endif data-label="{{ $timeSlot['value'] }}"><p>x</p></td>
                                                            </tr>
                                                        @endif
                                                        @php
                                                            $trClass += 1;
                                                        @endphp

                                                    @endforeach

                                                </table>
                                            </li>
                                        @endif
                                    @endforeach

                                </ul>
                            </div>
                        @endif
                        {!! \PaginationHelper::render($offset, $limit, $count, $baseUrl, $params, 8, 'shared.pagination') !!}
                    @endif
            <form id="bookingform" method="post" action="">
                {!! csrf_field() !!}
            </form>
@stop
