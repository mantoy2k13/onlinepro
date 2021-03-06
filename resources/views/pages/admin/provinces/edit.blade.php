@extends('layouts.admin.application', ['menu' => 'provinces'] )

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
Provinces
@stop

@section('breadcrumb')
    <li><a href="{!! action('Admin\ProvinceController@index') !!}"><i class="fa fa-files-o"></i> Provinces</a></li>
    @if( $isNew )
        <li class="active">New</li>
    @else
        <li class="active">{{ $province->id }}</li>
    @endif
@stop

@section('content')

    @if( $isNew )
        <form action="{!! action('Admin\ProvinceController@store') !!}" method="POST" enctype="multipart/form-data">
    @else
        <form action="{!! action('Admin\ProvinceController@update', [$province->id]) !!}" method="POST" enctype="multipart/form-data">
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
                        <label for="name_en">@lang('admin.pages.provinces.columns.name_en')</label>
                        <input type="text" class="form-control" id="name_en" name="name_en" value="{{ old('name_en') ? old('name_en') : $province->name_en }}">
                    </div>

                    <div class="form-group @if ($errors->has('name_ja')) has-error @endif">
                        <label for="name_ja">@lang('admin.pages.provinces.columns.name_ja')</label>
                        <input type="text" class="form-control" id="name_ja" name="name_ja" value="{{ old('name_ja') ? old('name_ja') : $province->name_ja }}">
                    </div>

                    <div class="form-group @if ($errors->has('country_code')) has-error @endif">
                        <label for="country_code">@lang('admin.pages.provinces.columns.country_code')</label>
                        <br>
                        <select id="country_code" class="selectpicker"  name="country_code" data-live-search="true" title="Please select a country ...">
                            @foreach ($countries as $country)
                                <option value="{{ $country->code }}" {{ old('country_code') ? 'selected' : '' }}
                                        {{ $country->code==$province->country_code ? 'selected' : '' }}>{{ $country->name_en . '-' .$country->name_ja}}</option>
                            @endforeach

                        </select>
                    </div>

                    <div class="form-group @if ($errors->has('order')) has-error @endif">
                        <label for="order">@lang('admin.pages.provinces.columns.order')</label>
                        <input type="text" class="form-control" id="order" name="order" value="{{ old('order') ? old('order') : $province->order }}">
                    </div>

                </div>
                <div class="box-footer">
                    <button type="submit" class="btn btn-primary">@lang('admin.pages.common.buttons.save')</button>
                </div>
            </div>
        </form>
@stop
