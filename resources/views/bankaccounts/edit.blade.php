@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card card-default">
                <div class="card-header">Edit Record</div>

                <div class="card-body">

{!! Form::model($bankaccounts, [
    'method' => 'PATCH',
    'route' => ['bankAccounts.update', $bankaccounts->id]
]) !!}

                        @csrf

                   @include('layouts.partials.forms.nameofbankoptionforbankaccounts')
                        @include('layouts.partials.forms.accountnumber')
@include('layouts.partials.forms.createdby')
@include('layouts.partials.forms.currentbalance')
@include('layouts.partials.forms.dateoflasttransaction')
@include('layouts.partials.forms.entryby')

{!! Form::submit('Update Bank Account', ['class' => 'btn btn-primary']) !!}

{!! Form::close() !!}
</div>
            </div>
        </div>
    </div>
</div>
</div>
@stop

