@extends('layouts.app')
<?php
//dd($supplierAccounts);
$field = \App\Transaction::pluck( 'supplier_name','account_number');
$fieldList = collect(['' => ''] + $field->all());

?>
@section('content')
    <div class="row">

        {!! Form::open([
        'method' => 'GET',
        'class'=>"form-inline",                                          
        'action'=>'DisplayRecordsController@displaySupplierAccountReport'
        ])!!}
        @csrf
        {!! Form::label('account_number','Select Supplier Name:',['class'=>'col-auto col-form-label']) !!}
        <div class="col-auto">
            {!!Form::select('account_number',$fieldList ,null, ['class' => 'form-control'])!!}
        </div>


        <div class="col-auto">
            <button type="submit" class="btn btn-primary">
                Submit
            </button>
        </div>
    {!! Form::close() !!}
        
    </div>



<div class="container">
<div class="row justify-content-center">
    <div class="card card-default">
        
            <div class="card-header">
                <h1>List Of Current Creditors</h1>
            </div>
        <div class="card-body">
            <table class="table table-striped table-borded table-hover table-sm table-bordered">
                <thead>
                    <tr>
                        <th>DATE</th>
                        <th>PRODUCT</th>
                        <th>LITERS</th>
                        <th>RATE</th>
                        <th>COST</th>
                        <th>AMOUNT PAID</th>
                        <th>BALANCE</th>
                    </tr>
                </thead>

                <tbody>
                    <tr>
                        @foreach($supplierAccounts as $supplierAccount)
                        <td>{{$supplierAccount['transaction_date']}}</td>
                        <td>{{$supplierAccount['product_type']}}</td>
                        <td>{{number_format($supplierAccount['liters'],2)}}</td>
                        <td>{{number_format($supplierAccount['unit_price'],2)}}</td>
                        <td>{{number_format($supplierAccount['cost'],2)}}</td>
                        <td>{{number_format($supplierAccount['amount_paid'],2)}}</td>
                        <td>{{number_format($supplierAccount['balance'],2)}}</td>
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
    
    
    
    