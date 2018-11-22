@extends('layouts.admin.application', ['menu' => 'reviews'] )

@section('metadata')
@stop

@section('styles')
@stop

@section('scripts')
<script src="{!! \URLHelper::asset('js/delete_item.js', 'admin') !!}"></script>
<script>
    $('#export').click(function(){
        var url = "{{ action('Admin\ReviewController@exportExcel') }}?" + $("#form-search").serialize();
        window.location = url;
    });
</script>
@stop

@section('title')
@stop

@section('header')
Reviews
@stop

@section('breadcrumb')
<li class="active">Reviews</li>
@stop

@section('content')
<div class="box box-primary">
    <div class="box-header with-border">
        <h3 class="box-title">
            <p class="text-right">

            </p>
        </h3>
        <div class="genre-search clearfix">

            <form action="{{ action('Admin\ReviewController@index') }}" method="get" id="form-search">
                <div class="col-lg-6">
                    <div class="form-group">
                        <label for="name_en">@lang('admin.pages.reviews.columns.user_id')</label>
                        <br>
                        <select id="user_id" class="selectpicker form-control"   data-width="100%"  name="user_id" data-live-search="true" title="All">
                            <option value="">All</option>
                            @foreach ($users as $user)
                                <option value="{{ $user->id }}" {{ $user->id==$userId ? 'selected' : '' }}>
                                    {{ $user->name . '<->' .$user->email}}</option>
                            @endforeach

                        </select>
                    </div>
                </div>

                <div class="col-lg-6">
                    <div class="form-group">
                        <label for="name_ja">@lang('admin.pages.reviews.columns.teacher_id')</label>
                        <br>
                        <select id="teacher_id" data-width="100%" class="selectpicker form-control"  name="teacher_id" data-live-search="true" title="All">
                            <option value="">All</option>
                            @foreach ($teachers as $teacher)
                                <option value="{{ $teacher->id }}" {{ $teacher->id==$teacherId ? 'selected' : '' }}>
                                    {{ $teacher->name . '<->' .$teacher->email}}</option>
                            @endforeach

                        </select>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="form-group">
                        <label for="country_code">@lang('admin.pages.reviews.columns.rating')</label>
                        <input type="text" name="rating" class="form-control" id="rating" placeholder="@lang('admin.pages.reviews.columns.rating')" value="{{ $rating }}">
                    </div>
                </div>
                <div class="clearfix"></div>
                <div class="form-group">
                    <p style="text-align: center"><a href="#"  onclick="$(this).parents('form:first').submit(); return false;" class="btn btn-primary">@lang('admin.pages.common.buttons.search')</a></p>
                    <button type="button" class="btn btn-primary" id="export">Export</button>
                </div>
            </form>
        </div>
        {!! \PaginationHelper::render($offset, $limit, $count, $baseUrl, $params, 10, 'shared.pagination') !!}
    </div>
    <div class="box-body">
        <table class="table table-bordered">
            <tr>
                <th style="width: 10px">ID</th>
                <th>@lang('admin.pages.reviews.columns.user_id')</th>
                <th>@lang('admin.pages.reviews.columns.teacher_id')</th>
                <th>@lang('admin.pages.reviews.columns.booking_id')</th>
                <th>@lang('admin.pages.reviews.columns.rating')</th>
                <th>@lang('admin.pages.reviews.columns.content')</th>

                <th style="width: 40px">&nbsp;</th>
            </tr>
            @foreach( $models as $model )
                <tr>
                    <td>{{ $model->id }}</td>
                <td>
                    @if(!empty($model->user))
                        {{ $model->user->name }}
                    @endif
                </td>
                <td>
                    @if(!empty($model->teacher))
                        {{ $model->teacher->name }}
                    @endif
                </td>
                <td>{{ $model->booking_id }}</td>
                <td>@if($model->target == 'teacher')
                    {{ $model->rating }}
                        @endif
                </td>
                <td>{{ $model->content }}</td>

                <td>
                    <a href="{!! URL::action('Admin\ReviewController@show', $model->id) !!}" class="btn btn-block btn-primary btn-sm">@lang('admin.pages.common.buttons.edit')</a>
                    <a href="#" class="btn btn-block btn-danger btn-sm delete-button" data-delete-url="{!! action('Admin\ReviewController@destroy', $model->id) !!}">@lang('admin.pages.common.buttons.delete')</a>
                </td>
                </tr>
            @endforeach
        </table>
    </div>
    <div class="box-footer">
        {!! \PaginationHelper::render($offset, $limit, $count, $baseUrl, $params, 10, 'shared.pagination') !!}
    </div>
</div>
@stop