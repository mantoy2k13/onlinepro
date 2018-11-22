@extends('layouts.admin.application', ['menu' => 'payment_logs'] )

@section('metadata')
@stop

@section('styles')
@stop

@section('scripts')
<script src="{{ \URLHelper::asset('libs/moment/moment.min.js', 'admin') }}"></script>
<script src="{{ \URLHelper::asset('libs/datetimepicker/js/bootstrap-datetimepicker.min.js', 'admin') }}"></script>
<script>
$('.datetime-field').datetimepicker({'format': 'YYYY-MM-DD',});
$('.date-field').datetimepicker({'format': 'YYYY-MM', });
</script>
@stop

@section('title')
@stop

@section('header')
PaymentLogs
@stop

@section('breadcrumb')
    <li><a href="{!! action('Admin\PaymentLogController@index') !!}"><i class="fa fa-files-o"></i> PaymentLogs</a></li>
    @if( $isNew )
        <li class="active">New</li>
    @else
        <li class="active">{{ $paymentLog->id }}</li>
    @endif
@stop

@section('content')

    @if( $isNew )
        <form action="{!! action('Admin\PaymentLogController@store') !!}" method="POST" enctype="multipart/form-data">
    @else
        <form action="{!! action('Admin\PaymentLogController@update', [$paymentLog->id]) !!}" method="POST" enctype="multipart/form-data">
            <input type="hidden" name="_method" value="PUT">
    @endif
            {!! csrf_field() !!}
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title">

                    </h3>
                </div>
                <div class="box-body">
                    <div class="form-group @if ($errors->has('teacher_id')) has-error @endif">
                        <label for="teacher_id">@lang('admin.pages.payment-logs.columns.teacher_id')</label>
                        <br>
                        <select id="teacher_id" class="selectpicker  form-control"  name="teacher_id" data-live-search="true" title="Choose one">
                            @foreach ($teachers as $teacher)
                                <option value="{{ $teacher->id }}" {{ $teacher->id==$paymentLog->teacher_id? 'selected' : '' }}>
                                    {{ $teacher->name . '-' .$teacher->email}}</option>
                            @endforeach

                        </select>
                    </div>
                    <div class="form-group @if ($errors->has('status')) has-error @endif">
                        <label for="status">@lang('admin.pages.payment-logs.columns.status')</label>
                        <input type="text" class="form-control" id="status" name="status" value="{{ old('status') ? old('status') : $paymentLog->status }}">
                    </div>

                    <div class="form-group @if ($errors->has('paid_amount')) has-error @endif">
                        <label for="paid_amount">@lang('admin.pages.payment-logs.columns.paid_amount')</label>
                        <input type="text" class="form-control" id="paid_amount" name="paid_amount" value="{{ old('paid_amount') ? old('paid_amount') : $paymentLog->paid_amount }}">
                    </div>
                    <div class="form-group @if ($errors->has('paid_for_month')) has-error @endif">
                        <label for="paid_for_month">@lang('admin.pages.payment-logs.columns.paid_for_month')</label>
                        <input type="text" class="form-control date-field" id="paid_for_month" name="paid_for_month" value="{{ old('paid_for_month') ? old('paid_for_month') : $paymentLog->paid_for_month }}">
                    </div>
                    <div class="form-group @if ($errors->has('paid_at')) has-error @endif">
                        <label for="paid_at">@lang('admin.pages.payment-logs.columns.paid_at')</label>
                        <input type="text" class="form-control datetime-field" id="paid_at" name="paid_at" value="{{ old('paid_at') ? old('paid_at') : $paymentLog->paid_at }}">
                    </div>

                    <div class="form-group @if ($errors->has('note')) has-error @endif">
                        <label for="note">@lang('admin.pages.payment-logs.columns.note')</label>
                        <textarea name="note" class="form-control" rows="5" placeholder="@lang('admin.pages.payment-logs.columns.note')">{{ old('note') ? old('note') : $paymentLog->note }}</textarea>
                    </div>

                </div>
                <div class="box-footer">
                    <button type="submit" class="btn btn-primary">@lang('admin.pages.common.buttons.save')</button>
                </div>
            </div>
        </form>
@stop
