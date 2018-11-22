@extends('layouts.admin.application', ['menu' => 'teacher_notifications'] )

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
TeacherNotifications
@stop

@section('breadcrumb')
<li class="active">TeacherNotifications</li>
@stop

@section('content')
<div class="box box-primary">
    <div class="box-header with-border">
        <h3 class="box-title">
            <p class="text-right">
                <a href="{!! action('Admin\TeacherNotificationController@create') !!}" class="btn btn-block btn-primary btn-sm">@lang('admin.pages.common.buttons.create')</a>
            </p>
        </h3>
        <div class="genre-search clearfix">

            <form action="{{ action('Admin\TeacherNotificationController@index') }}" method="get">
                <div class="col-lg-6">
                    <div class="form-group">
                        <label for="title">@lang('admin.pages.teacher-notifications.columns.title')</label>
                        <input type="text" name="title" class="form-control" id="title" placeholder="@lang('admin.pages.teacher-notifications.columns.title')" value="{{ $title }}">
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="form-group">
                        <label for="category_type">@lang('admin.pages.teacher-notifications.columns.category_type')</label>
                        <input type="text" name="category_type" class="form-control" id="category_type" placeholder="@lang('admin.pages.teacher-notifications.columns.category_type')" value="{{ $categoryType }}">
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="form-group">
                        <label for="type">@lang('admin.pages.teacher-notifications.columns.type')</label>
                        <input type="text" name="type" class="form-control" id="type" placeholder="@lang('admin.pages.teacher-notifications.columns.type')" value="{{ $type }}">
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="form-group">
                        <label for="user_id">@lang('admin.pages.teacher-notifications.columns.user_id')</label>
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
                        <label for="read">@lang('admin.pages.teacher-notifications.columns.read')</label>
                        <br>
                        <select id="read" class="selectpicker  form-control"  name="read" data-live-search="true" title="All">
                            <option value="-1"  {{ $read==-1 ? 'selected' : '' }}>All</option>
                            <option value="0" {{ $read==0 ? 'selected' : '' }}>Unread</option>
                            <option value="1" {{ $read==1 ? 'selected' : '' }}>Readed</option>

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
                <th>@lang('admin.pages.teacher-notifications.columns.user_id')</th>
                <th>@lang('admin.pages.teacher-notifications.columns.title')</th>
                <th>@lang('admin.pages.teacher-notifications.columns.category_type')</th>
                <th>@lang('admin.pages.teacher-notifications.columns.type')</th>
                <th>@lang('admin.pages.teacher-notifications.columns.locale')</th>
                <th>@lang('admin.pages.teacher-notifications.columns.read')</th>
                <th>@lang('admin.pages.teacher-notifications.columns.sent_at')</th>

                <th style="width: 40px">&nbsp;</th>
            </tr>
            @foreach( $models as $model )
                <tr>
                    <td>{{ $model->id }}</td>
                    <td>
                        @if( $model->isBroadcast() )
                            {{ $model->present()->userName }}
                        @else
                            <a href="{{ action('Admin\TeacherController@show',[$model->user_id]) }}">
                                {{ $model->present()->userName }}
                            </a>
                        @endif
                    </td>
                <td>{{ $model->title }}</td>
                <td>{{ $model->category_type }}</td>
                <td>{{ $model->type }}</td>
                <td>{{ $model->locale }}</td>
                <td>{{ $model->read }}</td>
                <td>{{ $model->present()->sentAt }}</td>

                    <td>
                        <a href="{!! action('Admin\TeacherNotificationController@show', $model->id) !!}" class="btn btn-block btn-primary btn-sm">@lang('admin.pages.common.buttons.edit')</a>
                        <a href="#" class="btn btn-block btn-danger btn-sm delete-button" data-delete-url="{!! action('Admin\TeacherNotificationController@destroy', $model->id) !!}">@lang('admin.pages.common.buttons.delete')</a>
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
