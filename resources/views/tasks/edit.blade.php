@extends('layouts.app')

@section('content')
{!! Form::model($task, [
    'method' => 'PATCH',
    'route' => ['tasks.update', $task->id]
]) !!}

<div class="form-group">
    {!! Form::label('title', 'Title:', ['class' => 'control-label']) !!}
    {!! Form::text('title', null, ['class' => 'form-control']) !!}
</div>

<div class="form-group">
    {!! Form::label('description', 'Description:', ['class' => 'control-label']) !!}
    {!! Form::textarea('description', null, ['class' => 'form-control']) !!}
</div>

{!! Form::submit('Update Task', ['class' => 'btn btn-primary']) !!}

{!! Form::close() !!}
@stop