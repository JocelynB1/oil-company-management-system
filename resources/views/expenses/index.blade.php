@extends('layouts.app')
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card card-default">
                <div class="card-header">Manage Records</div>

                <div class="card-body">

<div class="container">
        <form action="{{ route('expenses.search') }}" method="POST" role="search">
            {{ csrf_field() }}
            <div class="input-group">
                <input type="text" class="form-control" name="q"
                    placeholder="Search expenses"> <span class="input-group-btn">
                    <button type="submit" class="btn btn-default">
                        <span class="glyphicon glyphicon-search"></span>
                    </button>
                </span>
            </div>
        </form>
    </div>

<br>
                @if(isset($expenses))

<table class="table table-striped">
<tbody>
@foreach($expenses as $p)<tr>
<td>

    <h3>Expense Category: {{ $p->expense_category }}</h3>
    <p>Entry By: {{ $p->created_by}}</p>
   
      
      <a href="{{ route('expenses.show', $p->id) }}" class="btn btn-primary" >view</a>
    <a href="{{ route('expenses.edit', $p->id) }}"  class="btn btn-primary">edit</a>
      
      {!! Form::open([
                'method' => 'DELETE',
                'route' => ['expenses.destroy', $p->id]
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