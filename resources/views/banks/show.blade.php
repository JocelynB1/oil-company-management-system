@extends('layouts.app')

@section('content')
<div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card card-default">
                    <div class="card-header">View Record</div>
                    <div class="card-body">
    
                        <table class="table table-hover table-striped table-responsive">
    <thead>
    <tr>
          <th>Bank Name</th>
          <th>Entry By</th>
          <th>Created At</th>
          <th>Updated At</th>
        </tr>
    </thead>
    <tbody>
    <tr >
    <td>
    {{ $bank->bank_name }}
    </td>
    <td>
    {{ $bank->created_by}}
    </td>
    <td>
     {{ $bank->created_at}}
     </td>
     <td>
            {{ $bank->updated_at}}
            </td>
    </tr>
    
    <tbody>
    </table>
    
    
    <br><br><br>
    <a href="{{ route('banks.index') }}" class="btn btn-info">Back to banks</a>
    <a href="{{ route('banks.edit', $bank->id) }}"  class="btn btn-primary">edit</a>
    
    
    
    </div>
    </div>
    </div>
    </div>
    </div>
    </div>
    
    @stop