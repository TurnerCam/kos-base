@extends('adminlte::page')

@section('title', 'Environment')

@section('content_header')
    <h1>Environment</h1>
@stop

@section('content')
    <div class="card">
        <div class="card-body">
            @include('partials.environment-info')
        </div>
    </div>
@stop
