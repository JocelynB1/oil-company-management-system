@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card card-default">
                <div class="card-header">Edit Record</div>

                <div class="card-body">

{!! Form::model($banks, [
    'method' => 'PATCH',
    'route' => ['banks.update', $banks->id]
]) !!}
@csrf
 @include('layouts.partials.forms.id')
@include('layouts.partials.forms.nameofbank')
@include('layouts.partials.forms.entryby')

{!! Form::submit('Update Bank', ['class' => 'btn btn-primary']) !!}

{!! Form::close() !!}
</div>
            </div>
        </div>
    </div>
</div>
</div>
@stop