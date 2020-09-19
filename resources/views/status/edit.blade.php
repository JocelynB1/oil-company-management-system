@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card card-default">
                <div class="card-header">Edit Record</div>

                <div class="card-body">

{!! Form::model($status, [
    'method' => 'PATCH',
    'route' => ['status.update', $status->id]
]) !!}

       @csrf

       @include('layouts.partials.forms.status')
       @include('layouts.partials.forms.entryby')

 <div class="form-group row mb-0">
                            <div class="col-md-8 offset-md-4">
                       {!! Form::submit('Update Status', ['class' => 'btn btn-primary']) !!}
                       </div>
                        </div>
{!! Form::close() !!}
</div>
            </div>
        </div>
    </div>
</div>
</div>
@stop