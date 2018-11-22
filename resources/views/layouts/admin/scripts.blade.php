<!--[if lt IE 9]>
<script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
<script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
<![endif]-->
<script src="{!! \URLHelper::asset('libs/plugins/jQuery/jQuery-2.1.4.min.js', 'admin') !!}"></script>
<script src="{!! \URLHelper::asset('libs/bootstrap/js/bootstrap.min.js', 'admin') !!}"></script>
<script src="{!! \URLHelper::asset('libs//plugins/iCheck/icheck.min.js', 'admin') !!}"></script>
<script src="{!! \URLHelper::asset('libs/adminlte/js/app.min.js', 'admin') !!}"></script>

<!-- Latest compiled and minified JavaScript -->
<script src="{!! \URLHelper::asset('libs/bootstrap/bootstrap-select.js', 'admin') !!}"></script>


<script type="text/javascript">
    var Boilerplate = {
        'csrfToken': "{!! csrf_token() !!}"
    };


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

    $('.pdf-input').on("change",function () {
        var fileExtension = ['pdf'];
        if ($.inArray($(this).val().split('.').pop().toLowerCase(), fileExtension) == -1) {
            $('#spanFileName').html("Invalid format file.");
            $('.pdf-input').val('');
        }else if(this.files[0].size > {!! config('file.categories.textbook-file.limitSize') !!}){
            $('#spanFileName').html("File size must be < {!! config('file.categories.textbook-file.limitSize')/1024/1024 !!}Mb");
            $('.pdf-input').val('');
        }
        else {
            $('#spanFileName').html('');
        }
    })

</script>