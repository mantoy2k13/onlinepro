<p id="pageTop"><a href="#wrapper"><img src="{!! \URLHelper::asset('img/pagetop.png', 'user') !!}" alt="pagetop"><span>PAGE TOP</span></a></p>
<footer id="footer"><p>Copyright&copy; @lang('user.pages.footer.slogan') All Rights Reserved.</p></footer>
<form id="logout" method="post" action="{!! action('User\AuthController@postSignOut') !!}">
    {!! csrf_field() !!}
</form>
<div id="loading-image" style="display: none">
    <img src="{!! \URLHelper::asset('img/loader.gif', 'common') !!}">
</div>
<div id="none-booking" class="modal-content">
    <p class="em  text-center">@lang('user.pages.booking.failed_limited_today')</p>

    <p><a id="modal-close02" class="button-link text-center">@lang('user.pages.footer.close_popup')</a></p>
</div>