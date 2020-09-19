@extends('layouts.app')
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card card-default">
                <div class="card-header">Manage Records</div>

                <div class="card-body">

<div class="container">
        <form action="{{ route('salesrate.search') }}" method="POST" role="search">
            {{ csrf_field() }}
            <div class="input-group">
                <input type="text" class="form-control" name="q"
                    placeholder="Search Sales Rate"> <span class="input-group-btn">
                    <button type="submit" class="btn btn-default">
                        <span class="glyphicon glyphicon-search"></span>
                    </button>
                </span>
            </div>
        </form>
    </div>

<br>
                @if(isset($salesrate))

<table class="table table-striped">
<tbody>
@foreach($salesrate as $p)
<tr>
<td>
<h2>Product: {{ $p->product_type}}</h2>
    <h3>Date Set: {{ $p->updated_at }}</h3>
    <p>Sales Rate: {{ $p->selling_rate}}</p>
   
      <p>
    <a href="{{ route('salesrate.show', $p->id) }}" class="btn btn-primary" >view</a>
    <a href="{{ route('salesrate.edit', $p->id) }}"  class="btn btn-primary">edit</a>
     
    {!! Form::open([
        'method' => 'DELETE',
        'route' => ['salesrate.destroy', $p->id]
    ]) !!}
        {!! Form::submit('Delete', ['class' => 'btn btn-danger']) !!}
    {!! Form::close() !!}
      </p>
    
    </td>
    </tr>
@endforeach
<tbody>
</table>
{!! $salesrate->render() !!}@endif
</div>
            </div>
        </div>
    </div>
</div>
</div>
@stop