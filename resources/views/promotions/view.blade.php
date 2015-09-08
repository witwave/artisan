@extends('layouts.master')

@section('content')
    <div class="row">
        <div class="col-md-12">
            <ol class="breadcrumb">
                <li><a href="{{ URL::to('admin') }}">{{ Lang::get('menus.home') }}</a></li>
                <li class="active">{{ Lang::get('menus.promotions') }}</li>
            </ol>
        </div>
    </div>

    @include('partials.errors')
    
    <div class="row">
        <div class="col-md-12">
            <div class="nav-controls text-right">
                <div class="btn-group" role="group">
                @if (count($promotions) > 0)
                <a href="" class="btn btn-default btn-sm disabled btn-text">{{ $promotions->firstItem() . ' to ' . $promotions->lastItem() . ' of ' . $promotions->total() }}</a>
                @endif
                {!! HTML::link('admin/promotions/create', Lang::get('buttons.create_new'), array('class' => 'btn btn-primary btn-sm')) !!}
            </div>
            </div>
        </div>
    </div>
    
    @if (count($promotions) > 0)
        <table class='table table-striped table-bordered table-condensed'>
            <thead>
                <tr>
                    <th>{{ Lang::get('forms.promotion_and_events') }}</th>
                    <th>{{ Lang::get('forms.start_date') }}</th>
                    <th>{{ Lang::get('forms.end_date') }}</th>
                    <th>{{ Lang::get('forms.active') }}</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
            @foreach ($promotions as $promotion)
                <tr>
                    <td>
                        {{ $promotion->name }}
                    </td>
                    <td>{{ $promotion->start_date }}</td>
                    <td>{{ $promotion->end_date }}</td>
                    <td>
                        @if ($promotion->active)
                            <span class="label label-success"><span class='glyphicon glyphicon-ok'></span></span>
                        @else
                            <span class="label label-danger"><span class='glyphicon glyphicon-remove'></span></span>
                        @endif
                    </td>
                    <td class="table-actions text-right">
                        <div class="btn-group">
                            <button type="button" class="btn btn-link dropdown-toggle" data-toggle="dropdown">
								<span class="glyphicon glyphicon-option-horizontal"></span>
							</button>
						  	<ul class="dropdown-menu pull-right" role="menu">
						        <li>
						            <a href="{{ URL::to('admin/promotions/edit/' . $promotion->id) }}">
						                <i class="glyphicon glyphicon-edit"></i>{{ Lang::get('buttons.edit') }}</a>
						        </li>
						        <li>
						            <a href="{{ URL::to('admin/promotions/delete/' . $promotion->id) }}" class="btn-confirm">
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
        {!! $promotions->render() !!}
        </div>
    @else
        <div class="alert alert-info">{{ Lang::get('messages.no_promotion_found') }}</div>
    @endif
@stop
