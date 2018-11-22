@extends('layouts.teacher.application', ['menu' => 'time-slot'])

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
    @lang('teacher.pages.timeslot.page_title')
@stop

@section('header')
@stop

@section('content')
    <div class="content">
        @include('layouts.user.messagebox')
        <div class="calendararea">
            @php
                $dateValue = $date->format('Y-m-d');
                $preMonth = $timeSlot->present()->preMonth($dateValue);
                $nextMonth = $timeSlot->present()->nextMonth($dateValue);
            @endphp
            <ul>

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
                <li class="fl"><a href="{!! URL::action('Teacher\IndexController@timeSlot', $preMonth->format('Y-m-d')) !!}">Previous
                        month</a></li>
                <li class="fr"><a href="{!! URL::action('Teacher\IndexController@timeSlot', $nextMonth->format('Y-m-d')) !!}">Next
                        month</a></li>
            </ul>
        </div>
        <table class="daytable">
            <tr>
                <th>&nbsp;</th>
                <td>{!! $timeSlot->present()->dayTimeSlot($dateValue) !!}</td>

            </tr>
            <tr>
                <th>&nbsp;</th>
                <td>
                    <ul class="btnarea">
                        <li>
                            <form action="{!! action('Teacher\IndexController@openCloseAllTimeSlot') !!}" method="post">
                                <input type="hidden" value="on" name="status">
                                <input type="hidden" value="{!! $dateValue !!}" name="datetime">
                                {!! csrf_field() !!}
                                <a href="#" onclick="$(this).parents('form:first').submit(); return false;"
                                   class="btn-os @if($dateValue < $currentDate->format('Y-m-d')) disabled @endif ">@lang('teacher.pages.timeslot.open_all')</a>
                            </form>
                        </li>

                        <li>
                            <form action="{!! action('Teacher\IndexController@openCloseAllTimeSlot') !!}" method="post">
                                <input type="hidden" value="off" name="status">
                                <input type="hidden" value="{!! $dateValue !!}" name="datetime">
                                {!! csrf_field() !!}
                                <a href="#" onclick="$(this).parents('form:first').submit(); return false;"
                                   class="btn-grns @if($dateValue < $currentDate->format('Y-m-d')) disabled @endif ">@lang('teacher.pages.timeslot.close_all')</a>
                            </form>
                        </li>
                    </ul>
                </td>
            </tr>
            @php
                $timeArray = config('timeslot.timeSlot');
            @endphp
            @foreach($timeArray as $tms)
                @php
                    $timeSlotValue = $dateValue . ' ' . $tms;
                $timeSlot->present()->actionAble($timeSlotValue)
                @endphp

                @if($timeSlot->present()->checkIsHad($timeSlotValue, $timeSlots))
                    <tr>
                        <th>{!! $tms !!}</th>
                        <td data-label="11:00">
                            <div class="onoff" style="background-color: rgb(241, 169, 160);">
                                <span class="str" style="left: 10px;">Open</span>
                                <span class="circle @if(!$timeSlot->present()->actionAble($timeSlotValue)) disabled @endif"
                                      data-state="off"
                                      data-value="{!! $timeSlotValue !!}"
                                      data-post-url="@if($timeSlot->present()->actionAble($timeSlotValue)) {!! action('Teacher\IndexController@openCloseTimeSlot') !!} @endif "
                                      style="left: 72px; background-color: rgb(249, 249, 249);"></span>
                            </div>
                        </td>
                    </tr>
                @else

                    <tr>
                        <th>{!! $tms !!}</th>
                        <td data-label="11:00">
                            <div class="onoff">
                                <span class="str">Close</span>
                                <span class="circle @if(!$timeSlot->present()->actionAble($timeSlotValue)) disabled @endif "
                                      data-state="on"
                                      data-value="{!! $timeSlotValue !!}"
                                      data-post-url="@if($timeSlot->present()->actionAble($timeSlotValue)) {!! action('Teacher\IndexController@openCloseTimeSlot') !!} @endif"></span>
                            </div>
                        </td>
                    </tr>
                @endif


            @endforeach


        </table>
    </div>

@stop
