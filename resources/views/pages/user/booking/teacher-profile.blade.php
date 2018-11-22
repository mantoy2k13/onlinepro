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
                    moreLink: '<a href="#" class="btn-gs">もっと見る</a>',
                    lessLink: '<a href="#" class="btn-gs">閉じる</a>',
                    maxHeight: 1000
                });
            });
        }
    </script>
@stop

@section('title')
    @lang('user.pages.teacher_profile.page_title')
@stop

@section('header')
@stop

@section('content')
@section('breadcrumbs', Breadcrumbs::render('teacher-profile', $teacher))
@include('layouts.user.messagebox')
<div class="wrap">
    <section>
        <div class="teacherprof">
            <dl class="teacherprof-area">
                <dt>
                    <img src="{!! $teacher->getProfileImageUrl() !!}" alt="{!! $teacher->name !!}"/>
                </dt>
                <dd>
                    @if($isFavorite)
                        <a id="remove-favorite-button" class="btn-gs" href="#" data-action="DELETE"
                           data-url="{{ action('User\IndexController@removeFavoriteTeacher', $teacher->id) }}">
                            @lang('user.pages.category.teacher.delete_favorites')</a>
                    @else
                        <a id="favorite-button" class="btn-gs" href="#" data-action="post"
                           data-url="{{ action('User\IndexController@addFavoriteTeacher', $teacher->id) }}">
                            @lang('user.pages.category.teacher.add_to_favorites')</a>
                    @endif
                </dd>
                <form id="favorite-form" method="post" action="">
                    {!! csrf_field() !!}
                </form>
            </dl>
            <div class="profdata">
                <table class="form-b">
                    <tr>
                        <th>@lang('user.pages.category.teacher.name')</th>
                        <td>{{ $teacher['name'] }}</td>
                    </tr>
                    <tr>
                        <th>@lang('user.pages.category.teacher.age')</th>
                        <td>{{ $teacher['year_of_birth'] }}</td>
                    </tr>
                    <tr>
                        <th>@lang('user.pages.category.teacher.gender')</th>
                        <td>{{ trans('teacher.gender.'.$teacher['gender']) }}</td>
                    </tr>
                    <tr>
                        <th>@lang('user.pages.category.teacher.living_country_code')</th>
                        <td>{{ !empty($teacher->livingCountry) ? $teacher->livingCountry->present()->name : 'N/A' }}</td>
                    </tr>
                    <tr>
                        <th>@lang('user.pages.category.teacher.living_city_id')</th>
                        <td>{{ !empty($teacher->livingCity) ? $teacher->livingCity->present()->name : 'N/A' }}</td>
                    </tr>
                    <tr>
                        <th>@lang('user.pages.category.teacher.personalities')</th>
                        <td>{{ $teacher->present()->getListPersonality }}</td>
                    </tr>
                    <tr>
                        <th>@lang('user.pages.category.teacher.hobby')</th>
                        <td>{{ $teacher['hobby'] }}</td>
                    </tr>
                    <tr>
                        <th>@lang('user.pages.category.teacher.home_province_id')</th>
                        <td>{{ !empty($teacher->homeProvince) ? $teacher->homeProvince->present()->name : 'N/A'  }}</td>
                    </tr>

                </table>
            </div>
        </div>
    </section>
    <section class="sp-btm">
        <h3 class="title-s cent under-pink">@lang('user.pages.category.teacher.introduction')</h3>
        <div class="box-g">
            {{ $teacher->self_introduction }}
        </div>
    </section>
    <section>
        <div class="wrap">
            <h3 class="title-s cent under-pink">@lang('user.pages.category.teacher.review')</h3>
            <div class="box-gs">
                <p class="cent title-s">@lang('user.pages.category.teacher.evaluation')</p>
                <ul class="reviewstar">
                    @for( $i = 1; $i <= 5; $i++ )
                        @if( $i <= $teacher->present()->getAverageRating )
                            <li><img src="{{ \URLHelper::asset('img/icon-star-full.png', 'user') }}" alt="star"></li>
                        @else
                            <li><img src="{{ \URLHelper::asset('img/icon-star-empty.png', 'user') }}" alt="star"></li>
                        @endif
                    @endfor
                </ul>
            </div>


            @foreach( $reviews as $review )
                @if( $review['target'] == 'teacher' )
                    <div class="messagarea">
                        <dl class="profilephoto">
                            @if(!empty($review->user))
                            <dt>
                                <img class="photo" src="{{ $review->user->getProfileImageUrl() }}" alt="{{ $review->user->name }}">
                            </dt>
                            <dd>{{ $review->user->name }}</dd>
                            @endif
                        </dl>
                        <dl class="message_txt">
                            <dd>
                                <ul class="reviewstar">
                                    @for( $i = 1; $i <= 5; $i++ )
                                        @if( $i <= $review->rating )
                                            <li><img src="{{ \URLHelper::asset('img/icon-star-full.png', 'user') }}"
                                                     alt="star"></li>
                                        @else
                                            <li><img src="{{ \URLHelper::asset('img/icon-star-empty.png', 'user') }}"
                                                     alt="star"></li>
                                        @endif
                                    @endfor
                                </ul>
                                <div class="readmore">
                                    {{ $review->content }}
                                </div>
                            </dd>
                        </dl>
                    </div>
                @endif
            @endforeach
            {!! \PaginationHelper::render($offset, $limit, $count, $baseUrl, $params, 10, 'shared.pagination') !!}
        </div>
    </section>
</div>
@stop
