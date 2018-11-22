@extends('layouts.admin.application', ['menu' => 'teachers'] )

@section('metadata')
@stop

@section('styles')
@stop

@section('scripts')
<script src="{{ \URLHelper::asset('libs/moment/moment.min.js', 'admin') }}"></script>
<script src="{{ \URLHelper::asset('libs/datetimepicker/js/bootstrap-datetimepicker.min.js', 'admin') }}"></script>
<script>
    @php
        foreach( $provinces as $key => $province ) {
            $provinces[$key]->name = $province->present()->name;
        }
        foreach( $cities as $key => $city ) {
            $cities[$key]->name = $city->present()->name;
        }

    @endphp
            Boilerplate.provinces = {!! $provinces !!};
            Boilerplate.cities = {!! $cities !!};
$('.datetime-field').datetimepicker({'format': 'YYYY-MM-DD'});

</script>
<script src="{!! \URLHelper::asset('js/pages/teachers/edit.js', 'admin') !!}"></script>
@stop

@section('title')
@stop

@section('header')
Teachers
@stop

@section('breadcrumb')
    <li><a href="{!! action('Admin\TeacherController@index') !!}"><i class="fa fa-files-o"></i> Teachers</a></li>
    @if( $isNew )
        <li class="active">New</li>
    @else
        <li class="active">{{ $teacher->id }}</li>
    @endif
@stop

@section('content')



    @if( $isNew )
        <form action="{!! action('Admin\TeacherController@store') !!}" method="POST" enctype="multipart/form-data">
    @else
        <form action="{!! action('Admin\TeacherController@update', [$teacher->id]) !!}" method="POST" enctype="multipart/form-data">
            <input type="hidden" name="_method" value="PUT">
    @endif
            {!! csrf_field() !!}
            <div class="box box-primary">
                <div class="box-header with-border">
                    <a href="{!! URL::action('Admin\TeacherController@index') !!}" style="width: 125px; font-size: 14px;" class="btn btn-block btn-default btn-sm">@lang('admin.pages.common.buttons.back')</a>
                </div>
                <div class="box-body">

                    <div class="form-group @if ($errors->has('name')) has-error @endif">
                        <label for="name">@lang('admin.pages.teachers.columns.name')</label>
                        <input type="text" class="form-control" id="name" name="name" value="{{ old('name') ? old('name') : $teacher->name }}">
                    </div>
                    <div class="form-group @if ($errors->has('skype_id')) has-error @endif">
                        <label for="skype_id">@lang('admin.pages.teachers.columns.skype_id')</label>
                        <input type="text" class="form-control" id="skype_id" name="skype_id" value="{{ old('skype_id') ? old('skype_id') : $teacher->skype_id }}">
                    </div>
                    <div class="form-group @if ($errors->has('email')) has-error @endif">
                        <label for="email">@lang('admin.pages.teachers.columns.email')</label>
                        <input type="text" class="form-control" id="email" name="email" value="{{ old('email') ? old('email') : $teacher->email }}">
                    </div>
                    @if( $isNew )
                        <div class="form-group @if ($errors->has('password')) has-error @endif">
                            <label for="password">@lang('admin.pages.teachers.columns.password')</label>
                            <input type="text" class="form-control" id="password" name="password" value="{{ old('password') ? old('password') : '' }}">
                        </div>
                    @endif
                    <div class="form-group @if ($errors->has('locale')) has-error @endif">
                        <label for="locale">@lang('admin.pages.teachers.columns.locale')</label>
                        <input type="text" class="form-control" id="locale" name="locale" value="{{ old('locale') ? old('locale') : $teacher->locale }}">
                    </div>

                        <img width="400" src="{!! $teacher->getProfileImageUrl(480, 300) !!}" alt="{{$teacher->name}}" class="margin" id="cover-image-preview" />
                    <div class="form-group">
                        <label for="profile_image">@lang('admin.pages.teachers.columns.profile_image_id')</label>
                        <input type="file" class="image-input" id="cover-image" name="profile_image" accept="image/*" />
                        <p class="help-block">@lang('admin.pages.teachers.columns.profile_image_id')</p>
                        <span style="color:red" id='spanFileName'></span>
                    </div>

                    <div class="form-group @if ($errors->has('year_of_birth')) has-error @endif">
                        <label for="year_of_birth">@lang('admin.pages.teachers.columns.year_of_birth')</label>
                        @php
                            $nowTime = date('Y');
                            $last10y = $nowTime - 10;
                        @endphp
                        <select class="form-control selectpicker select" name="year_of_birth" data-live-search="true"
                                id="year_of_birth" style="margin-bottom: 15px;">
                            <option value="" class=" @if ($errors->has('year_of_birth')) has-error @endif">SELECT
                            </option>
                             @foreach( range($last10y-80, $last10y) as $year )
                                <option value="{!! $year !!}"
                                        @if( ($year == $teacher->year_of_birth) ) selected @endif
                                        @if( old('year_of_birth')==$year ) selected @endif>
                                    {!! $year !!}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group @if ($errors->has('gender')) has-error @endif">
                        <label for="gender">@lang('admin.pages.teachers.columns.gender')</label>
                        <br>
                        <input class="field"  {{ $teacher->gender=='male' ? 'checked="checked"' : '' }} {{ old('gender')=='male' ? 'checked="checked"' : '' }}  name="gender" type="radio" value="male">Male
                        <input class="field"{{ $teacher->gender=='female' ? 'checked="checked"' : '' }}  {{ old('gender')=='female' ? 'checked="checked"' : '' }}  name="gender" type="radio" value="female">Female
                    </div>
                    @if ( $isNew )
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="form-group @if ($errors->has('living_country_code')) has-error @endif">
                                    <label for="living_country_code">@lang('admin.pages.teachers.columns.living_country_code')</label>
                                    <select class="form-control selectpicker" name="living_country_code" data-live-search="true" id="living_country_code" style="margin-bottom: 15px;">
                                        <option value="">SELECT</option>
                                        @foreach( $countries as $key => $country )
                                            <option value="{!! $country->code !!}" @if( (old('living_country_code') === $country->code ) ) selected @endif>
                                                {{ $country->present()->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group @if ($errors->has('living_city_id')) has-error @endif">
                                    <label for="living_city_id">@lang('admin.pages.teachers.columns.living_city_id')</label>
                                    <select class="form-control selectpicker" data-live-search="true" name="living_city_id" id="living_city_id">
                                        <option value="">SELECT</option>
                                        @foreach($cities as $city)
                                            @if(old('living_country_code') && old('living_country_code') == $city->country_code )
                                                <option value="{{ $city->id }}"
                                                        @if(old('living_city_id') == $city->id )
                                                        selected
                                                        @endif
                                                >{{ $city->present()->name }}</option>

                                            @endif
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                    @else
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="form-group @if ($errors->has('living_country_code')) has-error @endif">
                                    <label for="living_country_code">@lang('admin.pages.teachers.columns.living_country_code')</label>
                                    <select class="form-control selectpicker" name="living_country_code" data-live-search="true" id="living_country_code" style="margin-bottom: 15px;">
                                        <option value="">SELECT</option>
                                        @foreach( $countries as $key => $country )
                                            <option value="{!! $country->code !!}"
                                                    @if(old('living_country_code') === $country->code )
                                                    selected
                                                    @elseif(!old('living_country_code') && $country->code === $teacher->living_country_code)
                                                    selected
                                                    @endif
                                            >
                                                {{ $country->present()->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group @if ($errors->has('living_city_id')) has-error @endif">
                                    <label for="living_city_id">@lang('admin.pages.teachers.columns.living_city_id')</label>
                                    <select class="form-control selectpicker" data-live-search="true" name="living_city_id" id="living_city_id">
                                        @foreach($cities as $city)
                                            @if(old('living_country_code') && old('living_country_code') == $city->country_code )
                                                <option value="{{ $city->id }}"
                                                        @if(old('living_city_id') == $city->id )
                                                        selected
                                                        @elseif($city->id === $teacher->living_city_id && !old('living_city_id')) selected
                                                        @endif

                                                >{{ $city->present()->name }}</option>
                                            @elseif( $city->country_code == $teacher->living_country_code && !old('living_country_code') )
                                                <option value="{{ $city->id }}" @if($city->id === $teacher->living_city_id) selected @endif>{{ $city->present()->name }}</option>
                                            @endif
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                    @endif

                    <div class="form-group @if ($errors->has('living_start_date')) has-error @endif">
                        <label for="living_start_date">@lang('admin.pages.teachers.columns.living_start_date')</label>
                        <input type="text" class="datetime-field form-control" id="living_start_date" name="living_start_date" value="{{ old('living_start_date') ? old('living_start_date') : $teacher->living_start_date }}">
                    </div>

                    @if ( $isNew )
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="form-group @if ($errors->has('nationality_country_code')) has-error @endif">
                                    <label for="nationality_country_code">@lang('admin.pages.teachers.columns.nationality_country_code')</label>
                                    <select class="form-control selectpicker" name="nationality_country_code"  data-live-search="true" id="nationality_country_code" style="margin-bottom: 15px;">
                                        <option value="">SELECT</option>
                                        @foreach( $countries as $key => $country )
                                            <option value="{!! $country->code !!}" @if( (old('nationality_country_code') === $country->code ) ) selected @endif>
                                                {{ $country->present()->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group @if ($errors->has('home_province_id')) has-error @endif">
                                    <label for="home_province_id">@lang('admin.pages.teachers.columns.home_province_id')</label>
                                    <select class="form-control selectpicker" data-live-search="true" name="home_province_id" id="home_province_id">
                                        <option value="">SELECT</option>
                                        @foreach($provinces as $province)
                                            @if(old('nationality_country_code') && old('nationality_country_code') == $province->country_code )
                                                <option value="{{ $province->id }}"
                                                        @if(old('home_province_id') == $province->id )
                                                        selected
                                                        @endif
                                                >{{ $province->present()->name }}</option>

                                            @endif
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                    @else
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="form-group @if ($errors->has('nationality_country_code')) has-error @endif">
                                    <label for="nationality_country_code">@lang('admin.pages.teachers.columns.nationality_country_code')</label>
                                    <select class="form-control selectpicker" name="nationality_country_code" data-live-search="true" id="nationality_country_code" style="margin-bottom: 15px;">
                                        <option value="">SELECT</option>

                                        @foreach( $countries as $key => $country )
                                            <option value="{!! $country->code !!}"
                                                    @if(old('nationality_country_code') === $country->code )
                                                    selected
                                                    @elseif(!old('nationality_country_code') && $country->code === $teacher->nationality_country_code)
                                                    selected
                                                    @endif
                                            >
                                                {{ $country->present()->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group @if ($errors->has('home_province_id')) has-error @endif">
                                    <label for="home_province_id">@lang('admin.pages.teachers.columns.home_province_id')</label>
                                    <select class="form-control selectpicker" data-live-search="true" name="home_province_id" id="home_province_id">
                                        @foreach($provinces as $province)
                                            @if(old('nationality_country_code') && old('nationality_country_code') == $province->country_code )
                                                <option value="{{ $province->id }}"
                                                        @if(old('home_province_id') == $province->id )
                                                        selected
                                                        @elseif($province->id === $teacher->home_province_id && !old('home_province_id')) selected
                                                        @endif

                                                >{{ $province->present()->name }}</option>
                                            @elseif( $province->country_code == $teacher->nationality_country_code && !old('nationality_country_code') )
                                                <option value="{{ $province->id }}" @if($province->id === $teacher->home_province_id) selected @endif>{{ $province->present()->name }}</option>
                                            @endif
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                    @endif
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="personality_id">@lang('admin.pages.teachers.columns.personality_id')</label>
                                <select class="form-control selectpicker" name="personality_id[]" multiple  data-live-search="true" id="personality_id" style="margin-bottom: 15px;">

                                    @foreach( $personalities as $key => $personality )
                                        <option value="{!! $personality->id !!}"
                                            @foreach( $teacher->personalities as $index => $tc)
                                                @if($personality->id === $tc->id) selected @endif
                                            @endforeach>
                                            {{ $personality->present()->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                    </div>
                    <div class="form-group @if ($errors->has('introduction_from_admin')) has-error @endif">
                        <label for="introduction_from_admin">@lang('admin.pages.teachers.columns.introduction_from_admin')</label>
                        <textarea name="introduction_from_admin" class="form-control" rows="5" placeholder="@lang('admin.pages.teachers.columns.introduction_from_admin')">{{ old('introduction_from_admin') ? old('introduction_from_admin') : $teacher->introduction_from_admin }}</textarea>
                    </div>
                    <div class="form-group @if ($errors->has('self_introduction')) has-error @endif">
                        <label for="self_introduction">@lang('admin.pages.teachers.columns.self_introduction')</label>
                        <textarea name="self_introduction" class="form-control" rows="5" placeholder="@lang('admin.pages.teachers.columns.self_introduction')">{{ old('self_introduction') ? old('self_introduction') : $teacher->self_introduction }}</textarea>
                    </div>

                    <div class="form-group @if ($errors->has('hobby')) has-error @endif">
                        <label for="hobby">@lang('admin.pages.teachers.columns.hobby')</label>
                        <textarea name="hobby" class="form-control" rows="5" placeholder="@lang('admin.pages.teachers.columns.hobby')">{{ old('hobby') ? old('hobby') : $teacher->hobby }}</textarea>
                    </div>

                    <div class="form-group @if ($errors->has('bank_account_info')) has-error @endif">
                        <label for="bank_account_info">@lang('admin.pages.teachers.columns.bank_account_info')</label>
                        <textarea name="bank_account_info" class="form-control" rows="5" placeholder="@lang('admin.pages.teachers.columns.bank_account_info')">{{{ old('bank_account_info') ? old('bank_account_info') : $teacher->bank_account_info }}}</textarea>
                    </div>

                </div>
                <div class="box-footer">
                    <button type="submit" class="btn btn-primary">@lang('admin.pages.common.buttons.save')</button>
                </div>
            </div>
        </form>
@stop
