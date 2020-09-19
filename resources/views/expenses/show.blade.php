
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
          <th>Expense Category</th>
          <th>Entry By</th>
          <th>Created At</th>
          <th>Updated At</th>
    </tr>
    </thead>
    <tbody>
    <tr>
    
    <td>
            {{ $expenses->expense_category}}
    </td>
    
    <td>
            {{ $expenses->created_by}}
    </td>
    
    <td>
            {{ $expenses->created_at}}
    </td>
    
    <td>
            {{ $expenses->updated_at}}
    </td>
    
    </tr>
    <tbody>
    </table>
    
    
    <br><br><br>
    <a href="{{ route('expenses.index') }}" class="btn btn-info">Back to Expenses Category</a>
    <a href="{{ route('expenses.edit', $expenses->id) }}"  class="btn btn-primary">edit</a>
    
    
    
    </div>
    </div>
    </div>
    </div>
    </div>
    </div>
    
    @stop
