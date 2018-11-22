<script src="{!! \URLHelper::asset('js/jQuery/jQuery-2.1.4.min.js', 'teacher') !!}"></script>
<script type="text/javascript" src="{!! \URLHelper::asset('js/script.js', 'user') !!}"></script>
<script type="text/javascript" src="{!! \URLHelper::asset('js/heightLine.js', 'user') !!}"></script>
<script type="text/javascript" src="{!! \URLHelper::asset('js/footerFixed.js', 'user') !!}"></script>
<script type="text/javascript" src="{!! \URLHelper::asset('js/jquery.smoothScroll.js', 'user') !!}"></script>
<script type="text/javascript" src="{!! \URLHelper::asset('js/modal-multi.js', 'user') !!}"></script>
<script>
    $(function () {
        $("#pageTop").hide();
        $(function () {
            $(window).scroll(function () {
                if ($(this).scrollTop() > 100) {
                    $('#pageTop').fadeIn();
                } else {
                    $('#pageTop').fadeOut();
                }
            });
            $('#pageTop a').click(function () {
                $('body,html').animate({
                    scrollTop: 0
                }, 800);
                return false;
            });
        });
    });
    $('.language-switcher').change(function () {
        var option = $(this).find('option:selected');
        window.location.href = $(option).data('link');
    });
</script>
<script>
    currentItem = $(".current-item");
    if (currentItem[0]) {
        currentItem.css({
            "width": currentItem.width(),
            "left": currentItem.position().left
        });
    }
</script>
<script>
    $("#navigation li").hover(
        function(){
            $("#slide-line").css({
                "width": $(this).width(),
                "left": $(this).position().left
            });
        },
        function(){
            if (currentItem[0]) {
                $("#slide-line").css({
                    "width": currentItem.width(),
                    "left": currentItem.position().left
                });
            }
            else {
                $("#slide-line").width(0);
            }
        }
    );
</script>
<script>
    $(function(){
        $("#toggle").click(function(){
            $("#categorymenu").slideToggle();
            return false;
        });
        $(window).resize(function(){
            var win = $(window).width();
            var p = 600;
            if(win > p){
                $("#categorymenu").show();
            } else {
                $("#categorymenu").hide();
            }
        });
    });
</script>
<script type="text/javascript" src="{!! \URLHelper::asset('js/jquery.lightbox_me.js', 'user') !!}"></script>
<script type="text/javascript" charset="utf-8">
    $(function() {
        function launch() {
            openLoginPopup();
        }
        $('#try-1').click(function(e) {
            openLoginPopup();
            e.preventDefault();
        });
        $('table tr:nth-child(even)').addClass('stripe');
    });
</script>
<script>
    var linkTouchStart = function(){
        thisAnchor = $(this);
        touchPos = thisAnchor.offset().top;
        moveCheck = function(){
            nowPos = thisAnchor.offset().top;
            if(touchPos == nowPos){
                thisAnchor.addClass("hover");
            }
        };
        setTimeout(moveCheck,100);
    };
    var linkTouchEnd = function(){
        thisAnchor = $(this);
        hoverRemove = function(){
            thisAnchor.removeClass("hover");
        };
        setTimeout(hoverRemove,500);
    };

    $(document).on('touchstart mousedown','a',linkTouchStart);
    $(document).on('touchend mouseup','a',linkTouchEnd);

    $('.logout').click(function () {
        $("#logout" ).submit();

    });
    function openLoginPopup() {
        $('#lightbox').lightbox_me({centered: true, onLoad: function() { $('#lightbox').find('input:first').focus()}});
    }
</script>
<script>

@if ($errors->has('field_password') || $errors->has('field_email'))
    openLoginPopup();
@endif

        $('.booking-button').click(function () {

            var self = $(this),
                    url = self.attr('href');
        @if( empty($authUser) )
             $(function() {
            openLoginPopup();

            });
            return false;
        @endif
                location.href = url;

        });

        $('.none-booking').click(function () {

            $('#none-booking').show();
            return false;

        });

</script>

<script type="text/javascript">
    var Boilerplate = {
        'csrfToken': "{!! csrf_token() !!}"
    };
</script>
<script>
    $(function() {
        $('.user-cancel-booking').on('click', function() {
            var self = $(this),
                    url = self.attr('data-post-url');
            console.log(url);
            $('#link-confirm').attr('data-post-url',url);
        });
        $('#link-confirm').on('click', function() {
            $('#loading-image').show();
            $('#loading-image').css('z-index', '5000');
            var self = $(this),
                    url = self.attr('data-post-url');
            $.ajax({
                url: url,
                method: 'DELETE',
                data: {
                    '_token': Boilerplate.csrfToken,
                },
                error: function (xhr, error) {
                    console.log(error);
                    self.loading = false;
                    location.reload();
                },
                success: function (response) {
                    console.log(response);
                    location.reload();
                }
            });
        });

        $("#favorite-button").click(function(){
                    @if( !empty($authUser) )
            var self = $(this),
                    url = self.attr('data-url'),
                    method = self.attr('data-action');
            $('#favorite-form').attr('action', url);
            $('#favorite-form').submit();
            @else
                 openLoginPopup();
            @endif

        });
        $('#remove-favorite-button').on('click', function() {
            if (window.confirm("@lang('user.messages.general.alert_remove_favorite_teacher')") === true) {
                $('#loading-image').show();
                var self = $(this),
                        url = self.attr('data-url');
                $.ajax({
                    url: url,
                    method: 'DELETE',
                    data: {
                        '_token': Boilerplate.csrfToken,
                    },
                    error: function (xhr, error) {
                        console.log(error);
                        self.loading = false;
                        location.reload();
                    },
                    success: function (response) {
                        console.log(response);
                        location.reload();
                    }
                });
            }
        });



        $('button.close').click(function () {
            $('.alert-dismissible').hide();

        })

    });
    $('.image-input').on("change",function () {
        var fileExtension = ['jpeg', 'jpg', 'png', 'gif', 'bmp'];
        if ($.inArray($(this).val().split('.').pop().toLowerCase(), fileExtension) == -1) {
            $('#spanFileName').html(this.value);
            $('#spanFileName').html("Invalid format image.");
            $('.image-input').val('');
        }
        else {
            $('#spanFileName').html('');
        }
    })
    $('#cover-image').change(function (event) {
        $('#cover-image-preview').attr('src', URL.createObjectURL(event.target.files[0]));
        $('#cover-image-preview').show();
    });

</script>
