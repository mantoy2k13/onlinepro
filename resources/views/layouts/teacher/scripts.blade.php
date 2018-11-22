<script src="{!! \URLHelper::asset('js/jQuery/jQuery-2.1.4.min.js', 'teacher') !!}"></script>
<script type="text/javascript" src="{!! \URLHelper::asset('js/script.js', 'user') !!}"></script>
<script type="text/javascript" src="{!! \URLHelper::asset('js/heightLine.js', 'user') !!}"></script>
<script type="text/javascript" src="{!! \URLHelper::asset('js/footerFixed.js', 'user') !!}"></script>
<script type="text/javascript" src="{!! \URLHelper::asset('js/jquery.smoothScroll.js', 'user') !!}"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/js/select2.min.js"></script>
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
    $('button.close').click(function () {
        $('.alert-dismissible').hide();

    })
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
            $('#sign_up').lightbox_me({centered: true, onLoad: function() { $('#sign_up').find('input:first').focus()}});
        }
        $('#try-1').click(function(e) {
            $("#sign_up").lightbox_me({centered: true, preventScroll: true, onLoad: function() {
                $("#sign_up").find("input:first").focus();
            }});
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
</script>
<script type="text/javascript">
    var Boilerplate = {
        'csrfToken': "{!! csrf_token() !!}"
    };
</script>
<script>
    $(function() {
        $('.circle').on('click', function() {
            $('#loading-image').show();
            if($(this).data('state') == 'off'){
                var self = $(this),
                        url = self.attr('data-post-url'),
                        statusvl = $(this).data('state'),
                        datavalue = self.attr('data-value');
                $(this).animate({'left': '72px','background-color':'#f9f9f9'}, 150).data('state','on');
                $(this).parent("div").animate({'background-color':'#f1a9a0'}, 150);
                $(this).prev("span").css({'left':'10px'}).text('Open');
                closeOpenTimeSlot(url, statusvl, datavalue);


            }else if($(this).data('state') == 'on'){
                var self = $(this),
                        url = self.attr('data-post-url'),
                        statusvl = $(this).data('state'),
                        datavalue = self.attr('data-value');
                $(this).animate({'left': '2px','background-color':'#f9f9f9'}, 150).data('state','off');
                $(this).parent("div").animate({'background-color':'#56cc9d'}, 150);
                $(this).prev("span").css({'left':'35px'}).text('Close');
                closeOpenTimeSlot(url, statusvl, datavalue);

            }
        });

    });
    function closeOpenTimeSlot(url, statusvl, datavalue) {
        console.log(datavalue);
        console.log(statusvl);
        console.log(url);
        $('#loading-image').show();
        $.ajax({
            url: url,
            method: 'POST',
            data: {
                '_token': Boilerplate.csrfToken,
                'datetime': datavalue,
                'status': statusvl,
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

    $('select').select2();

    $('.writeReviewBtn').on('click', function() {
        $('#loading-image').show();
        $.ajax({
            url: $('#url-post-review').val(),
            method: 'POST',
            data: $("#form-teacher-review").serialize(),
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
    })
    $('.logout').click(function () {
        $("#logout" ).submit();

    });
</script>

<script>
    $(function() {
        $('.teacher-cancel-booking').on('click', function() {
            var self = $(this),
                    url = self.attr('data-post-url');
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
