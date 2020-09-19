
@extends('layouts.app')

@section('content')
<div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card card-default">
                    <div class="card-header">View Record</div>
                    <div class="card-body">
    
                        <table class="table table-striped table-responsive">
    <thead>
    <tr>
          <th>Transaction Code</th>
          <th>Transaction Description</th>
          <th>Entry By</th>
          <th>Created At</th>
          <th>Updated At</th>
    </tr>
    </thead>
    <tbody>
    <tr>
    
    <td>
            {{ $transcodes->transaction_code}}
    </td>
    
    <td>
            {{ $transcodes->transaction_description}}
    </td>
    
    <td>
            {{ $transcodes->created_by}}
    </td>
    
    <td>
            {{ $transcodes->updated_at}}
    </td>
    
    <td>
            {{ $transcodes->created_at}}
    </td>
         
    </tr>
    <tbody>
    </table>
    
    
    <br><br><br>
    <a href="{{ route('transcodes.index') }}" class="btn btn-info">Back to transaction codes</a>
    <a href="{{ route('transcodes.edit', $transcodes->id) }}"  class="btn btn-primary">edit</a>
    
    
    
    </div>
    </div>
    </div>
    </div>
    </div>
    </div>
    
    @stop
