@extends('layouts.admin.application',['menu' => 'users'] )

@section('metadata')
@stop

@section('styles')
@stop

@section('scripts')
@stop

@section('title')
    {{ config('site.name') }} | Admin | Users | Edit
@stop

@section('header')
    Edit User:
@stop

@section('content')
    <form class="form-horizontal" action="{!! action('Admin\UserController@update', [$user->id]) !!}" method="post">
        {!! csrf_field() !!}
        <input type="hidden" name="_method" value="put">
        <div class="box-body">
            <div class="row">
                <div class="col-md-12">
                    <div class="form-group">
                        <label for="name" class="col-sm-2 control-label">@lang('admin.pages.users.columns.name')</label>

                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="name" placeholder="Name"
                                   value="{{ $user->name }}">
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="form-group">
                        <label for="email"
                               class="col-sm-2 control-label">@lang('admin.pages.users.columns.email')</label>

                        <div class="col-sm-10">
                            <input type="email" class="form-control" id="email" placeholder="Email"
                                   value="{{ $user->email }}">
                        </div>
                    </div>
                </div>
            </div>

            <div class="form-group">
                <label for="skype_id" class="col-sm-2 control-label">Skype</label>

                <div class="col-sm-10">
                    <input type="text" class="form-control" id="skype_id" placeholder="Skype" value="{{ $user->skype_id }}">
                </div>
            </div>

            <div class="form-group">
                <label for="gender" class="col-sm-2 control-label">Gender</label>

                <div class="col-sm-10">
                    <input type="text" class="form-control" id="gender" placeholder="Gender" value="{{ $user->gender }}">
                </div>
            </div>


        </div>
        <!-- /.box-body -->
        <div class="box-footer">
            <button type="submit" class="btn btn-info pull-right">Save</button>
        </div>
        <!-- /.box-footer -->
    </form>
@stop
