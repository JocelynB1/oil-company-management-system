@extends('layouts.app')
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card card-default">
                <div class="card-header">Manage Transaction Codes</div>

                <div class="card-body">

<div class="container">
        <form action="{{ route('transcodes.search') }}" method="POST" role="search">
            {{ csrf_field() }}
            <div class="input-group">
                <input type="text" class="form-control" name="q"
                    placeholder="Search Transaction Code"> <span class="input-group-btn">
                    <button type="submit" class="btn btn-default">
                        <span class="glyphicon glyphicon-search"></span>
                    </button>
                </span>
            </div>
        </form>
    </div>

<br>
                @if(isset($transcodes))

<table class="table table-striped">
<tbody>
@foreach($transcodes as $p)
<tr><td>
<h3>Tranaction Code: {{ $p->transaction_code }}</h3>
    <p>Transcation Description: {{ $p->transaction_description}}</p>
    <p>
    <a href="{{ route('transcodes.show', $p->id) }}" class="btn btn-primary" >view</a>
    <a href="{{ route('transcodes.edit', $p->id) }}"  class="btn btn-primary">edit</a>
       <a href="#" class="btn btn-danger">Delete Transaction Code</a>
      </p>
    
    </td></tr>
@endforeach
<tbody>
</table>
{!! $transcodes->render() !!}@endif
</div>
            </div>
        </div>
    </div>
</div>
</div>
@stop