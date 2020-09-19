@extends('layouts.app')
@section('content')
@foreach($tasks as $task)
    <h3>{{ $task->title }}</h3>
    <p>{{ $task->description}}</p>
    <p>
    <a href="{{ route('tasks.show', $task->id) }}" class="btn btn-primary" >view</a>
    <a href="{{ route('tasks.edit', $task->id) }}"  class="btn btn-primary">edit</a>
      </p>
    <hr>
@endforeach
@stop