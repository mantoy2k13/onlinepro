@extends('layouts.user.application', ['noFrame' => false, 'bodyClasses' => ''])

@section('metadata')
@stop

@section('styles')
@stop

@section('scripts')
@stop

@section('title')
    お問い合わせ
@stop

@section('header')
    お問い合わせ
@stop

@section('content')
@section('breadcrumbs', Breadcrumbs::render('contacts'))
    <div class="grayarea">
        <h2 class="title-m">お問い合わせ</h2>
    </div>
    <div class="content">
        <h3 class="title-s cent under-pink">お問い合わせ内容入力</h3>

        <div class="content">
            <form method="post" action="{{ action('User\ContactController@confirmContact') }}">
                {{ csrf_field() }}
                <table class="form">
                    <tbody>
                    <tr>
                        <th>お名前</th>
                        <td><input type="text" name="name" value="{{ old('name') ? old('name') : '' }}"
                                   class=" @if ($errors->has('name')) alert_outline @endif">
                            @if ($errors->has('name'))<p class="alert"> {!! $errors->first('name') !!}</p> @endif
                        </td>
                    </tr>
                    <tr>
                        <th>メールアドレス</th>
                        <td><input type="text" name="email" value="{{ old('email') ? old('email') : '' }}"
                                   class=" @if ($errors->has('email')) alert_outline @endif">
                            @if ($errors->has('email'))<p class="alert"> {!! $errors->first('email') !!}</p> @endif
                        </td>
                    </tr>
                    <tr>
                        <th>居住国</th>
                        <td>
                            <select class="form-control select @if ($errors->has('living_country_code')) has-error @endif"
                                    name="living_country_code" data-live-search="true" id="living_country_code"
                                    style="margin-bottom: 15px;">
                                @foreach( $countries as $key => $country )
                                    <option value="{!! $country->code !!}"
                                            @if( ($country->code === old('living_country_code')) ) selected @endif>
                                        {{ $country->name_ja }}
                                    </option>
                                @endforeach
                            </select>
                            @if ($errors->has('living_country_code'))<p
                                    class="alert"> {!! $errors->first('living_country_code') !!}</p> @endif
                        </td>
                    </tr>
                    <tr>
                        <th>お問い合わせ内容</th>
                        <td><select class="select @if ($errors->has('type')) alert_outline @endif" name="type">
                                @foreach( config('contact.inquiry_types') as $code => $type )
                                    <option value="{!! $code !!}">{{ trans(array_get($type, 'name', $code)) }}</option>
                                @endforeach
                            </select>
                            @if ($errors->has('type'))<p class="alert"> {!! $errors->first('type') !!}</p> @endif
                        </td>
                    </tr>
                    <tr>
                        <th>お問い合わせ内容</th>
                        <td><textarea class="textarea @if ($errors->has('content')) alert_outline @endif"
                                      name="content">{{ old('content') ? old('content') : '' }}</textarea>
                            @if ($errors->has('content'))<p class="alert"> {!! $errors->first('content') !!}</p> @endif
                        </td>
                    </tr>
                    </tbody>
                </table>
                <p><a href="#" class="btn-p" onclick="$(this).parents('form:first').submit(); return false;">確認する</a>
                </p>
            </form>
        </div>
    </div>
@stop