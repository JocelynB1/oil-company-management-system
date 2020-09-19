@extends('layouts.app')
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card card-default">
                <div class="card-header">Manage Payment Modes</div>

                <div class="card-body">

<div class="container">
        <form action="{{ route('paymentMode.search') }}" method="POST" role="search">
            {{ csrf_field() }}
            <div class="input-group">
                <input type="text" class="form-control" name="q"
                    placeholder="Search Payment Modes"> <span class="input-group-btn">
                    <button type="submit" class="btn btn-default">
                        <span class="glyphicon glyphicon-search"></span>
                    </button>
                </span>
            </div>
        </form>
    </div>

<br>
                @if(isset($paymentMode))

<table class="table table-striped">
<tbody>
@foreach($paymentMode as $p)
<tr><td>
<h3>{{ $p->payment_mode }}</h3>
    <p>
    <a href="{{ route('paymentMode.show', $p->id) }}" class="btn btn-primary" >view</a>
    <a href="{{ route('paymentMode.edit', $p->id) }}"  class="btn btn-primary">edit</a>
    <a href="#" class="btn btn-danger">Delete Payment Mode</a>
      </p>
    
    </td></tr>
@endforeach
<tbody>
</table>
{!! $paymentMode->render() !!}@endif
</div>
            </div>
        </div>
    </div>
</div>
</div>
@stop