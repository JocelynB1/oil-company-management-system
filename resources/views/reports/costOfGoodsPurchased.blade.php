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
                    'action'=>'DisplayRecordsController@displayCostOfGoodsPurchased'
                    ])!!}
                    @csrf

                    <div class="col-auto" style="display: none">
                        {!!Form::text('export',null, ['class' => 'form-control'])!!}
                    </div>

                    <div class="col-auto">
                        <button class="btn btn-success" type="submit">Export</button>
                    </div>
                    {!! Form::close() !!}
                </div>
                <h1>Cost Of Goods Purchased</h1>
            </div>
            <div class="card-body">
                <table class="table table-striped table-borded table-hover table-sm table-bordered">
                    <thead>
                        <tr>
                            <th>DATE</th>
                            <th>SUPPLIER</th>
                            <th>PRODUCT</th>
                            <th>LITERS SUPPLIED</th>
                            <th>SHORTAGE</th>
                            <th>NET LOAD IN LITERS</th>
                            <th>RATE</th>
                            <th>AMOUNT</th>
                            <th>TOTAL COST</th>
                        </tr>
                    </thead>

                    <tbody>
                        <tr>
                            @foreach($supplierPayments as $supplierPayment)
                            <td>{{$supplierPayment['transaction_date']}}</td>
                            <td>{{$supplierPayment['supplier_name']}}</td>
                            <td>{{$supplierPayment['product_type']}}</td>
                            <td>{{number_format($supplierPayment['litres_loaded'],2)}}</td>
                            <td>{{number_format($supplierPayment['shortages_in_litres'],2)}}</td>
                            <td>{{number_format($supplierPayment['net_loading_in_litres'],2)}}</td>
                            <td>{{number_format($supplierPayment['price_per_litre'],2)}}</td>
                            <td>{{number_format($supplierPayment['amount'],2)}}</td>
                            <td>{{number_format($supplierPayment['total_cost'],2)}}</td>
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
    
    
    
    