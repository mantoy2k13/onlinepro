@extends('layouts.admin.application',['menu' => 'users'] )

@section('metadata')
@stop

@section('styles')
@stop

@section('scripts')
    <script src="{!! \URLHelper::asset('js/sortable.js', 'admin') !!}"></script>
    <script src="{!! \URLHelper::asset('js/delete_item.js', 'admin') !!}"></script>
    <script>
        $('#export').click(function () {
            var url = "{{ action('Admin\UserController@exportExcel') }}?" + $("#form-search").serialize();
            window.location = url;
        });
    </script>
@stop

@section('title')
    {{ config('site.name') }} | Admin | Admin Users
@stop

@section('header')
    Users
@stop

@section('content')
    <div class="box box-primary">
        <div class="box-header with-border">
            <div class="genre-search clearfix">

                <form action="{{ action('Admin\UserController@index') }}" method="get" id="form-search">
                    <div class="col-lg-6">
                        <div class="form-group">
                            <label for="name_en">@lang('admin.pages.users.columns.name')</label>
                            <input type="text" name="name" class="form-control" id="name"
                                   placeholder="@lang('admin.pages.users.columns.name')" value="{{ $name }}">
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="form-group">
                            <label for="name_ja">@lang('admin.pages.users.columns.email')</label>
                            <input type="text" name="email" class="form-control" id="email"
                                   placeholder="@lang('admin.pages.users.columns.email')" value="{{ $email }}">
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="form-group">
                            <label for="skype_id">@lang('admin.pages.users.columns.skype_id')</label>
                            <input type="text" name="skype_id" class="form-control" id="skype_id"
                                   placeholder="@lang('admin.pages.users.columns.skype_id')" value="{{ $skypeId }}">
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="form-group">
                            <label for="status">@lang('admin.pages.users.columns.status')</label>
                            <select id="status" data-width="100%" class="selectpicker form-control"  name="status" data-live-search="true" title="--">
                                <option value=""></option>
                                <option value="all" {{$status=='all' ? 'selected' : ''}}>All</option>
                                <option value="confirmed" {{$status=='confirmed' ? 'selected' : ''}}>Confirmed</option>
                                <option value="not_confirmed" {{$status=='not_confirmed' ? 'selected' : ''}}>Not confirm</option>
                                <option value="deleted" {{$status=='deleted' ? 'selected' : ''}}>Deleted</option>

                            </select>
                        </div>
                    </div>
                    <div class="clearfix"></div>
                    <div class="form-group">
                        <p style="text-align: center"><a href="#"
                                                         onclick="$(this).parents('form:first').submit(); return false;"
                                                         class="btn btn-primary">@lang('admin.pages.common.buttons.search')</a>
                        </p>
                        <button type="button" class="btn btn-primary" id="export">Export</button>
                    </div>
                </form>
            </div>
            {!! \PaginationHelper::render($offset, $limit, $count, $baseUrl, $params, 10, 'shared.pagination') !!}
        </div>

        <div class="box-body scroll">
            Total {{$count}}
            <table class="table table-bordered">
                <tr>
                    <th style="width: 10px">ID</th>
                    <th class="sortable"
                        data-key="name">@lang('admin.pages.users.columns.name')  @if( $order=="name") @if( $direction=='asc')
                            <i class="fa fa-sort-amount-asc"></i> @else <i
                                    class="fa fa-sort-amount-desc"></i> @endif @endif</th>
                    <th>@lang('admin.pages.users.columns.email')</th>
                    <th>@lang('admin.pages.users.columns.gender')</th>
                    <th>@lang('admin.pages.users.columns.year_of_birth')</th>
                    <th>@lang('admin.pages.users.columns.profile_image')</th>
                    <th>@lang('admin.pages.users.columns.skype_id')</th>
                    <th>@lang('admin.pages.users.columns.points')</th>
                    <th>@lang('admin.pages.users.columns.register_type')</th>
                    <th>@lang('admin.pages.users.columns.status')</th>
                    <th>@lang('admin.pages.users.columns.created_at')</th>
                    <th style="width: 40px"></th>
                </tr>
                @foreach( $users as $user )
                    <tr>
                        <td>{{ $user->id }}</td>
                        <td>{{ $user->name }}</td>
                        <td>{{ $user->email }}</td>
                        <td>{{ $user->gender }}</td>
                        <td>{{ $user->year_of_birth }}</td>
                        <td>
                            <img width="100px" src="{!! $user->getProfileImageUrl() !!}" alt="{{ $user->name }}">
                        </td>
                        <td>{{ $user->skype_id }}</td>
                        <td>{{ $user->points }}</td>
                        <td>{{ $user->present()->registerType }}</td>
                        <td>@if($user->present()->status == 'not_confirmed')
                                <span class="label label-default">Not Confirmed</span>
                            @elseif($user->present()->status == 'deleted')
                                <span class="label label-danger">Deleted</span>
                            @else
                                <span class="label label-info">Confirmed</span>
                            @endif
                        </td>
                        <td>{{ $user->present()->createdAt }}</td>
                        <td>
                            @if($user->present()->status != 'deleted')
                                <a href="#" class="btn btn-block btn-danger btn-sm delete-button" data-delete-url="{!! action('Admin\UserController@destroy', $user->id) !!}">@lang('admin.pages.common.buttons.delete')</a>
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
