@extends('layouts.teacher.application', ['menu' => 'profile'])

@section('metadata')
@stop

@section('styles')
    @parent
@stop

@section('scripts')

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

    </script>
    <script src="{!! \URLHelper::asset('js/edit.js', 'teacher') !!}"></script>

@stop
@section('title')
    @lang('teacher.pages.edit_profile.page_title')
@stop

@section('header')
@stop

@section('content')
    <div class="wrap">
        <section>
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
        <form action="{!! action('Teacher\ProfileController@updateProfile') !!}" method="POST"
              enctype="multipart/form-data">
            <input type="hidden" name="_method" value="PUT">
            {!! csrf_field() !!}
            <dl class="profile-photoarea">
                    <dt><img width="400" id="cover-image-preview" src="{!! $teacher->getProfileImageUrl(480, 300) !!}"
                             alt="{!! $teacher->name !!}" class="margin profile-photo"/></dt>

                <dd><input type="file" class="image-input" id="cover-image" name="profile_image" accept="image/*">
                    <span style="color:red" id='spanFileName'></span>
                </dd>

            </dl>
            <table class="form-b">
                <tbody>
                <tr>
                    <th>@lang('teacher.pages.edit_profile.name')</th>
                    <td class=" @if ($errors->has('name')) alert_outline @endif">
                        <input type="text" name="name" value="{{ old('name') ? old('name') : $teacher->name }}"></td>
                    @if ($errors->has('name'))<p class="alert" >{!! $errors->first('name') !!}</p> @endif
                </tr>
                <tr>
                    <th>@lang('teacher.pages.edit_profile.skype_id')</th>
                    <td><input type="text" value="{{ old('skype_id') ? old('skype_id') : $teacher->skype_id }}"
                               name="skype_id" class=" @if ($errors->has('skype_id')) alert_outline @endif">
                        @if ($errors->has('skype_id'))<p class="alert"> {!! $errors->first('skype_id') !!}</p> @endif
                    </td>
                </tr>
                <tr>
                    <th>@lang('teacher.pages.edit_profile.age')</th>
                    @php
                        $nowTime = date('Y');
                        $last10y = $nowTime - 10;
                    @endphp
                    <td>
                        <select class="form-control selectpicker select" name="year_of_birth" data-live-search="true"
                                id="date_of_birth" style="margin-bottom: 15px;">
                            <option value="" class=" @if ($errors->has('year_of_birth')) alert_outline @endif">--
                            </option>
                            @foreach( range($last10y-80, $last10y) as $year )
                                <option value="{!! $year !!}"
                                        @if( ($year == $teacher->year_of_birth) ) selected @endif
                                        @if( old('year_of_birth')==$year ) selected @endif>
                                    {!! $year !!}
                                </option>
                            @endforeach
                        </select>
                        @if ($errors->has('year_of_birth'))<p class="alert" >{!! $errors->first('year_of_birth') !!}</p> @endif
                    </td>
                </tr>
                <tr>
                    <th>@lang('teacher.pages.edit_profile.sex')</th>
                    <td class="radio  @if ($errors->has('gender')) alert_outline @endif">
                        <input type="radio" name="gender" value="male"
                               {{ $teacher->gender=='male' ? 'checked="checked"' : '' }}
                               {{ old('gender')=='male' ? 'checked="checked"' : '' }}  id="gender-1"/>
                        <label for="gender-1">@lang('teacher.pages.edit_profile.male')</label>
                        <input type="radio" name="gender" value="female" id="gender-2"
                                {{ $teacher->gender=='female' ? 'checked="checked"' : '' }}
                                {{ old('gender')=='female' ? 'checked="checked"' : '' }} />
                        <label for="gender-2">@lang('teacher.pages.edit_profile.female')</label>
                        @if ($errors->has('gender'))<p class="alert" >{!! $errors->first('gender') !!}</p> @endif
                    </td>
                </tr>
                <tr>
                    <th>@lang('teacher.pages.edit_profile.living_country')</th>
                    <td>
                        <div class="form-group">
                            <select class="form-control select @if ($errors->has('living_country_code')) alert_outline @endif"
                                    name="living_country_code" data-live-search="true" id="living_country_code"
                                    style="margin-bottom: 15px;">
                                @foreach( $countries as $key => $country )
                                    <option value="{!! $country->code !!}"
                                            @if(old('living_country_code') === $country->code )
                                            selected
                                            @elseif( ($country->code === $teacher->living_country_code) && !old('living_country_code')  ) selected @endif>
                                        {{ $country->present()->name }}
                                    </option>
                                @endforeach
                            </select>
                            @if ($errors->has('living_country_code'))<p class="alert" >{!! $errors->first('living_country_code') !!}</p> @endif
                        </div>
                    </td>
                </tr>
                <tr>
                    <th>@lang('teacher.pages.edit_profile.living_city')</th>
                    <td>
                        <select class="select form-control @if ($errors->has('living_city_id')) alert_outline @endif"
                                data-live-search="true" name="living_city_id" id="living_city_id">
                            @foreach($cities as $city)
                                @if(old('living_country_code') && old('living_country_code') == $city->country_code )
                                    <option value="{{ $city->id }}"
                                            @if(old('living_city_id') == $city->id )
                                            selected
                                            @elseif($city->id === $teacher->living_city_id && !old('living_city_id')) selected
                                            @endif

                                    >{{ $city->present()->name }}</option>
                                @elseif ( $city->country_code == $teacher->living_country_code  && !old('living_country_code'))
                                    <option value="{{ $city->id }}"
                                            @if($city->id === $teacher->living_city_id) selected @endif>{{ $city->present()->name }}</option>
                                @endif
                            @endforeach
                        </select>
                        @if ($errors->has('living_city_id'))<p class="alert" >{!! $errors->first('living_city_id') !!}</p> @endif
                    </td>
                </tr>
                <tr>
                    <th>@lang('teacher.pages.edit_profile.lesson_content')</th>
                    <td>
                        @foreach( $personalities as $key => $personality )

                            <input id="checkcontent{{ $personality->id }}" type="checkbox" name="personality_id[]" value="{{ $personality->id}}"
                                   @foreach( $teacher->personalities as $index => $tc)
                                   @if($personality->id === $tc->id) checked @endif
                                    @endforeach />
                            <label for="checkcontent{{ $personality->id }}" class="checkbox">{{ $personality->present()->name }}</label>
                        @endforeach
                    </td>
                </tr>
                <tr>
                    <th>@lang('teacher.pages.edit_profile.hobby')</th>
                    <td>
                        <div class="form-group @if ($errors->has('hobby')) alert_outline @endif">
                            <input name="hobby" class="form-control" rows="5"
                                      placeholder="" value="{{ old('hobby') ? old('hobby') : $teacher->hobby }}"/>
                            @if ($errors->has('hobby'))<p class="alert" >{!! $errors->first('hobby') !!}</p> @endif
                        </div>
                    </td>
                </tr>
                <tr>
                    <th>@lang('teacher.pages.edit_profile.province')</th>
                    <td>
                        <select class="form-control select  @if ($errors->has('home_province_id')) alert_outline @endif"
                                data-live-search="true" name="home_province_id" id="home_province_id">
                            @foreach($provinces as $province)
                                @if( $province->country_code == $teacher->nationality_country_code )
                                    <option value="{{ $province->id }}"
                                            @if($province->id === $teacher->home_province_id) selected @endif>{{ $province->present()->name }}</option>
                                @endif
                            @endforeach
                        </select>
                        @if ($errors->has('home_province_id'))<p class="alert" >{!! $errors->first('home_province_id') !!}</p> @endif
                    </td>
                </tr>
                <tr>
                    <th>@lang('teacher.pages.edit_profile.self_introduction')</th>
                    <td>
                        <div class="form-group @if ($errors->has('self_introduction')) alert_outline @endif">
                            <textarea name="self_introduction" class="form-control" rows="5"
                                      placeholder="">{{ old('self_introduction') ? old('self_introduction') : $teacher->self_introduction }}</textarea>
                            @if ($errors->has('self_introduction'))<p class="alert" >{!! $errors->first('self_introduction') !!}</p> @endif
                        </div>
                    </td>
                </tr>

                </tbody>
            </table>
            <p><a href="#" onclick="$(this).parents('form:first').submit(); return false;" class="btn-o">@lang('teacher.pages.edit_profile.save')</a></p>
        </form>
            </section>
    </div>

@stop
