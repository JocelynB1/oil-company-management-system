@extends('layouts.app')
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card card-default">
                <div class="card-header">Manage Withdrawals</div>

                <div class="card-body">

<div class="container">
        <form action="{{ route('withdrawals.search') }}" method="POST" role="search">
            {{ csrf_field() }}
            <div class="input-group">
                <input type="text" class="form-control" name="q"
                    placeholder="Search Withdrawals"> <span class="input-group-btn">
                    <button type="submit" class="btn btn-default">
                        <span class="glyphicon glyphicon-search"></span>
                    </button>
                </span>
            </div>
        </form>
    </div>

<br>

                @if(isset($withdrawals))

<table class="table table-striped">
<tbody>
@foreach($withdrawals as $p)
<tr><td>
<h3>Tranaction Date: {{ $p->transaction_date }}</h3>
    <p>Bank Name: {{ $p->bank_name}}</p>
    <p>Amount: {{ $p->amount}}</p>
    <p>Account Number: {{ $p->account_number}}</p>
    <p>
    <a href="{{ route('withdrawals.show', $p->id) }}" class="btn btn-primary" >view</a>
    <a href="{{ route('withdrawals.edit', $p->id) }}"  class="btn btn-primary">edit</a>
       <a href="#" class="btn btn-danger">Delete Withdrawals</a>
      </p>
    
    </td></tr>
@endforeach
<tbody>
</table>
{!! $withdrawals->render() !!}@endif
</div>
            </div>
        </div>
    </div>
</div>
</div>
@stop