@extends('layouts.app')

@section('content')

<h1>{{ $customer->id }}</h1>
<p class="lead">{{ $customer->customer_name }}</p>
<hr>

<div class="row">
    <div class="col-md-6">
        <a href="{{ route('customers.index') }}" class="btn btn-info">Back to all customers</a>
        <a href="{{ route('customers.edit', $customer->id) }}" class="btn btn-primary">Edit Customer</a>
    </div>
    <div class="col-md-6 text-right">
        {!! Form::open([
            'method' => 'DELETE',
            'route' => ['customers.destroy', $customer->id]
        ]) !!}
            {!! Form::submit('Delete this Customer?', ['class' => 'btn btn-danger']) !!}
        {!! Form::close() !!}
    </div>
</div>

@stop