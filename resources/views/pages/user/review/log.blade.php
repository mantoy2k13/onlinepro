@extends('layouts.user.application', ['noFrame' => false, 'bodyClasses' => '', 'menuUser' => 'history-bookings'])

@section('metadata')
@stop

@section('styles')
@stop

@section('scripts')

@stop

@section('title')
    相談履歴-ログ | {{config('site.name', '')}} - ワンコインで気軽に相談。海外生活の悩みはセカイへ
@stop

@section('header')
@stop
@section('breadcrumbs', Breadcrumbs::render('reviews-log', $review->id))
@section('content')
    <main>

        <div class="grayarea">
            <h2 class="title-m">相談履歴</h2>
        </div>
        <div class="content">
            <section>
                <h3 class="title-s cent under-pink">ログ</h3>
                <dl class="logdet">
                    <dt class="cent em">「{{ !empty($review->booking) ? $review->booking->present()->category() : '' }}」
                        <br>
                        @if(!empty($review->teacher))
                            {{ $review->teacher->name }}
                        @endif
                        <time>
                            @if(!empty($review->booking) && !empty($review->booking->timeSlot))
                                {{  $review->booking->timeSlot->present()->dateFormatBookingExpert() }}
                                {{  $review->booking->timeSlot->present()->timeFormatBookingExpert() }}〜
                            @endif
                        </time></dt>
                    <dd><p>{{ $review->content }}</p></dd>
                </dl>
            </section>
        </div>
    </main>
@stop
