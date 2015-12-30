@extends('layouts.master')

@section('content')
    <div class="row">
        <div class="col-md-12">
            <ol class="breadcrumb">
                <li><a href="{{ URL::to('admin') }}">{{ Lang::get('menus.home') }}</a></li>
                <li><a href="{{ URL::to('admin/users') }}">{{ Lang::get('menus.users') }}</a></li>
                <li class="active">{{ Lang::get('forms.edit') }}</li>
            </ol>
        </div>
    </div>
    
    @include('partials.errors')

    {!! Form::open(array('action' => '\App\Http\Controllers\UserController@postStore', 'role' => 'form')) !!}
    {!! Form::hidden('id', $user->id) !!}
    <div class="row">
        <div class="col-md-9">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h4 class="panel-title">{{ Lang::get('forms.edit_user') }}</h4>
                </div>
                <div class="panel-body">
                    <div class="form-group">
                        {!! Form::label('name', Lang::get('forms.name')) !!}
                        {!! Form::text('name', $user->name, array('class' => 'form-control', 'required')) !!}
                    </div>

                    <div class="form-group">
                        {!! Form::label('nickname', Lang::get('forms.nickname')) !!}
                        {!! Form::text('nickname', $user->nickname, array('class' => 'form-control', 'required')) !!}
                    </div>

                    <div class="form-group">
                        {!! Form::label('email', Lang::get('forms.email')) !!}
                        {!! Form::email('email', $user->email, array('class' => 'form-control', 'required')) !!}
                    </div>
                    <div class="form-group">
                        {!! Form::label('mobile', Lang::get('forms.mobile')) !!}
                        {!! Form::text('mobile', $user->mobile, array('class' => 'form-control', 'required')) !!}
                    </div>
                    <div class="form-group">
                        {!! Form::label('password', Lang::get('forms.password')) !!}
                        {!! Form::password('password', array('class' => 'form-control')) !!}
                        <p class="help-block">{{ Lang::get('messages.leave_password_empty_to_keep_existing_password') }}</p>
                    </div>

                    <div class="form-group">
                        {!! Form::label('password_confirmation', Lang::get('forms.reenter_password')) !!}
                        {!! Form::password('password_confirmation', array('class' => 'form-control')) !!}
                    </div>

                    <div class="form-group">
                        {!! Form::label('type', Lang::get('forms.user_type')) !!}
                        {!! Form::select('type', Config::get('mall.types'), $user->type, array('class' => 'form-control')) !!}
                    </div>

                    <div class="form-group">
                        {!! Form::label('role', Lang::get('forms.role')) !!}
                        {!! Form::select('role', $roles, $group->id, array('class' => 'form-control')) !!}
                    </div>
                    <div class="well">
                        <div class="form-group">
                            <div class="checkbox">
                                <label for="activated-checker">
                                    {!! Form::checkbox('activated', 'yes', $user->activated, array('id' => 'activated-checker')) !!} {{ Lang::get('forms.activate_now') }}
                                </label>
                            </div>
                            <p class="help-block">{{ Lang::get('messages.allow_user_to_login_this_account') }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="well">
                <div class='form-actions'>
                    {!! HTML::link('admin/users', Lang::get('buttons.cancel'), array('class' => 'btn btn-link btn-sm'))!!}
                    {!! Form::submit(Lang::get('buttons.save'), array('class' => 'btn btn-primary btn-sm pull-right')) !!}
                </div>
            </div>
        </div>
    </div>
	{!! Form::close() !!}
@stop
