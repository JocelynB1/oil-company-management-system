@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card card-default">
                <div class="card-header">Edit Transaction codes</div>

                <div class="card-body">
                {!! Form::model($transcodes, [
    'method' => 'PATCH',
    'route' => ['transcodes.update', $transcodes->id]
]) !!}
             
                        @csrf
                   @include('layouts.partials.forms.transcode')
                   @include('layouts.partials.forms.transdescription') 
                   @include('layouts.partials.forms.entryby')
                
                        <div class="form-group row mb-0">
                            <div class="col-md-8 offset-md-4">
                            {!! Form::submit('Update Transaction Code', ['class' => 'btn btn-primary']) !!}

                            </div>
                        </div>
                        {!! Form::close() !!}
               
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
