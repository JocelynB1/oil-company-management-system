@extends('layouts.app')
<?php


?>
@section('content')
<div class="container">
                <div class="row">
                    <div class="auto">            
                        {!! Form::open([
                        'method' => 'GET',
                        'class'=>"form-inline",
                        'action'=>'DisplayRecordsController@displayCustomersAccountReport'
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
                    <h1>Customer Account Current Balances</h1>
                </div>
         
    
        <br><br>

            <div class="row justify-content-center">
                <div class="col-auto">  
                 @if(isset($customerAccounts))
                <table class="table table-striped table-borded table-hover table-sm table-bordered">
                    <thead>
                        <tr>
                            <th>LAST TRANSACTION DATE</th>
                            <th>CUSTOMER NUMBER</th>
                            <th>CUSTOMER NAME</th>
                            <th>TOTAL NUMBER OF LITERS</th>
                            <th>TOTAL COST</th>
                            <th>TOTAL AMOUNT PAID</th>
                            <th>BALANCE</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            @foreach($customerAccounts as $customerAccount)
                            <td>
                                <a href="{{
                                 route('reports.customersStatementReport',
                                [
                                    'customer_number'=>request('customer_number'),
                                    'customer_number'=>$customerAccount['customer_number']
                                ] 
                                )
                                 }}" style="color: black">
                                {{$customerAccount['transaction_date']}}
                                </a>
                            </td>
                            
                             <td>
                                <a href="{{
                                 route('reports.customersStatementReport',
                                [
                                    'customer_number'=>request('customer_number'),
                                    'customer_number'=>$customerAccount['customer_number']
                                ] 
                                )
                                 }}" style="color: black">
                                {{$customerAccount['customer_number']}}
                                </a>
                            </td>

                            <td>
                                  <a href="{{
                                 route('reports.customersStatementReport',
                                [
                                    'customer_number'=>request('customer_number'),
                                    'customer_number'=>$customerAccount['customer_number']
                                ] 
                                )
                                 }}" style="color: black">
                              
                                {{$customerAccount['customer_name']}}
                                  </a>
                                </td>

                                                            <td>
                                  <a href="{{
                                 route('reports.customersStatementReport',
                                [
                                    'customer_number'=>request('customer_number'),
                                    'customer_number'=>$customerAccount['customer_number']
                                ] 
                                )
                                 }}" style="color: black">
                              
                                {{number_format($customerAccount['liters'],2)}}
                                  </a>
                                </td>

                                  <td>
                                  <a href="{{
                                 route('reports.customersStatementReport',
                                [
                                    'customer_number'=>request('customer_number'),'customer_number'=>$customerAccount['customer_number']
                                ] 
                                )
                                 }}" style="color: black">
                              
                                {{number_format($customerAccount['cost'],2)}}
                                  </a>
                            </td>
                            <td>
                                  <a href="{{
                                 route('reports.customersStatementReport',
                                [
                                    'customer_number'=>request('customer_number'),'customer_number'=>$customerAccount['customer_number']
                                ] 
                                )
                                 }}" style="color: black">
                              
                                {{number_format($customerAccount['amount_paid'],2)}}
                                  </a>
                            </td>
                            <td>
                                  <a href="{{
                                 route('reports.customersStatementReport',
                                [
                                    'customer_number'=>request('customer_number'),'customer_number'=>$customerAccount['customer_number']
                                ] 
                                )
                                 }}" style="color: black">
                              
                                {{number_format($customerAccount['balance'],2)}}
                                  </a>
                                </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                {{$customerAccounts->appends($_GET)->links()}}
            @endif
 
            </div>
        </div>
        </div>
    

@endsection
@section("scripts")
    <?php
    //echo $a;
    //DisplayRecordsController@displayCustomersStatementReport
    ?>
@endsection
    
    
    
    