@extends('layouts.app')
<?php
//dd($expensePayments);
$field = \App\Transaction::pluck( 'expense_category','expense_category');
$fieldList = collect(['' => ''] + $field->all()+["All"=>"All"]);

$js=<<<JS


    var dateQueryEnd = document.querySelector("#dateQueryEnd");
    var dateQuery = document.querySelector("#dateQuery");
    dateQueryEnd.disabled = true;
    dateQuery.disabled = true;
var expCat = document.querySelector("#expense_category");

if (document.querySelector("#expense_category").value!=""){
getExpensePaymentDateRangeByCategory(expCat.value);
showDateQueryInputs();

}
if (document.querySelector("#expense_category")) {

expCat.addEventListener('change', function (e) {
getExpensePaymentDateRangeByCategory(expCat.value);
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


    function getExpensePaymentDateRangeByCategory(query) {
        request = createRequest();
        if (request == null) {

        }


        var url =  "../getExpensePaymentDateRangeByCategory/" + query + "/"
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
                    'action'=>'DisplayRecordsController@displayOtherExpensePaymentDetailsReport'
                    ])!!}
                    @csrf
                    {!! Form::label('expense_category','Expense Category:',['class'=>'col-auto col-form-label']) !!}
                    <div class="col-auto">
                        {!!Form::select('expense_category',$fieldList ,null, ['class' => 'form-control'])!!}
                    </div>
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
                    'action'=>'DisplayRecordsController@displayOtherExpensePaymentDetailsReport'
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
            <div class="row justify-content-center">
                <div class="col-auto">
                 @if(isset($expensePayments))

                    <table class="table table-striped table-borded table-hover table-sm table-bordered">
                        <thead>
                            <tr>
                                <th>TRANSACTION DATE</th>
                                <th>EXPENSE CATEGORY</th>
                                <th>NARRATION</th>
                                <th>PAYMENT MODE</th>
                                <th>BANK NAME</th>
                                <th>PAYMENT TO</th>
                                <th>ACCOUNT NUMBER</th>
                                <th>INVOICE NUMBER</th>
                                <th>CHEQUE NUMBER</th>
                                <th>AMOUNT</th>
                         </tr>
                        </thead>

                        <tbody>
                            <tr>
                                @foreach($expensePayments as $expensePayment)
                                <td>{{$expensePayment['transaction_date']}}</td>
                                <td>{{$expensePayment['expense_category']}}</td>
                                <td>{{$expensePayment['narration']}}</td>
                                <td>{{$expensePayment['payment_mode']}}</td>
                                <td>{{$expensePayment['bank_name']}}</td>
                                <td>{{$expensePayment['name']}}</td>
                                <td>{{$expensePayment['account_number']}}</td>
                                <td>{{$expensePayment['invoice_number']}}</td>
                                <td>{{$expensePayment['cheque_number']}}</td>
                                <td>{{number_format($expensePayment['amount_paid'],2)}}</td>
                              </tr>
                            @endforeach
                        </tbody>
                    </table>
                     {{$expensePayments->appends($_GET)->links()}}
            @endif

                </div>
            </div>
        

@endsection
@section("scripts")
{{!!$js!!}}
@endsection



