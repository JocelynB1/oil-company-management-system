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
          <th>Selling Rate</th>
          <th>Product Type</th>
          <th>Entry By</th>
          <th>Modified By</th>
        </tr>
    </thead>
    <tbody>
    <tr >
    <td>
    {{ $salesrate->selling_rate }}
    </td>
    <td>
    {{ $salesrate->product_type}}
    </td>
    <td>
    {{ $salesrate->created_by}}
    </td>
    <td>
     {{ $salesrate->modified_by}}
     </td>
    </tr>
    
    <tbody>
    </table>
    
    
    <br><br><br>
    <a href="{{ route('salesrate.index') }}" class="btn btn-info">Back to sales rates</a>
    <a href="{{ route('salesrate.edit', $salesrate->id) }}"  class="btn btn-primary">edit</a>
    
    
    
    </div>
    </div>
    </div>
    </div>
    </div>
    </div>
    
    @stop