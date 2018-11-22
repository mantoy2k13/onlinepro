@extends('layouts.admin.application', ['menu' => 'user_notifications'] )

@section('metadata')
@stop

@section('styles')
@stop

@section('scripts')
    <script src="{!! \URLHelper::asset('js/sortable.js', 'admin') !!}"></script>
    <script src="{!! \URLHelper::asset('js/delete_item.js', 'admin') !!}"></script>
@stop

@section('title')
@stop

@section('header')
    UserNotifications
@stop

@section('breadcrumb')
    <li class="active">UserNotifications</li>
@stop

@section('content')
    <div class="box box-primary">
        <div class="box-header with-border">
            <h3 class="box-title">
                <p class="text-right">
                    <a href="{!! URL::action('Admin\UserNotificationController@create') !!}"
                       class="btn btn-block btn-primary btn-sm">@lang('admin.pages.common.buttons.create')</a>
                </p>
            </h3>
            <div class="genre-search clearfix">

                <form action="{{ action('Admin\UserNotificationController@index') }}" method="get">
                    <div class="col-lg-6">
                        <div class="form-group">
                            <label for="category_type">@lang('admin.pages.user-notifications.columns.category_type')</label>
                            <select id="category_type" data-width="100%" class="selectpicker form-control"  name="category_type" data-live-search="true" title="Select">
                                <option value="">Select</option>
                                @foreach($categories as $catType)
                                    <option value="{{$catType}}"
                                            @if(old('category_type'))
                                            @if(old('category_type')==$catType)
                                            selected
                                            @endif
                                            @else
                                            @if($categoryType == $catType)
                                            selected
                                            @endif
                                            @endif
                                    >{{$catType}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="form-group">
                            <label for="type">@lang('admin.pages.user-notifications.columns.type')</label>

                            <select id="type" data-width="100%" class="selectpicker form-control"  name="type" data-live-search="true" title="Select">
                                <option value="">Select</option>
                                @foreach($types as $tp)
                                    <option value="{{$tp}}"
                                            @if(old('type'))
                                            @if(old('type')==$tp)
                                            selected
                                            @endif
                                            @else
                                            @if($type == $tp)
                                            selected
                                            @endif
                                            @endif
                                    >{{$tp}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="form-group">
                            <label for="user_id">@lang('admin.pages.user-notifications.columns.user_id')</label>
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
                            <label for="read">@lang('admin.pages.user-notifications.columns.read')</label>
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
        <div class="box-body scroll">
            <table class="table table-bordered">
                <tr>
                    <th style="width: 10px">ID</th>
                    <th>@lang('admin.pages.user-notifications.columns.user_id')</th>
                    <th>@lang('admin.pages.user-notifications.columns.title')</th>
                    <th>@lang('admin.pages.user-notifications.columns.category_type')</th>
                    <th>@lang('admin.pages.user-notifications.columns.type')</th>
                    <th>@lang('admin.pages.user-notifications.columns.locale')</th>
                    <th>@lang('admin.pages.user-notifications.columns.content')</th>
                    <th>@lang('admin.pages.user-notifications.columns.read')</th>
                    <th>@lang('admin.pages.user-notifications.columns.sent_at')</th>
                    <th style="width: 40px">&nbsp;</th>
                </tr>
                @foreach( $models as $model )
                    <tr>
                            <td>{{ $model->id }}</td>
                        <td>
                            @if( $model->isBroadcast() )
                                {{ $model->present()->userName }}
                            @else
                                <a href="{{ action('Admin\UserController@show',[$model->user_id]) }}">
                                    {{ $model->present()->userName }}
                                </a>
                            @endif
                        </td>
                        <td>{{ $model->title }}</td>
                        <td>{{ $model->category_type }}</td>
                        <td>{{ $model->type }}</td>
                        <td>{{ $model->locale }}</td>
                        <td>{{ $model->content }}</td>
                        <td>
                            @if( !$model->isBroadcast() )
                            @if( $model->read )
                                <span class="badge bg-green">@lang('admin.pages.user-notifications.columns.read_true')</span>
                            @else
                                <span class="badge bg-red">@lang('admin.pages.user-notifications.columns.read_false')</span>
                            @endif
                            @endif
                        </td>
                        <td>{{ $model->present()->sentAt }}</td>
                        <td>
                            <a href="{!! URL::action('Admin\UserNotificationController@show', $model->id) !!}"
                               class="btn btn-block btn-primary btn-sm">@lang('admin.pages.common.buttons.edit')</a>
                            <a href="#" class="btn btn-block btn-danger btn-sm delete-button"
                               data-delete-url="{!! action('Admin\UserNotificationController@destroy', $model->id) !!}">@lang('admin.pages.common.buttons.delete')</a>
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
