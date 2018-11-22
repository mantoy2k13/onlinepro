@extends('layouts.user.application', ['noFrame' => false, 'bodyClasses' => '', 'menuUser' => 'log'])

@section('metadata')
@stop

@section('styles')
@stop

@section('scripts')
@stop

@section('title')
    @lang('user.pages.booking_history.page_title')
@stop

@section('header')
@stop
@section('breadcrumbs', Breadcrumbs::render('history-bookings'))
@section('content')
    <main>
        @section('breadcrumbs', Breadcrumbs::render('history-bookings'))
        <div class="wrap">
            <section>
                <table class="historydata">
                    <thead>
                    <tr>
                        <th class="historydata-ll">@lang('user.pages.booking_history.lesson_date')</th>
                        <th class="historydata-ll">@lang('user.pages.booking_history.teacher_name')</th>
                        <th class="historydata-ll">@lang('user.pages.booking_history.review')</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($models as $model)
                        <tr>
                            <td data-label="相談日時">{!! $model->timeSlot->present()->dateFormatBookingExpert()!!}
                                <span>{!! $model->timeSlot->present()->timeFormatBookingExpert()!!}</span></td>
                            <td data-label="アドバイザー名前">
                                @if(!empty($model->teacher))
                                    <p class="teacherphoto"><a href="{{ action('User\IndexController@teacherProfile', $model->teacher->id) }}">
                                            <span class="teachertable-photo" style="background-image: url({!! $model->teacher->getProfileImageUrl() !!})"></span>
                                                <strong>{!! $model->teacher->name !!}</strong></a></p>

                                @endif
                            </td>

                            <td data-label="レビュー">
                                @if($model->present()->hasMyReview)
                                    <a href="{{ action('User\IndexController@teacherProfile', $model->teacher->id) }}" >@lang('user.pages.booking_history.check_review_button')</a>
                                @else
                                    <a href="{{ action('User\ReviewController@writeReviewForm', $model->id) }}" class="btn-gs">@lang('user.pages.booking_history.write_review_button')</a>
                                @endif

                            </td>
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
@stop
