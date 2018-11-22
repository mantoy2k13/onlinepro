@extends('layouts.user.application', ['noFrame' => false, 'bodyClasses' => '', 'menuUser' => 'history-bookings'])

@section('metadata')
@stop

@section('styles')
    <style>
        .reviewstar li button {
            background: url({{ \URLHelper::asset('img/icon-star-full.png', 'user') }}) no-repeat scroll left top;
            background-size: 18px 17px;
            width: 18px;
            height: 17px;
            display: block;
        }
        .reviewstar li button:hover img {
            filter:alpha(opacity=0); /* IE 6,7*/
            -ms-filter: "alpha(opacity=0)"; /* IE 8,9 */
            -moz-opacity:0; /* FF , Netscape */
            -khtml-opacity: 0; /* Safari 1.x */
            opacity:0;
            zoom:1; /*IE*/

        }
    </style>
@stop

@section('scripts')
    <script>
        function ratingReview(ratingVal) {
            console.log(ratingVal);
            $('#rating-review').val(ratingVal);
            $('.image-star').attr("src", "{{ \URLHelper::asset('img/icon-star-empty.png', 'user') }}");
            $('#image-'+ratingVal).attr("src", "{{ \URLHelper::asset('img/icon-star-full.png', 'user') }}");
        }
    </script>

@stop

@section('title')
    @lang('user.pages.write_review.page_title')
@stop

@section('header')
@stop
@section('breadcrumbs', Breadcrumbs::render('reviews-edit', $booking->id))
@section('content')
    <main>
        <div class="wrap">
            <section>
                <form action="{{ action('User\ReviewController@confirm', $booking->id) }}" method="post">
                    {{ csrf_field() }}
                    <h3 class="title-s cent under-pink">@lang('user.pages.write_review.review')</h3>
                    <input type="hidden" value="0" id="rating-review" name="rating">
                    <div class="box-g">
                        <div>
                            <ul class="reviewdet">
                                <li>@if(!empty($booking->teacher))
                                        <span>{{ $booking->teacher->name }}</span>
                                    @endif</li>
                                <li>
                                    <time>{{ $booking->timeSlot->present()->dateFormatBookingExpert() }}
                                        {{ $booking->timeSlot->present()->timeFormatBookingExpert() }}〜
                                    </time>
                                </li>
                            </ul>
                        </div>
                        <dl class="memo">
                            <dt>@lang('user.pages.write_review.evaluation')</dt>
                            <dd>
                                <ul class="reviewstar @if ($errors->has('rating')) alert_outline @endif">
                                    <li><button onclick="ratingReview(1); return false">
                                            <img class="image-star" id="image-1" src="{{ \URLHelper::asset('img/icon-star-empty.png', 'user') }}"
                                                    alt="star"></button></li>
                                    <li><button onclick="ratingReview(2); return false">
                                            <img  class="image-star" id="image-2" src="{{ \URLHelper::asset('img/icon-star-empty.png', 'user') }}"
                                                    alt="star"></button></li>
                                    <li><button onclick="ratingReview(3); return false">
                                            <img class="image-star" id="image-3" src="{{ \URLHelper::asset('img/icon-star-empty.png', 'user') }}"
                                                    alt="star"></button></li>
                                    <li><button onclick="ratingReview(4); return false">
                                            <img class="image-star" id="image-4" src="{{ \URLHelper::asset('img/icon-star-empty.png', 'user') }}"
                                                    alt="star"></button></li>
                                    <li><button onclick="ratingReview(5); return false">
                                            <img class="image-star" id="image-5" src="{{ \URLHelper::asset('img/icon-star-empty.png', 'user') }}"
                                                    alt="star"></button></li>
                                </ul>
                                @if ($errors->has('rating'))<p class="alert" >{{ $errors->first('rating') }}</p> @endif
                            </dd>
                            <dt>@lang('user.pages.write_review.review_comment')</dt>
                            <dd><textarea class="textarea @if ($errors->has('content')) alert_outline @endif" name="content" placeholder="">{{ old('content') ? old('content') : ''  }}</textarea>
                                @if ($errors->has('content'))<p class="alert" >{{ $errors->first('content') }}</p> @endif
                            </dd>
                        </dl>
                        <p><a href="#" onclick="$(this).parents('form:first').submit(); return false;"
                              class="btn-o">@lang('user.pages.write_review.submit')</a></p>
                    </div>
                </form>
            </section>
        </div>
    </main>
@stop
