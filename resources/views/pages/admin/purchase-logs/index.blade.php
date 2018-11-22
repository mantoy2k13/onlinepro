@extends('layouts.admin.application', ['menu' => 'purchase_logs'] )

@section('metadata')
@stop

@section('styles')
@stop

@section('scripts')
<script src="{!! \URLHelper::asset('js/delete_item.js', 'admin') !!}"></script>
<script>
    $('#export').click(function(){
        var url = "{{ action('Admin\PurchaseLogController@exportExcel') }}?" + $("#form-search").serialize();
        window.location = url;
    });
</script>
@stop

@section('title')
@stop

@section('header')
PurchaseLogs
@stop

@section('breadcrumb')
<li class="active">PurchaseLogs</li>
@stop

@section('content')
<div class="box box-primary">
    <div class="box-header with-border">
        <h3 class="box-title">
            <p class="text-right">

            </p>
        </h3>
        <div class="genre-search clearfix">

            <form action="{{ action('Admin\PurchaseLogController@index') }}" method="get" id="form-search">
                <div class="col-lg-6">
                    <div class="form-group">
                        <label for="purchase_method_type">@lang('admin.pages.purchase-logs.columns.purchase_method_type')</label>
                        <select id="purchase_method_type" data-width="100%" class="selectpicker form-control"  name="purchase_method_type" data-live-search="true" title="Select">
                            <option value="">Select</option>
                            @foreach($types as $tp)
                                <option value="{{$tp}}"
                                        @if(old('purchase_method_type'))
                                        @if(old('purchase_method_type')==$tp)
                                        selected
                                        @endif
                                        @else
                                        @if($purchaseMethodType == $tp)
                                        selected
                                        @endif
                                        @endif
                                >{{$tp}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="form-group">
                        <label for="point_amount">@lang('admin.pages.purchase-logs.columns.point_amount')</label>
                        <input type="text" name="point_amount" class="form-control" id="point_amount" placeholder="@lang('admin.pages.purchase-logs.columns.point_amount')" value="{{ $pointAmount }}">
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="form-group">
                        <label for="user_id">@lang('admin.pages.purchase-logs.columns.user')</label>
                        <br>
                        <select id="user_id" class="selectpicker form-control"  name="user_id" data-live-search="true" title="All">
                            <option value="0"
                                    @if(empty($userId) or $userId === 0)
                                        selected
                                    @endif
                            >All</option>
                            @foreach ($users as $user)
                                <option value="{{ $user->id }}" {{ $user->id==$userId ? 'selected' : '' }}>
                                    {{ $user->name }}</option>
                            @endforeach

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
        <table class="table table-bordered">
            <tr>
                <th style="width: 10px">ID</th>
                <th>@lang('admin.pages.purchase-logs.columns.user_id')</th>
                <th>@lang('admin.pages.purchase-logs.columns.user')</th>
                <th>@lang('admin.pages.purchase-logs.columns.purchase_method_type')</th>
                <th>@lang('admin.pages.purchase-logs.columns.point_amount')</th>
                <th>@lang('admin.pages.purchase-logs.columns.purchase_info')</th>
                <th>@lang('admin.pages.purchase-logs.columns.created_at')</th>

                <th style="width: 40px">&nbsp;</th>
            </tr>
            @foreach( $models as $model )
                <tr>
                    <td>{{ $model->id }}</td>
                    <td>
                        @if(!empty($model->user))
                            {{ $model->user->id }}
                        @endif
                    </td>
                    <td>
                        @if(!empty($model->user))
                        {{ $model->user->name }}
                        @endif
                    </td>
                    <td>{{ $model->purchase_method_type }}</td>
                    <td>{{ $model->point_amount }}</td>
                    <td>
                        @if($model->purchase_method_type == 'paypal')
                            <p>PaymentId: {{ !empty(json_decode($model->purchase_info)->id) ? json_decode($model->purchase_info)->id : '' }}</p>
                            <p>State: {{ !empty(json_decode($model->purchase_info)->state) ? json_decode($model->purchase_info)->state : '' }}</p>
                            <p>Name: {{ !empty(json_decode($model->purchase_info)->payer->payer_info->shipping_address->recipient_name) ? json_decode($model->purchase_info)->payer->payer_info->shipping_address->recipient_name : '' }}</p>
                            <p>Transactions amount: {{ !empty(json_decode($model->purchase_info)->transactions) ? json_decode($model->purchase_info)->transactions[0]->amount->total : ''}}
                            {{!empty(json_decode($model->purchase_info)->transactions) ? json_decode($model->purchase_info)->transactions[0]->amount->currency : '' }}</p>
                        @else
                            <p>{{$model->purchase_info}}</p>
                        @endif
                    </td>
                    <td>{{ $model->present()->createdAt }}</td>
                    <td>
                        <a href="{!! action('Admin\PurchaseLogController@show', $model->id) !!}" class="btn btn-block btn-primary btn-sm">@lang('admin.pages.common.buttons.edit')</a>
                        <a href="#" class="btn btn-block btn-danger btn-sm delete-button" data-delete-url="{!! action('Admin\PurchaseLogController@destroy', $model->id) !!}">@lang('admin.pages.common.buttons.delete')</a>
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
