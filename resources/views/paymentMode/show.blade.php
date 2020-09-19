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
          <th>Payment Mode Description</th>
          <th>Entry By</th>
          <th>Modified By</th>
          <th>Created At</th>
          <th>Updated At</th>
    </tr>
    </thead>
    <tbody>
    <tr>
    
    <td>
            {{ $paymentMode->payment_mode}}
    </td>
    
    <td>
            {{ $paymentMode->created_by}}
    </td>
    
    <td>
            {{ $paymentMode->modified_by}}
    </td>
    
    <td>
            {{ $paymentMode->updated_at}}
    </td>
    
    <td>
            {{ $paymentMode->created_at}}
    </td>
         
    </tr>
    <tbody>
    </table>
    
    
    <br><br><br>
    <a href="{{ route('paymentMode.index') }}" class="btn btn-info">Back to payment codes</a>
    <a href="{{ route('paymentMode.edit', $paymentMode->id) }}"  class="btn btn-primary">edit</a>
    
    
    
    </div>
    </div>
    </div>
    </div>
    </div>
    </div>
    
    @stop
