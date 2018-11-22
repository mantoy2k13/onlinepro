@extends('layouts.admin.application', ['menu' => 'teacher_notifications'] )

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
TeacherNotifications
@stop

@section('breadcrumb')
    <li><a href="{!! action('Admin\TeacherNotificationController@index') !!}"><i class="fa fa-files-o"></i> TeacherNotifications</a></li>
    @if( $isNew )
        <li class="active">New</li>
    @else
        <li class="active">{{ $teacherNotification->id }}</li>
    @endif
@stop

@section('content')
    @if (count($errors) > 0)
        <div class="alert alert-danger alert-dismissable">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    @if( $isNew )
        <form action="{!! action('Admin\TeacherNotificationController@store') !!}" method="POST" enctype="multipart/form-data">
    @else
        <form action="{!! action('Admin\TeacherNotificationController@update', [$teacherNotification->id]) !!}" method="POST" enctype="multipart/form-data">
            <input type="hidden" name="_method" value="PUT">
    @endif
            {!! csrf_field() !!}
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title">

                    </h3>
                </div>

                <div class="box-body">
                    @if( $isNew )
                        <div class="form-group @if ($errors->has('user_id')) has-error @endif">
                            <label for="user_id">@lang('admin.pages.user-notifications.columns.user_id')</label>
                            <br>
                            <select id="user_id" class="selectpicker  form-control"  name="user_id" data-live-search="true" title="Please select a teacher ...">
                                @foreach ($users as $user)
                                    <option value="{{ $user->id }}" {{ old('user_id') ? 'selected' : '' }} >{{ $user->name . '-' . $user->email }}</option>
                                @endforeach

                            </select>
                        </div>
                    @else
                        <div class="form-group">
                            <p>{{ $teacherNotification->present()->userName }}</p>
                            <input type="hidden" name="user_id" value="{{ $teacherNotification->user_id  }}">
                        </div>
                    @endif
                    <div class="form-group @if ($errors->has('title')) has-error @endif">
                        <label for="title">@lang('admin.pages.teacher-notifications.columns.title')</label>
                        <input type="text" class="form-control" id="title" name="title" value="{{ old('title') ? old('title') : $teacherNotification->title }}">
                    </div>

                    <div class="form-group @if ($errors->has('category_type')) has-error @endif">
                        <label for="category_type">@lang('admin.pages.teacher-notifications.columns.category_type')</label>
                        <input type="text" class="form-control" id="category_type" name="category_type" value="{{ old('category_type') ? old('category_type') : $teacherNotification->category_type }}">
                    </div>

                    <div class="form-group @if ($errors->has('type')) has-error @endif">
                        <label for="type">@lang('admin.pages.teacher-notifications.columns.type')</label>
                        <input type="text" class="form-control" id="type" name="type" value="{{ old('type') ? old('type') : $teacherNotification->type }}">
                    </div>

                    <div class="form-group @if ($errors->has('data')) has-error @endif">
                        <label for="data">@lang('admin.pages.teacher-notifications.columns.data')</label>
                        <textarea name="data" class="form-control" rows="5" placeholder="@lang('admin.pages.teacher-notifications.columns.data')">{{{ old('data') ? old('data') : json_decode($teacherNotification->data) }}}</textarea>
                    </div>

                    <div class="form-group @if ($errors->has('content')) has-error @endif">
                        <label for="content">@lang('admin.pages.teacher-notifications.columns.content')</label>
                        <textarea name="content" class="form-control" rows="5" placeholder="@lang('admin.pages.teacher-notifications.columns.content')">{{{ old('content') ? old('content') : $teacherNotification->content }}}</textarea>
                    </div>

                    <div class="form-group @if ($errors->has('locale')) has-error @endif">
                        <label for="locale">@lang('admin.pages.teacher-notifications.columns.locale')</label>
                        <input type="text" class="form-control" id="locale" name="locale" value="{{ old('locale') ? old('locale') : $teacherNotification->locale }}">
                    </div>

                    <div class="form-group">
                        <div class="checkbox">
                        <label>
                        <input type="checkbox" name="read" value="1"
                        @if( $teacherNotification->read) checked @endif
                        > @lang('admin.pages.teacher-notifications.columns.read')
                        </label>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="sent_at">@lang('admin.pages.teacher-notifications.columns.sent_at')</label>
                        <div class="input-group date datetime-field">
                        <input type="text" class="form-control" name="sent_at"
                        value="{{ old('sent_at') ? old('sent_at') : \DateTimeHelper::formatDateTime($teacherNotification->sent_at) }}">
                        <span class="input-group-addon">
                        <span class="glyphicon glyphicon-calendar"></span>
                        </span>
                        </div>
                    </div>

                </div>
                <div class="box-footer">
                    <button type="submit" class="btn btn-primary">@lang('admin.pages.common.buttons.save')</button>
                </div>
            </div>
        </form>
@stop
