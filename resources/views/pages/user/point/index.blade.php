@extends('layouts.user.application', ['noFrame' => false, 'bodyClasses' => '', 'menuUser' => 'point'])

@section('metadata')
@stop

@section('styles')
@stop

@section('scripts')
@stop

@section('title')
    @lang('user.pages.points.page_title')
@stop

@section('header')
@stop
@section('breadcrumbs', Breadcrumbs::render('point'))
@section('content')
    <main>

        @if (count($errors) > 0)
            <div class="content alert alert-danger">
                    @foreach ($errors->all() as $error)
                        <p class="error">{{ $error }}</p>
                    @endforeach
            </div>
        @endif

        <div class="wrap">
            <section>
                <div class="promos">
                    <div class="promo first">
                        <h3>@lang('user.pages.points.light_title')</h3>
                        <ul class="features">
                            <li class="price"><span>@lang('user.pages.points.light_price', ['price' => '6,780'])</span></li>
                            <li>@lang('user.pages.points.light_tickets', ['tickets' => '15'])</li>
                            <li>@lang('user.pages.points.light_time', ['minute' => '25', 'time' => '1'])</li>
                        </ul>
                    </div>
                    <div class="promo second">
                        <h3>@lang('user.pages.points.premium_title')</h3>
                        <ul class="features">
                            <li class="price">@lang('user.pages.points.premium_price', ['price' => '14,780'])</li>
                            <li>@lang('user.pages.points.premium_tickets', ['tickets' => '60'])</li>
                            <li>@lang('user.pages.points.premium_time', ['minute' => '25', 'time' => '3'])</li>
                        </ul>
                    </div>
                    <div class="promo third scale">
                        <h3>@lang('user.pages.points.basic_title')</h3>
                        <ul class="features">
                            <li class="price-orange">@lang('user.pages.points.basic_price', ['price' => '10,780'])</li>
                            <li>@lang('user.pages.points.basic_tickets', ['tickets' => '30'])</li>
                            <li>@lang('user.pages.points.basic_time', ['minute' => '25', 'time' => '2'])</li>
                        </ul>
                    </div>
                </div>
            </section>
        </div>
        <div class="content">
            <section>
                <div class="box-g">
                    <h4 class="title-buy">@lang('user.pages.points.purchase_from_here')</h4>
                    <form action="{{action('User\PointController@confirmPurchase')}}" method="post">
                        {!! csrf_field() !!}
                    <dl class="point-buy">
                        <dt>@lang('user.pages.points.lesson_plan')</dt>
                        <dd>
                            <select name="package" class="select">
                                <option value="light">@lang('user.pages.points.light_title') ￥6,780 JPY</option>
                                <option value="basic">@lang('user.pages.points.basic_title')  ￥10,780 JPY</option>
                                <option value="premium">@lang('user.pages.points.premium_title') ￥14,780 JPY</option>
                            </select>
                        </dd>
                    </dl>
                    <p><a href="#" onclick="$(this).parents('form:first').submit(); return false;" class="btn-o">@lang('user.pages.points.buy_now')</a></p>
                    </form>
                    <ul class="credit">
                        <li><img src="{{ \URLHelper::asset('img/american-express.png', 'user') }}" alt="AMERICAN EXPRESS"></li>
                        <li><img src="{{ \URLHelper::asset('img/jcb.png', 'user') }}" alt="JCB"></li>
                        <li><img src="{{ \URLHelper::asset('img/mastercard.png', 'user') }}" alt="Master Card"></li>
                        <li><img src="{{ \URLHelper::asset('img/visa.png', 'user') }}" alt="VISA"></li>
                    </ul>
                    <p>@lang('user.pages.points.paypal_description_first')</p>
                    <p>@lang('user.pages.points.paypal_description_second')</p>
                    <p>@lang('user.pages.points.paypal_description_third')</p>
                </div>
            </section>
        </div>
    </main>
@stop
