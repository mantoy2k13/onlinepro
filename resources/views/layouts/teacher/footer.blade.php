</main>
</div>
<p id="pageTop"><a href="#wrapper"><img src="{!! \URLHelper::asset('img/pagetop.png', 'user') !!}" alt="pagetop"><span>PAGE TOP</span></a>
</p>
<footer id="footer"><p>@lang('teacher.pages.footer.copyright')</p></footer>
<div id="loading-image" style="display: none">
    <img src="{!! \URLHelper::asset('img/loader.gif', 'common') !!}">
</div>
<div id="lightbox" style="display: none">
    <h3 id="see_id" class="sprited title-l">@lang('teacher.pages.footer.reservation_detail')</h3>
    <dl class="r-profilearea">
        <dt><img id="avatar-lightbox" src="{!! \URLHelper::asset('img/user.png', 'common') !!}" alt=""></dt>
        <dd id="user-lightbox"></dd>
    </dl>
    <dl class="box-g">
        <dt>@lang('teacher.pages.footer.advance_memo')</dt>
        <dd id="message-lightbox"></dd>
    </dl>
    <a id="close_x" class="close sprited" href="#"><img src="{!! \URLHelper::asset('img/close.png', 'user') !!}"
                                                        alt="close"></a>
</div>
