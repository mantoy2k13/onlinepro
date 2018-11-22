@extends('layouts.admin.application', ['menu' => 'lessons'] )

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
Lessons
@stop

@section('breadcrumb')
    <li><a href="{!! action('Admin\LessonController@index') !!}"><i class="fa fa-files-o"></i> Lessons</a></li>
    @if( $isNew )
        <li class="active">New</li>
    @else
        <li class="active">{{ $lesson->id }}</li>
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
        <form action="{!! action('Admin\LessonController@store') !!}" method="POST" enctype="multipart/form-data">
    @else
        <form action="{!! action('Admin\LessonController@update', [$lesson->id]) !!}" method="POST" enctype="multipart/form-data">
            <input type="hidden" name="_method" value="PUT">
    @endif
            {!! csrf_field() !!}
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title">

                    </h3>
                </div>
                <div class="box-body">
                    
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group @if ($errors->has('name_ja')) has-error @endif">
                                <label for="name_ja">@lang('admin.pages.lessons.columns.name_ja')</label>
                                <input type="text" class="form-control" id="name_ja" name="name_ja" value="{{ old('name_ja') ? old('name_ja') : $lesson->name_ja }}">
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group @if ($errors->has('name_en')) has-error @endif">
                                <label for="name_en">@lang('admin.pages.lessons.columns.name_en')</label>
                                <input type="text" class="form-control" id="name_en" name="name_en" value="{{ old('name_en') ? old('name_en') : $lesson->name_en }}">
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group @if ($errors->has('slug')) has-error @endif">
                                <label for="slug">@lang('admin.pages.lessons.columns.slug')</label>
                                <input type="text" class="form-control" id="slug" name="slug" value="{{ old('slug') ? old('slug') : $lesson->slug }}">
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-12">
                        @if( !empty($lesson->image) )
                            <img width="400" src="{!! $lesson->image->getThumbnailUrl(480, 300) !!}" alt="" class="margin" />
                        @endif
                            <div class="form-group">
                                <label for="image">@lang('admin.pages.lessons.columns.image_id')</label>
                                <input type="file" id="image-image" name="image">
                                <p class="help-block">@lang('admin.pages.lessons.columns.image_id')</p>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group @if ($errors->has('description_ja')) has-error @endif">
                              <label for="description_ja">@lang('admin.pages.lessons.columns.description_ja')</label>
                              <textarea name="description_ja" class="form-control" rows="5" placeholder="@lang('admin.pages.lessons.columns.description_ja')">{{ old('description_ja') ? old('description_ja') : $lesson->description_ja }}</textarea>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group @if ($errors->has('description_en')) has-error @endif">
                              <label for="description_en">@lang('admin.pages.lessons.columns.description_en')</label>
                              <textarea name="description_en" class="form-control" rows="5" placeholder="@lang('admin.pages.lessons.columns.description_en')">{{ old('description_en') ? old('description_en') : $lesson->description_en }}</textarea>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group @if ($errors->has('order')) has-error @endif">
                                <label for="order">@lang('admin.pages.lessons.columns.order')</label>
                                <input type="text" class="form-control" id="order" name="order" value="{{ old('order') ? old('order') : $lesson->order }}">
                            </div>
                        </div>
                    </div>

                </div>
                <div class="box-footer">
                    <button type="submit" class="btn btn-primary">@lang('admin.pages.common.buttons.save')</button>
                </div>
            </div>
        </form>
@stop
