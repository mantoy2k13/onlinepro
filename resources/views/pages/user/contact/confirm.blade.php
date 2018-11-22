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

    <div class="grayarea">
        <h2 class="title-m">お問い合わせ</h2>
    </div>
    <div class="content">
        <h3 class="title-s cent under-pink">送信内容確認画面</h3>

        <div class="content">
            <table class="form">
                <tbody>
                <tr>
                    <th>お名前</th>
                    <td>{{ $name }}</td>
                </tr>
                <tr>
                    <th>メールアドレス</th>
                    <td>{{ $email }}</td>
                </tr>
                <tr>
                    <th>居住国</th>
                    <td>{{ $country->name_ja }}</td>
                </tr>
                <tr>
                    <th>お問い合わせ内容</th>
                    <td>{{ \TypeHelper::getTypeName($type, config('contact.inquiry_types'))}}</td>
                </tr>
                <tr>
                    <th>お問い合わせ内容</th>
                    <td>
                        {{ $content }}
                    </td>
                </tr>
                </tbody>
            </table>
            <ul class="btnarea">

                <form method="post" action="{{ action('User\ContactController@postContact') }}">
                    {{ csrf_field() }}
                    <input type="hidden" name="name" value="{{ $name }}"/>
                    <input type="hidden" name="living_country_code" value="{{ $country->code }}"/>
                    <input type="hidden" name="email" value="{{ $email }}"/>
                    <input type="hidden" name="type" value="{{ $type }}"/>
                    <input type="hidden" name="content" value="{{ $content }}"/>
                    <ul class="contactbtnarea">
                        <li><a href="#" class="btn-g"
                               onclick="history.back(); return false;">戻る</a>
                        </li>
                        <li><a href="#" onclick="$(this).parents('form:first').submit(); return false;"
                               class="btn-p">送信する</a></li>
                    </ul>
                </form>

            </ul>
        </div>
    </div>
@stop