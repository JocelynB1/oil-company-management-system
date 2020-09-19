@extends('layouts.app')

@section('content')

<h1>{{ $paymentMode->id }}</h1>
<p class="lead">Payment Mode: {{ $paymentMode->payment_mode }}</p>
<hr>

<div class="row">
    <div class="col-md-6">
        <a href="{{ route('paymentMode.index') }}" class="btn btn-info">Back</a>
        <a href="{{ route('paymentMode.edit', $paymentMode->id) }}" class="btn btn-primary">Edit </a>
    </div>
    <div class="col-md-6 text-right">
        {!! Form::open([
            'method' => 'DELETE',
            'route' => ['paymentMode.destroy', $paymentMode->id]
        ]) !!}
            {!! Form::submit('Delete this payment?', ['class' => 'btn btn-danger']) !!}
        {!! Form::close() !!}
    </div>
</div>

@stop