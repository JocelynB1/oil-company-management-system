@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card card-default">
                <div class="card-header">Add A New Bank Account</div>

                <div class="card-body">
                
                @include('layouts.partials.alerts')
{!! Form::open([
'route'=>'bankAccounts.store'
])!!}
                        @csrf
                   @include('layouts.partials.forms.nameofbankoptionforbankaccounts')
                   @include('layouts.partials.forms.accountnumber')
                   @include('layouts.partials.forms.createdby')
                   @include('layouts.partials.forms.currentbalance')
                   @include('layouts.partials.forms.dateoflasttransaction')
                   @include('layouts.partials.forms.entryby')
                        <div class="form-group row mb-0">
                            <div class="col-md-8 offset-md-4">
                            {!! Form::submit('Add A New Bank Account',['class'=>'btn btn-primary']) !!}

                           </div>
                        </div>
                        {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
