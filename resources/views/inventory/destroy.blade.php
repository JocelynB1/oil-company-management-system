@extends('layouts.app')

@section('content')

<h1>{{ $inventory->supplier_name }}</h1>
<p class="lead">Product: {{ $inventory->product_type }}</p>
<hr>

<div class="row">
    <div class="col-md-6">
        <a href="{{ route('inventory.index') }}" class="btn btn-info">Back to Inventory</a>
        <a href="{{ route('inventory.edit', $inventory->id) }}" class="btn btn-primary">Edit Stock</a>
    </div>
    <div class="col-md-6 text-right">
        {!! Form::open([
            'method' => 'DELETE',
            'route' => ['inventory.destroy', $inventory->id]
        ]) !!}
            {!! Form::submit('Delete this inventory?', ['class' => 'btn btn-danger']) !!}
        {!! Form::close() !!}
    </div>
</div>

@stop