@extends('layouts.admin.application', ['menu' => 'inquiries'] )

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
Inquiries
@stop

@section('breadcrumb')
    <li><a href="{!! action('Admin\InquiryController@index') !!}"><i class="fa fa-files-o"></i> Inquiries</a></li>

    @if( $isNew )
        <li class="active">New</li>
    @else
        <li class="active">{{ $inquiry->id }}</li>
    @endif
@stop

@section('content')
    <div class="box-header">
        <a href="{!! URL::action('Admin\InquiryController@index') !!}" style="width: 125px; font-size: 14px;" class="btn btn-block btn-default btn-sm">@lang('admin.pages.common.buttons.back')</a>
    </div>
    @if( $isNew )
        <form action="{!! action('Admin\InquiryController@store') !!}" method="POST" enctype="multipart/form-data">
    @else
        <form action="{!! action('Admin\InquiryController@update', [$inquiry->id]) !!}" method="POST" enctype="multipart/form-data">
            <input type="hidden" name="_method" value="PUT">
    @endif
            {!! csrf_field() !!}
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title">

                    </h3>
                </div>
                <div class="box-body">

                    <div class="form-group @if ($errors->has('type')) has-error @endif">
                        <label for="type">@lang('admin.pages.inquiries.columns.type')</label>
                        <input type="text" class="form-control" id="type" name="type" value="{{ old('type') ? old('type') : $inquiry->type }}">
                    </div>
                    <div class="form-group @if ($errors->has('name')) has-error @endif">
                        <label for="name">@lang('admin.pages.inquiries.columns.name')</label>
                        <input type="text" class="form-control" id="name" name="name" value="{{ old('name') ? old('name') : $inquiry->name }}">
                    </div>
                    <div class="form-group @if ($errors->has('email')) has-error @endif">
                        <label for="email">@lang('admin.pages.inquiries.columns.email')</label>
                        <input type="email" class="form-control" id="email" name="email" value="{{ old('email') ? old('email') : $inquiry->email }}">
                    </div>
                    <div class="form-group @if ($errors->has('living_country_code')) has-error @endif">
                        <label for="living_country_code">@lang('admin.pages.inquiries.columns.living_country_code')</label>
                        <br>
                        <select id="living_country_code" class="selectpicker form-control"  name="living_country_code" data-live-search="true" title="Please select a country ...">
                            @foreach ($countries as $country)
                                <option value="{{ $country->code }}" {{ old('country_code') ? 'selected' : '' }}
                                        {{ $country->code==$inquiry->living_country_code ? 'selected' : '' }}>{{ $country->name_en }}</option>
                            @endforeach

                        </select>
                    </div>
                    <div class="form-group @if ($errors->has('type')) has-error @endif">
                        <label for="content">@lang('admin.pages.inquiries.columns.content')</label>
                        <textarea name="content" class="form-control" rows="5" placeholder="Content">{{ old('content') ? old('content') : $inquiry->content }}</textarea>
                    </div>

                </div>
                <div class="box-footer">
                    <button type="submit" class="btn btn-primary">@lang('admin.pages.common.buttons.save')</button>
                </div>
            </div>
        </form>
@stop
