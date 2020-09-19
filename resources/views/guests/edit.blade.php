@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card card-default">
                <div class="card-header">Edit Record</div>

                <div class="card-body">
                    {!! Form::model($guest, [
                    'method' => 'PATCH',
                    'route' => ['guests.update', $guest->id]
                    ]) !!}

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
    <div class="col-md-8 offset-md-4">
                    {!! Form::submit('Update Guest Details', ['class' => 'btn btn-primary']) !!}

                    {!! Form::close() !!}
                     </div>
                </div>
            </div>
        </div>
    </div>
</div>

@stop