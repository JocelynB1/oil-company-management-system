@extends('layouts.app')

@section('content')

<h1>{{ $transcodes->transaction_code }}</h1>
<p class="lead">{{ $transcodes->transaction_description }}</p>
<hr>

<div class="row">
    <div class="col-md-6">
        <a href="{{ route('transcodes.index') }}" class="btn btn-info">Back to all Transaction codes</a>
        <a href="{{ route('transcodes.edit', $transcodes->id) }}" class="btn btn-primary">Edit Task</a>
    </div>
    <div class="col-md-6 text-right">
        {!! Form::open([
            'method' => 'DELETE',
            'route' => ['transcodes.destroy', $transcodes->id]
        ]) !!}
            {!! Form::submit('Delete this transcation code?', ['class' => 'btn btn-danger']) !!}
        {!! Form::close() !!}
    </div>
</div>

@stop