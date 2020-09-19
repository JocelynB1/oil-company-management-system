@extends('layouts.app')
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card card-default">
                <div class="card-header">Manage Records</div>

                <div class="card-body">

<div class="container">
        <form action="{{ route('refunds.search') }}" method="POST" role="search">
            {{ csrf_field() }}
            <div class="input-group">
                <input type="text" class="form-control" name="q"
                    placeholder="Search refunds"> <span class="input-group-btn">
                    <button type="submit" class="btn btn-default">
                        <span class="glyphicon glyphicon-search"></span>
                    </button>
                </span>
            </div>
        </form>
    </div>

<br>
                @if(isset($refunds))

<table class="table table-striped">
<tbody>
@foreach($refunds as $p)<tr>
<td>

    <h3>Transaction Date: {{ $p->transaction_date }}</h3>
    <p>Customer Name: {{ $p->customer_name}}</p>
    <p>Account Number: {{ $p->account_number}}</p>
    <p>Refund Amount: {{ $p->refund_amount}}</p>
    <p>Payment Mode : {{ $p->payment_mode}}</p>
    <p>Entry by: {{ $p->created_by}}</p>
   
      
      <a href="{{ route('refunds.show', $p->id) }}" class="btn btn-primary" >view</a>
    <a href="{{ route('refunds.edit', $p->id) }}"  class="btn btn-primary">edit</a>
      
      {!! Form::open([
                'method' => 'DELETE',
                'route' => ['refunds.destroy', $p->id]
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