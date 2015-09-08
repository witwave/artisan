@extends('layouts.master')

@section('content')
    <div class="row">
        <div class="col-md-12">
            <ol class="breadcrumb">
                <li><a href="{{ URL::to('admin') }}">{{ Lang::get('menus.home') }}</a></li>
                <li class="active">{{ Lang::get('menus.memberships') }}</li>
            </ol>
        </div>
    </div>

    @include('partials.errors')
    
    <div class="row">
        <div class="col-md-12">
            <div class="nav-controls text-right">
                <div class="btn-group" role="group">
                @if (count($memberships) > 0)
                <a href="" class="btn btn-default btn-sm disabled btn-text">{{ $memberships->firstItem() . ' to ' . $memberships->lastItem() . ' of ' . $memberships->total() }}</a>
                @endif
                {!! HTML::link('admin/memberships/create', Lang::get('buttons.create_new'), array('class' => 'btn btn-primary btn-sm')) !!}
            </div>
            </div>
        </div>
    </div>

    @if (count($memberships) > 0)
        <table class='table table-striped table-bordered table-condensed'>
            <thead>
                <tr>
                    <th>{{ Lang::get('forms.rank') }}</th>
                    <th>{{ Lang::get('forms.name') }}</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
            @foreach ($memberships as $membership)
                <tr>
                    <td>{{ $membership->rank }}</td>
                    <td>{{ $membership->name }}</td>
                    <td class="table-actions text-right">
                        <div class="btn-group">
                            <button type="button" class="btn btn-link dropdown-toggle" data-toggle="dropdown">
								<span class="glyphicon glyphicon-option-horizontal"></span>
							</button>
                            <ul class="dropdown-menu pull-right" role="menu">
                                <li>
                                    <a href="{{ URL::to('admin/memberships/edit/' . $membership->id) }}">
                                        <i class="glyphicon glyphicon-edit"></i>{{ Lang::get('buttons.edit') }}</a>
                                </li>
                                <li>
                                    <a href="{{ URL::to('admin/memberships/delete/' . $membership->id) }}" class="btn-confirm">
                                        <i class="glyphicon glyphicon-remove"></i>{{ Lang::get('buttons.delete') }}</a>
                                </li>
                            </ul>
                        </div>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
        <div class="text-center">
        {!! $memberships->render() !!}
        </div>
    @else
        <div class="alert alert-info">{{ Lang::get('messages.no_membership_found') }}</div>
    @endif
@stop
