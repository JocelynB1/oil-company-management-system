@extends('layouts.app')
<?php
//dd($customerAccounts);
$field = \App\Customer::pluck( 'customer_name','customer_number');
$fieldList = collect(['' => ''] + $field->all());

if(!isset($customerAccounts[0]['customer_name'])){
$h1="PLEASE SELECT A CUSTOMER";

}else{

$h1=strtoupper($customerAccounts[0]['customer_name']).'\'S TRANSACTION WITH AGAZY LTD';

}

$js=<<<JS


    var dateQueryEnd = document.querySelector("#dateQueryEnd");
    var dateQuery = document.querySelector("#dateQuery");
    dateQueryEnd.disabled = true;
    dateQuery.disabled = true;

document.querySelector("#customer_number").value=document.querySelector("#account_number").value;

if (document.querySelector("#account_number")) {

var accountNumber = document.querySelector("#account_number");
var customerNumber = document.querySelector("#customer_number");
accountNumber.addEventListener('change', function (e) {
customerNumber.value=accountNumber.value;
getTransactionDateRangeOfCustomer(customerNumber.value);
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


    function getTransactionDateRangeOfCustomer(query) {
        request = createRequest();
        if (request == null) {

        }


        var url =  "../getTransactionDateRangeOfCustomer/" + query + "/"
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
                    'action'=>'DisplayRecordsController@displayCustomersStatementReport'
                    ])!!}
                    @csrf
                    {!! Form::label('account_number','Select Customer Name:',['class'=>'col-auto col-form-label']) !!}
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
                    'action'=>'DisplayRecordsController@displayCustomersStatementReport'
                    ])!!}
                    @csrf

                    <div class="col-auto" style="display: none">
                        {!!Form::text('customer_number',null, ['class' => 'form-control','id'=>'customer_number'])!!}
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
            <div class="row ">
                <div class="col-md-12">
                 @if(isset($customerAccounts))
                    <table class="table table-responsive table-striped table-borded table-hover table-sm table-bordered">
                        <thead>
                            <tr>
                                <th>DATE</th>
                                <th>REF #</th>
                                <th>CUSTOMER NAME</th>
                                <th>BANK NAME</th>
                                <th>PAYMENT MODE</th>
                                <th>PAYMENT STATUS</th>
                                <th>NARRATION</th>
                                <th>SUPPLIER RATE</th>
                                <th>LITERS</th>
                                 <th>DISCOUNT RATE</th>
                                <th>CASH DISCOUNT ALLOWED</th>
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
                                <td>{{$customerAccount['trn_ref_no']}}</td>
                                <td>{{$customerAccount['customer_name']}}</td>
                                <td>{{$customerAccount['bank_name']}}</td>
                                <td>{{$customerAccount['payment_mode']}}</td>
                                <td>{{$customerAccount['payment_status']}}</td>
                                <td>{{$customerAccount['narration']}}</td>
                                <td>{{number_format($customerAccount['supplier_rate'],2)}}</td>
                                <td>{{number_format($customerAccount['liters'],2)}}</td>
                                  <td>{{number_format($customerAccount['discount_rate'],2)}}</td>
                                <td>{{number_format($customerAccount['cash_discount_allowed'],2)}}</td>
                                <td>{{number_format($customerAccount['unit_price'],2)}}</td>
                                <td>{{number_format($customerAccount['cost'],2)}}</td>
                                <td>{{number_format($customerAccount['amount_paid'],2)}}</td>
                                <td>{{number_format($customerAccount['balance'],2)}}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                     {{$customerAccounts->appends($_GET)->links()}}
            @endif

                </div>
            </div>
       

@endsection
@section("scripts")
{{!!$js!!}}
@endsection



