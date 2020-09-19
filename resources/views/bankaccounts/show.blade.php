@extends('layouts.app')

@section('content')


<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card card-default">
                <div class="card-header">View Record</div>

                <div class="card-body">

<table class="table table-striped table-responsive ">
<thead>
<tr>
      <th>Account Number</th>
      <th>Name Of Bank</th>
      <th>Entry By</th>
      <th>Current Balance</th>
      <th>Date Of Last Transcation</th>
      <th>Name Of Bank</th>
    </tr>
</thead>
<tbody>
<tr >
<td>
{{ $bankaccounts->account_number }}
</td>
<td>
{{ $bankaccounts->bank_name}}
</td>
<td>
{{ $bankaccounts->created_by}}
</td>
<td>
 {{ $bankaccounts->current_balance}}
 </td>
<td>
{{ $bankaccounts->date_of_last_transaction}}
</td>

</tr>

<tbody>
</table>
<br><br><br>
<a href="{{ route('bankAccounts.index') }}" class="btn btn-info">Back to bank accounts</a>
    <a href="{{ route('bankAccounts.edit', $bankaccounts->id) }}"  class="btn btn-primary">edit</a>
    
</div>
            </div>
        </div>
    </div>
</div>
</div>
@stop
