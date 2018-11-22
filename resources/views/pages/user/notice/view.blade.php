@extends('layouts.user.application', ['noFrame' => false, 'bodyClasses' => ''])

@section('metadata')
@stop

@section('styles')
    @parent

@stop

@section('title')
    マイページ | {{config('site.name', '')}} - ワンコインで気軽に相談。海外生活の悩みはセカイへ
@stop

@section('scripts')
    @parent
@stop
@section('breadcrumbs', Breadcrumbs::render('notice', $notice))
@section('content')

    <div class="grayarea">
        <h2 class="title-m">マイページ</h2>
    </div>
    <section>
        <div class="content clearfix">
            @include('layouts.user.user-info-right')
            <div class="leftside">
                <dl class="newsdet">
                    <dt>{{ $notice->title }}</dt>
                    <dd><time>{!! $notice->sent_at->format('Y/m/d') !!}</time>
                        {{ $notice->content }}
                    </dd>
                </dl>
                <ul class="newslist">
                    @if(!empty($preNotice))
                        <li class="fl"><a href="{{ URL::action('User\ProfileController@showNotification', $preNotice->id) }}">{{ $preNotice->title }}</a></li>
                    @endif
                    @if(!empty($nextNotice))
                        <li class="fr"><a href="{{ URL::action('User\ProfileController@showNotification', $nextNotice->id) }}">{{ $nextNotice->title }}</a></li>
                    @endif
                </ul>
            </div>
        </div>
    </section>
@stop
