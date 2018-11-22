@extends('layouts.user.application', ['noFrame' => false, 'bodyClasses' => '', 'menuUser' => 'text-books'])

@section('metadata')
@stop

@section('styles')
@stop

@section('scripts')
@stop

@section('title')
    @lang('user.pages.textbooks.page_title')
@stop

@section('header')
@stop
@section('breadcrumbs', Breadcrumbs::render('text-books'))
@section('content')
    <main>
        <div class="wrap">
            <section>
                <div class="box-g">
                    <p class="fontcol-o title-s">@lang('user.pages.textbooks.download')</p>
                    <ul class="textlist">
                        @foreach($models as $model)
                        <li><a href="@if( !empty($model->file) ) {!! $model->file->url !!} @else # @endif">{!! $model->title !!}</a></li>
                            @endforeach
                    </ul>
                </div>
            </section>
        </div>
        @if($count > 0)
            {!! \PaginationHelper::render($offset, $limit, $count, $baseUrl, $params, 10, 'shared.pagination') !!}
        @endif
    </main>
@stop
