@extends('layouts.app')

@section('content')

<h1>{{ $product->id }}</h1>
<p class="lead">Product Name: {{ $product->product_type }}</p>
<hr>

<div class="row">
    <div class="col-md-6">
        <a href="{{ route('product.index') }}" class="btn btn-info">Back</a>
        <a href="{{ route('product.edit', $product->id) }}" class="btn btn-primary">Edit </a>
    </div>
    <div class="col-md-6 text-right">
        {!! Form::open([
            'method' => 'DELETE',
            'route' => ['product.destroy', $product->id]
        ]) !!}
            {!! Form::submit('Delete this product?', ['class' => 'btn btn-danger']) !!}
        {!! Form::close() !!}
    </div>
</div>

@stop