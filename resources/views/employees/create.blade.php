@extends('layouts.app')
<?php
$js=<<<_
//document.querySelector("#Employee").style.display="block";

if (document.getElementsByName('type')) {
    var type = document.getElementsByName('type');
    type[0].addEventListener('change', function (e) {
if(type[0].checked)
{
 document.querySelector("#Employee").style.display="block";
}else{
document.querySelector("#Employee").style.display="none";

}
        if (e.target != e.currentTarget) {
            e.preventDefault();
        }
        e.stopPropagation();
    }, false);


   type[1].addEventListener('change', function (e) {
if(!type[1].checked)
{
 document.querySelector("#Employee").style.display="block";
}else{
document.querySelector("#Employee").style.display="none";

}
        if (e.target != e.currentTarget) {
            e.preventDefault();
        }
        e.stopPropagation();
    }, false);



}
_;

?>
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card card-default">
                <div class="card-header">Create Other User</div>

                <div class="card-body">
                @include('layouts.partials.alerts')
{!! Form::open([
'route'=>'employees.store'
])!!}
              
                 
                        @csrf

                        <div class=" form-group row ">
{!! Form::label('staff','Staff:',['class'=>
'col-md-6 col-form-label text-md-right']) !!}
{!! Form::radio('type',"staff",['class'=> 'form-control','name'=>'type','id'=>'staff']) !!}
{!! Form::label('nonStaff','Non Staff:',['class'=>
'col-auto col-form-label text-md-right']) !!}
{!! Form::radio('type',"nonStaff",['class'=> 'form-control','name'=>'type']) !!}
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
                 
                        <div class="form-group row mb-0">
                            <div class="col-md-8 offset-md-4">
                            {!! Form::submit('Add Other User',['class'=>'btn btn-primary']) !!}

                            </div>
                        </div>
                        {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
