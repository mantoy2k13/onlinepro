@extends('layouts.admin.application', ['menu' => 'countries'] )

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
Countries
@stop

@section('breadcrumb')
    <li><a href="{!! action('Admin\CountryController@index') !!}"><i class="fa fa-files-o"></i> Countries</a></li>
    @if( $isNew )
        <li class="active">New</li>
    @else
        <li class="active">{{ $country->id }}</li>
    @endif
@stop

@section('content')

    @if( $isNew )
        <form action="{!! action('Admin\CountryController@store') !!}" method="POST" enctype="multipart/form-data">
    @else
        <form action="{!! action('Admin\CountryController@update', [$country->id]) !!}" method="POST" enctype="multipart/form-data">
            <input type="hidden" name="_method" value="PUT">
    @endif
            {!! csrf_field() !!}
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title">

                    </h3>
                </div>
                <div class="box-body">
                    
                    <div class="form-group @if ($errors->has('code')) has-error @endif">
                        <label for="code">@lang('admin.pages.countries.columns.code')</label>
                        <input type="text" class="form-control" id="code" name="code" value="{{ old('code') ? old('code') : $country->code }}">
                    </div>

                    <div class="form-group @if ($errors->has('name_en')) has-error @endif">
                        <label for="name_en">@lang('admin.pages.countries.columns.name_en')</label>
                        <input type="text" class="form-control" id="name_en" name="name_en" value="{{ old('name_en') ? old('name_en') : $country->name_en }}">
                    </div>

                    <div class="form-group @if ($errors->has('name_ja')) has-error @endif">
                        <label for="name_ja">@lang('admin.pages.countries.columns.name_ja')</label>
                        <input type="text" class="form-control" id="name_ja" name="name_ja" value="{{ old('name_ja') ? old('name_ja') : $country->name_ja }}">
                    </div>

                    @if( !empty($country->flagImage) )
                        <img id="cover-image-preview" width="52" src="{!! $country->flagImage->getThumbnailUrl(104, 76) !!}" alt="" class="margin" />
                    @else
                        <img width="52" style="display: none" id="cover-image-preview" src="{!! \URLHelper::asset('img/default-thumbnail.jpg', 'common') !!}" alt="" class="margin" />
                    @endif
                    <div class="form-group">
                        <label for="flag_image">@lang('admin.pages.countries.columns.flag_image_id')</label>
                        <input type="file" id="cover-image" name="flag_image" class="image-input" accept="image/*">
                        <p class="help-block">@lang('admin.pages.countries.columns.flag_image_id')</p>
                    </div>

                    <div class="form-group @if ($errors->has('order')) has-error @endif">
                        <label for="order">@lang('admin.pages.countries.columns.order')</label>
                        <input type="text" class="form-control" id="order" name="order" value="{{ old('order') ? old('order') : $country->order }}">
                    </div>
                </div>
                <div class="box-footer">
                    <button type="submit" class="btn btn-primary">@lang('admin.pages.common.buttons.save')</button>
                </div>
            </div>
        </form>
@stop
