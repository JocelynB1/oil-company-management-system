@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card card-default">
                <div class="card-header">Update Bank Deposit</div>

                <div class="card-body">
                @include('layouts.partials.alerts')
{!! Form::model($deposits,[
  'method' => 'PATCH',
    'route' => ['deposits.update', $deposits->id]
])!!}     
                        @csrf
                   @include('layouts.partials.forms.transactiondate')
                   @include('layouts.partials.forms.nameofbankoption')
                   @include('layouts.partials.forms.accountnumber')
                   @include('layouts.partials.forms.transcodeop')
                   @include('layouts.partials.forms.amount')
                   @include('layouts.partials.forms.narration')
                   @include('layouts.partials.forms.entryby')
                
                        <div class="form-group row mb-0">
                            <div class="col-md-8 offset-md-4">
                            {!! Form::submit('Update Bank Deposits',['class'=>'btn btn-primary']) !!}

                            </div>
                        </div>
                        {!! Form::close() !!}
               
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
