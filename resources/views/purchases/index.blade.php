@extends('layouts.app')
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card card-default">
                <div class="card-header">Manage Supplier Payments</div>

                <div class="card-body">

<div class="container">
        <form action="{{ route('purchases.search') }}" method="POST" role="search">
            {{ csrf_field() }}
            <div class="input-group">
                <input type="text" class="form-control" name="q"
                    placeholder="Search purchases"> <span class="input-group-btn">
                    <button type="submit" class="btn btn-default">
                        <span class="glyphicon glyphicon-search"></span>
                    </button>
                </span>
            </div>
        </form>
    </div>

<br>
                @if(isset($purchases))

<table class="table table-striped">
<tbody>
@foreach($purchases as $p)<tr>
<td>

    <h3>Transaction Date: {{ $p->transaction_date }}</h3>
    <p>Supplier Name: {{ $p->supplier_name}}</p>
    <p>Driver Name: {{ $p->driver_name}}</p>
    <p>Bank Name: {{ $p->bank_name}}</p>
    <p>Total Cost: {{ $p->total_cost}}</p>
    <p>Amount Paid: {{ $p->amount_paid}}</p>
    <p>Balance: {{ $p->balance}}</p>
    <p>Narration: {{ $p->amount}}</p>
   
      
      <a href="{{ route('purchases.show', $p->id) }}" class="btn btn-primary" >view</a>
    <a href="{{ route('purchases.edit', $p->id) }}"  class="btn btn-primary">edit</a>
      
      {!! Form::open([
                'method' => 'DELETE',
                'route' => ['purchases.destroy', $p->id]
            ]) !!}
                {!! Form::submit('Delete', ['class' => 'btn btn-danger']) !!}
            {!! Form::close() !!}
        

      </p>
    
    </td>
    </tr>
@endforeach
<tbody>
</table>
@endif
</div>
            </div>
        </div>
    </div>
</div>
</div>
@stop