
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
          <th>Transaction Date</th>
          <th>Name Of Bank</th>
          <th>Account Number</th>
          <th>Transaction Code</th>
          <th>Amount</th>
          <th>Narration</th>
          <th>Entry By</th>
        
    </tr>
    </thead>
    <tbody>
    <tr>
    
    <td>
            {{ $deposits->transaction_date}}
    </td>
    
    <td>
            {{ $deposits->bank_name}}
    </td>
    
    <td>
            {{ $deposits->account_number}}
    </td>
    
    <td>
            {{ $deposits->transaction_code}}
    </td>
    
    <td>
            {{ $deposits->amount}}
    </td>
    <td>
            {{ $deposits->narration}}
    </td>
    <td>
            {{ $deposits->created_by}}
    </td>
    
    </tr>
    <tbody>
    </table>
    
    
    <br><br><br>
    <a href="{{ route('deposits.index') }}" class="btn btn-info">Back to deposits </a>
    <a href="{{ route('deposits.edit', $deposits->id) }}"  class="btn btn-primary">edit</a>
    
    
    
    </div>
    </div>
    </div>
    </div>
    </div>
    </div>
    
    @stop
