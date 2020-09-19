@extends('layouts.app')
<?php


?>
@section('content')
    
<div class="container">
    <div class="card card-default">
        <div class="card-header">
            <div class="row">
                <div class="form-row align-items-center">            
                    {!! Form::open([
                    'method' => 'GET',
                    'class'=>"form-inline",
                    'action'=>'DisplayRecordsController@displayInactiveCustomersReport'
                    ])!!}
                    @csrf

                    <div class="col-auto" style="display:none">
                        {!!Form::text('export',null, ['class' => 'form-control'])!!}
                    </div>

                    <div class="col-auto">
                        <button class="btn btn-success" type="submit">Export</button>
                    </div>
                    {!! Form::close() !!}
                </div>
                <h1>Inactive Customer Accounts By Last Date Of Transaction</h1>
                <div class="card-body">
                </div>
            </div>
        </div><br><br>
        <div class="row justify-content-center">
            <div class="col-auto">
                <table class="table table-striped table-borded table-hover table-sm table-bordered">
                    <thead>
                        <tr>
                            <th>DATE</th>
                            <th>CUSTOMER NAME</th>                            
                            <th>NARRATION</th>
                            <th>LITERS</th>
                            <th>RATE</th>
                            <th>COST</th>
                            <th>AMOUNT PAID</th>
                            <th>BALANCE</th>
                        </tr>
                    </thead>

                    <tbody>
                        <tr>
                            @foreach($customerAccounts as $customerAccount)
                            <td>{{$customerAccount['transaction_date']}}</td>
                            <td>{{$customerAccount['customer_name']}}</td>
                            <td>{{$customerAccount['narration']}}</td>
                            <td>{{number_format($customerAccount['liters'],2)}}</td>
                            <td>{{number_format($customerAccount['unit_price'],2)}}</td>
                            <td>{{number_format($customerAccount['cost'],2)}}</td>
                            <td>{{number_format($customerAccount['amount_paid'],2)}}</td>
                            <td>{{number_format($customerAccount['balance'],2)}}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>




@endsection
@section("scripts")
    <?php
    //echo $a;
    ?>
@endsection
    
    
    
    