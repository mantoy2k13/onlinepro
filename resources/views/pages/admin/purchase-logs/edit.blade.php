@extends('layouts.admin.application', ['menu' => 'purchase_logs'] )

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
PurchaseLogs
@stop

@section('breadcrumb')
    <li><a href="{!! action('Admin\PurchaseLogController@index') !!}"><i class="fa fa-files-o"></i> PurchaseLogs</a></li>
    @if( $isNew )
        <li class="active">New</li>
    @else
        <li class="active">{{ $purchaseLog->id }}</li>
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
        <form action="{!! action('Admin\PurchaseLogController@store') !!}" method="POST" enctype="multipart/form-data">
            <input type="hidden" id="user_id" name="user_id" value="0">
    @else
        <form action="{!! action('Admin\PurchaseLogController@update', [$purchaseLog->id]) !!}" method="POST" enctype="multipart/form-data">
            <input type="hidden" name="_method" value="PUT">
            <input type="hidden" id="user_id" name="user_id" value="{{ $purchaseLog->user_id }}">
    @endif
            {!! csrf_field() !!}
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title">

                    </h3>
                </div>
                <div class="box-body">

                    <div class="form-group @if ($errors->has('purchase_method_type')) has-error @endif">
                        <label for="purchase_method_type">@lang('admin.pages.purchase-logs.columns.purchase_method_type')</label>
                        <input type="text" class="form-control" id="purchase_method_type" name="purchase_method_type" value="{{ old('purchase_method_type') ? old('purchase_method_type') : $purchaseLog->purchase_method_type }}">
                    </div>

                    <div class="form-group @if ($errors->has('point_amount')) has-error @endif">
                        <label for="point_amount">@lang('admin.pages.purchase-logs.columns.point_amount')</label>
                        <input type="text" class="form-control" id="point_amount" name="point_amount" value="{{ old('point_amount') ? old('point_amount') : $purchaseLog->point_amount }}">
                    </div>

                    <div class="form-group @if ($errors->has('purchase_info')) has-error @endif">
                        <label for="purchase_info">@lang('admin.pages.purchase-logs.columns.purchase_info')</label>

                        @if($purchaseLog->purchase_method_type == 'paypal')
                            {{ $purchaseLog->purchase_info }}
                            @else
                            <textarea name="purchase_info" class="form-control" rows="5" placeholder="@lang('admin.pages.purchase-logs.columns.purchase_info')">{{{ old('purchase_info') ? old('purchase_info') : $purchaseLog->purchase_info }}}</textarea>
                        @endif

                    </div>

                </div>
                <div class="box-footer">
                    <button type="submit" class="btn btn-primary">@lang('admin.pages.common.buttons.save')</button>
                </div>
            </div>
        </form>
@stop
