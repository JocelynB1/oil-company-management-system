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
          <th>Customer Number</th>
          <th>Customer Name</th>
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
     {{ $customer->customer_number}}
    </td>
    
    <td>
            {{ $customer->customer_name}}
    </td>
        
    <td>
            {{ $customer->company_name}}
    </td>
        
    <td>
            {{ $customer->phone_number}}
    </td>

    <td>
            {{ $customer->created_by}}
    </td>
    
    <td>
            {{ $customer->modified_by}}
    </td>
    
    <td>
            {{ $customer->created_at}}
    </td>
    
    <td>
            {{ $customer->updated_at}}
    </td>
    
    </tr>
    <tbody>
    </table>
    
    
    <br><br><br>
    <a href="{{ route('customers.index') }}" class="btn btn-info">Back to banks</a>
    <a href="{{ route('customers.edit', $customer->id) }}"  class="btn btn-primary">edit</a>
    
    
    
    </div>
    </div>
    </div>
    </div>
    </div>
    </div>
    
    @stop