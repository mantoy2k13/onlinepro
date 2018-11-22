@extends('layouts.user.application', ['noFrame' => false, 'bodyClasses' => ''])

@section('metadata')
@stop

@section('styles')
@stop

@section('scripts')

    <script type="text/javascript" src="{!! \URLHelper::asset('js/readmore.js', 'user') !!}"></script>
    <script type="text/javascript">
        if (!navigator.userAgent.match(/(iPhone|iPad|Android)/)) {
            $(function () {
                $('.readmore').readmore({
                    speed: 1000,
                    collapsedHeight: 700,
                    moreLink: '<a href="#" class="btn-gs">もっと見る</a>',
                    lessLink: '<a href="#" class="btn-gs">閉じる</a>',
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
@stop

@section('title')
    お問い合わせ
@stop

@section('header')
    お問い合わせ
@stop

@section('content')
    <main>

        @section('breadcrumbs', Breadcrumbs::render('category', $category))
        <div class="grayarea">
            <h2 class="title-m">{{ $category->present()->name }}</h2>
        </div>
        @include('layouts.user.messagebox')
        <div class="content">
            <h3 class="title-l fontcol-p arrow-p font-r">「{{ $category->present()->name }}」</h3>
            <section>
                <div class="wrap">
                    <dl class="category0{{ $category->id }}">
                    {!! $category->present()->description !!}
                        </dl>

                    <div class="box-g">
                        <ul class="weekselect">

                                @foreach( range(0,6) as $index )
                                <li>
                                    <a href="{{URL::action('User\CategoryController@index', $category->slug)}}?date={{$date->format('Y-m-d')}}" class="{{$index == 0 ? 'weekon' : ''}}"><strong>{{$date->format('d')}}</strong>{{ $category->present()->getDayOfWeekNameByDate($date)}}</a></li>
                                    @php($date->addDays(1))
                                @endforeach
                        </ul>
                        <ul>
                            <li class="back-day"><a href="{{URL::action('User\CategoryController@index', $category->slug)}}?date={{$back->format('Y-m-d')}}" ><strong> << </strong></a></li></li>
                            <li class="next-day"><a href="{{URL::action('User\CategoryController@index', $category->slug)}}?date={{$forward->format('Y-m-d')}}" ><strong> >> </strong></a></li></li>
                        </ul>

                        <form action="{{ action('User\CategoryController@index', $category->slug) }}" method="get">
                            <table class="search">
                                <tbody>
                                <tr>
                                    <th>国</th>
                                    <td>
                                        {{ old('country') }}
                                        <select name="country_code" class="select">
                                            <option value="">All</option>
                                            @foreach( $countries as $country )
                                                <option value="{!! $country->code !!}"
                                                        @if($country->code == $countryCode ) selected @endif >{{ $country->present()->name }}</option>
                                            @endforeach
                                        </select>
                                    </td>
                                </tr>

                                </tbody>
                            </table>
                            <p><a href="#" class="btn-p" onclick="$(this).closest('form').submit()">検索</a></p>
                        </form>
                    </div>
                </div>
            </section>

            <section class="c-container">
                @if(sizeof($teachers) <= 0)
                    <p class="message-teacher-empty">@lang('user.messages.general.empty_teacher_available')</p>
                @else
                <div class="content readmore">
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
                                                <p class="cent">
                                                    @if(!empty($teacher->livingCountry))
                                                        @if(!empty($teacher->livingCountry->flagImage))
                                                            <img src="{{ $teacher->livingCountry->flagImage->url }}"
                                                                 alt="{{ $teacher->livingCountry->name_ja }}"
                                                                 class="flag"></p>
                                                @else
                                                    <p style="text-align: center">{{ $teacher->present()->livingCountry }}</p>
                                                @endif
                                                @endif

                                                <p class="cent sm">{{ $teacher->present()->livingTimeInYear }}</p>
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
                                                    <a href="{{ action('User\CategoryController@teacher', $teacher->id) }}"
                                                       class="btn-gs arrow-gs">プロフィール</a></p>
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
                                                        @endif data-label="{{ $timeSlot['value'] }}"><p>予約済み</p></td>
                                                </tr>
                                            @elseif($timeSlot['timeSlot']['status'] == config('constants.timeslot_status.open'))
                                                <tr>
                                                    <td @if($trClass % 2 != 0) class="grayarea"
                                                        @endif data-label="{{ $timeSlot['value'] }}">
                                                        <p>
                                                            @if($teacher->present()->bookable($timeSlot['datetime-value']))
                                                                <a href="{!! URL::action('User\BookingController@index', [$timeSlot['timeSlot']['timeSlotId'], $category->id]) !!}"
                                                                   class=" btn-grs booking-button ">予約する
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
                    <div class="content readmore">
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
                                            <dl class="teachertable">
                                                <dt><span class="teachertable-photo" style="background-image: url('{!! $teacher->getProfileImageUrl(130, 95) !!}')"></span></dt>
                                                <dd>
                                                    <p class="teachertabele-name">{{ $teacher->present()->name }}</p>
                                                    <p class="cent">
                                                        @if(!empty($teacher->livingCountry))
                                                            @if(!empty($teacher->livingCountry->flagImage))
                                                                <img src="{{ $teacher->livingCountry->flagImage->url }}"
                                                                     alt="{{ $teacher->livingCountry->name_ja }}"
                                                                     class="flag"></p>
                                                    @else
                                                        <p style="text-align: center">{{ $teacher->present()->livingCountry }}</p>
                                                    @endif
                                                    @endif

                                                    <p class="cent sm">{{ $teacher->present()->livingTimeInYear }}</p>
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
                                                        <a href="{{ action('User\CategoryController@teacher', $teacher->id) }}"
                                                           class="btn-gs arrow-gs">プロフィール</a></p>
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
                                                            @endif data-label="{{ $timeSlot['value'] }}"><p>予約済み</p>
                                                        </td>
                                                    </tr>
                                                @elseif($timeSlot['timeSlot']['status'] == config('constants.timeslot_status.open'))
                                                    <tr>
                                                        <td @if($trClass % 2 != 0) class="grayarea"
                                                            @endif data-label="{{ $timeSlot['value'] }}">
                                                            <p>
                                                                @if($teacher->present()->bookable($timeSlot['datetime-value']))
                                                                    <a href="{!! URL::action('User\BookingController@index', [$timeSlot['timeSlot']['timeSlotId'], $category->id]) !!}"
                                                                       class=" btn-grs booking-button ">予約する
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
                {!! \PaginationHelper::render($offset, $limit, $count, $baseUrl, $params, 10, 'shared.pagination') !!}
                    @endif
            </section>
        </div>
        <form id="bookingform" method="post" action="">
            {!! csrf_field() !!}
        </form>
    </main>
@stop
