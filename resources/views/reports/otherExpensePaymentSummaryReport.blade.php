@extends('layouts.app')
<?php
//dd($expensePayments);
$field = \App\Expense::pluck( 'expense_category','expense_category');
$fieldList = collect(['' => ''] + $field->all());


$js=<<<JS


    var dateQueryEnd = document.querySelector("#dateQueryEnd");
    var dateQuery = document.querySelector("#dateQuery");
    dateQueryEnd.disabled = true;
    dateQuery.disabled = true;

getExpensePaymentDateRange();
showDateQueryInputs();


document.querySelector("#customer_number").value=document.querySelector("#account_number").value;

if (document.querySelector("#account_number")) {

var accountNumber = document.querySelector("#account_number");
var customerNumber = document.querySelector("#customer_number");
accountNumber.addEventListener('change', function (e) {
customerNumber.value=accountNumber.value;
getExpensePaymentDateRange(customerNumber.value);
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


    function getExpensePaymentDateRange() {
        request = createRequest();
        if (request == null) {

        }


        var url =  "../getExpensePaymentDateRange";
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
                    'action'=>'DisplayRecordsController@displayOtherExpensePaymentSummaryReport'
                    ])!!}
                    @csrf
                    {!! Form::label('dateQuery','Range:',['class'=>'col-auto col-form-label']) !!}

                                         <div class="col-auto" id="dateQueryDiv" >
                     
                                            {!! Form::date('dateQuery',null,['class'=> 'form-control', "id"=>"dateQuery"]) !!}
                    </div>
                    <div class="col-auto" id="dateQueryEndDiv" >
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
                    'action'=>'DisplayRecordsController@displayOtherExpensePaymentSummaryReport'
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
            </div>
            </div>

<br><br>
            <div class="row justify-content-center">
                <div class="col-auto">
                 @if(isset($expensePayments))

                    <table class="table table-striped table-borded table-hover table-sm table-bordered">
                        <thead>
                            <tr>
                                <th>EXPENSE CATEGORY</th>
                                <th>AMOUNT</th>
                         </tr>
                        </thead>

                        <tbody>
                            <tr>
                                @foreach($expensePayments as $expensePayment)
                                <td>
                                        <a href="{{
                                 route('reports.otherExpensePaymentDetailsReport',
                                [
                                    'expense_category'=>request('expense_category'),
                                    'expense_category'=>$expensePayment['expense_category']
                                ] 
                                )
                                 }}" style="color: black">
                             
                                    {{$expensePayment['expense_category']}}
                                 </a>
                                </td>
                                <td>
                                       <a href="{{
                                 route('reports.otherExpensePaymentDetailsReport',
                                [
                                    'expense_category'=>request('expense_category'),
                                    'expense_category'=>$expensePayment['expense_category']
                                ] 
                                )
                                 }}" style="color: black">
                             
                                    {{number_format($expensePayment['amount_paid'],2)}}</td>
                                       </a>
                              </tr>
                            @endforeach
                        </tbody>
                    </table>
                     {{$expensePayments->appends($_GET)->links()}}
            @endif
                    <hr><h2><pre>Total:         {{number_format($total,2)}}</pre></h2> 
                </div>
            </div>
      

@endsection
@section("scripts")
{{!!$js!!}}
@endsection



