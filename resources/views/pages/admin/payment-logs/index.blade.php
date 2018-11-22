@extends('layouts.admin.application', ['menu' => 'payment_logs'] )

@section('metadata')
@stop

@section('styles')
@stop

@section('scripts')
<script src="{!! \URLHelper::asset('js/delete_item.js', 'admin') !!}"></script>
<script>
    $('#export').click(function(){
        var url = "{{ action('Admin\PaymentLogController@exportExcel') }}?" + $("#form-search").serialize();
        window.location = url;
    });
</script>
<script src="{{ \URLHelper::asset('libs/moment/moment.min.js', 'admin') }}"></script>
<script src="{{ \URLHelper::asset('libs/datetimepicker/js/bootstrap-datetimepicker.min.js', 'admin') }}"></script>
<script>
    $('.date-field').datetimepicker({'format': 'YYYY-MM', });
</script>
@stop

@section('title')
@stop

@section('header')
PaymentLogs
@stop

@section('breadcrumb')
<li class="active">PaymentLogs</li>
@stop

@section('content')
<div class="box box-primary">
    <div class="box-header with-border">
        <h3 class="box-title">
            <p class="text-right">
                <a href="{!! URL::action('Admin\PaymentLogController@create') !!}" class="btn btn-block btn-primary btn-sm">@lang('admin.pages.common.buttons.create')</a>
            </p>
        </h3>
        <div class="genre-search clearfix">

            <form action="{{ action('Admin\PaymentLogController@index') }}" method="get">
                <div class="col-lg-6">
                    <div class="form-group">
                        <label for="status">@lang('admin.pages.payment-logs.columns.status')</label>
                        <input type="text" name="status" class="form-control" id="status" placeholder="@lang('admin.pages.payment-logs.columns.status')" value="{{ $status }}">
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="form-group">
                        <label for="paid_amount">@lang('admin.pages.payment-logs.columns.paid_amount')</label>
                        <input type="text" name="paid_amount" class="form-control" id="paid_amount" placeholder="@lang('admin.pages.payment-logs.columns.paid_amount')" value="{{ $paidAmount }}">
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="form-group">
                        <label for="teacher_id">@lang('admin.pages.payment-logs.columns.teacher_id')</label>
                        <br>
                        <select id="teacher_id" class="selectpicker form-control"  name="teacher_id" data-live-search="true" title="All">
                            <option value="">All</option>
                            @foreach ($teachers as $teacher)
                                <option value="{{ $teacher->id }}" {{ $teacher->id==$teacherId? 'selected' : '' }}>
                                    {{ $teacher->name . '-' .$teacher->email}}</option>
                            @endforeach

                        </select>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="form-group">
                        <label for="paid_for_month">@lang('admin.pages.payment-logs.columns.paid_for_month')</label>
                        <input type="text" name="paid_for_month" class="form-control date-field" id="paid_for_month" placeholder="@lang('admin.pages.payment-logs.columns.paid_for_month')" value="{{ $paidForMonth }}">
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
                <th>@lang('admin.pages.payment-logs.columns.status')</th>
                <th>@lang('admin.pages.payment-logs.columns.teacher_id')</th>
                <th>@lang('admin.pages.payment-logs.columns.paid_amount')</th>
                <th>@lang('admin.pages.payment-logs.columns.paid_for_month')</th>
                <th>@lang('admin.pages.payment-logs.columns.paid_at')</th>
                <th>@lang('admin.pages.payment-logs.columns.note')</th>

                <th style="width: 40px">&nbsp;</th>
            </tr>
            @foreach( $models as $model )
                <tr>
                    <td>{{ $model->id }}</td>
                <td>{{ $model->status }}</td>
                <td>
                    @if(!empty($model->teacher))
                    {{ $model->teacher->name }}
                    @endif
                </td>
                <td>{{ $model->paid_amount }}</td>
                <td>{{ $model->paid_for_month }}</td>
                <td>{{ $model->paid_at }}</td>
                <td>{{ $model->note }}</td>

                    <td>
                        <a href="{!! URL::action('Admin\PaymentLogController@show', $model->id) !!}" class="btn btn-block btn-primary btn-sm">@lang('admin.pages.common.buttons.edit')</a>
                        <a href="#" class="btn btn-block btn-danger btn-sm delete-button" data-delete-url="{!! action('Admin\PaymentLogController@destroy', $model->id) !!}">@lang('admin.pages.common.buttons.delete')</a>
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