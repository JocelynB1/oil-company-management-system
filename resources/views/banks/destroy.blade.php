@extends('layouts.app')

@section('content')

<h1>{{ $bank->id }}</h1>
<p class="lead">{{ $bank->bank_name }}</p>
<hr>

<div class="row">
    <div class="col-md-6">
        <a href="{{ route('banks.index') }}" class="btn btn-info">Back to all tasks</a>
        <a href="{{ route('banks.edit', $bank->id) }}" class="btn btn-primary">Edit Task</a>
    </div>
    <div class="col-md-6 text-right">
        {!! Form::open([
            'method' => 'DELETE',
            'route' => ['banks.destroy', $bank->id]
        ]) !!}
            {!! Form::submit('Delete this task?', ['class' => 'btn btn-danger']) !!}
        {!! Form::close() !!}
    </div>
</div>

@stop