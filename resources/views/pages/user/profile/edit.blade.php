@extends('layouts.user.application', ['noFrame' => false, 'bodyClasses' => '', 'mainClasses' => 'member'])

@section('metadata')
@stop

@section('styles')
    @parent
@stop

@section('title')
    @lang('user.pages.edit_profile.page_title')
@stop

@section('scripts')
    @parent
@stop
@section('content')

@section('breadcrumbs', Breadcrumbs::render('profile'))
@include('layouts.user.messagebox')
<div class="wrap">
    <section>
        <form action="{!! action('User\ProfileController@updateProfile') !!}" method="post"
              enctype="multipart/form-data">
            <div class="leftside">

                <input type="hidden" name="_method" value="PUT">
                {!! csrf_field() !!}
                <dl class="profile-photoarea">
                    <dt><img width="400" src="{!! $user->getProfileImageUrl() !!}" id="cover-image-preview"
                             alt="{!! $user->name !!}" class="margin profile-photo"/></dt>

                    <dd><input type="file" id="cover-image" name="profile_image" class="image-input"
                               accept="image/*">
                        <span style="color:red" id='spanFileName'></span>
                    </dd>

                </dl>

                <table class="form-b">
                    <tbody>
                    <tr>
                        <th>@lang('user.pages.edit_profile.nick_name')</th>
                        <td><input type="text" value="{{ old('name') ? old('name') : $user->name }}"
                                   name="name" class=" @if ($errors->has('name')) alert_outline @endif">
                            @if ($errors->has('name'))<p
                                    class="alert"> {!! $errors->first('name') !!}</p> @endif
                        </td>
                    </tr>

                    <tr>
                        <th>@lang('user.pages.edit_profile.birth_of_year')</th>
                        @php
                            $nowTime = date('Y');
                            $last10y = $nowTime - 10;
                        @endphp
                        <td>
                            <select class="form-control  @if ($errors->has('year_of_birth')) alert_outline @endif select"
                                    name="year_of_birth" data-live-search="true"
                                    id="year_of_birth" style="margin-bottom: 15px;">
                                <option value="">--
                                </option>
                                @foreach( range($last10y-80, $last10y) as $year )
                                    <option value="{!! $year !!}"
                                            @if( ($year == $user->year_of_birth) ) selected @endif
                                            @if( old('year_of_birth')==$year ) selected @endif>
                                        {!! $year !!}
                                    </option>
                                @endforeach
                            </select>
                            @if ($errors->has('year_of_birth'))<p
                                    class="alert"> {!! $errors->first('year_of_birth') !!} </p>@endif
                        </td>
                    </tr>
                    <tr>
                        <th>Skype ID</th>
                        <td><input type="text" value="{{ old('skype_id') ? old('skype_id') : $user->skype_id }}"
                                   name="skype_id" class=" @if ($errors->has('skype_id')) alert_outline @endif">
                            @if ($errors->has('skype_id'))<p
                                    class="alert"> {!! $errors->first('skype_id') !!}</p> @endif
                        </td>
                    </tr>
                    @if (empty($user->userServicesAuthentications))
                    <tr>
                        <th>@lang('user.pages.edit_profile.current_password')</th>
                        <td>
                            <input type="password"
                                   class=" @if ($errors->has('current_password')) alert_outline @endif"
                                   name="current_password"
                                   value="{{ old('current_password') ? old('current_password') : '' }}">
                            @if ($errors->has('current_password'))<p
                                    class="alert"> {!! $errors->first('current_password') !!} </p>@endif
                        </td>
                    </tr>
                    <tr>
                        <th>@lang('user.pages.edit_profile.new_password')</th>
                        <td>
                            <input type="password" class=" @if ($errors->has('password')) alert_outline @endif"
                                   name="password" value="{{ old('password') ? old('password') : '' }}">
                            @if ($errors->has('password'))<p
                                    class="alert"> {!! $errors->first('password') !!} </p>@endif
                        </td>
                    </tr>
                    <tr>
                        <th>@lang('user.pages.edit_profile.new_password_confirm')</th>
                        <td>
                            <input type="password"
                                   class=" @if ($errors->has('password_confirmation')) alert_outline @endif"
                                   name="password_confirmation"
                                   value="{{ old('password_confirmation') ? old('password_confirmation') : '' }}">
                            @if ($errors->has('password_confirmation'))<p
                                    class="alert"> {!! $errors->first('password_confirmation') !!} </p>@endif
                        </td>
                    </tr>
                    @endif
                    </tbody>
                </table>
                <p><a href="#" onclick="$(this).parents('form:first').submit(); return false;"
                      class="btn-o">@lang('user.pages.edit_profile.submit')</a></p>

            </div>
        </form>
    </section>
</div>
@stop
