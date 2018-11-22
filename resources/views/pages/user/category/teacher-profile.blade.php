@extends('layouts.user.application', ['noFrame' => false, 'bodyClasses' => ''])

@section('metadata')
@stop

@section('styles')
@stop

@section('scripts')

@stop

@section('title')
    お問い合わせ
@stop

@section('header')
    お問い合わせ
@stop

@section('content')
    <main>
        @section('breadcrumbs', Breadcrumbs::render('teacher-profile', $teacher))
        <div class="grayarea">
            <h2 class="title-m">@lang('user.pages.category.teacher.teacher_profile')</h2>
        </div>
        @include('layouts.user.messagebox')
        <div class="content">
            <section>
                <div class="teacherprof">
                    <dl class="teacherprof-photo">
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
                        <table class="form">
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
            <section>
                <h3 class="title-s cent under-pink">@lang('user.pages.category.teacher.introduction_from_admin')</h3>
                <div class="box-g">
                    {{ $teacher->introduction_from_admin }}
                </div>
            </section>
            <section>
                <h3 class="title-s cent under-pink">@lang('user.pages.category.teacher.introduction')</h3>
                <div class="box-g">
                    {{ $teacher->self_introduction }}
                </div>
            </section>
            <section>
                <div class="content">
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



                    @foreach( $teacher->reviews as $review )
                        @if( $review['target'] == 'teacher' )
                            <div class="messagarea">
                                <dl class="r-profilearea">
                                    <dt>
                                        <img src="{{ $review->user->getProfileImageUrl() }}" alt="{{ $review->user->name }}">
                                    </dt>
                                    <dd>{{ $review->user->name }}</dd>
                                </dl>
                                <dl class="message_txt">
                                    <dd>
                                        <ul class="reviewstar">
                                            @for( $i = 1; $i <= 5; $i++ )
                                                @if( $i <= $review->rating )
                                                    <li><img src="{{ \URLHelper::asset('img/icon-star-full.png', 'user') }}" alt="star"></li>
                                                @else
                                                    <li><img src="{{ \URLHelper::asset('img/icon-star-empty.png', 'user') }}" alt="star"></li>
                                                @endif
                                            @endfor
                                        </ul>
                                        {{ $review->content }}
                                    </dd>
                                </dl>
                            </div>
                        @endif
                    @endforeach
                </div>
            </section>
        </div>
    </main>
@stop
