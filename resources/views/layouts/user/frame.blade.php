<div id="wrapper">
    @if( !empty($authUser) )
        @include('layouts.user.user-widget')
    @endif
    <main class="{!! isset($mainClasses) ? $mainClasses : 'member' !!}">
        <header>
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
            <h1>{!! isset($titlePage) ? $titlePage : trans('user.pages.title.home') !!}</h1></header>
        <div class="mainarea">
            @yield('breadcrumbs')
            @yield('content')
        </div>
    </main>
    @include('layouts.user.footer')
</div>
