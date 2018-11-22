@extends('layouts.user.application', ['noFrame' => false, 'bodyClasses' => ''])

@section('metadata')
@stop

@section('styles')
@stop

@section('scripts')
@stop

@section('title')
    @lang('user.pages.booking.page_title')
@stop

@section('header')
@stop
@section('breadcrumbs', Breadcrumbs::render('booking_confirm', $timeSlot['id']))
@section('content')
    <main>

        <div class="content">
            <section>
                <h3 class="title-s cent under-pink">@lang('user.pages.booking.teacher_profile')</h3>
                <div class="teacherprof">
                    <dl class="teacherprof-area">
                        <dt>
                        <dt><span class="teacherprof-photo" style="background-image: url('{!! $teacher->getProfileImageUrl() !!}')"></span></dt>

                        </dt>
                        <dd>
                            @if($isFavorite)
                                <a id="remove-favorite-button" class="btn-gs" href="#" data-action="DELETE"
                                   data-url="{{ action('User\IndexController@removeFavoriteTeacher', $teacher->id) }}">
                                    @lang('user.pages.category.teacher.delete_favorites')</a>
                            @else
                                <a id="favorite-button" class="btn-gs" href="#" data-action="post"
                                   data-url="{{ action('User\IndexController@addFavoriteTeacher', $teacher->id) }}">
                                    @lang('user.pages.category.teacher.add_to_favorites')</a>
                            @endif
                        </dd>
                        <form id="favorite-form" method="post" action="">
                            {!! csrf_field() !!}
                        </form>
                    </dl>
                    <div class="profdata">
                        <table class="form-b">
                            <tr>
                                <th>@lang('user.pages.booking.name')</th>
                                <td>{{ $teacher['name'] }}</td>
                            </tr>
                            <tr>
                                <th>@lang('user.pages.booking.age')</th>
                                <td>{{ $teacher['year_of_birth'] }}</td>
                            </tr>
                            <tr>
                                <th>@lang('user.pages.booking.gender')</th>
                                <td>{{ trans('teacher.gender.'.$teacher['gender']) }}</td>
                            </tr>
                            <tr>
                                <th>@lang('user.pages.booking.living_country_code')</th>
                                <td>@if(!empty($teacher->livingCountry))
                                        {{ $teacher->livingCountry->present()->name }}
                                    @endif</td>
                            </tr>
                            <tr>
                                <th>@lang('user.pages.booking.living_city_id')</th>
                                <td>@if(!empty($teacher->livingCity))
                                    {{ $teacher->livingCity->present()->name }}
                                        @endif
                                </td>
                            </tr>
                            <tr>
                                <th>@lang('user.pages.booking.personalities')</th>
                                <td>{{ $teacher->present()->getListPersonality }}</td>
                            </tr>
                            <tr>
                                <th>@lang('user.pages.booking.hobby')</th>
                                <td>{{ $teacher['hobby'] }}</td>
                            </tr>
                            <tr>
                                <th>@lang('user.pages.booking.home_province_id')</th>
                                <td>@if(!empty($teacher->livingCity))
                                    {{ $teacher->homeProvince->present()->name }}
                                    @endif
                                </td>
                            </tr>

                        </table>
                    </div>
                </div>
            </section>
            <section>
                <form action="{{ action('User\BookingController@booking', [$timeSlot['id']]) }}" method="POST">
                    {!! csrf_field() !!}
                    <h3 class="title-s cent under-pink">@lang('user.pages.booking.reservation_content')</h3>

                    <div class="box-g">
                        <p class="cent">@lang('user.pages.booking.reservation_confirm')</p>
                        <p class="bookingtime">
                            <time>
                                @php
                                    $startAt = \DateTimeHelper::changeToPresentationTimeZone($timeSlot->start_at);
                                @endphp
                                @lang('user.pages.booking.reservation_date', ['month' => $startAt->format('m'), 'date' => $startAt->format('d'), 'day' => $startAt->format('D')])
                                <span>@lang('user.pages.booking.reservation_time', ['hour' => $startAt->format('H'), 'minute' => $startAt->format('i')])</span>
                            </time>
                        </p>
                        <dl class="memo">
                            <dt>@lang('user.pages.booking.advance_memo')</dt>
                            <dd>
                                <textarea class="textarea" name="message" placeholder="@lang('user.pages.booking.reservation_placeholder')"></textarea>
                            </dd>
                        </dl>
                        <p><a href="#" class="btn-o" onclick="$(this).closest('form').submit()">@lang('user.pages.booking.reservation_submit')</a></p>
                    </div>
                </form>
            </section>
        </div>
    </main>
@stop
