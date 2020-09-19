@extends('layouts.app')
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card card-default">
                <div class="card-header">Manage Records</div>

                <div class="card-body">

<div class="container">
        <form action="{{ route('expensepayments.search') }}" method="POST" role="search">
            {{ csrf_field() }}
            <div class="input-group">
                <input type="text" class="form-control" name="q"
                    placeholder="Search Expense Payments"> <span class="input-group-btn">
                    <button type="submit" class="btn btn-default">
                        <span class="glyphicon glyphicon-search"></span>
                    </button>
                </span>
            </div>
        </form>
    </div>

<br>
                @if(isset($expensepayments))

<table class="table table-striped">
<tbody>
@foreach($expensepayments as $p)<tr>
<td>

    <h3>Transaction Date: {{ $p->transaction_date }}</h3>
    <p>Expense Category: {{ $p->expense_category}}</p>
    <p>Invoice Number: {{ $p->invoice_number}}</p>
    <p>Amount: {{ $p->amount}}</p>
    <p>Entry By: {{ $p->created_by}}</p>
   
      
      <a href="{{ route('expensepayments.show', $p->id) }}" class="btn btn-primary" >view</a>
    <a href="{{ route('expensepayments.edit', $p->id) }}"  class="btn btn-primary">edit</a>
      
      {!! Form::open([
                'method' => 'DELETE',
                'route' => ['expensepayments.destroy', $p->id]
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