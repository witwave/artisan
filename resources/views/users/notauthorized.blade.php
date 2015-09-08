@extends('layouts.plain')

@section('content')
    <div class="alert alert-danger">
        <p>{{ Lang::get('messages.not_authorized_to_view_this_page') }}</p>
    </div>
@stop