@extends('layouts.app')

@section('content')

<h1>{{ $supplier->supplier_name }}</h1>
<p class="lead">{{ $supplier->supplier_number }}</p>
<hr>

<div class="row">
    <div class="col-md-6">
        <a href="{{ route('suppliers.index') }}" class="btn btn-info">Back to all tasks</a>
        <a href="{{ route('suppliers.edit', $supplier->id) }}" class="btn btn-primary">Edit Task</a>
    </div>
    <div class="col-md-6 text-right">
        {!! Form::open([
            'method' => 'DELETE',
            'route' => ['suppliers.destroy', $task->id]
        ]) !!}
            {!! Form::submit('Delete this supplier?', ['class' => 'btn btn-danger']) !!}
        {!! Form::close() !!}
    </div>
</div>

@stop