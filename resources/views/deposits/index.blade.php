@extends('layouts.app')
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card card-default">
                <div class="card-header">Manage Records</div>

                <div class="card-body">

<div class="container">
        <form action="{{ route('deposits.search') }}" method="POST" role="search">
            {{ csrf_field() }}
            <div class="input-group">
                <input type="text" class="form-control" name="q"
                    placeholder="Search deposits"> <span class="input-group-btn">
                    <button type="submit" class="btn btn-default">
                        <span class="glyphicon glyphicon-search"></span>
                    </button>
                </span>
            </div>
        </form>
    </div>

<br>
                @if(isset($deposits))

<table class="table table-striped">
<tbody>
@foreach($deposits as $p)<tr>
<td>

    <h3>Transaction Date: {{ $p->transaction_date }}</h3>
    <p>Bank Name: {{ $p->bank_name}}</p>
    <p>Account Number: {{ $p->account_number}}</p>
    <p>Amount: {{ $p->amount}}</p>
    <p>Entry by: {{ $p->created_by}}</p>
   
      
      <a href="{{ route('deposits.show', $p->id) }}" class="btn btn-primary" >view</a>
    <a href="{{ route('deposits.edit', $p->id) }}"  class="btn btn-primary">edit</a>
      
      {!! Form::open([
                'method' => 'DELETE',
                'route' => ['deposits.destroy', $p->id]
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