@extends('layouts.master')

@section('content')
    <div class="row">
        <div class="col-md-12">
            <ol class="breadcrumb">
                <li><a href="{{ URL::to('admin') }}">{{ Lang::get('menus.home') }}</a></li>
                <li><a href="{{ URL::to('admin/pages') }}">{{ Lang::get('menus.pages') }}</a></li>
                <li class="active">{{ Lang::get('forms.create') }}</li>
            </ol>
        </div>
    </div>
    
    @include('partials.errors')

    {!! Form::open(array('files' => TRUE, 'action' => '\App\Http\Controllers\PageController@postStore', 'role' => 'form')) !!}

    <div class='row'>
        <div class="col-md-3 col-md-push-9">
            <div class="well">
                <div class='form-actions'>
                    {!! HTML::link('admin/pages', Lang::get('buttons.cancel'), array('class' => 'btn btn-link btn-sm'))!!}
                    {!! Form::submit(Lang::get('buttons.create'), array('class' => 'btn btn-primary btn-sm pull-right')) !!}
                </div>
            </div>
            <div class='well well-small'>
                <div class="form-group">
                    <div class="checkbox">
                        <label for="private-checker">
                            {!! Form::checkbox('private', true, true, array('id' => 'private-checker')) !!} {{ Lang::get('forms.private') }}
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
                        <li>
                            <a href="0" class="active"><span class="glyphicon glyphicon-chevron-right"></span> {{ Lang::get('forms.no_category') }}</a>
                        </li>
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
                    <h4 class="panel-title">{{ Lang::get('forms.create_page') }}</h4>
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
                                {!! Form::label('title', Lang::get('forms.title')) !!}
                                {!! Form::text('title', null, array('class' => 'form-control')) !!}
                            </div>

                            <div class="form-group">
                                {!! Form::label('slug', Lang::get('forms.slug')) !!}
                                {!! Form::text('slug', null, array('class' => 'form-control')) !!}
                            </div>

                            <div class="form-group">
                                {!! Form::label('content', Lang::get('forms.content')) !!}
                                {!! Form::textarea('content', null, array('class' => 'form-control', 'style' => 'height:400px')) !!}
                            </div>
                        </div>
                        @foreach(\Config::get('translation') as $translation)
                            @if($translation['lang'] != 'en')
                            <div class="tab-pane" id="lang-{{ $translation['lang'] }}">
                                <div class="form-group">
                                    {!! Form::label($translation['lang'] . '_title', Lang::get('forms.title')) !!}
                                    {!! Form::text($translation['lang'] . '_title', null, array('class' => 'form-control')) !!}
                                </div>

                                <div class="form-group">
                                    {!! Form::label($translation['lang'] . '_slug', Lang::get('forms.slug')) !!}
                                    {!! Form::text($translation['lang'] . '_slug', null, array('class' => 'form-control')) !!}
                                </div>

                                <div class="form-group">
                                    {!! Form::label($translation['lang'] . '_content', Lang::get('forms.content')) !!}
                                    {!! Form::textarea($translation['lang'] . '_content', null, array('class' => 'form-control', 'style' => 'height:400px')) !!}
                                </div>
                            </div>
                            @endif
                        @endforeach
                    </div>
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
                // On load, check if previous category exists for error message
                function checkCategory() {
                    $selected_val = $('#category_id').val();
                    if ($selected_val != '') {
                        $('.redooor-hierarchy a').each(function() {
                            if ($(this).attr('href') == $selected_val) {
                                $(this).addClass('active');
                            }
                        });
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
                });
            })
        }(window.jQuery);
    </script>
    @include('plugins/tinymce')
@stop
