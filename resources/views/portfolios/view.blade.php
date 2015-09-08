@extends('layouts.master')

@section('content')
    <div class="row">
        <div class="col-md-12">
            <ol class="breadcrumb">
                <li><a href="{{ URL::to('admin') }}">{{ Lang::get('menus.home') }}</a></li>
                <li class="active">{{ Lang::get('menus.portfolios') }}</li>
            </ol>
        </div>
    </div>

    @include('partials.errors')
    
    <div class="row">
        <div class="col-md-12">
            <div class="nav-controls text-right">
                <div class="btn-group" role="group">
                @if (count($portfolios) > 0)
                <a href="" class="btn btn-default btn-sm disabled btn-text">{{ $portfolios->firstItem() . ' to ' . $portfolios->lastItem() . ' of ' . $portfolios->total() }}</a>
                @endif
                {!! HTML::link('admin/portfolios/create', Lang::get('buttons.create_new'), array('class' => 'btn btn-primary btn-sm')) !!}
            </div>
            </div>
        </div>
    </div>
    
    @if (count($portfolios) > 0)
        <table class='table table-striped table-bordered table-condensed'>
            <thead>
                <tr>
                    <th>{{ Lang::get('forms.name') }}</th>
                    <th>{{ Lang::get('forms.category') }}</th>
                    <th>{{ Lang::get('forms.summary') }}</th>
                    <th>{{ Lang::get('forms.active') }}</th>
                    <th>{{ Lang::get('forms.updated') }}</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
            @foreach ($portfolios as $portfolio)
                <tr>
                    <td>{{ $portfolio->name }}</td>
                    <td>{{ $portfolio->category->name }}</td>
                    <td>{{ $portfolio->short_description }}</td>
                    <td>
                        @if ($portfolio->active)
                            <span class="label label-success"><span class='glyphicon glyphicon-ok'></span></span>
                        @else
                            <span class="label label-danger"><span class='glyphicon glyphicon-remove'></span></span>
                        @endif
                    </td>
                    <td>{{ date('d-M-y', strtotime($portfolio->updated_at)) }}</td>
                    <td class="table-actions text-right">
                        <div class="btn-group">
                            <button type="button" class="btn btn-link dropdown-toggle" data-toggle="dropdown">
								<span class="glyphicon glyphicon-option-horizontal"></span>
							</button>
                            <ul class="dropdown-menu pull-right" role="menu">
                                <li>
                                    <a href="{{ URL::to('admin/portfolios/edit/' . $portfolio->id) }}">
                                        <i class="glyphicon glyphicon-edit"></i>{{ Lang::get('buttons.edit') }}</a>
                                </li>
                                <li>
                                    <a href="{{ URL::to('admin/portfolios/delete/' . $portfolio->id) }}" class="btn-confirm">
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
        {!! $portfolios->render() !!}
        </div>
    @else
        <div class="alert alert-info">{{ Lang::get('messages.no_portfolio_found') }}</div>
    @endif
@stop
