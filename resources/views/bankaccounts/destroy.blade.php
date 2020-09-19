@extends('layouts.master')

@section('content')

<h1>{{ $bankaccount->bank_name }}</h1>
<p class="lead">{{ $bankaccount->account_number }}</p>
<hr>

<div class="row">
    <div class="col-md-6">
        <a href="{{ route('bankaccounts.index') }}" class="btn btn-info">Back to all Bank Accounts</a>
        <a href="{{ route('bankaccounts.edit', $bankaccount->id) }}" class="btn btn-primary">Edit Bank Accounts</a>
    </div>
    <div class="col-md-6 text-right">
        {!! Form::open([
            'method' => 'DELETE',
            'route' => ['bankaccounts.destroy', $bankaccount->id]
        ]) !!}
            {!! Form::submit('Delete this bank account?', ['class' => 'btn btn-danger']) !!}
        {!! Form::close() !!}
    </div>
</div>

@stop