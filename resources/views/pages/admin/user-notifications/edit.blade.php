@extends('layouts.admin.application', ['menu' => 'user_notifications'] )

@section('metadata')
@stop

@section('styles')
@stop

@section('scripts')
@stop

@section('title')
@stop

@section('header')
    UserNotifications
@stop

@section('breadcrumb')
    <li><a href="{!! action('Admin\UserNotificationController@index') !!}"><i class="fa fa-files-o"></i>
            UserNotifications</a></li>
    @if( $isNew )
        <li class="active">New</li>
    @else
        <li class="active">{{ $userNotification->id }}</li>
    @endif
@stop

@section('content')
    @if( $isNew )
        <form action="{!! action('Admin\UserNotificationController@store') !!}" method="POST"
              enctype="multipart/form-data">
            @else
                <form action="{!! action('Admin\UserNotificationController@update', [$userNotification->id]) !!}"
                      method="POST" enctype="multipart/form-data">
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
                                    <select id="user_id" class="selectpicker  form-control" name="user_id"
                                            data-live-search="true" title="Please select a user ...">
                                        <option value="">All</option>
                                        @foreach ($users as $user)
                                            <option value="{{ $user->id }}" {{ old('user_id') ? 'selected' : '' }} >{{ $user->name . '-' . $user->email }}</option>
                                        @endforeach

                                    </select>
                                </div>
                            @else
                                <div class="form-group">
                                    <p>{{ $userNotification->present()->userName }}</p>
                                    <input type="hidden" name="user_id" value="{{ $userNotification->user_id  }}">
                                </div>
                            @endif
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group @if ($errors->has('title')) has-error @endif">
                                            <label
                                                    for="title">@lang('admin.pages.user-notifications.columns.title')</label>
                                            <input type="text" class="form-control" id="title"
                                                   name="title"
                                                   value="{{ old('title') ? old('title') : $userNotification->title }}">
                                        </div>
                                    </div>
                                </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group @if ($errors->has('category_type')) has-error @endif">
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
                                                        @if($userNotification->category_type == $catType)
                                                        selected
                                                        @endif
                                                        @endif
                                                >{{$catType}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group @if ($errors->has('type')) has-error @endif">
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
                                                @if($userNotification->type == $tp)
                                                selected
                                                @endif
                                                @endif
                                        >{{$tp}}</option>
                                    @endforeach
                                </select>
                            </div>

                            <label for="locale">@lang('admin.pages.site-configurations.columns.locale')</label>
                            <select name="locale" class="form-control">
                                @foreach( config('locale.languages') as $code => $locale )
                                    <option value="{!! $code !!}"
                                            @if( (old('locale') && old('locale') == $code) || (!old('locale') && $userNotification->locale == $code)) selected @endif >@lang(array_get($locale, 'name', $code))</option>
                                @endforeach
                            </select>

                            <div class="form-group @if ($errors->has('data')) has-error @endif">
                                <label for="data">@lang('admin.pages.user-notifications.columns.data')</label>
                                <textarea name="data" class="form-control" rows="5"
                                          placeholder="JSON DATA">{{ old('data') ? old('data') : json_decode($userNotification->data) }}</textarea>
                            </div>

                            <div class="form-group @if ($errors->has('content')) has-error @endif">
                                <label for="content">@lang('admin.pages.user-notifications.columns.content')</label>
                                <textarea name="content" class="form-control" rows="5"
                                          placeholder="Content">{{ old('content') ? old('content') : $userNotification->content }}</textarea>
                            </div>
                        </div>
                        <div class="box-footer">
                            <button type="submit"
                                    class="btn btn-primary">@lang('admin.pages.common.buttons.save')</button>
                        </div>
                    </div>
                </form>
@stop
