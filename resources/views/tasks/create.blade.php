@extends('layouts.app')
@section('content')


@if(Session::has('flash_message'))
    <div class="alert alert-success">
        {{ Session::get('flash_message') }}
    </div>
@endif

@include('layouts.partials.alerts');
<h1>Add a new Task</h1>
<p class="lead">Add to your task list bellow.</p>
<hr>

{!! Form::open([
'route'=>'tasks.store'
])!!}

<div class="form-group">
{!! Form::label('title','Title:',['class'=>
'control-lablel']) !!}
{!! Form::text('title',null,['class'=> 'form-control']) !!}
</div>

<div class="form-group">
{!! Form::label('description','Description:',
['class'=>'control-label']) !!}
{!! Form::textarea('description',null,['class'
=>'form-control']) !!}
</div>

{!! Form::submit('Create New Task',['class'=>'btn btn-primary']) !!}

{!! Form::close() !!}
@stop

