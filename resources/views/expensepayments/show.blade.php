
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
          <th>Expense Category</th>
          <th>Invoice Number</th>
          <th>Amount</th>
          <th>Narration</th>
          <th>Entry by</th>
          <th>Payment to</th>
          <th>Bank Name</th>
          <th>Payment Mode</th>
        
    </tr>
    </thead>
    <tbody>
    <tr>
    
    <td>
            {{ $expensepayments->transaction_date}}
    </td>
    
    <td>
            {{ $expensepayments->expense_category}}
    </td>
    
    <td>
            {{ $expensepayments->invoice_number}}
    </td>
    
    <td>
            {{ $expensepayments->amount}}
    </td>
    
    <td>
            {{ $expensepayments->narration}}
    </td>
    <td>
            {{ $expensepayments->created_by}}
    </td>
    <td>
            {{ $expensepayments->payment_to}}
    </td>
    <td>
            {{ $expensepayments->bank_name}}
    </td>
    <td>
            {{ $expensepayments->payment_mode}}
    </td>
    </tr>
    <tbody>
    </table>
    
    
    <br><br><br>
    <a href="{{ route('expensepayments.index') }}" class="btn btn-info">Back to expensepayments </a>
    <a href="{{ route('expensepayments.edit', $expensepayments->id) }}"  class="btn btn-primary">edit</a>
    
    
    
    </div>
    </div>
    </div>
    </div>
    </div>
    </div>
    
    @stop
