@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card card-default">
                <div class="card-header">Create Guests</div>

                <div class="card-body">
                @include('layouts.partials.alerts')
{!! Form::open([
'route'=>'guests.store'
])!!}
              
                 
                        @csrf

                        
<div class="form-group row">
{!! Form::label('guest_number','Guest Number:',['class'=>
'col-md-4 col-form-label text-md-right']) !!}
<div class="col-md-6">
{!! Form::text('guest_number',null,['class'=> 'form-control']) !!}
</div>
</div>


<div class="form-group row">
{!! Form::label('guest_name','Guest Name:',['class'=>
'col-md-4 col-form-label text-md-right']) !!}
<div class="col-md-6">
{!! Form::text('guest_name',null,['class'=> 'form-control']) !!}
</div>
</div>

                   @include('layouts.partials.forms.phonenumber')
                   @include('layouts.partials.forms.createdby')
                   @include('layouts.partials.forms.modifiedby')
                 
                        <div class="form-group row mb-0">
                            <div class="col-md-8 offset-md-4">
                            {!! Form::submit('Add A New Guest',['class'=>'btn btn-primary']) !!}

                            </div>
                        </div>
                        {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
