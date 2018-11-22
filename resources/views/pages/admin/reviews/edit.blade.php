@extends('layouts.admin.application', ['menu' => 'reviews'] )

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
Reviews
@stop

@section('breadcrumb')
    <li><a href="{!! action('Admin\ReviewController@index') !!}"><i class="fa fa-files-o"></i> Reviews</a></li>
    @if( $isNew )
        <li class="active">New</li>
    @else
        <li class="active">{{ $review->id }}</li>
    @endif
@stop

@section('content')

    @if( $isNew )
        <form action="{!! action('Admin\ReviewController@store') !!}" method="POST" enctype="multipart/form-data">
            <input type="hidden" id="booking_id" name="booking_id" value="0">
    @else
        <form action="{!! action('Admin\ReviewController@update', [$review->id]) !!}" method="POST" enctype="multipart/form-data">
            <input type="hidden" name="_method" value="PUT">
            <input type="hidden" id="booking_id" name="booking_id" value="{{ $review->booking_id }}">
    @endif
            {!! csrf_field() !!}
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title">

                    </h3>
                </div>
                <div class="box-body">
                    <input type="hidden" id="booking_id" name="booking_id" value="{!! $review->booking_id !!}">
                    <div class="col-lg-6">
                        <div class="form-group @if ($errors->has('user_id')) has-error @endif">
                            <label for="user_id">@lang('admin.pages.reviews.columns.user_id')</label>
                            <br>
                            <select id="user_id" class="selectpicker form-control"   data-width="100%"  name="user_id" data-live-search="true" title="All">
                                <option value="">All</option>
                                @foreach ($users as $user)
                                    <option value="{{ $user->id }}" {{ $user->id==$review->user_id ? 'selected' : '' }}>
                                        {{ $user->name . '<->' .$user->email}}</option>
                                @endforeach

                            </select>
                        </div>
                    </div>

                    <div class="col-lg-6">
                        <div class="form-group  @if ($errors->has('teacher_id')) has-error @endif">
                            <label for="teacher_id">@lang('admin.pages.reviews.columns.teacher_id')</label>
                            <br>
                            <select id="teacher_id" data-width="100%" class="selectpicker form-control"  name="teacher_id" data-live-search="true" title="All">
                                <option value="">All</option>
                                @foreach ($teachers as $teacher)
                                    <option value="{{ $teacher->id }}" {{ $teacher->id==$review->teacher_id ? 'selected' : '' }}>
                                        {{ $teacher->name . '<->' .$teacher->email}}</option>
                                @endforeach

                            </select>
                        </div>
                    </div>

                    <div class="form-group @if ($errors->has('rating')) has-error @endif">
                        <label for="rating">@lang('admin.pages.reviews.columns.rating')</label>
                        <input type="text" class="form-control" id="rating" name="rating" value="{{ old('rating') ? old('rating') : $review->rating }}">
                    </div>

                    <div class="form-group @if ($errors->has('content')) has-error @endif">
                        <label for="content">@lang('admin.pages.reviews.columns.content')</label>
                        <textarea name="content" class="form-control" rows="5" placeholder="@lang('admin.pages.reviews.columns.content')">{{{ old('content') ? old('content') : $review->content }}}</textarea>
                    </div>

                </div>
                <div class="box-footer">
                    <button type="submit" class="btn btn-primary">@lang('admin.pages.common.buttons.save')</button>
                </div>
            </div>
        </form>
@stop
