@extends('layouts.admin.application', ['menu' => 'text_books'] )

@section('metadata')
@stop

@section('styles')
@stop

@section('scripts')
<script src="{!! \URLHelper::asset('js/delete_item.js', 'admin') !!}"></script>
@stop

@section('title')
@stop

@section('header')
TextBooks
@stop

@section('breadcrumb')
<li class="active">TextBooks</li>
@stop

@section('content')
<div class="box box-primary">
    <div class="box-header with-border">
        <h3 class="box-title">
            <p class="text-right">
                <a href="{!! action('Admin\TextBookController@create') !!}" class="btn btn-block btn-primary btn-sm">@lang('admin.pages.common.buttons.create')</a>
            </p>
        </h3>
        <div class="genre-search clearfix">

            <form action="{{ action('Admin\TextBookController@index') }}" method="get">
                <div class="col-lg-6">
                    <div class="form-group">
                        <label for="title">@lang('admin.pages.text-books.columns.title')</label>
                        <input type="text" name="title" class="form-control" id="title" placeholder="@lang('admin.pages.text-books.columns.title')" value="{{ $title }}">
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="form-group">
                        <label for="level">@lang('admin.pages.text-books.columns.level')</label>
                        <input type="text" name="level" class="form-control" id="level" placeholder="@lang('admin.pages.text-books.columns.level')" value="{{ $level }}">
                    </div>
                </div>
                <div class="clearfix"></div>
                <div class="form-group">
                    <p style="text-align: center"><a href="#"  onclick="$(this).parents('form:first').submit(); return false;" class="btn btn-primary">@lang('admin.pages.common.buttons.search')</a></p>
                </div>
            </form>
        </div>
        {!! \PaginationHelper::render($offset, $limit, $count, $baseUrl, $params, 10, 'shared.pagination') !!}
    </div>
    <div class="box-body">
        <table class="table table-bordered">
            <tr>
                <th style="width: 10px">ID</th>
                <th>@lang('admin.pages.text-books.columns.title')</th>
                <th>@lang('admin.pages.text-books.columns.level')</th>
                <th>@lang('admin.pages.text-books.columns.order')</th>
                <th>@lang('admin.pages.text-books.columns.file_id')</th>

                <th style="width: 40px">&nbsp;</th>
            </tr>
            @foreach( $models as $model )
                <tr>
                    <td>{{ $model->id }}</td>
                <td>{{ $model->title }}</td>
                <td>{{ $model->level }}</td>
                <td>{{ $model->order }}</td>

                    <td>
                        @if( !empty($model->file) )
                            <a href="{!! $model->file->url !!}" alt="" class="margin" download>Download</a>
                        @endif
                    </td>
                    <td>
                        <a href="{!! action('Admin\TextBookController@show', $model->id) !!}" class="btn btn-block btn-primary btn-sm">@lang('admin.pages.common.buttons.edit')</a>
                        <a href="#" class="btn btn-block btn-danger btn-sm delete-button" data-delete-url="{!! action('Admin\TextBookController@destroy', $model->id) !!}">@lang('admin.pages.common.buttons.delete')</a>
                    </td>
                </tr>
            @endforeach
        </table>
    </div>
    <div class="box-footer">
        {!! \PaginationHelper::render($offset, $limit, $count, $baseUrl, $params, 10, 'shared.pagination') !!}
    </div>
</div>
@stop
