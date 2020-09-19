
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
          <th>Bank Name</th>
          <th>Account Number</th>
          <th>Transaction Code</th>
          <th>Amount</th>
          <th>Narration</th>        
          <th>Entry by At</th>
          <th>Created At</th>
          <th>Updated At</th>
    </tr>
    </thead>
    <tbody>
    <tr>
    
    <td>
            {{ $withdrawals->transaction_date}}
    </td>
    
    <td>
            {{ $withdrawals->bank_name}}
    </td>
    
    <td>
            {{ $withdrawals->account_number}}
    </td>
    
    <td>
            {{ $withdrawals->transaction_code}}
    </td>
    <td>
            {{ $withdrawals->amount}}
    </td>
    <td>
            {{ $withdrawals->narration}}
    </td>
    
    <td>
            {{ $withdrawals->created_by}}
    </td>
    
    <td>
            {{ $withdrawals->updated_at}}
    </td>
    
    <td>
            {{ $withdrawals->created_at}}
    </td>
         
    </tr>
    <tbody>
    </table>
    
    
    <br><br><br>
    <a href="{{ route('withdrawals.index') }}" class="btn btn-info">Back to withdrawals</a>
    <a href="{{ route('withdrawals.edit', $withdrawals->id) }}"  class="btn btn-primary">edit</a>
    
    
    
    </div>
    </div>
    </div>
    </div>
    </div>
    </div>
    
    @stop
