@extends('layouts.admin.application', ['menu' => 'text_books'] )

@section('metadata')
@stop

@section('styles')
@stop

@section('scripts')
<script src="{{ \URLHelper::asset('libs/moment/moment.min.js', 'admin') }}"></script>
<script src="{{ \URLHelper::asset('libs/datetimepicker/js/bootstrap-datetimepicker.min.js', 'admin') }}"></script>
<script>
$('.datetime-field').datetimepicker({'format': 'YYYY-MM-DD HH:mm:ss'});
</script>
@stop

@section('title')
@stop

@section('header')
TextBooks
@stop

@section('breadcrumb')
    <li><a href="{!! action('Admin\TextBookController@index') !!}"><i class="fa fa-files-o"></i> TextBooks</a></li>
    @if( $isNew )
        <li class="active">New</li>
    @else
        <li class="active">{{ $textBook->id }}</li>
    @endif
@stop

@section('content')
    @if (count($errors) > 0)
        <div class="alert alert-danger alert-dismissable">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    @if( $isNew )
        <form action="{!! action('Admin\TextBookController@store') !!}" method="POST" enctype="multipart/form-data">
    @else
        <form action="{!! action('Admin\TextBookController@update', [$textBook->id]) !!}" method="POST" enctype="multipart/form-data">
            <input type="hidden" name="_method" value="PUT">
    @endif
            {!! csrf_field() !!}
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title">

                    </h3>
                </div>
                <div class="box-body">
                    
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group @if ($errors->has('title')) has-error @endif">
                                <label for="title">@lang('admin.pages.text-books.columns.title')</label>
                                <input type="text" class="form-control" id="title" name="title" value="{{ old('title') ? old('title') : $textBook->title }}">
                            </div>
                        </div>
                    </div>
                    @if( !empty($textBook->file) )
                        <a href="{!! $textBook->file->url !!}" alt="" class="margin" download>Download</a>
                    @endif
                    <div class="form-group">
                        <label for="file">@lang('admin.pages.text-books.columns.file_id')</label>
                        <input type="file" name="file-pdf" class="pdf-input" accept="application/pdf">
                        <p class="help-block">@lang('admin.pages.text-books.columns.file_id')</p>
                        <span style="color:red" id='spanFileName'></span>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group @if ($errors->has('level')) has-error @endif">
                                <label for="level">@lang('admin.pages.text-books.columns.level')</label>
                                <input type="text" class="form-control" id="level" name="level" value="{{ old('level') ? old('level') : $textBook->level }}">
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group @if ($errors->has('content')) has-error @endif">
                              <label for="content">@lang('admin.pages.text-books.columns.content')</label>
                              <textarea name="content" class="form-control" rows="5" placeholder="@lang('admin.pages.text-books.columns.content')">{{ old('content') ? old('content') : $textBook->content }}</textarea>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group @if ($errors->has('order')) has-error @endif">
                                <label for="order">@lang('admin.pages.text-books.columns.order')</label>
                                <input type="text" class="form-control" id="order" name="order" value="{{ old('order') ? old('order') : $textBook->order }}">
                            </div>
                        </div>
                    </div>

                </div>
                <div class="box-footer">
                    <button type="submit" class="btn btn-primary">@lang('admin.pages.common.buttons.save')</button>
                </div>
            </div>
        </form>
@stop
