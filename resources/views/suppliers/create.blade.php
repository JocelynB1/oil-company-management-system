@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card card-default">
                <div class="card-header">Create Suppliers</div>
                <div class="card-body">
                @include('layouts.partials.alerts')
{!! Form::open([
'route'=>'suppliers.store'
])!!}     
                        @csrf

                   @include('layouts.partials.forms.suppliernumber')               
                   @include('layouts.partials.forms.supplier_name_in')
                   @include('layouts.partials.forms.companyname') 
                   @include('layouts.partials.forms.phonenumber')
                   @include('layouts.partials.forms.createdby')
                    @include('layouts.partials.forms.modifiedby')
                   @include('layouts.partials.forms.entryby')
                        
                        <div class="form-group row mb-0">
                            <div class="col-md-8 offset-md-4">
                            {!! Form::submit('Add New Supplier',['class'=>'btn btn-primary']) !!}


                            </div>
                        </div>
                        {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
