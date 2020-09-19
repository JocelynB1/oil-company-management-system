@extends('layouts.app')
<?php
//dd($supplierAccounts);
$field = \App\Supplier::pluck( 'supplier_name','supplier_number');
$fieldList = collect(['' => ''] + $field->all());

if(!isset($supplierAccounts[0]['supplier_name'])){
    $h1="PLEASE SELECT A SUPPLIER";
    
}else{
                
         $h1=strtoupper($supplierAccounts[0]['supplier_name']).'\'S TRANSACTION WITH AGAZY LTD';
    
}

$js=<<<JS

   var dateQueryEnd = document.querySelector("#dateQueryEnd");
    var dateQuery = document.querySelector("#dateQuery");
    dateQueryEnd.disabled = true;
    dateQuery.disabled = true;

        document.querySelector("#supplier_number").value=document.querySelector("#account_number").value;
      
    if (document.querySelector("#account_number")) {
   
        var accountNumber = document.querySelector("#account_number");
        var supplierNumber = document.querySelector("#supplier_number");
        accountNumber.addEventListener('change', function (e) {
        supplierNumber.value=accountNumber.value;
        getTransactionDateRangeOfSupplier(supplierNumber.value);
        showDateQueryInputs();

            if (e.target != e.currentTarget) {
                e.preventDefault();
            }
            e.stopPropagation();
        }, false);
    }

function showDateQueryInputs() {
    dateQuery.disabled = false;
    dateQueryEnd.disabled = false;
    dateQuery.style.display = "block";
    dateQueryEnd.style.display = "block";
    document.querySelector("#dateQueryEndDiv").style.display = "block";
    document.querySelector("#dateQueryDiv").style.display = "block";
}

function createRequest() {
        try {
            request = new XMLHttpRequest();
        } catch (tryMS) {
            try {
                request = new ActiveXObject("Msxml2.XMLHTTP");
            } catch (otherMS) {
                try {
                    request = new ActiveXObject("Microsoft.XMLHTTP");
                } catch (failed) {
                    request = null;
                }
            }
        }
        return request;
    }


    function getTransactionDateRangeOfSupplier(query) {
        request = createRequest();
        if (request == null) {

        }


        var url =  "../getTransactionDateRangeOfSupplier/" + query + "/"
        request.onreadystatechange = setStartAndEndDates;
        request.open("GET", url, true);
        request.setRequestHeader("Accept", "text/plain");
        request.setRequestHeader("Content-Type", "text/plain");
        request.responseType = 'text';
        request.send();

    }
    function setStartAndEndDates() {
        if (request.readyState == 4) {
            if (request.status == 200) {
                var dates = JSON.parse(request.responseText);
                var startDate=dates[0].transaction_date;
                var  endDate=dates[dates.length-1].transaction_date;
                dateQuery.value = startDate;
                dateQueryEnd.value = endDate;         
            }
        }
    }


JS;


?>
@section('content')

<div class="container">   
                <div class="row">
                    <div class="col-auto">
                        {!! Form::open([
                        'method' => 'GET',
                        'class'=>"form-inline",                                          
                        'action'=>'DisplayRecordsController@displaySuppliersStatementReport'
                        ])!!}
                        @csrf
                        {!! Form::label('account_number','Select Supplier Name:',['class'=>'col-auto col-form-label']) !!}
                        <div class="col-auto">
                            {!!Form::select('account_number',$fieldList ,null, ['class' => 'form-control'])!!}
                        </div>
                                             <div class="col-auto" id="dateQueryDiv" style="display:none">
                        {!! Form::date('dateQuery',null,['class'=> 'form-control', "id"=>"dateQuery"]) !!}
                    </div>
                    <div class="col-auto" id="dateQueryEndDiv" style="display:none">
                            {!! Form::date('dateQueryEnd',null,['class'=> 'form-control', "id"=>"dateQueryEnd"]) !!}
                        </div>

                        <div class="col-auto">
                            <button type="submit" class="btn btn-primary">
                                Submit
                            </button>
                        </div>
                        {!! Form::close() !!}
                    </div>
                    <div class="col-auto">
                        {!! Form::open([
                        'method' => 'GET',
                        'class'=>"form-inline",
                        'action'=>'DisplayRecordsController@displaySuppliersStatementReport'
                        ])!!}
                        @csrf

                        <div class="col-auto" style="display: none">
                            {!!Form::text('supplier_number',null, ['class' => 'form-control','id'=>'supplier_number'])!!}
                        </div>

                        <div class="col-auto" style="display: none">
                            {!!Form::text('export',null, ['class' => 'form-control'])!!}
                        </div>

                        <div class="col-auto">
                            <button class="btn btn-success" type="submit">Export</button>
                        </div>
                        {!! Form::close() !!}
                    </div>
                </div>
            </div>
<br><br>
                <div class="row justify-content-center">
                    <div class="col-auto">
                 @if(isset($supplierAccounts))

                        <table class="table table-striped table-borded table-hover table-sm table-bordered table-responsive">
                            <thead>
                                <tr>
                                    <th>DATE</th>
                                    <th>SUPPLIER NAME</th>
                                    <th>NARRATION</th>
                                    <th>PRODUCT</th>
                                    <th>PAYMENT MODE</th>
                                    <th>BANK NAME</th>
                                    <th>CHEQUE NUMBER</th>
                                    <th>LITERS</th>
                                    <th>UNIT PRICE</th>
                                    <th>SUPPLIER RATE</th>
                                    <th>COST</th>
                                    <th>AMOUNT PAID</th>
                                    <th>BALANCE</th>
                                </tr>
                            </thead>

                            <tbody>
                                <tr>
                                    @foreach($supplierAccounts as $supplierAccount)
                                    <td>{{$supplierAccount['transaction_date']}}</td>
                                    <td>{{$supplierAccount['supplier_name']}}</td>                             
                                    <td>{{$supplierAccount['narration']}}</td>
                                    <td>{{$supplierAccount['product_type']}}</td>
                                    <td>{{$supplierAccount['payment_mode']}}</td>
                                    <td>{{$supplierAccount['bank_name']}}</td>
                                    <td>{{$supplierAccount['cheque_number']}}</td>
                                    <td>{{number_format($supplierAccount['liters'],2)}}</td>
                                    <td>{{number_format($supplierAccount['unit_price'],2)}}</td>
                                    <td>{{number_format($supplierAccount['supplier_rate'],2)}}</td>
                                    <td>{{number_format($supplierAccount['cost'],2)}}</td>
                                    <td>{{number_format($supplierAccount['amount_paid'],2)}}</td>
                                    <td>{{number_format($supplierAccount['balance'],2)}}</td>
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
{{!!$js!!}}
@endsection
    
    
    
    