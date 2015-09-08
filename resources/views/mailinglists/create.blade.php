@extends('layouts.master')

@section('content')
    <div class="row">
        <div class="col-md-12">
            <ol class="breadcrumb">
                <li><a href="{{ URL::to('admin') }}">{{ Lang::get('menus.home') }}</a></li>
                <li><a href="{{ URL::to('admin/mailinglists') }}">{{ Lang::get('menus.mailinglist') }}</a></li>
                <li class="active">{{ Lang::get('forms.create') }}</li>
            </ol>
        </div>
    </div>
    
    @include('partials.errors')

    {!! Form::open(array('files' => TRUE, 'action' => '\App\Http\Controllers\MailinglistController@postStore', 'role' => 'form')) !!}

        <div class="row">
            <div class="col-md-9">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h4 class="panel-title">{{ Lang::get('forms.create_mailinglist') }}</h4>
                    </div>
                    <div class="panel-body">
                        <div class="form-group">
                            {!! Form::label('first_name', Lang::get('forms.first_name')) !!}
                            {!! Form::text('first_name', null, array('class' => 'form-control', 'required', 'autofocus')) !!}
                        </div>

                        <div class="form-group">
                            {!! Form::label('last_name', Lang::get('forms.last_name')) !!}
                            {!! Form::text('last_name', null, array('class' => 'form-control', 'required')) !!}
                        </div>

                        <div class="form-group">
                            {!! Form::label('email', Lang::get('forms.email')) !!}
                            {!! Form::email('email', null, array('class' => 'form-control', 'required')) !!}
                        </div>
                        
                        <div class="well">
                            <div class="form-group">
                                <div class="checkbox">
                                    <label for="active-checker">
                                        {!! Form::checkbox('active', true, true, array('id' => 'active-checker')) !!} {{ Lang::get('forms.active') }}
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class='well'>
                    <div class='form-actions'>
                        {!! HTML::link('admin/mailinglists', Lang::get('buttons.cancel'), array('class' => 'btn btn-link btn-sm'))!!}
                        {!! Form::submit(Lang::get('buttons.create'), array('class' => 'btn btn-primary btn-sm pull-right')) !!}
                    </div>
                </div>
            </div>
        </div>
    {!! Form::close() !!}
@stop

@section('footer')
@stop
