@extends('layouts.master')

@section('content')
    <div class="row">
        <div class="col-md-12">
            <ol class="breadcrumb">
                <li><a href="{{ URL::to('admin') }}">{{ Lang::get('menus.home') }}</a></li>
                <li class="active">{{ Lang::get('menus.products') }}</li>
            </ol>
        </div>
    </div>

    @include('partials.errors')
    
    <div class="row">
        <div class="col-md-12">
            <div class="nav-controls text-right">
                <div class="btn-group" role="group">
                @if (count($products) > 0)
                <a href="" class="btn btn-default btn-sm disabled btn-text">{{ $products->firstItem() . ' to ' . $products->lastItem() . ' of ' . $products->total() }}</a>
                @endif
                {!! HTML::link('admin/products/create', Lang::get('buttons.create_new'), array('class' => 'btn btn-primary btn-sm')) !!}
            </div>
            </div>
        </div>
    </div>

    @if (count($products) > 0)
        <table class='table table-striped table-bordered table-condensed'>
            <thead>
                <tr>
                    <th>{{ Lang::get('forms.name') }}</th>
                    <th>{{ Lang::get('forms.category') }}</th>
                    <th>{{ Lang::get('forms.sku') }}</th>
                    <th>{{ Lang::get('forms.price') }}</th>
                    <th>{{ Lang::get('forms.summary') }}</th>
                    <th>{{ Lang::get('forms.tags') }}</th>
                    <th>{{ Lang::get('forms.featured') }}</th>
                    <th>{{ Lang::get('forms.active') }}</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
            @foreach ($products as $product)
                <tr>
                    <td>{{ $product->name }}</td>
                    <td>{{ $product->category->name }}</td>
                    <td>{{ $product->sku }}</td>
                    <td>{{ $product->price }}</td>
                    <td>{{ $product->short_description }}</td>
                    <td>
                        @foreach ($product->tags as $tag)
                        <span class="label label-info">{{ $tag->name }}</span>
                        @endforeach
                    </td>
                    <td>
                        @if ($product->featured)
                            <span class="label label-success"><span class='glyphicon glyphicon-ok'></span></span>
                        @else
                            <span class="label label-danger"><span class='glyphicon glyphicon-remove'></span></span>
                        @endif
                    </td>
                    <td>
                        @if ($product->active)
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
                                    <a href="{{ URL::to('admin/products/edit/' . $product->id) }}">
                                        <i class="glyphicon glyphicon-edit"></i>{{ Lang::get('buttons.edit') }}</a>
                                </li>
                                <li>
                                    <a href="{{ URL::to('admin/products/delete/' . $product->id) }}" class="btn-confirm">
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
        {!! $products->render() !!}
        </div>
    @else
        <div class="alert alert-info">{{ Lang::get('messages.no_product_found') }}</div>
    @endif
@stop
