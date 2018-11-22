@extends('layouts.admin.application', ['menu' => 'point_logs'] )

@section('metadata')
@stop

@section('styles')
@stop

@section('scripts')
<script src="{{ \URLHelper::asset('libs/moment/moment.min.js', 'admin') }}"></script>
<script src="{{ \URLHelper::asset('libs/datetimepicker/js/bootstrap-datetimepicker.min.js', 'admin') }}"></script>
<script>
$('.datetime-field').datetimepicker({'format': 'YYYY-MM-DD HH:mm:ss'});
</script>
@stop

@section('title')
@stop

@section('header')
PointLogs
@stop

@section('breadcrumb')
    <li><a href="{!! action('Admin\PointLogController@index') !!}"><i class="fa fa-files-o"></i> PointLogs</a></li>
    @if( $isNew )
        <li class="active">New</li>
    @else
        <li class="active">{{ $pointLog->id }}</li>
    @endif
@stop

@section('content')

    @if( $isNew )
        <form action="{!! action('Admin\PointLogController@store') !!}" method="POST" enctype="multipart/form-data">
    @else
        <form action="{!! action('Admin\PointLogController@update', [$pointLog->id]) !!}" method="POST" enctype="multipart/form-data">
            <input type="hidden" name="_method" value="PUT">
    @endif
            {!! csrf_field() !!}
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title">

                    </h3>
                </div>
                <div class="box-body">
                    <div class="form-group  @if ($errors->has('user_id')) has-error @endif">
                        <label for="user_id">@lang('admin.pages.point-logs.columns.user_id')</label>
                        <br>
                        <select id="user_id" class="selectpicker form-control"  name="user_id" data-live-search="true" title="Choose one">
                            @foreach ($users as $user)
                                <option value="{{ $user->id }}" {{ $user->id==$pointLog->user_id ? 'selected' : '' }}>
                                    {{ $user->name . '-' .$user->email }}</option>
                            @endforeach

                        </select>
                    </div>
                    <div class="form-group @if ($errors->has('point_amount')) has-error @endif">
                        <label for="point_amount">@lang('admin.pages.point-logs.columns.point_amount')</label>
                        <input type="text" class="form-control" id="point_amount" name="point_amount" value="{{ old('point_amount') ? old('point_amount') : $pointLog->point_amount }}">
                    </div>

                    <div class="form-group @if ($errors->has('type')) has-error @endif">
                        <label for="type">@lang('admin.pages.point-logs.columns.type')</label>
                        <select id="type" data-width="100%" class="selectpicker form-control"  name="type" data-live-search="true" title="Select">
                            <option value="">Select</option>
                            @foreach($types as $type)
                            <option value="{{$type}}"
                                    @if(old('type'))
                                        @if(old('type')==$type)
                                            selected
                                        @endif
                                    @else
                                        @if($pointLog->type == $type)
                                            selected
                                        @endif
                                    @endif
                                    >{{$type}}</option>
                                @endforeach
                        </select>
                    </div>

                    <div class="form-group @if ($errors->has('description')) has-error @endif">
                        <label for="description">@lang('admin.pages.point-logs.columns.description')</label>
                        <textarea name="description" class="form-control" rows="5" placeholder="@lang('admin.pages.point-logs.columns.description')">{{{ old('description') ? old('description') : $pointLog->description }}}</textarea>
                    </div>

                </div>
                <div class="box-footer">
                    <button type="submit" class="btn btn-primary">@lang('admin.pages.common.buttons.save')</button>
                </div>
            </div>
        </form>
@stop
