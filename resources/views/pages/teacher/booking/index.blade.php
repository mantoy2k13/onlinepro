@extends('layouts.teacher.application', ['menu' => 'booking'])

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


    <script type="text/javascript" charset="utf-8">
        Boilerplate.bookings = {!! json_encode($bookingReviews) !!};
        $(function () {

            $('.writelog').click(function (e) {
                var self = $(this),
                        bookingId = self.attr('data-content'),
                        itemName = "",
                        itemId = "",
                        itemStartAt = "",
                        content = "",
                        reviewId = 0;
                Boilerplate.bookings.forEach(function (booking) {
                            if (booking.id == bookingId) {
                                itemName = 'User: '+booking.name;
                                itemStartAt = booking.start_at;
                                content = booking.content;
                                reviewId = booking.review_id;
                            }
                        }
                )
                $("#date-lightbox02").html(itemStartAt);
                $("#user-lightbox02").html(itemName);
                $("#content-lightbox02").html(content);
                $("#booking_id").val(bookingId);
                $("#review_id").val(reviewId);
                $("#lightbox02").lightbox_me({
                    centered: true, preventScroll: true, onLoad: function () {
                        $("#lightbox02").find("input:first").focus();
                    }
                });
                e.preventDefault();
            });
            $('table tr:nth-child(even)').addClass('stripe');
        });

        $('.client').click(function (e) {
            var self = $(this),
                    bookingId = self.attr('data-content'),
                    userName = "",
                    userAvatar = "{{ \URLHelper::asset('img/user.png', 'common') }}",
                    userMessage = "";
            Boilerplate.bookings.forEach(function (booking) {
                        if (booking.id == bookingId) {
                            userName = booking.name;
                            userAvatar = booking.avatar;
                            userMessage = booking.message;
                        }
                    }
            )
            $("#avatar-lightbox").attr('src', userAvatar);
            $("#avatar-lightbox").attr('alt', userName);
            $("#user-lightbox").html(userName);
            $("#message-lightbox").html(userMessage);
            $("#lightbox").lightbox_me({
                centered: true, preventScroll: true, onLoad: function () {
                    $("#lightbox").find("input:first").focus();
                }
            });
            e.preventDefault();
        });
    </script>
@stop
@section('title')
    @lang('teacher.pages.reservation.page_title')
@stop

@section('header')
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
        @include('layouts.user.messagebox')
        <div class="content">
            <table class="historydata">
                <thead>
                <tr>
                    <th class="historydata-s">@lang('teacher.pages.reservation.date')</th>
                    <th class="historydata-s">@lang('teacher.pages.reservation.time')</th>
                    <th class="historydata-l">@lang('teacher.pages.reservation.user_name')</th>
                    <th class="historydata-l">@lang('teacher.pages.reservation.cancel')</th>
                </tr>
                </thead>
                @foreach($models as $model)

                    <tr>
                        <td data-label="日付">{!! $model->timeSlot->present()->dateFormatBookingExpert()!!}</td>
                        <td data-label="時間">{!! $model->timeSlot->present()->timeFormatBookingExpert()!!}</td>
                        <td data-label="予約者">
                            <p>
                                @if(!empty($model->user))
                                    {!! $model->user->name !!}
                                @endif
                            </p>
                        </td>

                        <td data-label="キャンセル">

                            @if($model->present()->teacherAbleCancel)
                                <a class="modal-syncer btn-gs teacher-cancel-booking" data-target="modal-content" data-post-url="{!! action('Teacher\IndexController@cancelReservation', [$model->id]) !!}"
                                    >@lang('teacher.pages.reservation.cancel_button')</a>

                            @endif

                        </td>
                    </tr>
                @endforeach

            </table>
        </div>
        @if($count>0)
        {!! \PaginationHelper::render($offset, $limit, $count, $baseUrl, $params, 10, 'shared.pagination') !!}
            @endif

    </div>
    <div id="modal-content" class="modal-content">
        <p class="em">@lang('teacher.pages.reservation.cancel_popup_title')</p>
        <ul class="btnarea">
            <li><a id="link-confirm" href="#" class="btn-gs" data-post-url="">@lang('teacher.pages.reservation.yes')</a></li>
            <li><p><a id="modal-close02" class="btn-gs button-link">@lang('teacher.pages.reservation.no')</a></p></li>
        </ul>
        <p><a id="modal-close" class="button-link">@lang('teacher.pages.reservation.close')</a></p>
    </div>
@stop
