@extends('layouts.user.application', ['noFrame' => false, 'bodyClasses' => ''])

@section('metadata')
@stop

@section('styles')
@stop

@section('scripts')
    <script type="text/javascript" src="{!! \URLHelper::asset('js/readmore.js', 'user') !!}"></script>
    <script type="text/javascript">
        if(!navigator.userAgent.match(/(iPhone|iPad|Android)/)){
            $(function () {
                $('.readmore').readmore({
                    speed: 1000,
                    collapsedHeight:700,
                    moreLink: '<a href="#" class="btn-gs">@lang('user.common.buttons.see_more')</a>',
                    lessLink: '<a href="#" class="btn-gs">@lang('user.common.buttons.close_up')</a>',
                    maxHeight: 1000
                });
            });
        }
    </script>
    <script type="text/javascript">
        if(navigator.userAgent.match(/(iPhone|iPad|iPod|Android)/)){
            $(function() {
                $('div').removeClass('pagiationarea');
            });
        }
    </script>
@stop

@section('title')
    @lang('user.pages.favorites.page_title')
@stop

@section('header')
@stop

@section('content')
<main>
    @section('breadcrumbs', Breadcrumbs::render('favorites'))
    <div class="content">
        <section>
            <ul class="favoritelist readmore">
                @foreach($models as $model)

                    <li class="heightLine-group1">
                        <dl class="teachertable">
                            <dt>
                                <span class="teachertable-photo" style="background-image: url('{!! $model->getProfileImageUrl(130, 95) !!}')"></span>
                                    <strong>{!! $model->name !!}</strong>

                            </dt>
                            <dd>
                                <ul class="reviewstar">
                                    @for( $i = 1; $i <= 5; $i++ )
                                        @if( $i <= $model->present()->getAverageRating )
                                            <li><img src="{{ \URLHelper::asset('img/icon-star-full.png', 'user') }}" alt="star"></li>
                                        @else
                                            <li><img src="{{ \URLHelper::asset('img/icon-star-empty.png', 'user') }}" alt="star"></li>
                                        @endif
                                    @endfor
                                </ul>
                                <p><a href="{{ action('User\IndexController@teacherProfile', $model->id) }}" class="btn-gs arrow-gs">@lang('user.pages.favorites.teacher_profile')</a></p>
                            </dd>
                        </dl>
                    </li>
                @endforeach

            </ul>
            {!! \PaginationHelper::render($offset, $limit, $count, $baseUrl, $params, 10, 'shared.pagination') !!}
        </section>
    </div>
</main>
@stop
