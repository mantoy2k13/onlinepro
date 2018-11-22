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
@section('breadcrumbs', Breadcrumbs::render('me'))
@section('content')

    <div class="grayarea">
        <h2 class="title-m">マイページ</h2>
    </div>
    <section>
        <div class="content clearfix">
            @include('layouts.user.user-info-right')
            <div class="leftside">
                <h3 class="title-s sidebar-pink">お知らせ</h3>
                <ul class="newsarea">
                    @foreach($models as $model)
                    <li><time>{!! $model->sent_at->format('Y/m/d') !!}</time><p
                        ><a href="{{ URL::action('User\ProfileController@showNotification', $model->id) }}" >{!! $model->title !!}</a></p></li>
                    @endforeach
                </ul>
                <div class="box-footer">
                    {!! \PaginationHelper::render($offset, $limit, $count, $baseUrl, $params, 10, 'shared.pagination') !!}
                </div>
            </div>
        </div>
    </section>
@stop
