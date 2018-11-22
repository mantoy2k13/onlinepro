@extends('layouts.admin.application', ['menu' => 'personalities'] )

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
Personalities
@stop

@section('breadcrumb')
    <li><a href="{!! action('Admin\PersonalityController@index') !!}"><i class="fa fa-files-o"></i> Personalities</a></li>
    @if( $isNew )
        <li class="active">New</li>
    @else
        <li class="active">{{ $personality->id }}</li>
    @endif
@stop

@section('content')

    @if( $isNew )
        <form action="{!! action('Admin\PersonalityController@store') !!}" method="POST" enctype="multipart/form-data">
    @else
        <form action="{!! action('Admin\PersonalityController@update', [$personality->id]) !!}" method="POST" enctype="multipart/form-data">
            <input type="hidden" name="_method" value="PUT">
    @endif
            {!! csrf_field() !!}
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title">

                    </h3>
                </div>
                <div class="box-body">
                    
                    <div class="form-group @if ($errors->has('name_en')) has-error @endif">
                        <label for="name_en">@lang('admin.pages.personalities.columns.name_en')</label>
                        <input type="text" class="form-control" id="name_en" name="name_en" value="{{ old('name_en') ? old('name_en') : $personality->name_en }}">
                    </div>

                    <div class="form-group @if ($errors->has('name_ja')) has-error @endif">
                        <label for="name_ja">@lang('admin.pages.personalities.columns.name_ja')</label>
                        <input type="text" class="form-control" id="name_ja" name="name_ja" value="{{ old('name_ja') ? old('name_ja') : $personality->name_ja }}">
                    </div>
                    <div class="form-group @if ($errors->has('name_vi')) has-error @endif">
                        <label for="name_vi">@lang('admin.pages.personalities.columns.name_vi')</label>
                        <input type="text" class="form-control" id="name_vi" name="name_vi" value="{{ old('name_vi') ? old('name_vi') : $personality->name_vi }}">
                    </div>
                    <div class="form-group @if ($errors->has('name_zh')) has-error @endif">
                        <label for="name_zh">@lang('admin.pages.personalities.columns.name_zh')</label>
                        <input type="text" class="form-control" id="name_zh" name="name_zh" value="{{ old('name_zh') ? old('name_zh') : $personality->name_zh }}">
                    </div>
                    <div class="form-group @if ($errors->has('name_ru')) has-error @endif">
                        <label for="name_ru">@lang('admin.pages.personalities.columns.name_ru')</label>
                        <input type="text" class="form-control" id="name_ru" name="name_ru" value="{{ old('name_ru') ? old('name_ru') : $personality->name_ru }}">
                    </div>
                    <div class="form-group @if ($errors->has('name_ko')) has-error @endif">
                        <label for="name_ko">@lang('admin.pages.personalities.columns.name_ko')</label>
                        <input type="text" class="form-control" id="name_ko" name="name_ko" value="{{ old('name_ko') ? old('name_ko') : $personality->name_ko }}">
                    </div>

                    <div class="form-group @if ($errors->has('order')) has-error @endif">
                        <label for="order">@lang('admin.pages.personalities.columns.order')</label>
                        <input type="text" class="form-control" id="order" name="order" value="{{ old('order') ? old('order') : $personality->order }}">
                    </div>

                </div>
                <div class="box-footer">
                    <button type="submit" class="btn btn-primary">@lang('admin.pages.common.buttons.save')</button>
                </div>
            </div>
        </form>
@stop
