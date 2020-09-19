@extends('layouts.app')

@section('content')

<h3>Tranaction Date: {{ $withdrawals->transaction_date }}</h3>
    <p>Bank Name: {{ $withdrawals->bank_name}}</p>
    <p>Amount: {{ $withdrawals->amount}}</p>
    <p>Account Number: {{ $withdrawals->account_number}}</p>
<hr>

<div class="row">
    <div class="col-md-6">
        <a href="{{ route('withdrawals.index') }}" class="btn btn-info">Back to all withdrawals</a>
        <a href="{{ route('withdrawals.edit', $withdrawals->id) }}" class="btn btn-primary">Edit withdrawal</a>
    </div>
    <div class="col-md-6 text-right">
        {!! Form::open([
            'method' => 'DELETE',
            'route' => ['withdrawals.destroy', $withdrawals->id]
        ]) !!}
            {!! Form::submit('Delete this withdrawal?', ['class' => 'btn btn-danger']) !!}
        {!! Form::close() !!}
    </div>
</div>

@stop