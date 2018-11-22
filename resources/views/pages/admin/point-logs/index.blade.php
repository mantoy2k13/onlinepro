@extends('layouts.admin.application', ['menu' => 'point_logs'] )

@section('metadata')
@stop

@section('styles')
@stop

@section('scripts')
<script src="{!! \URLHelper::asset('js/delete_item.js', 'admin') !!}"></script>
<script>
    $('#export').click(function(){
        var url = "{{ action('Admin\PointLogController@exportExcel') }}?" + $("#form-search").serialize();
        window.location = url;
    });
</script>
@stop

@section('title')
@stop

@section('header')
PointLogs
@stop

@section('breadcrumb')
<li class="active">PointLogs</li>
@stop

@section('content')
<div class="box box-primary">
    <div class="box-header with-border">
        <h3 class="box-title">
            <p class="text-right">
                <a href="{!! URL::action('Admin\PointLogController@create') !!}" class="btn btn-block btn-primary btn-sm">@lang('admin.pages.common.buttons.create')</a>
            </p>
        </h3>
        <div class="genre-search clearfix">

            <form action="{{ action('Admin\PointLogController@index') }}" method="get" id="form-search">
                <div class="col-lg-6">
                    <div class="form-group">
                        <label for="type">@lang('admin.pages.point-logs.columns.type')</label>
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
                        <label for="point_amount">@lang('admin.pages.point-logs.columns.point_amount')</label>
                        <input type="text" name="point_amount" class="form-control" id="point_amount" placeholder="@lang('admin.pages.point-logs.columns.point_amount')" value="{{ $pointAmount }}">
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="form-group">
                        <label for="user_id">@lang('admin.pages.point-logs.columns.user_id')</label>
                        <br>
                        <select id="user_id" class="selectpicker form-control"  name="user_id" data-live-search="true" title="All">
                            <option value="">All</option>
                            @foreach ($users as $user)
                                <option value="{{ $user->id }}" {{ $user->id==$userId ? 'selected' : '' }}>
                                    {{ $user->name }}</option>
                            @endforeach

                        </select>
                    </div>
                </div>
                <div class="clearfix"></div>
                <div class="form-group">
                    <p style="text-align: center"><a href="#"  onclick="$(this).parents('form:first').submit(); return false;" class="btn btn-primary">@lang('admin.pages.common.buttons.search')</a></p>
                    <button type="button" class="btn btn-primary" id="export">Export</button>
                </div>
            </form>
        </div>
        {!! \PaginationHelper::render($offset, $limit, $count, $baseUrl, $params, 10, 'shared.pagination') !!}
    </div>
    <div class="box-body">
        <table class="table table-bordered">
            <tr>
                <th style="width: 10px">ID</th>
                <th>@lang('admin.pages.point-logs.columns.point_amount')</th>
                <th>@lang('admin.pages.point-logs.columns.type')</th>
                <th>@lang('admin.pages.point-logs.columns.user_id')</th>
                <th>@lang('admin.pages.point-logs.columns.created_at')</th>
                <th>@lang('admin.pages.point-logs.columns.expire_at')</th>

            </tr>
            @foreach( $models as $model )
                <tr>
                    <td>{{ $model->id }}</td>
                <td>{{ $model->point_amount }}</td>
                <td>{{ $model->type }}
                    <br>
                    {{ $model->present()->package }}
                </td>
                <td>@if(!empty($model->user))
                    {{ $model->user->name }}
                    @endif
                </td>
                    <td>{{ $model->present()->createdAt }}</td>
                    <td>
                        @if(!empty($model->purchaseLog) && $model->point_amount > 0)
                            {{ $model->purchaseLog->point_expired_at }}
                        @endif

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