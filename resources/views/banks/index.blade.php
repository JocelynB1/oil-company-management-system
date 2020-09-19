@extends('layouts.app')
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card card-default">
                <div class="card-header">Add Banks</div>

                <div class="card-body">

<div class="container">
        <form action="{{ route('banks.search') }}" method="POST" role="search">
            {{ csrf_field() }}
            <div class="input-group">
                <input type="text" class="form-control" name="q"
                    placeholder="Search Bank Names"> <span class="input-group-btn">
                    <button type="submit" class="btn btn-default">
                        <span class="glyphicon glyphicon-search"></span>
                    </button>
                </span>
            </div>
        </form>
    </div>

<br>
                @if(isset($banks))

<table class="table table-striped">
<tbody>
@foreach($banks as $bank)
<tr><td>
    <h3>{{ $bank->id }}</h3>
    <p>{{ $bank->bank_name}}</p>
    <p>
    <a href="{{ route('banks.show', $bank->id) }}" class="btn btn-primary" >view</a>
    <a href="{{ route('banks.edit', $bank->id) }}"  class="btn btn-primary">edit</a>
    {!! Form::open([
        'method' => 'DELETE',
        'route' => ['banks.destroy', $bank->id]
    ]) !!}
        {!! Form::submit('Delete', ['class' => 'btn btn-danger']) !!}
    {!! Form::close() !!}


</p>
    
    </td></tr>
@endforeach
<tbody>
</table>
{!! $banks->render() !!}@endif
</div>
            </div>
        </div>
    </div>
</div>
</div>
@stop