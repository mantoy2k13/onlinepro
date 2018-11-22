@extends('layouts.admin.application', ['menu' => 'email_logs'] )

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
EmailLogs
@stop

@section('breadcrumb')
    <li><a href="{!! action('Admin\EmailLogController@index') !!}"><i class="fa fa-files-o"></i> EmailLogs</a></li>
    @if( $isNew )
        <li class="active">New</li>
    @else
        <li class="active">{{ $emailLog->id }}</li>
    @endif
@stop

@section('content')

    @if( $isNew )
        <form action="{!! action('Admin\EmailLogController@store') !!}" method="POST" enctype="multipart/form-data">
    @else
        <form action="{!! action('Admin\EmailLogController@update', [$emailLog->id]) !!}" method="POST" enctype="multipart/form-data">
            <input type="hidden" name="_method" value="PUT">
    @endif
            {!! csrf_field() !!}
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title">

                    </h3>
                </div>
                <div class="box-body">
                    <div class="form-group @if ($errors->has('old_email')) has-error @endif">
                        <label for="old_email">@lang('admin.pages.email-logs.columns.old_email')</label>
                        <input type="text" class="form-control" id="old_email" name="old_email" value="{{ old('old_email') ? old('old_email') : $emailLog->old_email }}">
                    </div>

                    <div class="form-group @if ($errors->has('new_email')) has-error @endif">
                        <label for="new_email">@lang('admin.pages.email-logs.columns.new_email')</label>
                        <input type="text" class="form-control" id="new_email" name="new_email" value="{{ old('new_email') ? old('new_email') : $emailLog->new_email }}">
                    </div>
                    <div class="form-group">
                        <label for="user_id">@lang('admin.pages.user-notifications.columns.user_id')</label>
                        <br>
                        <select id="user_id" class="selectpicker form-control"  name="user_id" data-live-search="true" title="All">
                            <option value="0"></option>
                            @foreach ($users as $user)
                                <option value="{{ $user->id }}" {{ $user->id==$emailLog->user_id ? 'selected' : '' }} {{ old('user_id')==$user->id ? 'selected' : '' }}>
                                    {{ $user->name }}</option>
                            @endforeach

                        </select>
                    </div>
                    <div class="form-group @if ($errors->has('status')) has-error @endif">
                        <div class="form-group">
                            <label for="read">@lang('admin.pages.email-logs.columns.status')</label>
                            <br>
                            <select id="status" class="selectpicker  form-control"  name="status" data-live-search="true" title="All">
                                <option value="0" {{ $emailLog->status==0 ? 'selected' : '' }} {{ old('status')==0 ? 'selected' : '' }} >@lang('admin.pages.email-logs.columns.status_false')</option>
                                <option value="1" {{ $emailLog->status==1 ? 'selected' : '' }} {{ old('status')==1 ? 'selected' : '' }}>@lang('admin.pages.email-logs.columns.status_true')</option>

                            </select>
                        </div>
                    </div>
                    <div class="form-group @if ($errors->has('validation_code')) has-error @endif">
                        <label for="validation_code">@lang('admin.pages.email-logs.columns.validation_code')</label>
                        <input type="text" class="form-control" id="validation_code" name="validation_code" value="{{ old('validation_code') ? old('validation_code') : $emailLog->validation_code }}">
                    </div>
                </div>
                <div class="box-footer">
                    <button type="submit" class="btn btn-primary">@lang('admin.pages.common.buttons.save')</button>
                </div>
            </div>
        </form>
@stop
