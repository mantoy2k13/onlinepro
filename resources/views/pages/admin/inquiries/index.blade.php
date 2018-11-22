@extends('layouts.admin.application', ['menu' => 'inquiries'] )

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
Inquiries
@stop

@section('breadcrumb')
<li class="active">Inquiries</li>
@stop

@section('content')
<div class="box box-primary">
    <div class="box-header with-border">
        <h3 class="box-title">
            <p class="text-right">
                <a href="{!! action('Admin\InquiryController@create') !!}" class="btn btn-block btn-primary btn-sm">@lang('admin.pages.common.buttons.create')</a>
            </p>
        </h3>
        <div class="genre-search clearfix">

            <form action="{{ action('Admin\InquiryController@index') }}" method="get">
                <div class="col-lg-6">
                    <div class="form-group">
                        <label for="type">@lang('admin.pages.inquiries.columns.type')</label>
                        <input type="text" name="type" class="form-control" id="type" placeholder="@lang('admin.pages.inquiries.columns.type')" value="{{ $type }}">
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="form-group">
                        <label for="name">@lang('admin.pages.inquiries.columns.name')</label>
                        <input type="text" name="name" class="form-control" id="name" placeholder="@lang('admin.pages.inquiries.columns.name')" value="{{ $name }}">
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="form-group">
                        <label for="email">@lang('admin.pages.inquiries.columns.email')</label>
                        <input type="text" name="email" class="form-control" id="email" placeholder="@lang('admin.pages.inquiries.columns.email')" value="{{ $email }}">
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="form-group">
                        <label for="living_country_code">@lang('admin.pages.inquiries.columns.living_country_code')</label>
                        <br>
                        <select id="living_country_code" class="selectpicker form-control"  name="living_country_code" data-live-search="true" title="All">
                            <option value="">All</option>
                            @foreach ($countries as $country)
                                <option value="{{ $country->code }}" {{ $country->code==$livingCountryCode ? 'selected' : '' }}>
                                    {{ $country->name_en . '-' .$country->name_ja}}</option>
                            @endforeach

                        </select>
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
                <th>@lang('admin.pages.inquiries.columns.name')</th>
                <th>@lang('admin.pages.inquiries.columns.email')</th>
                <th>@lang('admin.pages.inquiries.columns.user_id')</th>
                <th>@lang('admin.pages.inquiries.columns.living_country_code')</th>
                <th>@lang('admin.pages.inquiries.columns.content')</th>

                <th style="width: 40px">&nbsp;</th>
            </tr>
            @foreach( $models as $model )
                <tr>
                    <td>{{ $model->id }}</td>
                    <td>{{ $model->name }}</td>
                    <td>{{ $model->email }}</td>
                    <td>
                        @if(!empty($model->user_id))
                            <a href="{!! action('Admin\UserController@show', $model->user_id) !!}">{!! $model->user->name !!}</a>
                        @endif
                    </td>
                    <td>
                        @if(!empty($model->living_country_code))
                            {!! $model->country->name_en !!}
                        @endif
                    </td>
                    <td>{{ $model->content }}</td>
                    <td>
                        <a href="{!! action('Admin\InquiryController@show', $model->id) !!}" class="btn btn-block btn-primary btn-sm">@lang('admin.pages.common.buttons.edit')</a>
                        <a href="#" class="btn btn-block btn-danger btn-sm delete-button" data-delete-url="{!! action('Admin\InquiryController@destroy', $model->id) !!}">@lang('admin.pages.common.buttons.delete')</a>
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
