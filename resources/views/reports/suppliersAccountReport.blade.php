@extends('layouts.app')
<?php

?>
@section('content')
<div class="container">   
                <div class="row">
                    <div class="col-auto">
                        {!! Form::open([
                        'method' => 'GET',
                        'class'=>"form-inline",
                        'action'=>'DisplayRecordsController@displaySupplierAccountReport'
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
                <h1>Supplier Account Current Balances</h1>                    
                </div>
            </div><br><br>

            <div class="row justify-content-center">
                <div class="auto">
                 @if(isset($supplierAccounts))
                    <table class="table table-striped table-borded table-hover table-sm table-bordered">
                        <thead>
                            <tr>
                                <th>LAST TRANSACTION DATE</th>
                                <th>SUPPLIER NUMBER</th>
                                <th>SUPPLIER NAME</th> 
                                      <th>TOTAL LITERS SUPPLIED</th>
                                <th>TOTAL COST</th>
                                <th>TOTAL AMOUNT PAID</th>
                                <th>BALANCE</th>
                            </tr>
                        </thead>

                        <tbody>
                            <tr>
                                @foreach($supplierAccounts as $supplierAccount)
                                <td>
                                       <a href="{{
                                 route('reports.suppliersStatementReport',
                                [
                                    'supplier_number'=>request('supplier_number'),
                                    'supplier_number'=>$supplierAccount['supplier_number']
                                ] 
                                )
                                 }}" style="color: black">
                             
                                    {{$supplierAccount['transaction_date']}}
                                       </a>
                                </td>
                                <td>
                                        <a href="{{
                                 route('reports.suppliersStatementReport',
                                [
                                    'supplier_number'=>request('supplier_number'),
                                    'supplier_number'=>$supplierAccount['supplier_number']
                                ] 
                                )
                                 }}" style="color: black">
                             
                                    {{$supplierAccount['supplier_number']}}
                                        </a>
                                </td>
                                <td>
                                        <a href="{{
                                 route('reports.suppliersStatementReport',
                                [
                                    'supplier_number'=>request('supplier_number'),
                                    'supplier_number'=>$supplierAccount['supplier_number']
                                ] 
                                )
                                 }}" style="color: black">
                             
                                    {{$supplierAccount['supplier_name']}}
                                        </a>
                                    </td>
                                    







 <td>
                                        <a href="{{
                                 route('reports.suppliersStatementReport',
                                [
                                    'supplier_number'=>request('supplier_number'),
                                    'supplier_number'=>$supplierAccount['supplier_number']
                                ] 
                                )
                                 }}" style="color: black">
                             
                                    {{number_format($supplierAccount['liters'],2)}}
                                        </a>
                                    </td>
                               

                                <td>
                                    
                                        <a href="{{
                                 route('reports.suppliersStatementReport',
                                [
                                    'supplier_number'=>request('supplier_number'),
                                    'supplier_number'=>$supplierAccount['supplier_number']
                                ] 
                                )
                                 }}" style="color: black">
                             
                                    {{number_format($supplierAccount['cost'],2)}}
                                        </a>
                                    </td>
                                <td>
                                        <a href="{{
                                 route('reports.suppliersStatementReport',
                                [
                                    'supplier_number'=>request('supplier_number'),
                                    'supplier_number'=>$supplierAccount['supplier_number']
                                ] 
                                )
                                 }}" style="color: black">
                             
                                    {{number_format($supplierAccount['amount_paid'],2)}}
                                        </a>
                                </td>
                                <td>
                                        <a href="{{
                                 route('reports.suppliersStatementReport',
                                [
                                    'supplier_number'=>request('supplier_number'),
                                    'supplier_number'=>$supplierAccount['supplier_number']
                                ] 
                                )
                                 }}" style="color: black">
                             
                                    {{number_format($supplierAccount['balance'],2)}}
                                        </a>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                    {{$supplierAccounts->appends($_GET)->links()}}
            @endif
 
                </div>
            </div>        
    

@endsection
@section("scripts")
    <?php
    //echo $a;
    ?>
@endsection
    
    
    
    