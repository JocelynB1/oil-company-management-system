@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card card-default">
                <div class="card-header">Edit Record</div>

                <div class="card-body">
{!! Form::model($customer, [
    'method' => 'PATCH',
    'route' => ['customers.update', $customer->id]
]) !!}

       @csrf

@include('layouts.partials.forms.customernumber')
@include('layouts.partials.forms.customername') 
@include('layouts.partials.forms.companyname') 
@include('layouts.partials.forms.phonenumber')
@include('layouts.partials.forms.createdby')
@include('layouts.partials.forms.modifiedby')


    <div class="col-md-8 offset-md-4">

{!! Form::submit('Update Customer Details', ['class' => 'btn btn-primary']) !!}

{!! Form::close() !!}
    </div>
</div>
            </div>
        </div>
    </div>
</div>
</div>
@stop