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
          <th>Product Name</th>
          <th>Created By</th>
          <th>Modified By</th>
          <th>Created At</th>
          <th>Updated At</th>
    </tr>
    </thead>
    <tbody>
    <tr>
    
    <td>
     {{ $product->product_type}}
    </td>
    
    <td>
            {{ $product->created_by}}
    </td>
    
    <td>
            {{ $product->modified_by}}
    </td>
    
    <td>
            {{ $product->created_at}}
    </td>
    
    <td>
            {{ $product->updated_at}}
    </td>
    
    </tr>
    <tbody>
    </table>
    
    
    <br><br><br>
    <a href="{{ route('product.index') }}" class="btn btn-info">Back to products</a>
    <a href="{{ route('product.edit', $product->id) }}"  class="btn btn-primary">edit</a>
    
    
    
    </div>
    </div>
    </div>
    </div>
    </div>
    </div>
    
    @stop