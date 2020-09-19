@extends('layouts.app')
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card card-default">
                <div class="card-header">Manage Records</div>

                <div class="card-body">

<div class="container">
        <form action="{{ route('suppliers.search') }}" method="POST" role="search">
            {{ csrf_field() }}
            <div class="input-group">
                <input type="text" class="form-control" name="q"
                    placeholder="Search Suppliers"> <span class="input-group-btn">
                    <button type="submit" class="btn btn-default">
                        <span class="glyphicon glyphicon-search"></span>
                    </button>
                </span>
            </div>
        </form>
    </div>

<br>
                @if(isset($supplier))

<table class="table table-striped">
<tbody>
@foreach($supplier as $p)<tr>
<td>

    <h3>Date Set: {{ $p->updated_at }}</h3>
    <p>Sales Rate: {{ $p->selling_rate}}</p>
   
      <p>
      <a href="{{ route('suppliers.show', $p->id) }}" class="btn btn-primary" >view</a>
    <a href="{{ route('suppliers.edit', $p->id) }}"  class="btn btn-primary">edit</a>
        <a href="#" class="btn btn-danger">Delete Suppliers</a>
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