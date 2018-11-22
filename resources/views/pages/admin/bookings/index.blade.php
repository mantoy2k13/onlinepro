@extends('layouts.admin.application', ['menu' => 'bookings'] )

@section('metadata')
@stop

@section('styles')
@stop

@section('scripts')
<script src="{!! \URLHelper::asset('js/delete_item.js', 'admin') !!}"></script>
<script src="{{ \URLHelper::asset('libs/moment/moment.min.js', 'admin') }}"></script>
<script src="{{ \URLHelper::asset('libs/datetimepicker/js/bootstrap-datetimepicker.min.js', 'admin') }}"></script>
<script>
$('.datetime-field').datetimepicker({'format': 'YYYY-MM-DD'});
$('#export').click(function(){
    var url = "{{ action('Admin\BookingController@exportExcel') }}?" + $("#booking-counsellings").serialize();
    window.location = url;
});

</script>
@stop

@section('title')
@stop

@section('header')
Bookings
@stop

@section('breadcrumb')
<li class="active">Bookings</li>
@stop

@section('content')
<div class="box box-primary">
    <div class="box-header with-border">
        <h3 class="box-title">
            <p class="text-right">

            </p>

        </h3>
        <div class="genre-search clearfix">

            <form action="{{ action('Admin\BookingController@index') }}" id="booking-counsellings" method="get">
                <div class="col-lg-6">
                    <div class="form-group">
                        <label for="name_en">@lang('admin.pages.bookings.columns.user_id')</label>
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
                        <label for="name_ja">@lang('admin.pages.bookings.columns.teacher_id')</label>
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
                        <label for="date_from">@lang('admin.pages.bookings.columns.date_from')</label>
                        <input type="text" name="date_from" class="datetime-field form-control" id="date_from" placeholder="@lang('admin.pages.bookings.columns.date_from')" value="{{ $dateFrom }}">
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="form-group">
                        <label for="country_code">@lang('admin.pages.bookings.columns.date_to')</label>
                        <input type="text" name="date_to" class="datetime-field form-control" id="date_to" placeholder="@lang('admin.pages.bookings.columns.date_to')" value="{{ $dateTo }}">
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="form-group">
                        <label for="country_code">@lang('admin.pages.bookings.columns.status')</label>
                        <select id="status" data-width="100%" class="selectpicker form-control"  name="status" data-live-search="true" title="All">
                            <option value="">All</option>
                            <option value="canceled" {{$status=='canceled' ? 'selected' : ''}}>Canceled</option>
                            <option value="pending" {{$status=='pending' ? 'selected' : ''}}>Pending</option>
                            <option value="finished" {{$status=='finished' ? 'selected' : ''}}>Finished</option>

                        </select>
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
        <p>@lang('admin.pages.common.label.total_result') {{ $count }} </p>
        <table class="table table-bordered">
            <tr>
                <th style="width: 10px">ID</th>
                <th>@lang('admin.pages.bookings.columns.status')</th>
                <th>@lang('admin.pages.bookings.columns.user_id')</th>
                <th>@lang('admin.pages.bookings.columns.teacher_id')</th>
                <th>@lang('admin.pages.bookings.columns.message')</th>
                <th>@lang('admin.pages.bookings.columns.counseling_start_time')</th>
                <th>@lang('admin.pages.bookings.columns.counseling_end_time')</th>

                <th style="width: 40px">&nbsp;</th>
            </tr>
            @foreach( $models as $model )
                <tr>
                    <td>{{ $model->id }}</td>
                    <td>{{ $model->status }}</td>
                    <td>{{ $model->present()->userName }}</td>
                    <td>{{ $model->present()->teacherName }}</td>
                    <td>{{ $model->present()->message }}</td>
                    <td>{{ $model->present()->timeSlotStart }}</td>
                    <td>{{ $model->present()->timeSlotEnd }}</td>

                    <td>
                        <a href="#" class="btn btn-block btn-danger btn-sm delete-button" data-delete-url="{!! action('Admin\BookingController@destroy', $model->id) !!}">@lang('admin.pages.common.buttons.delete')</a>
                        <a href="#" class="btn btn-block btn-warning btn-sm cancel-button
                                @if($model->timeSlot->start_at < $now || $model->status != 'pending')
                                    disabled
                                @endif
                                " data-cancel-url="{!! action('Admin\BookingController@cancelBooking', $model->id) !!}">
                            @lang('admin.pages.common.buttons.cancel')</a>
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
