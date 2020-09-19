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
                @if(isset($bankAccounts))
@foreach($bankAccounts as $bankAccount)
<table class="table table-striped">
<tbody>
<tr>
<td>
<h3>{{ $bankAccount->bank_name }}</h3>
    <p>{{ $bankAccount->account_number}}</p>
    <p>
    <a href="{{ route('bankAccounts.show', $bankAccount->id) }}" class="btn btn-primary" >view</a>
    <a href="{{ route('bankAccounts.edit', $bankAccount->id) }}"  class="btn btn-primary">edit</a>
    <a href="{{ route('bankAccounts.destroy', $bankAccount->id)}}" class="btn btn-danger">Delete bank</a>
      </p>
    <hr>
    </tr>
    </td>
@endforeach
<tbody>
</table>
{!! $bankAccounts->render() !!}@endif
</div>
            </div>
        </div>
    </div>
</div>
</div>
@stop