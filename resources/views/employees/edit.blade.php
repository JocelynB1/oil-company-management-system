@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card card-default">
                <div class="card-header">Edit Record</div>

                <div class="card-body">
                    {!! Form::model($employee, [
                    'method' => 'PATCH',
                    'route' => ['employees.update', $employee->id]
                    ]) !!}

                    @csrf

    <div class=" form-group row ">
{!! Form::label('staff','Staff:',['class'=>
'col-md-4 col-form-label text-md-right']) !!}
<div class="col-md-6">
{!! Form::radio('type',"staff",['class'=> 'form-control','name'=>'type','id'=>'staff']) !!}
</div>
</div>

         <div class=" form-group row ">
{!! Form::label('nonStaff','Non Staff:',['class'=>
'col-md-4 col-form-label text-md-right']) !!}
<div class="col-md-6">
{!! Form::radio('type',"nonStaff",['class'=> 'form-control','name'=>'type']) !!}
</div>
</div>

        
        <div class="form-group row">
{!! Form::label('employee_name','Name:',['class'=>
'col-md-4 col-form-label text-md-right']) !!}
<div class="col-md-6">
{!! Form::text('employee_name',null,['class'=> 'form-control']) !!}
</div>



    </div>



                   @include('layouts.partials.forms.phonenumber')
                   @include('layouts.partials.forms.createdby')
                   @include('layouts.partials.forms.modifiedby')
                 

                    <div class="col-md-8 offset-md-4">
                    {!! Form::submit('Update Other User Details', ['class' => 'btn btn-primary']) !!}

                    {!! Form::close() !!}
                     </div>
                </div>
            </div>
        </div>
    </div>
</div>

@stop