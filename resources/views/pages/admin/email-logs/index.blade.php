@extends('layouts.admin.application', ['menu' => 'email_logs'] )

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
EmailLogs
@stop

@section('breadcrumb')
<li class="active">EmailLogs</li>
@stop

@section('content')
<div class="box box-primary">
    <div class="box-header with-border">
        <h3 class="box-title">
            <p class="text-right">

            </p>
        </h3>
        <form action="{{ action('Admin\EmailLogController@index') }}" method="get">
            <div class="col-lg-6">
                <div class="form-group">
                    <label for="user_id">@lang('admin.pages.email-logs.columns.user_id')</label>
                    <br>
                    <select id="user_id" class="selectpicker form-control"  name="user_id" data-live-search="true" title="All">
                        <option value=""></option>
                        @foreach ($users as $user)
                            <option value="{{ $user->id }}" {{ $user->id==$userId ? 'selected' : '' }}>
                                {{ $user->name }}</option>
                        @endforeach

                    </select>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="form-group">
                    <label for="status">@lang('admin.pages.email-logs.columns.status')</label>
                    <br>
                    <select id="status" class="selectpicker  form-control"  name="status" data-live-search="true" title="All">
                        <option value="-1"  {{ $status==-1 ? 'selected' : '' }}>All</option>
                        <option value="0" {{ $status==0 ? 'selected' : '' }}>@lang('admin.pages.email-logs.columns.status_false')</option>
                        <option value="1" {{ $status==1 ? 'selected' : '' }}>@lang('admin.pages.email-logs.columns.status_true')</option>

                    </select>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="form-group">
                    <label for="old_email">@lang('admin.pages.email-logs.columns.old_email')</label>
                    <input type="text" name="old_email" class="form-control" id="old_email"
                           placeholder="@lang('admin.pages.email-logs.columns.old_email')" value="{{ $oldEmail }}">
                </div>
            </div>
            <div class="col-lg-6">
                <div class="form-group">
                    <label for="new_email">@lang('admin.pages.email-logs.columns.new_email')</label>
                    <input type="text" name="new_email" class="form-control" id="new_email"
                           placeholder="@lang('admin.pages.email-logs.columns.new_email')" value="{{ $newEmail }}">
                </div>
            </div>
            <div class="col-lg-6">
                <div class="form-group">
                    <label for="validation_code">@lang('admin.pages.email-logs.columns.validation_code')</label>
                    <input type="text" name="validation_code" class="form-control" id="validation_code"
                           placeholder="@lang('admin.pages.email-logs.columns.validation_code')" value="{{ $validationCode }}">
                </div>
            </div>
            <div class="clearfix"></div>
            <div class="form-group">
                <p style="text-align: center"><a href="#"  onclick="$(this).parents('form:first').submit(); return false;" class="btn btn-primary">@lang('admin.pages.common.buttons.search')</a></p>
            </div>
        </form>
        {!! \PaginationHelper::render($offset, $limit, $count, $baseUrl, []) !!}
    </div>
    <div class="box-body">
        <table class="table table-bordered">
            <tr>
                <th style="width: 10px">ID</th>

                <th>@lang('admin.pages.email-logs.columns.old_email')</th>
                <th>@lang('admin.pages.email-logs.columns.new_email')</th>
                <th>@lang('admin.pages.email-logs.columns.user_id')</th>
                <th>@lang('admin.pages.email-logs.columns.status')</th>
                <th>@lang('admin.pages.email-logs.columns.validation_code')</th>
                <th style="width: 40px">&nbsp;</th>
            </tr>
            @foreach( $models as $model )
                <tr>
                    <td>{{ $model->id }}</td>
                    <td>{{ $model->old_email }}</td>
                    <td>{{ $model->new_email }}</td>
                    <td>@if(!empty($model->user))
                        {{ $model->user->name }}
                        @else
                            N/A
                        @endif
                    </td>

                    <td>
                        @if( $model->status )
                            <span class="badge bg-green">@lang('admin.pages.email-logs.columns.status_true')</span>
                        @else
                            <span class="badge bg-red">@lang('admin.pages.email-logs.columns.status_false')</span>
                        @endif
                    </td>
                    <td>{{ $model->validation_code }}</td>
                    <td>
                        <a href="#" class="btn btn-block btn-danger btn-sm delete-button" data-delete-url="{!! action('Admin\EmailLogController@destroy', $model->id) !!}">@lang('admin.pages.common.buttons.delete')</a>
                    </td>
                </tr>
            @endforeach
        </table>
    </div>
    <div class="box-footer">
        {!! \PaginationHelper::render($offset, $limit, $count, $baseUrl, []) !!}
    </div>
</div>
@stop
