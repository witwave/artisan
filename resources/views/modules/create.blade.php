@extends('layouts.master')

@section('content')
    <div class="row">
        <div class="col-md-12">
            <ol class="breadcrumb">
                <li><a href="{{ URL::to('admin') }}">{{ Lang::get('menus.home') }}</a></li>
                <li><a href="{{ URL::to('admin/modules') }}">{{ Lang::get('menus.modules') }}</a></li>
                <li class="active">{{ Lang::get('forms.create') }}</li>
            </ol>
        </div>
    </div>
    
    @include('partials.errors')

    {!! Form::open(array('files' => TRUE, 'action' => '\App\Http\Controllers\ModuleController@postStore', 'role' => 'form')) !!}

    	<div class='row'>
            <div class="col-md-3 col-md-push-9">
                <div class="well">
                    <div class='form-actions'>
                        {!! HTML::link('admin/modules', Lang::get('buttons.cancel'), array('class' => 'btn btn-link btn-sm'))!!}
                        {!! Form::submit(Lang::get('buttons.create'), array('class' => 'btn btn-primary btn-sm pull-right')) !!}
                    </div>
                </div>
                <div class='well well-small'>
                    <div class="form-group">
                        <div class="checkbox">
                            <label for="featured-checker">
                                {!! Form::checkbox('featured', true, true, array('id' => 'featured-checker')) !!} {{ Lang::get('forms.featured') }}
                            </label>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="checkbox">
                            <label for="active-checker">
                                {!! Form::checkbox('active', true, true, array('id' => 'active-checker')) !!} {{ Lang::get('forms.active') }}
                            </label>
                        </div>
                    </div>
                </div>
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <div class="panel-title">{{ Lang::get('forms.category') }}</div>
                    </div>
                    <div class="panel-body">
                        {!! Form::hidden('category_id', null, array('id' => 'category_id')) !!}
                        <ul class="redooor-hierarchy">
                        @foreach ($categories as $item)
                            <li>{!! $item->printCategory() !!}</li>
                        @endforeach
                        </ul>
                    </div>
                </div>
		        <div>
                    <div class="fileupload fileupload-new" data-provides="fileupload">
                      <div class="fileupload-preview thumbnail" style="width: 200px; height: 150px;"></div>
                      <div>
                        <span class="btn btn-default btn-file"><span class="fileupload-new">{{ Lang::get('forms.select_image') }}</span><span class="fileupload-exists">{{ Lang::get('forms.change_image') }}</span>{!! Form::file('image') !!}</span>
                        <a href="#" class="btn btn-danger fileupload-exists" data-dismiss="fileupload">{{ Lang::get('forms.remove_image') }}</a>
                      </div>
                    </div>
                </div>
	        </div>

	        <div class="col-md-9 col-md-pull-3">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h4 class="panel-title">{{ Lang::get('forms.create_module') }}</h4>
                    </div>
                    <div class="panel-body">
                        <ul class="nav nav-tabs" id="lang-selector">
                           @foreach(\Config::get('translation') as $translation)
                           <li><a href="#lang-{{ $translation['lang'] }}">{{ $translation['name'] }}</a></li>
                           @endforeach
                       </ul>
                        <div class="tab-content">
                            <div class="tab-pane active" id="lang-en">
                                <div class="form-group">
                                    {!! Form::label('name', Lang::get('forms.title')) !!}
                                    {!! Form::text('name', null, array('class' => 'form-control')) !!}
                                </div>

                                <div class="form-group">
                                    {!! Form::label('short_description', Lang::get('forms.summary')) !!}
                                    {!! Form::text('short_description', null, array('class' => 'form-control')) !!}
                                </div>

                                <div class="form-group">
                                    {!! Form::label('long_description', Lang::get('forms.description')) !!}
                                    {!! Form::textarea('long_description', null, array('class' => 'form-control', 'style' => 'height:200px')) !!}
                                </div>
                            </div>
                            @foreach(\Config::get('translation') as $translation)
                                @if($translation['lang'] != 'en')
                                <div class="tab-pane" id="lang-{{ $translation['lang'] }}">
                                    <div class="form-group">
                                        {!! Form::label($translation['lang'] . '_name', Lang::get('forms.title')) !!}
                                        {!! Form::text($translation['lang'] . '_name', null, array('class' => 'form-control')) !!}
                                    </div>

                                    <div class="form-group">
                                        {!! Form::label($translation['lang'] . '_short_description', Lang::get('forms.summary')) !!}
                                        {!! Form::text($translation['lang'] . '_short_description', null, array('class' => 'form-control')) !!}
                                    </div>

                                    <div class="form-group">
                                        {!! Form::label($translation['lang'] . '_long_description', Lang::get('forms.description')) !!}
                                        {!! Form::textarea($translation['lang'] . '_long_description', null, array('class' => 'form-control', 'style' => 'height:200px')) !!}
                                    </div>
                                </div>
                                @endif
                            @endforeach
                        </div>
                    </div>
                </div>
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h4 class="panel-title">{{ Lang::get('forms.module_properties') }}</h4>
                    </div>
                    <div class="panel-body">
                        <div class="form-group">
                            {!! Form::label('sku', Lang::get('forms.sku')) !!}
                            {!! Form::text('sku', null, array('class' => 'form-control')) !!}
                        </div>
                        <div class="form-group">
                            {!! Form::label('tags', Lang::get('forms.tags_separated_by_comma')) !!}
                            {!! Form::text('tags', null, array('class' => 'form-control')) !!}
                        </div>
                    </div>
                </div>
                @if (isset($memberships))
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h4 class="panel-title">{{ Lang::get('forms.price_list') }}</h4>
                    </div>
                    <table class="table table-striped table-bordered">
                        <thead>
                            <tr>
                                <th>{{ Lang::get('forms.membership') }}</th>
                                <th>{{ Lang::get('forms.price') }}</th>
                                <th>{{ Lang::get('forms.enabled') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                        @foreach ($memberships as $membership)
                            <tr>
                                <td>{{ $membership->name }}</td>
                                <td>{!! Form::text('price_' . $membership->id, null, array('class' => 'form-control')) !!}</td>
                                <td>
                                    <div class="form-group">
                                        <div class="checkbox">
                                            <label for="{{ 'price_active_' . $membership->id }}">
                                                {!! Form::checkbox('price_active_' . $membership->id, 'true', false, array('id' => 'price_active_' . $membership->id)) !!}
                                            </label>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
                @endif
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h4 class="panel-title">{{ Lang::get('forms.medias') }}</h4>
                    </div>
                    <div id="media-wrapper">
                        <div class="well">{{ Lang::get('messages.select_category_to_load_media') }}</div>
                    </div>
                </div>
	        </div>
        </div>
    {!! Form::close() !!}
@stop

@section('footer')
    <script src="{{ URL::to('js/bootstrap-fileupload.js') }}"></script>
    <script>
        !function ($) {
            $(function(){
                $('#lang-selector li').first().addClass('active');
                $('#lang-selector a').click(function (e) {
                    e.preventDefault();
                    $(this).tab('show');
                });
                // Load medias base on selected category
                function loadMedia() {
                    $selected_val = $('#category_id').val();
                    $('#media-wrapper').empty().load('medias/' + $selected_val);
                }
                // On load, check if previous category exists for error message
                function checkCategory() {
                    $selected_val = $('#category_id').val();
                    if ($selected_val != '') {
                        $('.redooor-hierarchy a').each(function() {
                            if ($(this).attr('href') == $selected_val) {
                                $(this).addClass('active');
                            }
                        });
                        loadMedia();
                    }
                }
                checkCategory();
                // Change selected category
                $(document).on('click', '.redooor-hierarchy a', function(e) {
                    e.preventDefault();
                    $selected = $(this).attr('href');
                    $('#category_id').val($selected);
                    $('.redooor-hierarchy a.active').removeClass('active');
                    $(this).addClass('active');
                    // Load medias
                    loadMedia();
                });
            })
        }(window.jQuery);
    </script>
    @include('plugins/tinymce')
@stop
