@extends('layouts.teacher.application', ['menu' => 'calendar'])

@section('metadata')
@stop

@section('styles')
    @parent
    <style>
        .disabled {
            pointer-events: none;
            cursor: default;
        }

    </style>
@stop

@section('scripts')
@stop
@section('title')
    @lang('teacher.pages.calendar_registration.page_title')
@stop

@section('header')
    講師専用 予約可能日登録 | 格安オンライン英会話なら英会話プロ
@stop

@section('content')
    <div class="content">
        @if (count($errors) > 0)
            <div class="alert alert-danger alert-dismissable">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        <div class="calendararea">
            <ul>
                @php
                    $dateValue = $date->format('Y-m-d');
                    $preMonth = $timeSlot->present()->preMonth($dateValue);
                    $nextMonth = $timeSlot->present()->nextMonth($dateValue);
                @endphp
                <li>
                    <div class="calendar">
                        {!! $timeSlot->present()->drawCalendar($date->format('Y'),$date->format('m')) !!}
                    </div>
                </li>
                <li>
                    <div class="calendar">
                        {!! $timeSlot->present()->drawCalendar($nextMonth->format('Y'), $nextMonth->format('m')) !!}
                    </div>
                </li>
            </ul>
            <ul>
                <li class="fl">
                    <a href="{!! URL::action('Teacher\IndexController@calendarRegistration', $preMonth->format('Y-m-d')) !!}">
                        Previous month</a></li>
                <li class="fr">
                    <a href="{!! URL::action('Teacher\IndexController@calendarRegistration', $nextMonth->format('Y-m-d')) !!}">
                        Next month</a></li>
            </ul>
        </div>
            <ul class="weektable">

                <li class="weektabletime">
                    <table>
                        <tr><th class="heightLine-group1">@lang('teacher.pages.calendar_registration.date_time')</th></tr>
                        @php
                            $timeArray = config('timeslot.timeSlot');
                        @endphp
                        @foreach($timeArray as $index => $time)
                        <tr><td class="@if($index%2 != 0)grayarea @endif" data-label="">{!! $time !!}</td></tr>

                        @endforeach

                    </table>
                </li>
                @foreach($listTimeSlot as $tsls)
                <li>
                    <table>
                        <tr><th class="heightLine-group1">
                                <a href="{!! URL::action('Teacher\IndexController@timeSlot', $tsls['date']->format('Y-m-d')) !!}">{!! $tsls['date']->format('m/d') !!}<br>
                                    ({!! $timeSlot->present()->getDayOfWeek($tsls['date']->format('Y-m-d')) !!})</a>
                            </th></tr>
                        @php
                            $timeArray = config('timeslot.timeSlot');
                            $i = 0;
                        @endphp
                        @foreach($timeArray as $tms)
                            @php
                                $timeSlotValue = $tsls['date']->format('Y/m/d') . ' ' . $tms;
                                $i++;
                            @endphp

                            @if($timeSlot->present()->checkIsHad($timeSlotValue, $tsls['data']))
                                <tr><td class="@if($i%2 == 0)grayarea @endif" data-label="{!! $tms !!}"><p class="fontcol-o em">Open</p></td></tr>
                            @else
                                <tr><td data-label="{!! $tms !!}" class="@if($i%2 == 0)grayarea @endif">
                                        <p class="fontcol-g em">Close</p></td></tr>
                            @endif
                        @endforeach

                    </table>
                </li>
                @endforeach

            </ul>
    </div>

@stop
