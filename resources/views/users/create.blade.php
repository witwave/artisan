@extends('layouts.master')

@section('content')
    <div class="row">
        <div class="col-md-12">
            <ol class="breadcrumb">
                <li><a href="{{ URL::to('admin') }}">{{ Lang::get('menus.home') }}</a></li>
                <li><a href="{{ URL::to('admin/users') }}">{{ Lang::get('menus.users') }}</a></li>
                <li class="active">{{ Lang::get('forms.create') }}</li>
            </ol>
        </div>
    </div>
    
    @include('partials.errors')

	{!! Form::open(array('action' => '\App\Http\Controllers\UserController@postStore', 'role' => 'form')) !!}
    <div class="row">
        <div class="col-md-9">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h4 class="panel-title">{{ Lang::get('forms.create_user') }}</h4>
                </div>
                <div class="panel-body">
                    <div class="form-group">
                        {!! Form::label('first_name', Lang::get('forms.first_name')) !!}
                        {!! Form::text('first_name', null, array('class' => 'form-control', 'autofocus', 'required')) !!}
                    </div>

                    <div class="form-group">
                        {!! Form::label('last_name', Lang::get('forms.last_name')) !!}
                        {!! Form::text('last_name', null, array('class' => 'form-control', 'required')) !!}
                    </div>

                    <div class="form-group">
                        {!! Form::label('email', Lang::get('forms.email')) !!}
                        {!! Form::email('email', null, array('class' => 'form-control', 'required')) !!}
                    </div>

                    <div class="form-group">
                        {!! Form::label('password', Lang::get('forms.password')) !!}
                        {!! Form::password('password', array('class' => 'form-control', 'required')) !!}
                    </div>

                    <div class="form-group">
                        {!! Form::label('password_confirmation', Lang::get('forms.reenter_password')) !!}
                        {!! Form::password('password_confirmation', array('class' => 'form-control', 'required')) !!}
                    </div>

                    <div class="form-group">
                        {!! Form::label('role', Lang::get('forms.role')) !!}
                        {!! Form::select('role', $roles, null, array('class' => 'form-control')) !!}
                    </div>
                    <div class="well">
                        <div class="form-group">
                            <div class="checkbox">
                                <label for="activated-checker">
                                    {!! Form::checkbox('activated', 'yes', true, array('id' => 'activated-checker')) !!} {{ Lang::get('forms.activate_now') }}
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
                    {!! Form::submit(Lang::get('buttons.create'), array('class' => 'btn btn-primary btn-sm pull-right')) !!}
                </div>
            </div>
        </div>
    </div>
	{!! Form::close() !!}
@stop
