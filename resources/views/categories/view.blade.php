@extends('layouts.master')

@section('content')
    <div class="row">
        <div class="col-md-12">
            <ol class="breadcrumb">
                <li><a href="{{ URL::to('admin') }}">{{ Lang::get('menus.home') }}</a></li>
                <li class="active">{{ Lang::get('menus.categories') }}</li>
            </ol>
        </div>
    </div>

    @include('partials.errors')
    
    <div class="row">
        <div class="col-md-12">
            <div class="nav-controls text-right">
                {!! HTML::link('admin/categories/create', Lang::get('buttons.create_new'), array('class' => 'btn btn-primary btn-sm')) !!}
            </div>
        </div>
    </div>

    @if (count($categories) > 0)
        <div class="row">
            <div class="col-md-4">
                <div class="panel panel-default">
                    <div class="panel-body">
                        <ul class="redooor-hierarchy no-max-height">
                        @foreach ($categories as $item)
                            <li>{!! $item->printCategory(true) !!}</li>
                        @endforeach
                        </ul>
                    </div>
                </div>
            </div>
            <div class="col-md-8">
                <div class="rdpt-preloader"><img src="{{ URL::to('img/Preloader_2.gif') }}" class="img-circle"/></div>
                <div id="category-detail">
                    <div class="alert alert-info">
                        <span class="glyphicon glyphicon-chevron-left"></span> {{ Lang::get('messages.select_category_to_view_detail') }}
                    </div>
                </div>
            </div>
        </div>
    @else
        <div class="alert alert-info">{{ Lang::get('messages.no_category_found') }}</div>
    @endif
@stop

@section('footer')
    <script>
        !function ($) {
            $(function(){
                $(document).on('click', '.redooor-hierarchy a', function(e) {
                    e.preventDefault();
                    $('.rdpt-preloader').show();
                    $url = "{{ URL::to('admin/categories/detail') }}";
                    $detail_url = $url + '/' + $(this).attr('href');
                    $('#category-detail').empty().load($detail_url, function() {
                        $('.rdpt-preloader').hide();
                    });
                    return false;
                });
            })
        }(window.jQuery);
    </script>
@stop
