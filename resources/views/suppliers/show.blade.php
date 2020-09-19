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
          <th>Supplier Number</th>
          <th>Supplier Name</th>
          <th>Company Name</th>
          <th>Phone Number</th>
          <th>Created By</th>
          <th>Modified By</th>
          <th>Created At</th>
          <th>Updated At</th>
    </tr>
    </thead>
    <tbody>
    <tr>
    
    <td>
            {{ $supplier->supplier_number}}
    </td>
    
    <td>
            {{ $supplier->supplier_name}}
    </td>
    
    <td>
            {{ $supplier->company_name}}
    </td>
    
    <td>
            {{ $supplier->phone_number}}
    </td>
    
    <td>
            {{ $supplier->created_by}}
    </td>
    
    <td>
            {{ $supplier->modified_by}}
    </td>
    <td>
            {{ $supplier->created_at}}
    </td>
    
    <td>
            {{ $supplier->updated_at}}
    </td>
    
    </tr>
    <tbody>
    </table>
    
    
    <br><br><br>
    <a href="{{ route('suppliers.index') }}" class="btn btn-info">Back to suppliers</a>
    <a href="{{ route('suppliers.edit', $supplier->id) }}"  class="btn btn-primary">edit</a>
    
    
    
    </div>
    </div>
    </div>
    </div>
    </div>
    </div>
    
    @stop
