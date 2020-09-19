@extends('layouts.app')

@section('content')

<h1> Set :{{ $salesrate->updated_at }}</h1>
<p class="lead">Sales Rate: {{ $salesrate->selling_rate }}</p>
<hr>

<div class="row">
    <div class="col-md-6">
        <a href="{{ route('salesrate.index') }}" class="btn btn-info">Back</a>
        <a href="{{ route('salesrate.edit', $salesrate->id) }}" class="btn btn-primary">Edit </a>
    </div>
    <div class="col-md-6 text-right">
        {!! Form::open([
            'method' => 'DELETE',
            'route' => ['salesrate.destroy', $salesrate->id]
        ]) !!}
            {!! Form::submit('Delete this Sales Rate?', ['class' => 'btn btn-danger']) !!}
        {!! Form::close() !!}
    </div>
</div>

@stop