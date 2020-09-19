@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card card-default">
                <div class="card-header">Add Transaction codes</div>

                <div class="card-body">
                @include('layouts.partials.alerts')
{!! Form::open([
'route'=>'transcodes.store'
])!!}     
                        @csrf
                   @include('layouts.partials.forms.transcode')
                   @include('layouts.partials.forms.transdescription') 
                   @include('layouts.partials.forms.entryby')
                
                        <div class="form-group row mb-0">
                            <div class="col-md-8 offset-md-4">
                            {!! Form::submit('Add New Transaction Code',['class'=>'btn btn-primary']) !!}

                            </div>
                        </div>
                        {!! Form::close() !!}
               
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
