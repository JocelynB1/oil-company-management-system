@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card card-default">
                <div class="card-header">Payment Modes</div>
                <div class="card-body">
                @include('layouts.partials.alerts')
{!! Form::open([
'route'=>'paymentMode.store'
])!!}     
                        @csrf
   
                   @include('layouts.partials.forms.paymentmode')
                   @include('layouts.partials.forms.entryby') 
                   @include('layouts.partials.forms.modifiedby')
                        <div class="form-group row mb-0">
                            <div class="col-md-8 offset-md-4">
                            {!! Form::submit('Add New Payment mode',['class'=>'btn btn-primary']) !!}

                            </div>
                        </div>
                        {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
