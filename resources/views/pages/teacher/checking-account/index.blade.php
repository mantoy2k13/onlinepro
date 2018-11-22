@extends('layouts.teacher.application', ['menu' => 'checking-account'])

@section('metadata')
@stop

@section('styles')
    @parent

@stop

@section('scripts')
@stop
@section('title')
    @lang('teacher.pages.checking_account.page_title')
@stop

@section('header')
@stop

@section('content')
    <div class="wrap">
        <section>
        <h2 class="title-m cent">{{ $dateNow->format('Y') }}@lang('teacher.pages.checking_account.year'){{ $dateNow->format('m') }}@lang('teacher.pages.checking_account.monthly_fee')</h2>
            <p class="box-gs cent title-m">{{ number_format(sizeof($datas)*config('cent_booking.cent_per_booking')) }}@lang('teacher.pages.checking_account.yen')</p>
            <p class="cent">※@lang('teacher.pages.checking_account.paid_info')</p>
            <div class="contents current-month">
                <table class="form-c">
                    @foreach($datas as $data)
                    <tr>
                        <th>{{ $data->present()->timeInCheckingAccount }}</th>
                        <td>{{config('cent_booking.cent_per_booking')}}@lang('teacher.pages.checking_account.yen')</td>
                    </tr>
                    @endforeach

                </table>
            </div>
        </section>
        <section>
            <h3 class="em-l cent">@lang('teacher.pages.checking_account.past_transfer')</h3>
            <div class="contents">
            <table class="form-c">
                @foreach($paymentLogs as $paymentLog)
                <tr>
                    <th>{{ $paymentLog->present()->paidForMonth }}</th>
                    <td>{{ $paymentLog->present()->paidAmount }}@lang('teacher.pages.checking_account.yen')</td>
                </tr>
               @endforeach
            </table>
            </div>
            <div class="box-footer">
                @if($count > 0)
                {!! \PaginationHelper::render($offset, $limit, $count, $baseUrl, $params, 10, 'shared.pagination') !!}
                    @endif
            </div>
        </section>
    </div>

@stop
