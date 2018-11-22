@extends('layouts.admin.application', ['menu' => 'teachers'] )

@section('metadata')
@stop

@section('styles')
@stop

@section('scripts')
    <script src="{!! \URLHelper::asset('js/delete_item.js', 'admin') !!}"></script>
    <script src="{{ \URLHelper::asset('libs/moment/moment.min.js', 'admin') }}"></script>
    <script src="{{ \URLHelper::asset('libs/datetimepicker/js/bootstrap-datetimepicker.min.js', 'admin') }}"></script>
    <script>
        $('#export').click(function(){
            var url = "{{ action('Admin\TeacherController@exportExcel') }}?" + $("#form-search").serialize();
            window.location = url;
        });
    </script>
@stop

@section('title')
@stop

@section('header')
    Teachers
@stop

@section('breadcrumb')
    <li class="active">Teachers</li>
@stop

@section('content')
    <div class="box box-primary">
        <div class="box-header with-border">
            <h3 class="box-title">
                <p class="text-right">
                    <a href="{!! URL::action('Admin\TeacherController@create') !!}" class="btn btn-block btn-primary btn-sm">@lang('admin.pages.common.buttons.create')</a>
                </p>
            </h3>
            <div class="genre-search clearfix">

                <form action="{{ action('Admin\TeacherController@index') }}" method="get" id="form-search">
                    <div class="col-lg-6">
                        <div class="form-group">
                            <label for="name">@lang('admin.pages.teachers.columns.name')</label>
                            <input type="text" name="name" class="form-control" id="name" placeholder="@lang('admin.pages.teachers.columns.name')" value="{{ $name }}">
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="form-group">
                            <label for="email">@lang('admin.pages.teachers.columns.email')</label>
                            <input type="text" name="email" class="form-control" id="email" placeholder="@lang('admin.pages.teachers.columns.email')" value="{{ $email }}">
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="form-group">
                            <label for="living_country_code">@lang('admin.pages.teachers.columns.living_country_code')</label>
                            <br>
                            <select id="living_country_code" data-width="100%" class="selectpicker"  name="living_country_code" data-live-search="true" title="All">
                                <option value="">All</option>
                                @foreach ($countries as $country)
                                    <option value="{{ $country->code }}" {{ $country->code==$livingCountryCode ? 'selected' : '' }}>
                                        {{ $country->name_en . '-' .$country->name_ja}}</option>
                                @endforeach

                            </select>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="form-group">
                            <label for="status">@lang('admin.pages.teachers.columns.status')</label>
                            <select id="status" data-width="100%" class="selectpicker form-control"  name="status" data-live-search="true" title="--">
                                <option value=""></option>
                                <option value="all" {{$status=='all' ? 'selected' : ''}}>All</option>
                                <option value="deleted" {{$status=='deleted' ? 'selected' : ''}}>Deleted</option>

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
            Total: {{ $count }}
            <table class="table table-bordered">
                <tr>
                    <th style="width: 10px">ID</th>
                    <th>@lang('admin.pages.teachers.columns.name')</th>
                    <th>@lang('admin.pages.teachers.columns.email')</th>
                    <th>@lang('admin.pages.teachers.columns.skype_id')</th>
                    <th>@lang('admin.pages.teachers.columns.locale')</th>
                    <th>@lang('admin.pages.teachers.columns.year_of_birth')</th>
                    <th>@lang('admin.pages.teachers.columns.gender')</th>
                    <th>@lang('admin.pages.teachers.columns.living_country_code')</th>
                    <th>@lang('admin.pages.teachers.columns.living_start_date')</th>
                    <th>@lang('admin.pages.teachers.columns.nationality_country_code')</th>
                    <th>@lang('admin.pages.users.columns.status')</th>

                    <th style="width: 40px">&nbsp;</th>
                </tr>
                @foreach( $models as $model )
                    <tr>
                        <td>{{ $model->id }}</td>
                        <td>{{ $model->name }}</td>
                        <td>{{ $model->email }}</td>
                        <td>{{ $model->skype_id }}</td>
                        <td>{{ $model->locale }}</td>
                        <td>{{ $model->year_of_birth }}</td>
                        <td>{{ $model->gender  }}</td>
                        <td>{{ $model->livingCountry->name_en . '-' . $model->livingCountry->name_ja}}</td>
                        <td>{{ $model->living_start_date }}</td>
                        <td>{{ $model->nationalityCountry->name_en . '-' . $model->nationalityCountry->name_ja }}</td>
                        <td>@if($model->present()->status == 'deleted')
                                <span class="label label-danger">Deleted</span>
                            @else
                                <span class="label label-info"></span>
                            @endif
                        </td>

                        <td>
                            @if($model->present()->status != 'deleted')
                                <a href="{!! URL::action('Admin\TeacherController@show', $model->id) !!}" class="btn btn-block btn-primary btn-sm">@lang('admin.pages.common.buttons.edit')</a>
                                <a href="#" class="btn btn-block btn-danger btn-sm delete-button" data-delete-url="{!! action('Admin\TeacherController@destroy', $model->id) !!}">@lang('admin.pages.common.buttons.delete')</a>
                            @endif
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
