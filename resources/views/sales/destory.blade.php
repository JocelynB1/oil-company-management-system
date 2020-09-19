@extends('layouts.app')

@section('content')

<h1>{{ $sales->id }}</h1>
<p class="lead">Sale: {{ $sales->product_type }}</p>
<hr>

<div class="row">
    <div class="col-md-6">
        <a href="{{ route('sales.index') }}" class="btn btn-info">Back</a>
        <a href="{{ route('sales.edit', $sales->id) }}" class="btn btn-primary">Edit </a>
    </div>
    <div class="col-md-6 text-right">
        {!! Form::open([
            'method' => 'DELETE',
            'route' => ['sales.destroy', $sales->id]
        ]) !!}
            {!! Form::submit('Delete this sales?', ['class' => 'btn btn-danger']) !!}
        {!! Form::close() !!}
    </div>
</div>

@stop