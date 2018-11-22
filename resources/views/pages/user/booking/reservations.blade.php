@extends('layouts.user.application', ['noFrame' => false, 'bodyClasses' => '', 'menuUser' => 'booking'])

@section('metadata')
@stop

@section('styles')
@stop

@section('scripts')
@stop

@section('title')
    @lang('user.pages.reservation.page_title')
@stop

@section('header')
@stop

@section('content')
    <main>
        @section('breadcrumbs', Breadcrumbs::render('user-reservations'))
        <div class="wrap">
            <section>
                <table class="historydata">
                    <thead>
                    <tr>
                        <th>@lang('user.pages.reservation.lesson_date')</th>
                        <th>@lang('user.pages.reservation.lesson_time')</th>
                        <th>@lang('user.pages.reservation.teacher_name')</th>
                        <th class="historydata-m">@lang('user.pages.reservation.teacher_skype')</th>
                        <th class="historydata-l">@lang('user.pages.reservation.cancel')</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($models as $model)
                    <tr>
                        <td data-label="相談日時">{!! $model->timeSlot->present()->dateFormatBookingExpert()!!}
                            </td>
                        <td data-label="相談カテゴリー">{!! $model->timeSlot->present()->timeFormatBookingExpert()!!}</td>
                        <td data-label="講師名前">{!! $model->teacher->name !!}</td>
                        <td data-label="講師 SkypeID">{!! $model->teacher->skype_id !!}</td>
                        <td data-label="キャンセル">
                        @if($model->present()->userAbleCancel)
                                <a data-post-url="{!! action('User\BookingController@cancelReservation', [$model->id]) !!}" data-target="modal-content"
                                   href="#" class="modal-syncer btn-gs user-cancel-booking">@lang('user.pages.reservation.cancel_button')</a>
                        @endif
                    </tr>
                    @endforeach

                    </tbody>

                </table>
                @if($count > 0)
                {!! \PaginationHelper::render($offset, $limit, $count, $baseUrl, $params, 10, 'shared.pagination') !!}
                    @endif
            </section>
        </div>
    </main>
    <div id="modal-content" class="modal-content">
        <p class="em">@lang('user.pages.reservation.cancel_confirm_message')</p>
        <ul class="btnarea">
            <li><a id="link-confirm" href="#" class="btn-gs" data-post-url="">@lang('user.pages.reservation.yes')</a></li>
            <li><p><a id="modal-close02" class="btn-gs button-link">@lang('user.pages.reservation.no')</a></p></li>
        </ul>
        <p><a id="modal-close" class="button-link">@lang('user.pages.reservation.close')</a></p>
    </div>
@stop