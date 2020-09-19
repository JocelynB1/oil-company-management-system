@extends('layouts.app')
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-auto">
            <div class="card card-default">
                <div class="card-header">Manage Records</div>

                <div class="card-body">

<div class="container">
        <form action="{{ route('accountantsales.search') }}" method="POST" role="search">
            {{ csrf_field() }}
            <div class="input-group">
                <input type="text" class="form-control" name="q"
                    placeholder="Search customer payments"> <span class="input-group-btn">
                    <button type="submit" class="btn btn-default">
                        <span class="glyphicon glyphicon-search"></span>
                    </button>
                </span>
            </div>
        </form>
    </div>

<br>
                @if(isset($accountantsales))

<table class="table table-striped">
<thead>
    <tr>
        <th>Date Posted</th>
        <th>Customer Name</th>
        <th>Account Number</th>
        <th>Accept Customer Payment</th>
        <th>Delete</th>
    </tr>
</thead>
    <tbody>
@foreach($accountantsales as $p)
<tr>

    <td>{{ $p->sales_date }}</td>
    <td>{{ $p->customer_name}}</td>
    <td>{{ $p->customer_number}}</td>
    <td>
        <a href="{{ route('accountantsales.edit', $p->id) }}"  class="btn btn-primary">Complete Sale</a>
    </td>
    <td>
      {!! Form::open([
                'method' => 'DELETE',
                'route' => ['accountantsales.destroy', $p->id]
            ]) !!}
                {!! Form::submit('Delete', ['class' => 'btn btn-danger']) !!}
            {!! Form::close() !!}
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