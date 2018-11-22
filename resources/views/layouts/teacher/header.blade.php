<form id="logout" method="post" action="{!! action('Teacher\AuthController@postSignOut') !!}">
    {!! csrf_field() !!}
</form>
<div id="wrapper">
    <main class="{!! isset($mainClasses) ? $mainClasses : 'member' !!}">
        <header class="expert">
            <p>
                <select name="lang" class="select language-switcher">
                    @foreach($languages as $code => $language)
                        <option value="{{ $code }}"
                                @if(\LocaleHelper::getLocale() === $code) selected @endif
                                data-link="{{ \LocaleHelper::getCurrentUrlWithLocaleCode($code) }}">
                            @lang($language['name'])
                        </option>
                    @endforeach
                </select>
            </p>
            <h1><strong>@lang('teacher.pages.header.teacher_only')</strong>{!! isset($titlePage) ? $titlePage : trans('teacher.pages.title.home') !!}</h1>
        </header>

