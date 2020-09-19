@extends('layouts.app')
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card card-default">
                <div class="card-header">Add Customers</div>

                <div class="card-body">

<div class="container">
        <form action="{{ route('customers.search') }}" method="POST" role="search">
            {{ csrf_field() }}
            <div class="input-group">
                <input type="text" class="form-control" name="q"
                    placeholder="Search Customer Names"> <span class="input-group-btn">
                    <button type="submit" class="btn btn-default">
                        <span class="glyphicon glyphicon-search"></span>
                    </button>
                </span>
            </div>
        </form>
    </div>

<br>
                @if(isset($customers))

<table class="table table-striped">
<tbody>
@foreach($customers as $customer)
<tr><td>
<h3>{{ $customer->customer_number }}</h3>
    <p>{{ $customer->customer_name}}</p>
    <p>
    <a href="{{ route('customers.show', $customer->id) }}" class="btn btn-primary" >view</a>
    <a href="{{ route('customers.edit', $customer->id) }}"  class="btn btn-primary">edit</a>
    
    {!! Form::open([
        'method' => 'DELETE',
        'route' => ['customers.destroy', $customer->id]
    ]) !!}
        {!! Form::submit('Delete', ['class' => 'btn btn-danger']) !!}
    {!! Form::close() !!}

      </p>
    </td></tr>
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