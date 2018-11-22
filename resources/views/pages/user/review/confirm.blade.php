@extends('layouts.user.application', ['noFrame' => false, 'bodyClasses' => '', 'menuUser' => 'history-bookings'])

@section('metadata')
@stop

@section('styles')
@stop

@section('scripts')

@stop

@section('title')
    @lang('user.pages.confirm_review.page_title')
@stop

@section('header')
@stop
@section('breadcrumbs', Breadcrumbs::render('reviews-confirm', $booking->id))
@section('content')
    <main>

        <div class="wrap">
            <section>
                <div class="box-g">
                    <div>
                        <ul class="reviewdet">
                            <li>@if(!empty($booking->teacher))
                                    <span>{!! $booking->teacher->name !!}</span>
                                @endif</li>
                            <li>
                                <time>{!! $booking->timeSlot->present()->dateFormatBookingExpert()!!}
                                    {!! $booking->timeSlot->present()->timeFormatBookingExpert()!!}〜
                                </time>
                            </li>
                        </ul>
                    </div>
                    <dl class="memo">
                        <dt>@lang('user.pages.confirm_review.evaluation')</dt>
                        <dd>
                            <ul class="reviewstar">
                                <ul class="reviewstar">
                                    @for( $i = 1; $i <= 5; $i++ )
                                        @if( $i <= $rating )
                                            <li><img src="{{ \URLHelper::asset('img/icon-star-full.png', 'user') }}"
                                                     alt="star"></li>
                                        @else
                                            <li><img src="{{ \URLHelper::asset('img/icon-star-empty.png', 'user') }}"
                                                     alt="star"></li>
                                        @endif
                                    @endfor
                                </ul>
                            </ul>
                        </dd>
                        <dt>@lang('user.pages.confirm_review.review_comment')</dt>
                        <dd class="box-g"><p>
                                {{ $content }}
                            </p></dd>
                    </dl>
                    <form method="post" action="{{ action('User\ReviewController@complete', $booking->id) }}">
                        {{ csrf_field() }}
                        <input type="hidden" name="rating" value="{{ $rating }}"/>
                        <input type="hidden" name="content" value="{{ $content }}"/>
                        <ul class="btnarea">

                            <li><a href="#" class="btn-g"
                                   onclick="history.back(); return false;">@lang('user.pages.confirm_review.back')</a>
                            </li>
                            <li><a href="#" onclick="$(this).parents('form:first').submit(); return false;"
                                   class="btn-o">@lang('user.pages.confirm_review.submit')</a></li>

                        </ul>
                    </form>
                </div>
            </section>
        </div>
    </main>
@stop
