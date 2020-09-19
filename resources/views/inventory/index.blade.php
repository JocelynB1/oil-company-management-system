@extends('layouts.app')
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card card-default">
                <div class="card-header">Add Stock</div>

                <div class="card-body">

<div class="container">
        <form action="{{ route('inventory.search') }}" method="POST" role="search">
            {{ csrf_field() }}
            <div class="input-group">
                <input type="text" class="form-control" name="q"
                    placeholder="Search Stock"> <span class="input-group-btn">
                    <button type="submit" class="btn btn-default">
                        <span class="glyphicon glyphicon-search"></span>
                    </button>
                </span>
            </div>
        </form>
    </div>

<br>
                @if(isset($inventory))

<table class="table table-striped">
<tbody>
@foreach($inventory as $inv)
<tr><td>
<h3>{{ $inv->supplier_name }}</h3>
    <p>{{ $inv->product_type}}</p>
    <p>
    <a href="{{ route('inventory.show', $inv->id) }}" class="btn btn-primary" >view</a>
    <a href="{{ route('inventory.edit', $inv->id) }}"  class="btn btn-primary">edit</a>
        {!! Form::open([
            'method' => 'DELETE',
            'route' => ['inventory.destroy', $inv->id]
        ]) !!}
            {!! Form::submit('Delete', ['class' => 'btn btn-danger']) !!}
        {!! Form::close() !!}
   
</p>
    
    </td></tr>
@endforeach
<tbody>
</table>
{!! $inventory->render() !!}@endif
</div>
            </div>
        </div>
    </div>
</div>
</div>
@stop