@extends('layouts.admin.application', ['menu' => 'categories'] )

@section('metadata')
@stop

@section('styles')
    <link href="https://cdnjs.cloudflare.com/ajax/libs/froala-editor/2.3.4/css/froala_editor.min.css" rel="stylesheet" type="text/css" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/froala-editor/2.3.4/css/froala_style.min.css" rel="stylesheet" type="text/css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/froala-editor/2.3.4/css/plugins/char_counter.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/froala-editor/2.3.4/css/plugins/code_view.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/froala-editor/2.3.4/css/plugins/colors.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/froala-editor/2.3.4/css/plugins/emoticons.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/froala-editor/2.3.4/css/plugins/file.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/froala-editor/2.3.4/css/plugins/fullscreen.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/froala-editor/2.3.4/css/plugins/image.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/froala-editor/2.3.4/css/plugins/image_manager.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/froala-editor/2.3.4/css/plugins/line_breaker.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/froala-editor/2.3.4/css/plugins/quick_insert.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/froala-editor/2.3.4/css/plugins/table.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/froala-editor/2.3.4/css/plugins/video.css">
    <link href="{{ \URLHelper::asset('libs/datetimepicker/css/bootstrap-datetimepicker.min.css', 'admin') }}" rel="stylesheet" type="text/css">
    <style>
        .froala-element {
            min-height: 500px;
            max-height: 500px;
            overflow-y: scroll;
        }
        .f-html .froala-element {
            min-height: 520px;
            max-height: 520px;
            overflow-y: scroll;
        }
    </style>
    <link href="http://netdna.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.css" rel="stylesheet">
    <link href="http://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.2/summernote.css" rel="stylesheet">
@stop

@section('scripts')
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/froala-editor/2.3.4/js/froala_editor.min.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/froala-editor/2.3.4/js/plugins/align.min.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/froala-editor/2.3.4/js/plugins/char_counter.min.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/froala-editor/2.3.4/js/plugins/code_beautifier.min.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/froala-editor/2.3.4/js/plugins/code_view.min.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/froala-editor/2.3.4/js/plugins/colors.min.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/froala-editor/2.3.4/js/plugins/emoticons.min.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/froala-editor/2.3.4/js/plugins/entities.min.js"></script>
    <!--
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/froala-editor/2.3.4/js/plugins/file.min.js"></script>
    -->
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/froala-editor/2.3.4/js/plugins/font_family.min.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/froala-editor/2.3.4/js/plugins/font_size.min.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/froala-editor/2.3.4/js/plugins/fullscreen.min.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/froala-editor/2.3.4/js/plugins/image.min.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/froala-editor/2.3.4/js/plugins/image_manager.min.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/froala-editor/2.3.4/js/plugins/inline_style.min.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/froala-editor/2.3.4/js/plugins/line_breaker.min.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/froala-editor/2.3.4/js/plugins/link.min.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/froala-editor/2.3.4/js/plugins/lists.min.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/froala-editor/2.3.4/js/plugins/paragraph_format.min.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/froala-editor/2.3.4/js/plugins/paragraph_style.min.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/froala-editor/2.3.4/js/plugins/quick_insert.min.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/froala-editor/2.3.4/js/plugins/quote.min.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/froala-editor/2.3.4/js/plugins/table.min.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/froala-editor/2.3.4/js/plugins/save.min.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/froala-editor/2.3.4/js/plugins/url.min.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/froala-editor/2.3.4/js/plugins/video.min.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/froala-editor/2.3.4/js/plugins/code_view.min.js"></script>
    <script src="{{ \URLHelper::asset('libs/moment/moment.min.js', 'admin') }}"></script>
    <script src="{{ \URLHelper::asset('libs/datetimepicker/js/bootstrap-datetimepicker.min.js', 'admin') }}"></script>

    <script>
        $.FroalaEditor.DEFAULTS.key = '';
    </script>
    <script src="{{ \URLHelper::asset('js/pages/articles/edit.js', 'admin') }}"></script>

    <script src="{{ \URLHelper::asset('libs/moment/moment.min.js', 'admin') }}"></script>
<script src="{{ \URLHelper::asset('libs/datetimepicker/js/bootstrap-datetimepicker.min.js', 'admin') }}"></script>

<script src="{{ \URLHelper::asset('js/pages/categories/edit.js', 'admin') }}"></script>
@stop

@section('title')
@stop

@section('header')
Categories
@stop

@section('breadcrumb')
    <li><a href="{!! action('Admin\CategoryController@index') !!}"><i class="fa fa-files-o"></i> Categories</a></li>
    @if( $isNew )
        <li class="active">New</li>
    @else
        <li class="active">{{ $category->id }}</li>
    @endif
@stop

@section('content')

    @if( $isNew )
        <form id="form-category" action="{!! action('Admin\CategoryController@store') !!}" method="POST" enctype="multipart/form-data">
    @else
        <form id="form-category" action="{!! action('Admin\CategoryController@update', [$category->id]) !!}" method="POST" enctype="multipart/form-data">
            <input type="hidden" name="_method" value="PUT">
    @endif
            {!! csrf_field() !!}
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title">

                    </h3>
                </div>
                <div class="box-body">
                    
                    <div class="form-group @if ($errors->has('name_ja')) has-error @endif">
                        <label for="name_ja">@lang('admin.pages.categories.columns.name_ja')</label>
                        <input type="text" class="form-control" id="name_ja" name="name_ja" value="{{ old('name_ja') ? old('name_ja') : $category->name_ja }}">
                    </div>

                    <div class="form-group @if ($errors->has('name_en')) has-error @endif">
                        <label for="name_en">@lang('admin.pages.categories.columns.name_en')</label>
                        <input type="text" class="form-control" id="name_en" name="name_en" value="{{ old('name_en') ? old('name_en') : $category->name_en }}">
                    </div>

                    <div class="form-group @if ($errors->has('slug')) has-error @endif">
                        <label for="slug">@lang('admin.pages.categories.columns.slug')</label>
                        <input type="text" class="form-control" id="slug" name="slug" value="{{ old('slug') ? old('slug') : $category->slug }}">
                    </div>

                    @if( !empty($category->image) )
                        <img width="400" id="cover-image-preview" src="{!! $category->image->getThumbnailUrl(480, 300) !!}" alt="" class="margin" />
                    @else
                        <img width="400" style="display: none" id="cover-image-preview" src="{!! \URLHelper::asset('img/default-thumbnail.jpg', 'common') !!}" alt="" class="margin" />
                    @endif
                    <div class="form-group">
                        <label for="image">@lang('admin.pages.categories.columns.image_id')</label>
                        <input type="file" id="cover-image" name="image">
                        <p class="help-block">@lang('admin.pages.categories.columns.image_id')</p>
                    </div>


                    <div class="form-group  @if ($errors->has('description_ja')) has-error @endif">
                        <label for="description_ja">@lang('admin.pages.categories.columns.description_ja')</label>
                        <section id="editor2">
                            <div id='edit-desription-ja'>
                            </div>
                        </section>
                        <input type="hidden" name="description_ja" id="description-ja" value="{{ old('description_ja') ? old('description_ja') : $category->description_ja }}">
                    </div>

                    <div class="form-group @if ($errors->has('description_en')) has-error @endif">
                        <label for="description_ja">@lang('admin.pages.categories.columns.description_en')</label>
                        <section id="editor1">
                            <div id='edit-desription-en'>
                            </div>
                        </section>
                        <input type="hidden" name="description_en" id="description-en" value="{{ old('description_en') ? old('description_en') : $category->description_en }}">
                    </div>
                    <div class="form-group @if ($errors->has('order')) has-error @endif">
                        <label for="order">@lang('admin.pages.categories.columns.order')</label>
                        <input type="text" class="form-control" id="order" name="order" value="{{ old('order') ? old('order') : $category->order }}">
                    </div>
                </div>
                <div class="box-footer">
                    <button id="button-save" type="submit" class="btn btn-primary">@lang('admin.pages.common.buttons.save')</button>
                </div>
            </div>
        </form>
@stop
