@extends('layouts.master')

@section('content')
    <div class="row">
        <div class="col-md-12">
            <ol class="breadcrumb">
                <li><a href="{{ URL::to('admin') }}">{{ Lang::get('menus.home') }}</a></li>
                <li><a href="{{ URL::to('admin/promotions') }}">{{ Lang::get('menus.promotions') }}</a></li>
                <li class="active">{{ Lang::get('forms.edit') }}</li>
            </ol>
        </div>
    </div>
    
    @include('partials.errors')

    {!! Form::open(array('files' => TRUE, 'action' => '\App\Http\Controllers\PromotionController@postStore', 'role' => 'form')) !!}
        {!! Form::hidden('id', $promotion->id) !!}

    	<div class='row'>
    	    <div class="col-md-3 col-md-push-9">
                <div class="well">
                    <div class='form-actions'>
                        {!! HTML::link('admin/promotions', Lang::get('buttons.cancel'), array('class' => 'btn btn-link btn-sm'))!!}
                        {!! Form::submit(Lang::get('buttons.save'), array('class' => 'btn btn-primary btn-sm pull-right')) !!}
                    </div>
                </div>
                <div class='well well-sm'>
                    <div class="form-group">
                        <div class="checkbox">
                            <label for="active-checker">
                                {!! Form::checkbox('active', $promotion->active, $promotion->active, array('id' => 'active-checker')) !!} {{ Lang::get('forms.active') }}
                            </label>
                        </div>
                    </div>
                </div>
                <div class="well well-sm">
                    <div class="form-group">
                        {!! Form::label('start_date', Lang::get('forms.start_date')) !!}
                        <div class="input-group" id='start-date'>
                            {!! Form::input('text', 'start_date', $start_date->format('d/m/Y'), array('class' => 'form-control datepicker', 'readonly')) !!}
                            <span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
                        </div>
                    </div>
                    <div class="form-group">
                        {!! Form::label('end_date', Lang::get('forms.end_date')) !!}
                        <div class="input-group" id='end-date'>
                            {!! Form::input('text', 'end_date', $end_date->format('d/m/Y'), array('class' => 'form-control datepicker', 'readonly')) !!}
                            <span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
                        </div>
                    </div>
                </div>
                <div class="fileupload fileupload-new" data-provides="fileupload">
                    <div class="fileupload-preview thumbnail" style="width: 200px; height: 150px;"></div>
                    <div>
                        <span class="btn btn-default btn-file"><span class="fileupload-new">{{ Lang::get('forms.select_image') }}</span><span class="fileupload-exists">{{ Lang::get('forms.change_image') }}</span>{!! Form::file('image') !!}</span>
                        <a href="#" class="btn btn-danger fileupload-exists" data-dismiss="fileupload">{{ Lang::get('forms.remove_image') }}</a>
                    </div>
                </div>
            </div>
    	    <div class="col-md-9 col-md-pull-3">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h4 class="panel-title">{{ Lang::get('forms.edit_promotion') }}</h4>
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
                                    {!! Form::text('name', $promotion->name, array('class' => 'form-control')) !!}
                                </div>

                                <div class="form-group">
                                    {!! Form::label('short_description', Lang::get('forms.summary')) !!}
                                    {!! Form::text('short_description', $promotion->short_description, array('class' => 'form-control')) !!}
                                </div>

                                <div class="form-group">
                                    {!! Form::label('long_description', Lang::get('forms.description')) !!}
                                    {!! Form::textarea('long_description', $promotion->long_description, array('class' => 'form-control', 'style' => 'height:200px')) !!}
                                </div>
                            </div>
                            @foreach(\Config::get('translation') as $translation)
                                @if($translation['lang'] != 'en')
                                <div class="tab-pane" id="lang-{{ $translation['lang'] }}">
                                    <div class="form-group">
                                        {!! Form::label($translation['lang'] . '_name', Lang::get('forms.title')) !!}
                                        @if ($translated)
                                        {!! Form::text($translation['lang'] . '_name', (array_key_exists($translation['lang'], $translated) ? $translated[$translation['lang']]->name : ''), array('class' => 'form-control')) !!}
                                        @else
                                        {!! Form::text($translation['lang'] . '_name', null, array('class' => 'form-control')) !!}
                                        @endif
                                    </div>

                                    <div class="form-group">
                                        {!! Form::label($translation['lang'] . '_short_description', Lang::get('forms.summary')) !!}
                                        @if ($translated)
                                        {!! Form::text($translation['lang'] . '_short_description', (array_key_exists($translation['lang'], $translated) ? $translated[$translation['lang']]->short_description : ''), array('class' => 'form-control')) !!}
                                        @else
                                        {!! Form::text($translation['lang'] . '_short_description', null, array('class' => 'form-control')) !!}
                                        @endif
                                    </div>

                                    <div class="form-group">
                                        {!! Form::label($translation['lang'] . '_long_description', Lang::get('forms.description')) !!}
                                        @if ($translated)
                                        {!! Form::textarea($translation['lang'] . '_long_description', (array_key_exists($translation['lang'], $translated) ? $translated[$translation['lang']]->long_description : ''), array('class' => 'form-control', 'style' => 'height:200px')) !!}
                                        @else
                                        {!! Form::textarea($translation['lang'] . '_long_description', null, array('class' => 'form-control', 'style' => 'height:200px')) !!}
                                        @endif
                                    </div>
                                </div>
                                @endif
                            @endforeach
                        </div>
                    </div>
                </div>
                @if (count($promotion->images) > 0)
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h4 class="panel-title">{{ Lang::get('forms.uploaded_photos') }}</h4>
                    </div>
                    <div class="panel-body">
                        <div class='row'>
                            @foreach ($promotion->images as $image)
                             <div class='col-md-3'>
                                {!! HTML::image($imagine->getUrl($image->path), $promotion->name, array('class' => 'img-thumbnail', 'alt' => $image->path)) !!}
                                <br><br>
                                <div class="btn-group btn-group-sm">
                                    <a href="{{ URL::to('admin/promotions/imgremove/' . $image->id) }}" class="btn btn-danger btn-confirm">
                                        <span class="glyphicon glyphicon-remove"></span>
                                    </a>
                                    <a href="{{ URL::to($imagine->getUrl($image->path, 'large')) }}" class="btn btn-primary btn-copy">
                                        <span class="glyphicon glyphicon-link"></span>
                                    </a>
                                    <a href="{{ URL::to($imagine->getUrl($image->path, 'large')) }}" class="btn btn-info" target="_blank">
                                        <span class="glyphicon glyphicon-eye-open"></span>
                                    </a>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                </div>
                @endif
            </div>
    	</div>
    {!! Form::close() !!}
@stop

@section('footer')
    <script src="{{ URL::to('js/bootstrap-fileupload.js') }}"></script>
    <script>
        !function ($) {
            $(function(){
                $( ".datepicker" ).datepicker({ dateFormat: "dd/mm/yy" });

                $( "#end-date .input-group-addon" ).click( function() {
                    $( "#end_date" ).datepicker( "show" );
                });

                $( "#start-date .input-group-addon" ).click( function() {
                    $( "#start_date" ).datepicker( "show" );
                });

                $('#lang-selector li').first().addClass('active');
                $('#lang-selector a').click(function (e) {
                    e.preventDefault();
                    $(this).tab('show');
                });
            })
        }(window.jQuery);
    </script>
    @include('plugins/tinymce')
@stop
