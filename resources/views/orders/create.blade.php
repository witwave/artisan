@extends('layouts.master')

@section('content')
    <div class="row">
        <div class="col-md-12">
            <ol class="breadcrumb">
                <li><a href="{{ URL::to('admin') }}">{{ Lang::get('menus.home') }}</a></li>
                <li><a href="{{ URL::to('admin/orders') }}">{{ Lang::get('menus.orders') }}</a></li>
                <li class="active">{{ Lang::get('forms.create') }}</li>
            </ol>
        </div>
    </div>
    
    @include('partials.errors')

    {!! Form::open(array('files' => TRUE, 'action' => '\App\Http\Controllers\OrderController@postStore', 'role' => 'form')) !!}
    
    <div class="row">
        <div class="col-md-9">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h4 class="panel-title">{{ Lang::get('forms.create_order') }}</h4>
                </div>
                <div class="panel-body">
                    <div class="form-group scrollable-dropdown-menu">
                        {!! Form::label('email', Lang::get('forms.email')) !!}
                        {!! Form::text('email', null, array('class' => 'form-control typeahead', 'required')) !!}
                    </div>
                    <div class="form-group">
                        {!! Form::label('payment_status', Lang::get('forms.payment_status')) !!}
                        {!! Form::select('payment_status', $payment_statuses, null, array('class' => 'form-control')) !!}
                    </div>
                    <div class="form-group">
                        {!! Form::label('paid', Lang::get('forms.paid')) !!}
                        <div class="input-group">
                            <span class="input-group-addon">￥</span>
                            {!! Form::text('paid', null, array('class' => 'form-control', 'required')) !!}
                        </div>
                    </div>
                    <div class="form-group">
                        {!! Form::label('transaction_id', Lang::get('forms.transaction_id')) !!}
                        {!! Form::text('transaction_id', null, array('class' => 'form-control', 'required')) !!}
                    </div>
                    <div class="form-group">
                        @if (count($products) > 0)
                            {!! Form::label('product_id', Lang::get('forms.products')) !!}
                            {!! Form::select('product_id', $products, null, array('class' => 'form-control', 'id' => 'product_id', 'multiple', 'name' => 'product_id[]')) !!}
                        @else
                            <div class="alert alert-warning">{{ Lang::get('messages.no_product_found') }}</div>
                        @endif
                    </div>
                    <div class="form-group">
                        @if (count($bundles) > 0)
                            {!! Form::label('bundle_id', Lang::get('forms.bundles')) !!}
                            {!! Form::select('bundle_id', $bundles, null, array('class' => 'form-control', 'id' => 'bundle_id', 'multiple', 'name' => 'bundle_id[]')) !!}
                        @else
                            <div class="alert alert-warning">{{ Lang::get('messages.no_bundle_found') }}</div>
                        @endif
                    </div>
                </div>
                <div class="panel-footer">
                    <p class="help-block">{{ Lang::get('messages.allow_select_multiple') }}</p>
                    <p class="help-block">{{ Lang::get('messages.how_to_deselect_multiple') }}</p>
                </div>
            </div>
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h4 class="panel-title">{{ Lang::get('forms.apply_coupon') }}</h4>
                </div>
                <div class="panel-body">
                    <div class="form-group">
                        @if (count($coupons) > 0)
                            {!! Form::label('coupon_id', Lang::get('forms.coupons') . '(' . Lang::get('forms.optional') . ')') !!}
                            {!! Form::select('coupon_id', $coupons, null, array('class' => 'form-control', 'id' => 'coupon_id', 'multiple', 'name' => 'coupon_id[]')) !!}
                        @else
                            <div class="alert alert-warning">{{ Lang::get('messages.no_coupon_found') }}</div>
                        @endif
                    </div>
                </div>
                <div class="panel-footer">
                    <p class="help-block">{{ Lang::get('messages.coupon_restriction_applies') }}</p>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="well">
                <div class='form-actions'>
                    {!! HTML::link('admin/orders', Lang::get('buttons.cancel'), array('class' => 'btn btn-link btn-sm'))!!}
                    {!! Form::submit(Lang::get('buttons.create'), array('class' => 'btn btn-primary btn-sm pull-right')) !!}
                </div>
            </div>
        </div>
    </div>
    {!! Form::close() !!}
@stop

@section('footer')
{!! HTML::script('js/typeahead.bundle.js') !!}
<script>
    (function ($){
        $(function() {
            var substringMatcher = function(strs) {
                return function findMatches(q, cb) {
                    var matches, substrRegex;

                    // an array that will be populated with substring matches
                    matches = [];

                    // regex used to determine if a string contains the substring `q`
                    substrRegex = new RegExp(q, 'i');

                    // iterate through the pool of strings and for any string that
                    // contains the substring `q`, add it to the `matches` array
                    $.each(strs, function(i, str) {
                        if (substrRegex.test(str)) {
                            // the typeahead jQuery plugin expects suggestions to a
                            // JavaScript object, refer to typeahead docs for more info
                            matches.push({ value: str });
                        }
                    });

                    cb(matches);
                };
            };

            $.get( "{{ URL::to('admin/orders/emails') }}", function( data ) {
                var emails = data;
                
                $('.typeahead').typeahead({
                    hint: true,
                    highlight: true,
                    minLength: 1
                },
                {
                    name: 'emails',
                    displayKey: 'value',
                    source: substringMatcher(emails)
                });
            });
        });
    })(window.jQuery);
</script>
@stop
