@extends('layouts.app')
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card card-default">
                <div class="card-header">Manage Records</div>

                <div class="card-body">

<div class="container">
        <form action="{{ route('createnewusers.search') }}" method="POST" role="search">
            {{ csrf_field() }}
            <div class="input-group">
                <input type="text" class="form-control" name="q"
                    placeholder="Search createnewusers"> <span class="input-group-btn">
                    <button type="submit" class="btn btn-default">
                        <span class="glyphicon glyphicon-search"></span>
                    </button>
                </span>
            </div>
        </form>
    </div>

<br>
                @if(isset($createnewusers))

<table class="table table-striped">
<tbody>
@foreach($createnewusers as $p)<tr>
<td>

    <h3>Transaction Date: {{ $p->name }}</h3>
    <p>Email: {{ $p->email}}</p>
    <p>Account Number: {{ $p->account_number}}</p>
    <p>Role: {{ $p->Description}}</p>
    
      
      <a href="{{ route('createnewusers.show', $p->id) }}" class="btn btn-primary" >view</a>
    <a href="{{ route('createnewusers.edit', $p->id) }}"  class="btn btn-primary">edit</a>
      
      {!! Form::open([
                'method' => 'DELETE',
                'route' => ['createnewusers.destroy', $p->id]
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